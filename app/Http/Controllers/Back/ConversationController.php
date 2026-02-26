<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Events\MessageSent;
use App\Events\UserTyping;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ConversationController extends Controller
{
    /**
     * Affiche la liste des conversations
     */
    public function index()
    {
        $conversations = auth()->user()->conversations()
            ->with([
                'users',
                'lastMessage',
                'messages' => function ($q) {
                    $q->latest()->limit(1);
                }
            ])
            ->get();

        $unreadCount = auth()->user()->unreadMessagesCount();

        return view('back.messagerie.index', compact('conversations', 'unreadCount'));
    }

    /**
     * Affiche une conversation spécifique
     */
    public function show(Conversation $conversation)
    {
        // Vérifier que l'utilisateur participe à la conversation
        if (!$conversation->users->contains(auth()->id())) {
            abort(403);
        }

        $messages = $conversation->messages()
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->paginate(50)
            ->items();


        $otherUser = $conversation->users()
            ->where('users.id', '!=', auth()->id())
            ->first();

        return view('back.messagerie.show', compact('conversation', 'messages', 'otherUser'));
    }

    /**
     * Envoyer un message texte
     */

public function sendMessage(Request $request, Conversation $conversation)
{
    // ✅ IMPORTANT : autoriser body nullable ET file nullable
    $data = $request->validate([
        'body' => ['nullable', 'string', 'max:5000'],
        'file' => ['nullable', 'file', 'max:10240'], // 10MB
        'reply_to_id' => ['nullable', 'integer', Rule::exists('messages', 'id')],
    ]);

    if (empty(trim($data['body'] ?? '')) && !$request->hasFile('file')) {
        return response()->json(['message' => 'Message vide'], 422);
    }

    // (optionnel) vérifier que l’utilisateur fait partie de la conversation
    if (!$conversation->users->contains(auth()->id())) {
        abort(403);
    }

    $filePayload = [
        'file_path' => null,
        'file_name' => null,
        'file_type' => null,
        'file_size' => null,
    ];

    if ($request->hasFile('file')) {
        $file = $request->file('file');

        $path = $file->store("conversations/{$conversation->id}", 'public');

        $filePayload = [
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'file_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
        ];
    }

    $message = $conversation->messages()->create([
        'user_id' => auth()->id(),
        'body' => trim($data['body'] ?? ''),
        'reply_to_id' => $data['reply_to_id'] ?? null,
        ...$filePayload,
    ]);

    // Recharge replyTo pour l’affichage
    $message->load('replyTo');

    // Retour JSON complet pour Alpine
    return response()->json([
        'id' => $message->id,
        'user_id' => $message->user_id,
        'body' => $message->body,
        'created_at' => $message->created_at->toISOString(),
        'reply_to_id' => $message->reply_to_id,
        'reply_to' => $message->replyTo ? [
            'id' => $message->replyTo->id,
            'user_id' => $message->replyTo->user_id,
            'body' => $message->replyTo->body,
            'file_name' => $message->replyTo->file_name,
        ] : null,

        'file_path' => $message->file_path,
        'file_name' => $message->file_name,
        'file_type' => $message->file_type,
        'file_size' => $message->file_size,
        'file_url' => $message->file_path ? asset('storage/'.$message->file_path) : null,
    ]);
} /**
     * ✅ NOUVELLE MÉTHODE : Upload de fichier
     */
    /**
     * Upload de fichier dans une conversation
     */
   /**
 * Upload de fichier dans une conversation
 */
public function uploadFile(Request $request, $conversationId)
{
    try {
        Log::info('📤 Upload de fichier démarré', [
            'conversation_id' => $conversationId,
            'user_id' => auth()->id()
        ]);

        $request->validate([
            'file' => 'required|file|max:10240|mimes:jpeg,png,jpg,gif,mp4,mov,avi,pdf,doc,docx,xls,xlsx,zip,rar,txt',
        ]);

        $conversation = Conversation::findOrFail($conversationId);

        if (!$conversation->users->contains(auth()->id())) {
            Log::warning('⛔ Upload non autorisé', [
                'user_id' => auth()->id(),
                'conversation_id' => $conversationId
            ]);
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        $file = $request->file('file');

        if (!$file->isValid()) {
            throw new \Exception('Fichier invalide');
        }

        // Générer un nom unique
        $timestamp = time();
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $cleanName = preg_replace('/[^a-zA-Z0-9_.-]/', '_', pathinfo($originalName, PATHINFO_FILENAME));
        $fileName = $timestamp . '_' . $cleanName . '.' . $extension;

        // Stocker le fichier
        $path = $file->storeAs('chat-files/' . $conversationId, $fileName, 'public');

        Log::info('📁 Fichier sauvegardé', [
            'path' => $path,
            'original_name' => $originalName,
            'size' => $file->getSize()
        ]);

        // Créer le message avec le fichier
        $message = Message::create([
            'conversation_id' => $conversationId,
            'user_id' => auth()->id(),
            'body' => '',
            'file_path' => $path,
            'file_name' => $originalName,
            'file_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'is_read' => false,
            'created_at' => now(),
        ]);

        // Charger la relation user
        $message->load('user');

        Log::info('✅ Message avec fichier créé', [
            'message_id' => $message->id,
            'file_name' => $message->file_name
        ]);

        // Mettre à jour last_read_at pour l'expéditeur
        $conversation->users()->updateExistingPivot(auth()->id(), [
            'last_read_at' => now()
        ]);

        // Broadcast
        broadcast(new MessageSent($message))->toOthers();

        // ✅ Retourner le message avec tous les accesseurs
        return response()->json([
            'id' => $message->id,
            'body' => $message->body,
            'file_path' => $message->file_path,
            'file_name' => $message->file_name,
            'file_type' => $message->file_type,
            'file_size' => $message->file_size,
            'file_url' => $message->file_url,
            'file_icon' => $message->file_icon,
            'formatted_size' => $message->formatted_size,
            'user_id' => $message->user_id,
            'user' => [
                'id' => $message->user->id,
                'name' => $message->user->name
            ],
            'created_at' => $message->created_at->toISOString()
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::error('❌ Validation erreur upload:', [
            'errors' => $e->errors()
        ]);
        return response()->json([
            'error' => 'Fichier invalide. Types acceptés: images, vidéos, PDF, documents (max 10MB)'
        ], 422);

    } catch (\Exception $e) {
        Log::error('❌ Erreur upload fichier:', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
    /**
     * Marquer les messages comme lus
     */
    public function markAsRead($conversationId)
    {
        try {
            $conversation = Conversation::findOrFail($conversationId);

            Message::where('conversation_id', $conversationId)
                ->where('user_id', '!=', auth()->id())
                ->where('is_read', false)
                ->update(['is_read' => true]);

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            Log::error('❌ Erreur markAsRead:', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Indicateur de frappe
     */




    public function typing(Request $request, $conversationId)
    {
        try {
            $request->validate([
                'is_typing' => 'required|boolean'
            ]);

            $conversation = Conversation::findOrFail($conversationId);

            broadcast(new UserTyping(
                $conversationId,
                auth()->id(),
                auth()->user()->name,
                $request->is_typing
            ))->toOthers();

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            Log::error('❌ Erreur typing:', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Démarrer une conversation avec un utilisateur
     */
    public function startWithUser(User $user)
    {
        // Vérifier qu'on ne démarre pas avec soi-même
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas démarrer une conversation avec vous-même');
        }

        // Chercher une conversation existante
        $conversation = Conversation::whereHas('users', function ($q) {
            $q->where('user_id', auth()->id());
        })->whereHas('users', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->first();

        // Si aucune conversation n'existe, en créer une
        if (!$conversation) {
            $conversation = Conversation::create([
                'is_group' => false
            ]);

            $conversation->users()->attach([auth()->id(), $user->id]);
        }

        return redirect()->route('back.messagerie.show', $conversation->id);
    }

    /**
     * Récupérer les messages non lus pour le dropdown
     */
    public function dropdown()
    {
        $unreadMessages = Message::whereHas('conversation', function ($q) {
            $q->whereHas('users', function ($q2) {
                $q2->where('users.id', auth()->id());
            });
        })
            ->where('user_id', '!=', auth()->id())
            ->where('is_read', false)
            ->with(['user', 'conversation'])
            ->latest()
            ->take(10)
            ->get();

        $unreadCount = auth()->user()->unreadMessagesCount();

        return response()->json([
            'messages' => $unreadMessages,
            'count' => $unreadCount
        ]);
    }

    public function updateMessage(Request $request, Conversation $conversation, Message $message)
{
    if ($message->conversation_id !== $conversation->id) abort(404);
    if ($message->user_id !== auth()->id()) abort(403);

    $data = $request->validate([
        'body' => ['required', 'string', 'max:5000'],
    ]);

    $message->update(['body' => $data['body']]);

    return response()->json([
        'id' => $message->id,
        'body' => $message->body,
        'updated_at' => $message->updated_at?->toISOString(),
    ]);
}

public function deleteMessage(Request $request, Conversation $conversation, Message $message)
{
    if ($message->conversation_id !== $conversation->id) abort(404);
    if ($message->user_id !== auth()->id()) abort(403);

    // si tu veux supprimer aussi le fichier
    if ($message->file_path) {
        Storage::disk('public')->delete($message->file_path);
    }

    $id = $message->id;
    $message->delete();

    return response()->json(['deleted' => true, 'id' => $id]);
}
}
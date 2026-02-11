<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\User;
use App\Events\MessageSent;
use App\Events\UserTyping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    /**
     * Liste toutes les conversations de l'utilisateur connecté
     */
public function index()
{
    $user = Auth::user();
    $conversations = $user->conversations()
        ->with(['users', 'lastMessage.user']) // ✅ plus de where('user_id', '!=', ...)
        ->orderByDesc(
            Conversation::select('created_at')
                ->from('messages')
                ->whereColumn('conversation_id', 'conversations.id')
                ->latest()
                ->limit(1)
        )
        ->get();

    return view('back.messagerie.index', compact('conversations'));
}

    /**
     * Affiche une conversation spécifique
     */
    public function show(Conversation $conversation)
    {
        // Vérifier que l'utilisateur est participant
        if (!$conversation->users->contains(Auth::id())) {
            abort(403);
        }

        $messages = $conversation->messages()
            ->with('user')
            ->orderBy('created_at')
            ->paginate(50);

        // Marquer comme lu
        $conversation->users()->updateExistingPivot(Auth::id(), [
            'last_read_at' => now()
        ]);

        $otherUser = $conversation->users->where('id', '!=', Auth::id())->first();

        return view('back.messagerie.show', compact('conversation', 'messages', 'otherUser'));
    }

    /**
     * Démarrer une conversation avec un autre utilisateur
     */
    public function startWithUser(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Vous ne pouvez pas discuter avec vous-même.');
        }

        // Rechercher une conversation privée existante entre les deux
        $conversation = Conversation::where('is_group', false)
            ->whereHas('users', fn($q) => $q->where('user_id', Auth::id()))
            ->whereHas('users', fn($q) => $q->where('user_id', $user->id))
            ->first();

        if (!$conversation) {
            $conversation = Conversation::create(['is_group' => false]);
            $conversation->users()->attach([Auth::id(), $user->id]);
        }

        return redirect()->route('back.messagerie.show', $conversation);
    }

    /**
     * Envoyer un message (AJAX)
     */
    public function sendMessage(Request $request, Conversation $conversation)
    {
        $request->validate(['body' => 'required|string|max:5000']);

        if (!$conversation->users->contains(Auth::id())) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $message = $conversation->messages()->create([
            'user_id' => Auth::id(),
            'body' => $request->body,
            'is_read' => false,
        ]);

        // Charger la relation user pour le broadcast
        $message->load('user');

        // Diffuser l'événement aux autres participants
        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'id' => $message->id,
            'body' => $message->body,
            'created_at' => $message->created_at->format('H:i'),
            'user' => [
                'id' => $message->user->id,
                'name' => $message->user->name,
            ],
        ]);
    }

    /**
     * Indicateur de frappe (AJAX)
     */
    public function typing(Request $request, Conversation $conversation)
    {
        $request->validate(['is_typing' => 'required|boolean']);

        broadcast(new UserTyping(Auth::user(), $conversation, $request->is_typing))->toOthers();

        return response()->json(['success' => true]);
    }

    /**
     * Marquer tous les messages comme lus (AJAX)
     */
    public function markAsRead(Conversation $conversation)
    {
        $conversation->users()->updateExistingPivot(Auth::id(), [
            'last_read_at' => now()
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Dropdown AJAX pour la navbar (rechargement en temps réel)
     */
    public function dropdown()
    {
        $user = Auth::user();
        $conversations = $user->conversations()
            ->with(['users' => fn($q) => $q->where('user_id', '!=', $user->id), 'lastMessage.user'])
            ->orderByDesc(
                Conversation::select('created_at')
                    ->from('messages')
                    ->whereColumn('conversation_id', 'conversations.id')
                    ->latest()
                    ->limit(1)
            )
            ->limit(5)
            ->get();

        $unreadCount = $user->unreadMessagesCount();

        return view('back.partials.messages-dropdown', compact('conversations', 'unreadCount'))->render();
    }
}
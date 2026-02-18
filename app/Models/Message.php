<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'conversation_id',
        'user_id',
        'body',
        'is_read',
        'file_path',
        'file_name',
        'file_type',
        'file_size'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'created_at' => 'datetime',
    ];

    // Relations
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accesseurs pour les fichiers
    public function getFileUrlAttribute()
    {
        return $this->file_path ? asset('storage/' . $this->file_path) : null;
    }

    public function getFileIconAttribute()
    {
        if (!$this->file_type) return 'fa-file';
        
        if (str_contains($this->file_type, 'image')) return 'fa-file-image';
        if (str_contains($this->file_type, 'video')) return 'fa-file-video';
        if (str_contains($this->file_type, 'pdf')) return 'fa-file-pdf';
        if (str_contains($this->file_type, 'word')) return 'fa-file-word';
        if (str_contains($this->file_type, 'excel')) return 'fa-file-excel';
        
        return 'fa-file';
    }

    public function getFormattedSizeAttribute()
    {
        if (!$this->file_size) return '';
        
        $size = $this->file_size;
        $units = ['o', 'Ko', 'Mo', 'Go'];
        $i = 0;
        
        while ($size >= 1024 && $i < 3) {
            $size /= 1024;
            $i++;
        }
        
        return round($size, 2) . ' ' . $units[$i];
    }

    public function getFormattedTimeAttribute()
    {
        return $this->created_at->format('H:i');
    }
}
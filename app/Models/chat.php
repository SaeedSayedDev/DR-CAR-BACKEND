<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by', 'name'
    ];

    public function participants()
    {
        return $this->hasMany(ChatParticipant::class, 'chat_id');
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'chat_id');
    }

    public function lastMessage()
    {
        return $this->hasOne(ChatMessage::class, 'chat_id')->latest('updated_at');
    }

    public function scopeHasParticipant($query, int $userId)
    {
        return $query->whereHas('participants', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });
    }

    public function scopeHasCountUnreadMessage($query)
    {
        // return;

        // return $query->where('created_by', 1)->count();
        return $query->whereHas('messages', function ($q) {
            $q->where('read', 0)->count();
        });
    }
    public function unreadMessages()
    {
        return $this->hasMany(ChatMessage::class, 'chat_id')->where('read', 0);
    }
}
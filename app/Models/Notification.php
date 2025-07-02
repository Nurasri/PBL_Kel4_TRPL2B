<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'title', 
        'message',
        'type',
        'action_url',
        'read_at'
    ];

    protected $casts = [
        'read_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function markAsRead()
    {
        $this->update(['read_at' => now()]);
    }

    public function isRead()
    {
        return !is_null($this->read_at);
    }

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function getTypeColorAttribute()
    {
        return match($this->type) {
            'success' => 'green',
            'warning' => 'yellow', 
            'danger' => 'red',
            default => 'blue'
        };
    }
}

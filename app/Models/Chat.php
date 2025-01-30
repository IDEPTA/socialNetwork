<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'senderId',
        'recipientId',
    ];

    // Связь с отправителем (пользователем)
    public function sender()
    {
        return $this->belongsTo(User::class, 'senderId');
    }

    // Связь с получателем (пользователем)
    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipientId');
    }

    //Связь с сообщением
    public function message()
    {
        return $this->hasMany(Message::class);
    }
}
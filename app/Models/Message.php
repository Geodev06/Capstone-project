<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = ['sender_id', 'sender_name', 'message_id', 'message', 'sender_type', 'sender_email'];
}

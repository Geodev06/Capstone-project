<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unread extends Model
{
    use HasFactory;
    protected $fillable = ['message_id', 'receiver_type'];
}

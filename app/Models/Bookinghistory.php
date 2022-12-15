<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookinghistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'payment_id',
        'booking_no',
        'user_id',
        'room_no'
    ];
}

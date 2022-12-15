<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'payment_id',
        'checker_name',
        'address',
        'email',
        'mobile',
        'target_date',
        'plan',
        'user_id',
        'room_no',
        'validity',
    ];
}

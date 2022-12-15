<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrance extends Model
{
    use HasFactory;
    protected $fillable = [
        'payment_id',
        'user_id',
        'target_date',
        'amount',
        'no_of_person',
        'status'
    ];
}

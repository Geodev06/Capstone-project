<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Establishment extends Model
{
    use HasFactory;

    protected $fillable = [
        'establishment_name',
        'establishment_address',
        'schedule',
        'contact',
        'email',
        'open',
        'close',
        'lat',
        'long',
    ];
}

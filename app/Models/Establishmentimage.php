<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Establishmentimage extends Model
{
    use HasFactory;
    protected $fillable = [
        'establishment_id',
        'image'
    ];
}

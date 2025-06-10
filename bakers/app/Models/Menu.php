<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
     protected $fillable = [
        'name',
        'description',
        'stock',
        'category',
        'price',
        'image',  // kalau ada upload gambar juga
    ];
}

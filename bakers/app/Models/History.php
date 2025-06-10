<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
     protected $fillable = ['user_id', 'menu_id', 'stock', 'price', 'status'];
     
    public function user() {
    return $this->belongsTo(User::class);
}

public function menu() {
    return $this->belongsTo(Menu::class);
}
}

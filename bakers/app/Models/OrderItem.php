<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Topping;


class OrderItem extends Model
{
    protected $fillable = ['order_id', 'menu_id', 'quantity'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
    public function order()
{
    return $this->belongsTo(Order::class);
}

public function toppings()
{
    return $this->belongsToMany(Topping::class, 'order_item_topping')->withTimestamps();
}

}

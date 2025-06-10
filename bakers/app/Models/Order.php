<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Order extends Model
{
    protected $fillable = ['user_id',' customer_name', 'status'];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function user()
{
    return $this->belongsTo(User::class);
}

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    protected static function booted()
{
    static::creating(function ($order) {
        do {
            $code = 'ORD-' . strtoupper(Str::random(6));
        } while (Order::where('order_code', $code)->exists());

        $order->order_code = $code;
    });
}

public function toppings()
{
    return $this->belongsToMany(Topping::class, 'order_topping', 'order_id', 'topping_id');
}


}

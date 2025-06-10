<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
  use App\Models\Order;
    use Illuminate\Support\Str;

    
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Artisan::command('generate:order-codes', function () {


    $orders = Order::whereNull('order_code')->orWhere('order_code', '')->get();

    foreach ($orders as $order) {
        do {
            $code = 'ORD-' . strtoupper(Str::random(6));
        } while (Order::where('order_code', $code)->exists());

        $order->order_code = $code;
        $order->save();
    }

    $this->info('Order codes generated successfully.');
});
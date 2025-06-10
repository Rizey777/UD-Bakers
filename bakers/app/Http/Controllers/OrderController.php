<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu;
use App\Models\Topping;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $order = Order::firstOrCreate(
            ['user_id' => $user->id, 'status' => 'pending'],
            ['kode_abstrak' => 'CUST-' . now()->format('Y') . '-USER' . str_pad($user->id, 4, '0', STR_PAD_LEFT) . '-' . strtoupper(Str::random(8))]
        );

        $order->load('items.menu', 'items.toppings');

        return view('order.index', compact('order'));
    }

    // Tambah menu ke keranjang (order pending)
    public function addToCart(Request $request, $menu_id)
    {
        $user_id = Auth::id();

        $order = Order::firstOrCreate(
            ['user_id' => $user_id, 'status' => 'pending'],
            ['kode_abstrak' => 'CUST-' . now()->format('Y') . '-USER' . str_pad($user_id, 4, '0', STR_PAD_LEFT) . '-' . strtoupper(Str::random(8))]
        );

        $menu = Menu::findOrFail($menu_id);

        if ($menu->stock < 1) {
            return back()->with('error', 'Stok menu habis!');
        }

        // Cari order item yang sudah ada
        $orderItem = $order->items()->where('menu_id', $menu_id)->first();

        if ($orderItem) {
            $orderItem->quantity += 1;
            $orderItem->save();
        } else {
            $orderItem = $order->items()->create([
                'menu_id' => $menu_id,
                'quantity' => 1,
                'price' => $menu->price, // simpan harga saat itu
            ]);
        }

        // Simpan topping jika ada (sinkron pivot tabel order_item_topping)
        if ($request->has('toppings')) {
            $orderItem->toppings()->sync($request->toppings);
        }

        return redirect()->route('order.index')->with('success', 'Menu berhasil ditambahkan ke keranjang');
    }

    // Update quantity item keranjang
    public function updateItem(Request $request, $orderId, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $order = Order::findOrFail($orderId);
        $orderItem = $order->items()->where('id', $itemId)->firstOrFail();

        $orderItem->quantity = $request->quantity;
        $orderItem->save();

        return back()->with('success', 'Jumlah item berhasil diperbarui.');
    }

    // Hapus item dari keranjang
    public function destroyItem($orderId, $itemId)
    {
        $order = Order::findOrFail($orderId);
        $orderItem = $order->items()->where('id', $itemId)->firstOrFail();

        $orderItem->delete();

        return back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    // Simpan nama pembeli ke order pending
    public function saveBuyerName(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
        ]);

        $userId = Auth::id();
        $order = Order::where('user_id', $userId)->where('status', 'pending')->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Order tidak ditemukan.');
        }

        $order->customer_name = $request->customer_name;
        $order->save();

        session(['customer_name' => $request->customer_name]);

        return redirect()->back()->with('success', 'Nama pembeli berhasil disimpan!');
    }

    // Tampilkan halaman konfirmasi order
    public function confirm($orderId)
    {
        $order = Order::with('items.menu', 'items.toppings')->findOrFail($orderId);
        return view('order.confirm', compact('order'));
    }

    // Checkout dan tandai order selesai + update stok menu
    public function success(Order $order)
    {
        foreach ($order->items as $item) {
            $menu = $item->menu;
            if ($menu) {
                $menu->stock = max(0, $menu->stock - $item->quantity);
                $menu->save();
            }
        }

        $order->status = 'paid';
        $order->save();

        return view('order.success', compact('order'));
    }

    // Untuk halaman cart (lihat item di keranjang)
    public function cart()
    {
        $userId = Auth::id();

        $order = Order::where('user_id', $userId)
                      ->where('status', 'pending')
                      ->with('items.menu', 'items.toppings')
                      ->first();

        if (!$order) {
            $order = Order::create([
                'user_id' => $userId,
                'status' => 'pending',
                'kode_abstrak' => 'CUST-' . now()->format('Y') . '-USER' . str_pad($userId, 4, '0', STR_PAD_LEFT) . '-' . strtoupper(Str::random(8)),
            ]);
        }

        $menus = Menu::all();

        return view('order.cart', compact('order', 'menus'));
    }

    // Generate kode order unik untuk order yang belum ada kode
    public function generateOrderCodes()
    {
        $orders = Order::whereNull('order_code')->orWhere('order_code', '')->get();

        foreach ($orders as $order) {
            do {
                $code = 'ORD-' . strtoupper(Str::random(6));
            } while (Order::where('order_code', $code)->exists());

            $order->order_code = $code;
            $order->save();
        }

        return "Order codes generated successfully.";
    }

  public function store(Request $request)
{
    $request->validate([
        'customer_name' => 'required|string|max:255',
    ]);

    $userId = Auth::id();

    // Ambil order yang sedang 'pending' milik user
    $order = Order::where('user_id', $userId)->where('status', 'pending')->first();

    if ($order) {
        // Jika nama berbeda, update nama
        if ($order->customer_name !== $request->customer_name) {
            $order->customer_name = $request->customer_name;

            // Jika belum ada kode_abstrak, buat baru
            if (!$order->kode_abstrak) {
                $order->kode_abstrak = 'CUST-' . now()->format('Y') . '-USER' .
                    str_pad($userId, 4, '0', STR_PAD_LEFT) . '-' .
                    strtoupper(Str::random(8));
            }

            $order->save();
        }
    } else {
        // Jika belum ada order pending, buat baru
        $order = Order::create([
            'user_id' => $userId,
            'status' => 'pending',
            'customer_name' => $request->customer_name,
            'kode_abstrak' => 'CUST-' . now()->format('Y') . '-USER' .
                str_pad($userId, 4, '0', STR_PAD_LEFT) . '-' .
                strtoupper(Str::random(8))
        ]);
    }

    // Simpan nama ke session agar bisa dipakai di halaman menu
    session(['customer_name' => $request->customer_name]);

    return redirect()->back()->with('success', 'Nama pembeli berhasil disimpan.');
}
protected function generateUniqueOrderCode()
    {
        do {
            $code = 'ORD-' . strtoupper(Str::random(8));
        } while (Order::where('order_code', $code)->exists());

        return $code;
    }
}

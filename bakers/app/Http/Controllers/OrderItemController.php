<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Topping;

class OrderItemController extends Controller
{
    // Tampilkan daftar item dari sebuah order
    public function index(Order $order)
    {
        // Ambil semua item terkait order ini (relasi orderItems)
        $items = $order->orderItems()->with('menu', 'toppings')->get();
        $order->load('items.menu', 'items.toppings');

        return view('order.index', compact('order', 'items'));
    }

    // Update quantity dan toppings item
    public function update(Request $request, $orderId, $itemId)
    {
        $orderItem = OrderItem::findOrFail($itemId);

        // Update quantity
        $orderItem->quantity = $request->input('quantity', $orderItem->quantity);
        $orderItem->save();

        // Update toppings
        if ($request->has('toppings')) {
            $orderItem->toppings()->sync($request->input('toppings'));
        } else {
            // Kosongkan relasi topping jika tidak ada yang dipilih
            $orderItem->toppings()->detach();
        }

        return redirect()->back()->with('success', 'Item berhasil diperbarui');
    }

    // Tambah item ke order
 public function store(Request $request, $orderId)
{
    $request->validate([
        'menu_id' => 'required|exists:menus,id',
        'quantity' => 'nullable|integer|min:1',
        'toppings' => 'nullable|string' // ini string kayak "1,2"
    ]);

    $orderItem = OrderItem::create([
        'order_id' => $orderId,
        'menu_id' => $request->menu_id,
        'quantity' => $request->quantity ?? 1,
    ]);

    // Simpan topping (jika ada)
    if ($request->filled('toppings')) {
        // ubah string "1,2,3" jadi array [1, 2, 3]
        $toppingIds = explode(',', $request->toppings);
        $orderItem->toppings()->attach($toppingIds);
    }

    return redirect()->route('order.index')->with('success', 'Menu ditambahkan ke keranjang!');
}



    // Hapus item dari order
    public function destroy(Order $order, OrderItem $item)
    {
        $item->delete();

        return redirect()->route('order.items', $order->id)
                         ->with('success', 'Item berhasil dihapus');
    }
}

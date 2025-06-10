<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Topping; // import model topping
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();

        // Ambil topping untuk dipilih di view
          $toppings = Topping::all()->unique('id');

        // Cek apakah ada order terakhir
        $order = Order::latest()->first();
        

        return view('menus.index', compact('menus', 'order', 'toppings'));
    }

    public function create()
    {
        return view('menus.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string|max:50',
            'price' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048', // max 2MB
        ]);

        // Upload gambar jika ada
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('menus', 'public');
            $validated['image'] = $path;
        }

        Menu::create($validated);

        return redirect()->route('menus.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    public function edit(Menu $menu)
    {
        return view('menus.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string|max:50',
            'price' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('name', 'stock', 'category', 'price', 'description');

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($menu->image) {
                Storage::disk('public')->delete($menu->image);
            }
            $path = $request->file('image')->store('menus', 'public');
            $data['image'] = $path;
        }

        $menu->update($data);

        return redirect()->route('menus.index')->with('success', 'Menu berhasil diperbarui');
    }

    public function destroy(Menu $menu)
    {
        // Hapus gambar jika ada
        if ($menu->image) {
            Storage::disk('public')->delete($menu->image);
        }

        $menu->delete();

        return redirect()->route('menus.index')->with('success', 'Menu berhasil dihapus');
    }
}

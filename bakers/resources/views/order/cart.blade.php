<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Keranjang Belanja</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto p-4">
        {{-- Tampilkan daftar menu --}}
        <h3 class="text-lg font-semibold mb-4">Daftar Menu</h3>
        <div class="grid grid-cols-3 gap-4 mb-6">
            @foreach($menus as $menu)
                <div class="border rounded p-4 text-center">
                    <h4 class="font-semibold">{{ $menu->name }}</h4>
                    <p>Rp{{ number_format($menu->price, 0, ',', '.') }}</p>
                    {{-- Tambah tombol untuk tambah ke keranjang --}}
                    <form action="{{ route('order.items.add', $order->id) }}" method="POST" class="mt-2">
                        @csrf
                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                        <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">Tambah ke Keranjang</button>
                    </form>
                </div>
            @endforeach
        </div>

        {{-- Tampilkan isi keranjang --}}
        <h3 class="text-lg font-semibold mb-4">Isi Keranjang</h3>
        @if($order->items->count() > 0)
            <table class="w-full border-collapse border border-gray-300 mb-4">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2">Nama Menu</th>
                        <th class="border border-gray-300 px-4 py-2">Qty</th>
                        <th class="border border-gray-300 px-4 py-2">Harga Satuan</th>
                        <th class="border border-gray-300 px-4 py-2">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($order->items as $item)
                        @php
                            $subtotal = $item->quantity * $item->menu->price;
                            $total += $subtotal;
                        @endphp
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">{{ $item->menu->name }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $item->quantity }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-right">Rp{{ number_format($item->menu->price, 0, ',', '.') }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-right">Rp{{ number_format($subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr class="font-bold">
                        <td colspan="3" class="border border-gray-300 px-4 py-2 text-right">Total</td>
                        <td class="border border-gray-300 px-4 py-2 text-right">Rp{{ number_format($total, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>

            <a href="{{ route('order.confirm', $order->id) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Lanjut Pembayaran →</a>
        @else
            <p>Keranjang masih kosong.</p>
        @endif
    </div>
</x-app-layout>

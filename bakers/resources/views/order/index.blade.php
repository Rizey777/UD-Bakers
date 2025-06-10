<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Keranjang Belanja</h2>
    </x-slot>

    <style>
        .max-w-4xl {
            background: #f9fafb;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            padding: 24px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #1f2937;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        thead tr {
            background-color: #3b82f6;
            color: white;
        }
        th, td {
            border: 1px solid #d1d5db;
            padding: 12px 16px;
            text-align: left;
        }
        tbody tr:nth-child(even) {
            background-color: #f3f4f6;
        }
        tbody tr:hover {
            background-color: #e0e7ff;
            transition: background-color 0.3s ease;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: 700; }

        button {
            cursor: pointer;
            font-weight: 600;
            border: none;
            padding: 8px 14px;
            border-radius: 6px;
            transition: background-color 0.3s ease;
            font-size: 0.9rem;
        }
        button.bg-blue-500 {
            background-color: #3b82f6;
            color: white;
        }
        button.bg-blue-500:hover {
            background-color: #2563eb;
        }
        button.bg-red-500 {
            background-color: #ef4444;
            color: white;
        }
        button.bg-red-500:hover {
            background-color: #dc2626;
        }

        a.bg-gray-300 {
            background-color: #d1d5db;
            color: #374151;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        a.bg-gray-300:hover {
            background-color: #9ca3af;
            color: white;
        }
        a.bg-green-500 {
            background-color: #22c55e;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        a.bg-green-500:hover {
            background-color: #16a34a;
        }
        .bg-green-100 {
            background-color: #d1fae5;
            color: #065f46;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-weight: 600;
            box-shadow: 0 2px 6px rgba(34, 197, 94, 0.3);
        }
    </style>

    <div class="max-w-4xl mx-auto p-4">
        @if(session('success'))
            <div class="bg-green-100">
                {{ session('success') }}
            </div>
        @endif

        @if($order->items->count() > 0)
            <div class="mb-4">
                <p><strong>Nama Pembeli:</strong> {{ session('customer_name') ?? $order->customer_name ?? 'Belum diisi' }}</p>
                <p><strong>ID Pembeli:</strong> {{ $order->kode_abstrak ?? 'Belum tersedia' }}</p>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Nama Menu</th>
                        <th>Toping</th> {{-- Kolom baru --}}
                        <th>Qty</th>
                        <th class="text-right">Harga Satuan</th>
                        <th class="text-right">Subtotal</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($order->items as $item)
                        @php
                            $menuPrice = $item->menu->price;
                            $toppingsPrice = $item->toppings->sum('price'); // total harga topping
                            $unitPrice = $menuPrice + $toppingsPrice; // harga per item + topping
                            $subtotal = $unitPrice * $item->quantity;
                            $total += $subtotal;
                        @endphp
                        <tr>
                            <td>
                                {{ $item->menu->name }}
                            </td>
                            <td>
                                @if($item->toppings->count() > 0)
                                    <ul style="list-style:none; padding-left:0; margin:0;">
                                        @foreach($item->toppings as $topping)
                                            <li>{{ $topping->name }} (Rp{{ number_format($topping->price, 0, ',', '.') }})</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <em>Tanpa toping</em>
                                @endif
                            </td>
                            <td class="text-center">
                                <form action="{{ route('order.items.update', [$order->id, $item->id]) }}" method="POST" class="flex items-center justify-center space-x-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="w-16 px-2 py-1 border rounded text-center" />
                                    <button type="submit" class="bg-blue-500">Update</button>
                                </form>
                            </td>
                           <td class="text-right">Rp{{ number_format($menuPrice, 0, ',', '.') }}</td> {{-- Harga menu asli --}}
<td class="text-right">Rp{{ number_format($subtotal, 0, ',', '.') }}</td> {{-- Total termasuk topping --}}

                            <td class="text-center">
                                <form action="{{ route('order.items.destroy', [$order->id, $item->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus item ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="font-bold">
                        <td colspan="4" class="text-right">Total</td>
                        <td class="text-right">Rp{{ number_format($total, 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="6" class="text-center">
                         <a href="{{ route('menus.index') }}"
    class="bg-blue-500 inline-block px-6 py-2 rounded text-white font-semibold hover:bg-blue-600 transition">
     + Tambah Menu
</a>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="flex justify-between">
                <a href="{{ route('menus.index') }}" class="bg-gray-300">← Kembali ke Menu</a>
                <a href="{{ route('order.confirm', $order->id) }}" class="bg-green-500">Lanjut Pembayaran →</a>
            </div>
        @else
            <p>Keranjang kosong.</p>
            <a href="{{ route('menus.index') }}" class="bg-blue-500 inline-block mt-4 px-6 py-2 rounded text-white font-semibold hover:bg-blue-600 transition">
                + Tambah Menu
            </a>
        @endif
    </div>
</x-app-layout>

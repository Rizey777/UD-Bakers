<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pembayaran Berhasil</h2>
    </x-slot>

    <div class="confirmation-container">
        <div class="header-section">
            <h3>Terima kasih atas pesanan Anda!</h3>
            <p>Berikut detail pesanan Anda:</p>
        </div>

        <div class="buyer-info">
            <p><strong>Nama Pembeli:</strong> {{ session('customer_name') ?? $order->customer_name ?? 'Belum diisi' }}</p>
            <p><strong>ID Pembeli:</strong> {{ $order->kode_abstrak ?? 'Belum tersedia' }}</p>
            <p><strong>Kode Pesanan:</strong> #{{ $order->id }}</p>
        </div>

        <table class="order-table">
            <thead>
                <tr>
                    <th>Nama Menu</th>
                    <th>Qty</th>
                    <th>Harga Satuan</th>
                    <th>Subtotal</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($order->items as $item)
                    @php
                        $toppingPrice = $item->toppings->sum('price');
                        $subtotal = ($item->menu->price + $toppingPrice) * $item->quantity;
                        $total += $subtotal;
                    @endphp
                    <tr>
                        <td>
                            {{ $item->menu->name }}
                            @if($item->toppings->count() > 0)
                                <ul style="margin: 0.25rem 0 0 1rem; padding: 0; list-style-type: disc; font-size: 0.875rem; color: #555;">
                                    @foreach($item->toppings as $topping)
                                        <li>{{ $topping->name }} (+Rp{{ number_format($topping->price, 0, ',', '.') }})</li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-right">Rp{{ number_format($item->menu->price, 0, ',', '.') }}</td>
                        <td class="text-right">Rp{{ number_format($subtotal, 0, ',', '.') }}</td>
                        <td>{{ $item->menu->description ?? '-' }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="4" class="text-right">Total</td>
                    <td class="text-right">Rp{{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="button-group">
            <a href="{{ route('menus.index') }}" class="btn btn-primary">Kembali ke Beranda</a>
            <a href="{{ route('history.index') }}" class="btn btn-secondary">Lihat Riwayat Pesanan</a>
        </div>
    </div>

    <style>
        .confirmation-container {
            max-width: 700px;
            margin: 2.5rem auto;
            padding: 2rem;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #374151;
        }
        .header-section {
            text-align: center;
            margin-bottom: 2rem;
        }
        .header-section h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #16a34a;
            margin-bottom: 0.5rem;
        }
        .header-section p {
            font-size: 1rem;
            color: #6b7280;
        }
        .buyer-info p {
            font-size: 1rem;
            margin: 0.25rem 0;
        }
        .order-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2rem;
            font-size: 1rem;
        }
        .order-table thead tr {
            background-color: #f3f4f6;
        }
        .order-table th,
        .order-table td {
            border: 1px solid #d1d5db;
            padding: 0.75rem 1rem;
            vertical-align: top;
        }
        .order-table th {
            font-weight: 600;
            text-align: left;
            color: #374151;
        }
        .order-table td.text-center {
            text-align: center;
        }
        .order-table td.text-right {
            text-align: right;
        }
        .order-table tbody tr:hover {
            background-color: #e0e7ff;
            transition: background-color 0.3s ease;
        }
        .total-row td {
            font-weight: 700;
            background-color: #f9fafb;
            color: #111827;
        }
        .button-group {
            text-align: center;
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .btn {
            display: inline-block;
            padding: 0.75rem 1.75rem;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            user-select: none;
            cursor: pointer;
            min-width: 150px;
            text-align: center;
        }
        .btn-primary {
            background-color: #2563eb;
            color: white;
        }
        .btn-primary:hover {
            background-color: #1d4ed8;
            box-shadow: 0 8px 20px rgba(29, 78, 216, 0.4);
        }
        .btn-secondary {
            background-color: #6b7280;
            color: white;
        }
        .btn-secondary:hover {
            background-color: #4b5563;
            box-shadow: 0 8px 20px rgba(75, 85, 99, 0.4);
        }
        @media (max-width: 480px) {
            .confirmation-container {
                padding: 1.5rem 1rem;
            }
            .button-group {
                flex-direction: column;
            }
            .btn {
                width: 100%;
                min-width: unset;
            }
        }
    </style>
</x-app-layout>

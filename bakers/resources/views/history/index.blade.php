<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Riwayat Pesanan</h2>
    </x-slot>

    <div class="history-container">
        <div class="text-right mb-4">
            <a href="{{ route('history.downloadPdf') }}" target="_blank" class="btn btn-green">
                Unduh PDF
            </a>
        </div>

        @forelse($histories as $order)
            <div class="order-card">
                <h3 class="order-code">Kode Pesanan: {{ $order->id }}</h3>
               <p><strong>Nama Pembeli:</strong> {{ $order->customer_name ?? 'Belum diisi' }}</p>
                 <p><strong>ID Pembeli:</strong> {{ $order->kode_abstrak ?? 'Belum tersedia' }}</p>

                <div class="order-table-wrapper">
                    <table class="order-table">
                        <thead>
                            <tr>
                                <th>Nama Menu</th>
                                <th>Toping</th>
                                <th>Qty</th>
                                <th>Harga Satuan</th>
                                <th>Subtotal</th>
                                <th>Waktu & Jam</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                                $total = 0; 
                                $itemCount = $order->items->count();
                            @endphp

                            @if($itemCount > 0)
                                @foreach($order->items as $item)
                                    @php
                                        $toppingPrice = $item->toppings->sum('price');
                                        $subtotal = ($item->menu->price + $toppingPrice) * $item->quantity;
                                        $total += $subtotal;
                                    @endphp
                                    <tr>
                                        <td>{{ $item->menu->name }}</td>
                                        <td>
                                            @if($item->toppings->count() > 0)
                                                <ul>
                                                    @foreach($item->toppings as $topping)
                                                        <li>{{ $topping->name }} (+Rp{{ number_format($topping->price, 0, ',', '.') }})</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <em>-</em>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-right">Rp{{ number_format($item->menu->price, 0, ',', '.') }}</td>
                                        <td class="text-right">Rp{{ number_format($subtotal, 0, ',', '.') }}</td>

                                        @if ($loop->first)
                                            <td class="text-center" rowspan="{{ $itemCount }}">
                                                {{ $order->created_at->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s') }}
                                            </td>
                                            <td class="text-center font-semibold" rowspan="{{ $itemCount }}">
                                                @if ($order->status == 'paid')
                                                    <span class="status success">Success</span>
                                                @elseif ($order->status == 'pending')
                                                    <span class="status pending">Pending</span>
                                                @elseif ($order->status == 'failed')
                                                    <span class="status failed">Gagal</span>
                                                @else
                                                    <span>{{ ucfirst($order->status) }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center" rowspan="{{ $itemCount }}">
                                                <form action="{{ route('history.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus pesanan ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-delete">Hapus</button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                                <tr class="total-row">
                                    <td colspan="4" class="text-right">Total</td>
                                    <td class="text-right">Rp{{ number_format($total, 0, ',', '.') }}</td>
                                    <td colspan="3"></td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada item pesanan.</td>
                                    <td colspan="2"></td>
                                    <td class="text-center">
                                        <form action="{{ route('history.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus pesanan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-delete">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <p class="empty-msg">Belum ada riwayat pesanan.</p>
        @endforelse

        <div class="text-center mt-6">
            <a href="{{ route('menus.index') }}" class="btn btn-blue">Kembali ke Beranda</a>
        </div>
    </div>

    <style>
        .history-container {
            max-width: 700px;
            margin: 2rem auto;
            padding: 1.5rem;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #374151;
            background-color: #f9fafb;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        }

        .order-table-wrapper {
            overflow-x: auto;
            margin-top: 1rem;
            border-radius: 0.75rem;
            box-shadow: inset 0 0 10px rgba(0,0,0,0.05);
        }

        .order-table {
            width: 100%;
            min-width: 600px;
            border-collapse: separate;
            border-spacing: 0 8px;
            font-size: 0.95rem;
            background-color: transparent;
        }

        .order-table thead tr {
            background-color: #3b82f6;
            color: white;
        }

        .order-table thead th {
            padding: 0.75rem 1rem;
            font-weight: 700;
            text-align: left;
            white-space: nowrap;
        }

        .order-table tbody tr {
            background-color: #f3f4f6;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: background-color 0.3s ease;
        }

        .order-table tbody tr:hover {
            background-color: #dbeafe;
        }

        .order-table td {
            padding: 0.75rem 1rem;
            vertical-align: middle;
            white-space: nowrap;
        }

        .order-table td ul {
            list-style-type: disc;
            margin: 0;
            padding-left: 1rem;
            color: #555;
            font-size: 0.85rem;
            white-space: normal;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .total-row td {
            font-weight: 700;
            background-color: #2563eb;
            color: white;
            border-radius: 0 0 1rem 1rem;
        }

        .status.success {
            color: #16a34a;
            background-color: #dcfce7;
            padding: 0.2rem 0.6rem;
            border-radius: 0.5rem;
        }

        .status.pending {
            color: #ca8a04;
            background-color: #fef9c3;
            padding: 0.2rem 0.6rem;
            border-radius: 0.5rem;
        }

        .status.failed {
            color: #dc2626;
            background-color: #fee2e2;
            padding: 0.2rem 0.6rem;
            border-radius: 0.5rem;
        }

        .btn {
            display: inline-block;
            padding: 0.5rem 1.25rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            cursor: pointer;
            user-select: none;
            border: none;
            color: white;
        }

        .btn-green {
            background-color: #16a34a;
        }

        .btn-green:hover {
            background-color: #15803d;
        }

        .btn-blue {
            background-color: #2563eb;
            margin-top: 1rem;
        }

        .btn-blue:hover {
            background-color: #1d4ed8;
        }

        .btn-delete {
            background-color: transparent;
            color: #dc2626;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: underline;
        }

        .btn-delete:hover {
            color: #b91c1c;
        }

        .empty-msg {
            text-align: center;
            color: #6b7280;
            font-size: 1.15rem;
            margin-top: 4rem;
        }

        @media (max-width: 700px) {
            .history-container {
                padding: 1rem;
                margin: 1rem;
            }
        }
    </style>
</x-app-layout>

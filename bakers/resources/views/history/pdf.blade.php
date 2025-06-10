<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Riwayat Pesanan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #999;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #eee;
        }
        h2 {
            text-align: center;
        }
        ul {
            margin: 0;
            padding-left: 1rem;
            font-size: 11px;
        }
    </style>
</head>
<body>

<h2>Riwayat Pesanan</h2>

@forelse($histories as $order)
    <h4>Kode Pesanan: {{ $order->id }}</h4>
    <p><strong>Nama Pembeli:</strong> {{ $order->customer_name ?? 'Belum diisi' }}</p>
   <p><strong>ID Pembeli:</strong> {{ $order->kode_abstrak ?? 'Belum tersedia' }}</p>

    <table>
        <thead>
            <tr>
                <th>Nama Menu</th>
                <th>Toping</th>
                <th>Qty</th>
                <th>Harga Satuan</th>
                <th>Subtotal</th>
                <th>Waktu & Jam</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($order->items as $item)
                @php
                    $toppingTotal = $item->toppings->sum('price');
                    $subtotal = ($item->menu->price + $toppingTotal) * $item->quantity;
                    $total += $subtotal;
                @endphp
                <tr>
                    <td>{{ $item->menu->name }}</td>
                    <td>
                        @if ($item->toppings->count() > 0)
                            <ul>
                                @foreach ($item->toppings as $topping)
                                    <li>{{ $topping->name }} (+Rp{{ number_format($topping->price, 0, ',', '.') }})</li>
                                @endforeach
                            </ul>
                        @else
                            <em>-</em>
                        @endif
                    </td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rp{{ number_format($item->menu->price, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($subtotal, 0, ',', '.') }}</td>

                    @if ($loop->first)
                        <td rowspan="{{ $order->items->count() }}">
                            {{ $order->created_at->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s') }}
                        </td>
                        <td rowspan="{{ $order->items->count() }}">
                            @if ($order->status == 'paid')
                                Success
                            @elseif ($order->status == 'pending')
                                Pending
                            @elseif ($order->status == 'failed')
                                Gagal
                            @else
                                {{ ucfirst($order->status) }}
                            @endif
                        </td>
                    @endif
                </tr>
            @endforeach
            <tr>
                <td colspan="4" style="text-align: right;"><strong>Total</strong></td>
                <td><strong>Rp{{ number_format($total, 0, ',', '.') }}</strong></td>
                <td colspan="2"></td>
            </tr>
        </tbody>
    </table>
@empty
    <p>Tidak ada data pesanan.</p>
@endforelse

</body>
</html>

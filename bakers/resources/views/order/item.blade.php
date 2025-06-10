<x-app-layout>
    <x-slot name="header">
        <h2>Detail Pesanan #{{ $order->id }}</h2>
    </x-slot>

    <div style="max-width: 700px; margin: 20px auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: #f3f4f6;">
                    <th style="padding: 8px; border: 1px solid #ddd;">Menu</th>
                    <th style="padding: 8px; border: 1px solid #ddd;">Jumlah</th>
                    <th style="padding: 8px; border: 1px solid #ddd;">Harga (Rp)</th>
                    <th style="padding: 8px; border: 1px solid #ddd;">Subtotal (Rp)</th>
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
                        <td style="padding: 8px; border: 1px solid #ddd;">{{ $item->menu->name }}</td>
                        <td style="padding: 8px; border: 1px solid #ddd; text-align: center;">{{ $item->quantity }}</td>
                        <td style="padding: 8px; border: 1px solid #ddd; text-align: right;">{{ number_format($item->menu->price) }}</td>
                        <td style="padding: 8px; border: 1px solid #ddd; text-align: right;">{{ number_format($subtotal) }}</td>
                    </tr>
                @endforeach
                <tr style="font-weight: bold; background-color: #f9fafb;">
                    <td colspan="3" style="padding: 8px; border: 1px solid #ddd; text-align: right;">Total</td>
                    <td style="padding: 8px; border: 1px solid #ddd; text-align: right;">{{ number_format($total) }}</td>
                </tr>
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            <a href="{{ route('orders.confirm', $order->id) }}" 
               style="background-color: #3b82f6; color: white; padding: 10px 16px; border-radius: 6px; text-decoration: none; font-weight: 600;">
                Konfirmasi Pembayaran
            </a>
        </div>
    </div>
</x-app-layout>

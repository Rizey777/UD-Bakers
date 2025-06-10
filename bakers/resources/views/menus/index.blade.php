<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <h2 style="margin: 0 auto; text-align: center; flex-grow: 1; font-weight: 700; font-size: 1.5rem;">
                Daftar Menu
            </h2>
            

            <a href="{{ route('history.index') }}"
               style="background-color: #60a5fa; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-weight: 600; margin-left: 12px;">
                Riwayat Pesanan
            </a>

            <a href="{{ url('/menus/create') }}"
               style="background-color: #3b82f6; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-weight: 600;">
                Tambah Barang
            </a>
        </div>
    </x-slot>

    @php
        date_default_timezone_set('Asia/Jakarta');
        $nowTime = date('H:i');
        $canBuy = ($nowTime >= '07:30' && $nowTime <= '16:00');
    @endphp

    <style>
        /* CSS halaman menu */
        .menu-list {
            display: flex;
            flex-wrap: wrap;
            gap: 24px;
            justify-content: center;
        }

        .menu-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            width: 260px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .menu-card img,
        .menu-card .no-image {
            width: 100%;
            height: 160px;
            object-fit: cover;
            display: block;
        }

        .menu-card .no-image {
            background: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #9ca3af;
            font-style: italic;
        }

        .menu-card-content {
            padding: 16px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .menu-card-content h3 {
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 4px;
            text-align: center;
        }

        .menu-card-content p.description {
            font-size: 0.9rem;
            font-style: italic;
            color: #555;
            min-height: 50px;
        }

        .menu-card-content p.detail {
            font-size: 0.9rem;
            margin: 4px 0;
        }

        .menu-card-content p.price {
            font-weight: 600;
            font-size: 1rem;
            margin: 4px 0 12px 0;
        }

        .menu-card-content button[type="submit"] {
            background-color: #10b981;
            color: white;
            border: none;
            padding: 8px;
            width: 100%;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(16,185,129,0.3);
            margin-top: 12px;
        }

        .menu-card-content button[disabled] {
            background-color: #d1d5db;
            cursor: not-allowed;
            box-shadow: none;
        }

        .menu-card-content .actions {
            margin-top: 12px;
            display: flex;
            justify-content: space-between;
        }

        .menu-card-content .actions a,
        .menu-card-content .actions button {
            font-weight: 600;
            font-size: 0.9rem;
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            text-decoration: none;
        }

        .menu-card-content .actions a {
            color: #3b82f6;
        }

        .menu-card-content .actions button {
            color: #ef4444;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            padding: 10px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .time-info {
            background-color: #fefce8;
            border: 1px solid #fde68a;
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 24px;
            text-align: center;
            font-weight: 600;
            color: #92400e;
        }

        /* CSS form simpan nama pembeli */
        .buyer-form {
            text-align: center;
            margin-bottom: 24px;
        }

        .buyer-form form {
            display: inline-flex;
            gap: 8px;
            align-items: center;
        }

        .buyer-form input[type="text"] {
            padding: 10px 14px;
            width: 280px;
            border: 1.5px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .buyer-form input[type="text"]:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 6px rgba(59, 130, 246, 0.5);
        }

        .buyer-form button[type="submit"] {
            background-color: #3b82f6;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 3px 8px rgba(59, 130, 246, 0.5);
            transition: background-color 0.3s ease;
        }

        .buyer-form button[type="submit"]:hover {
            background-color: #2563eb;
        }

        .buyer-form button[type="submit"]:active {
            background-color: #1d4ed8;
        }

       /* Tambahan CSS topping yang lebih rapi */
.toppings-container {
    margin: 8px 0 12px 0;
    padding: 12px;
    border: 1.5px solid #d1d5db;
    border-radius: 8px;
    background-color: #f9fafb;
    max-height: 140px;
    overflow-y: auto;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 8px;
}

.toppings-container label {
    display: flex;
    align-items: center;
    gap: 8px;
    background-color: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    padding: 6px 10px;
    font-size: 0.9rem;
    font-weight: 500;
    color: #374151;
    transition: all 0.2s ease;
    cursor: pointer;
}

.toppings-container label:hover {
    background-color: #f3f4f6;
    border-color: #3b82f6;
}

.topping-item input[type="checkbox"] {
    width: 16px;
    height: 16px;
    accent-color: #3b82f6;
    cursor: pointer;
}

        .total-price {
            font-weight: 700;
            font-size: 1.1rem;
            text-align: center;
            margin-top: 8px;
            color: #059669;
        }
    </style>

    <div style="padding: 30px 20px; background: linear-gradient(to bottom right, #f0f9ff, #e0f2fe); min-height: 100vh;">
        <div style="max-width: 1100px; margin: 0 auto;">

            {{-- Keterangan waktu --}}
            <div class="time-info">
                Waktu saat ini: <strong>{{ date('H:i:s') }}</strong> -
                <span style="color: {{ $canBuy ? '#15803d' : '#b91c1c' }};">
                    {{ $canBuy ? 'Toko Buka (07:30 - 16:00)' : 'Toko Tutup' }}
                </span>
            </div>

            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Input nama pembeli --}}
           <div class="buyer-form">
    <form method="POST" action="{{ route('order.store') }}">
        @csrf
        <input type="text" name="customer_name" value="{{ session('customer_name', old('customer_name')) }}" placeholder="Masukkan nama pembeli..." required>
        <button type="submit">Simpan Nama</button>
    </form>
</div>

{{-- Daftar Menu --}}
<div class="menu-list">
    @foreach($menus as $menu)
        <div class="menu-card" data-menu-id="{{ $menu->id }}">
            {{-- Gambar --}}
            @if($menu->image)
    <img src="{{ asset('images/' . $menu->image) }}" alt="{{ $menu->name }}">
@else
    <div class="no-image">Gambar tidak tersedia</div>
@endif


            <div class="menu-card-content">
                <h3>{{ $menu->name }}</h3>
                <p class="description">{{ $menu->description ?? 'Tidak ada deskripsi' }}</p>
                <p class="detail">Stok: {{ $menu->stock }}</p>
                <p class="detail">Kategori: {{ ucfirst($menu->category) }}</p>
                <p class="price base-price">Harga dasar: Rp{{ number_format($menu->price, 0, ',', '.') }}</p>

                {{-- Form pembelian --}}
                <form action="{{ route('order.add', $menu->id) }}" method="POST" class="buy-form">
                    @csrf
                    <input type="hidden" name="customer_name" value="{{ session('customer_name') }}">

                    {{-- Pilih topping --}}
                    <div class="toppings-container">
                                    <label style="font-weight: 600; margin-bottom: 6px; display: block;">Pilih Topping:</label>
                                    @foreach($toppings as $index => $topping)
                                        <label class="topping-item" for="topping-{{ $menu->id }}-{{ $index }}">
                                            <input type="checkbox"
                                                   id="topping-{{ $menu->id }}-{{ $index }}"
                                                   class="topping-checkbox"
                                                   data-price="{{ $topping->price }}"
                                                   name="toppings[]"
                                                   value="{{ $topping->id }}">
                                            {{ $topping->name }} (Rp{{ number_format($topping->price, 0, ',', '.') }})
                                        </label>
                                    @endforeach
                                </div>

                    <p class="total-price">Total Harga: Rp{{ number_format($menu->price, 0, ',', '.') }}</p>

                    <button type="submit"
                        {{ ($menu->stock < 1 || !$canBuy || !session('customer_name')) ? 'disabled' : '' }}>
                        @if($menu->stock < 1)
                            Stok Habis
                        @elseif(!$canBuy)
                            Diluar Jam Beli
                        @elseif(!session('customer_name'))
                            Isi Nama Dulu
                        @else
                            Beli
                        @endif
                    </button>
                </form>

                {{-- Aksi admin --}}
                <div class="actions">
                    <a href="{{ route('menus.edit', $menu->id) }}">Edit</a>
                    <form action="{{ route('menus.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus menu ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>

        </div>
    </div>

    <script>
        document.querySelectorAll('.menu-card').forEach(function(card){
    const basePriceEl = card.querySelector('.base-price');
    const basePrice = parseInt(basePriceEl.textContent.replace(/[^0-9]/g, ''));
    const totalPriceEl = card.querySelector('.total-price');
    const checkboxes = card.querySelectorAll('.topping-checkbox');

    function updateTotalPrice() {
        let toppingTotal = 0;

        checkboxes.forEach(function(box){
            if(box.checked) {
                toppingTotal += parseInt(box.getAttribute('data-price'));
            }
        });

        const newTotal = basePrice + toppingTotal;
        totalPriceEl.textContent = 'Total Harga: Rp' + newTotal.toLocaleString('id-ID');
    }

    checkboxes.forEach(function(box){
        box.addEventListener('change', updateTotalPrice);
    });

    updateTotalPrice();
});

    </script>
</x-app-layout>

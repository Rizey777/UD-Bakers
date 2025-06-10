<x-app-layout>
    <x-slot name="header">
        <h2>Tambah Menu Baru</h2>
    </x-slot>

    <style>
        form {
            max-width: 480px;
            margin: 20px auto;
            background: #f9fafb;
            padding: 24px 32px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        form label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
            color: #374151; /* abu gelap */
        }
        form input[type="text"],
        form input[type="number"],
        form textarea,
        form input[type="file"] {
            width: 100%;
            padding: 10px 14px;
            margin-bottom: 18px;
            border: 1.8px solid #d1d5db; /* abu terang */
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
            font-family: inherit;
            resize: vertical;
        }
        form input[type="text"]:focus,
        form input[type="number"]:focus,
        form textarea:focus,
        form input[type="file"]:focus {
            outline: none;
            border-color: #3b82f6; /* biru */
            box-shadow: 0 0 6px rgba(59,130,246,0.4);
            background-color: #ffffff;
        }
        form button {
            background-color: #3b82f6;
            color: white;
            padding: 12px 28px;
            border-radius: 8px;
            border: none;
            font-weight: 700;
            font-size: 1.1rem;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(59,130,246,0.3);
            transition: background-color 0.3s ease;
            width: 100%;
        }
        form button:hover {
            background-color: #2563eb; /* biru lebih gelap */
        }
        a {
            display: inline-block;
            margin-top: 12px;
            color: #6b7280;
            font-weight: 600;
            text-decoration: none;
            font-size: 1rem;
            transition: color 0.3s ease;
        }
        a:hover {
            color: #374151;
        }
        /* Styling untuk pesan error */
        div[style*="color: red;"] ul {
            list-style-type: none;
            padding-left: 0;
            margin-top: 0;
            color: #b91c1c; /* merah */
            font-weight: 600;
        }
        div[style*="color: red;"] ul li {
            margin-bottom: 6px;
        }
    </style>

    <div>
        @if ($errors->any())
            <div style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('menus.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div>
                <label>Nama Menu:</label><br>
                <input type="text" name="name" value="{{ old('name') }}" required>
            </div>
            <div>
                <label>Deskripsi:</label><br>
                <textarea name="description" rows="3">{{ old('description') }}</textarea>
            </div>
            <div>
                <label>Stok:</label><br>
                <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0" required>
            </div>
            <div>
    <label>Kategori:</label><br>
    <select name="category" required style="width: 100%; padding: 10px 14px; border: 1.8px solid #d1d5db; border-radius: 8px; font-size: 1rem; font-family: inherit;">
        <option value="" disabled {{ old('category') ? '' : 'selected' }}>-- Pilih Kategori --</option>
        <option value="basah" {{ old('category') == 'basah' ? 'selected' : '' }}>Basah</option>
        <option value="kering" {{ old('category') == 'kering' ? 'selected' : '' }}>Kering</option>
    </select>
</div>
            <div>
                <label>Harga (Rp):</label><br>
                <input type="number" name="price" value="{{ old('price', 0) }}" min="0" required>
            </div>
            <div>
                <label>Gambar (opsional):</label><br>
                <input type="file" name="image" accept="image/*">
            </div>
            <br>
            <button type="submit">
                Simpan
            </button>
            <a href="{{ route('menus.index') }}">Batal</a>
        </form>
    </div>
</x-app-layout>

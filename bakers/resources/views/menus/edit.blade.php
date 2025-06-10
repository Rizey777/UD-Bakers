<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 1.5rem; font-weight: bold; text-align: center;">Edit Menu</h2>
    </x-slot>

    <style>
        .form-container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
            font-family: 'Segoe UI', sans-serif;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            font-weight: 600;
            display: block;
            margin-bottom: 6px;
            color: #374151;
        }

        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group input[type="file"] {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #d1d5db;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-group input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
            outline: none;
        }

        .form-group img {
            margin-top: 8px;
            border-radius: 6px;
        }

        .btn-submit {
            background-color: #3b82f6;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-submit:hover {
            background-color: #2563eb;
        }

        .btn-cancel {
            margin-left: 12px;
            color: #6b7280;
            text-decoration: none;
            font-weight: 500;
        }

        .btn-cancel:hover {
            text-decoration: underline;
        }

        .error-message {
            background-color: #fee2e2;
            border: 1px solid #fca5a5;
            color: #b91c1c;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .error-message ul {
            margin: 0;
            padding-left: 20px;
        }
    </style>

    <div class="form-container">
        @if ($errors->any())
            <div class="error-message">
                <strong>Terjadi kesalahan:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('menus.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nama Menu</label>
                <input type="text" name="name" value="{{ old('name', $menu->name) }}" required>
            </div>

            <div class="form-group">
                <label>Stok</label>
                <input type="number" name="stock" value="{{ old('stock', $menu->stock) }}" min="0" required>
            </div>

            <div class="form-group">
                <label>Kategori (Basah/Kering)</label>
                <input type="text" name="category" value="{{ old('category', $menu->category) }}" required>
            </div>

            <div class="form-group">
                <label>Harga (Rp)</label>
                <input type="number" name="price" value="{{ old('price', $menu->price) }}" min="0" required>
            </div>

            <div class="form-group">
                <label>Gambar (opsional)</label>
                @if($menu->image)
                    <img src="{{ asset('storage/'.$menu->image) }}" width="150" alt="Gambar menu">
                @endif
                <input type="file" name="image" accept="image/*">
            </div>

            <div style="margin-top: 24px;">
                <button type="submit" class="btn-submit">Update</button>
                <a href="{{ route('menus.index') }}" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>

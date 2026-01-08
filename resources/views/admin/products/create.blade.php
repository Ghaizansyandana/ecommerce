<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk Baru - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="max-w-4xl mx-auto py-10 px-4">
        <div class="mb-6">
            <a href="/admin/products" class="text-blue-600 hover:underline text-sm">← Kembali ke Daftar Produk</a>
            <h1 class="text-2xl font-bold text-gray-800 mt-2">Tambah Produk Baru</h1>
        </div>

        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="/admin/products" method="POST" enctype="multipart/form-data">
                @csrf 
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                        <input type="text" name="name" class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: Kopi Susu" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
                        <input type="number" name="price" class="w-full border border-gray-300 rounded-md p-2" placeholder="0" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                            <input type="number" name="stock" class="w-full border border-gray-300 rounded-md p-2" placeholder="0" min="0" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Berat (gram)</label>
                            <input type="number" name="weight" class="w-full border border-gray-300 rounded-md p-2" placeholder="0" min="1" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select name="category_id" class="w-full border border-gray-300 rounded-md p-2" required>
                            <option value="" disabled selected>Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Produk</label>
                        <textarea name="description" rows="4" class="w-full border border-gray-300 rounded-md p-2" required></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Foto Produk</label>
                        <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-md transition duration-200">
                            Simpan Produk
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
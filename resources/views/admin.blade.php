<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Tokokopi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;500;600;700&family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
        .form-card { transition: all 0.3s ease; }
        .form-card:focus-within { box-shadow: 0 8px 30px rgba(120,53,15,0.12); }
        .table-row { transition: all 0.2s ease; }
        .table-row:hover { background: #FEF3C7; }
        .action-btn { transition: all 0.2s ease; }
        .action-btn:hover { transform: translateY(-1px); }
        .action-btn:active { transform: scale(0.95); }
    </style>
</head>
<body class="bg-coffee-50 font-sans min-h-screen">
    <nav class="bg-coffee-800 shadow-lg sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <span class="text-2xl">☕</span>
                <h1 class="text-lg font-caveat text-coffee-100">Tokokopi</h1>
                <span class="text-xs bg-coffee-600 text-coffee-200 px-2 py-0.5 rounded-full">Admin</span>
            </div>
            <div class="flex items-center gap-3">
                <a href="/" class="text-coffee-200 hover:text-coffee-100 text-sm transition-colors px-3 py-1.5 rounded-lg hover:bg-coffee-700/50">Kasir</a>
                <span class="text-sm text-coffee-300">{{ Auth::user()->name }}</span>
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" class="text-red-300 hover:text-red-200 text-sm transition-colors px-3 py-1.5 rounded-lg hover:bg-red-800/30">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto px-4 py-8">
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm animate-fade-up flex items-center gap-2">
                <svg class="w-5 h-5 shrink-0 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="flex items-center gap-3 mb-8">
            <div class="h-1 flex-1 bg-gradient-to-r from-coffee-300 via-coffee-400 to-coffee-300 rounded-full"></div>
            <h2 class="text-sm font-semibold text-coffee-700 tracking-widest uppercase">Manajemen Produk</h2>
            <div class="h-1 flex-1 bg-gradient-to-r from-coffee-300 via-coffee-400 to-coffee-300 rounded-full"></div>
        </div>

        <div class="bg-white rounded-2xl shadow-md p-6 mb-8 border border-coffee-100 form-card animate-fade-up">
            <h3 class="font-bold text-coffee-800 mb-5 flex items-center gap-2">
                <svg class="w-5 h-5 text-coffee-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                <span id="formTitle">Tambah Produk Baru</span>
            </h3>
            <form method="POST" action="/admin/products" id="productForm" enctype="multipart/form-data">
                @csrf
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <label for="nama_kopi" class="block text-sm font-semibold text-coffee-600 mb-1.5">Nama Kopi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-coffee-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                            </div>
                            <input type="text" name="nama_kopi" id="nama_kopi"
                                   class="w-full pl-10 pr-4 py-3 bg-coffee-50 border border-coffee-200 rounded-xl text-coffee-900 placeholder-coffee-400 focus:ring-2 focus:ring-coffee-400 focus:border-coffee-400 outline-none transition-all"
                                   placeholder="Espresso" required>
                        </div>
                        @error('nama_kopi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="flex-1">
                        <label for="harga" class="block text-sm font-semibold text-coffee-600 mb-1.5">Harga (Rp)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-coffee-400 font-semibold">Rp</span>
                            </div>
                            <input type="number" name="harga" id="harga" min="0"
                                   class="w-full pl-10 pr-4 py-3 bg-coffee-50 border border-coffee-200 rounded-xl text-coffee-900 placeholder-coffee-400 focus:ring-2 focus:ring-coffee-400 focus:border-coffee-400 outline-none transition-all"
                                   placeholder="25000" required>
                        </div>
                        @error('harga') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="flex-1">
                        <label for="foto" class="block text-sm font-semibold text-coffee-600 mb-1.5">Foto Produk (Opsional)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-coffee-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <input type="file" name="foto" id="foto" accept="image/*"
                                   class="w-full pl-10 pr-4 py-2.5 bg-coffee-50 border border-coffee-200 rounded-xl text-coffee-900 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-coffee-700 file:text-white hover:file:bg-coffee-600 focus:ring-2 focus:ring-coffee-400 focus:border-coffee-400 outline-none transition-all">
                        </div>
                        @error('foto') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" id="submitBtn"
                                class="bg-gradient-to-r from-coffee-700 to-coffee-800 text-white py-3 px-8 rounded-xl font-bold text-sm tracking-wider transition-all duration-300 hover:from-coffee-600 hover:to-coffee-700 hover:shadow-lg hover:shadow-coffee-300/30 active:scale-[0.98]">
                            Simpan
                        </button>
                        <button type="button" id="cancelBtn" onclick="resetForm()"
                                class="hidden py-3 px-4 rounded-xl text-sm text-coffee-500 hover:text-coffee-700 transition-colors">
                            Batal
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-coffee-100 animate-fade-up">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-coffee-800 text-coffee-100">
                            <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider">No</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider">Foto</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider">Nama Kopi</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider">Harga</th>
                            <th class="px-5 py-4 text-right text-xs font-semibold uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-coffee-100">
                        @forelse ($products as $product)
                            <tr class="table-row animate-fade-in" style="animation-delay: {{ $loop->index * 0.05 }}s">
                                <td class="px-5 py-4 text-sm text-coffee-500 font-medium">{{ $loop->iteration }}</td>
                                <td class="px-5 py-4">
                                    <div class="w-12 h-12 rounded-lg bg-coffee-100 border border-coffee-200 overflow-hidden flex items-center justify-center">
                                        @if($product->foto)
                                            <img src="{{ asset('storage/' . $product->foto) }}" alt="{{ $product->nama_kopi }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-xl">☕</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-sm font-semibold text-coffee-800">{{ $product->nama_kopi }}</td>
                                <td class="px-5 py-4 text-sm font-bold text-coffee-600">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                                <td class="px-5 py-4 text-sm text-right">
                                    <div class="flex gap-2 justify-end">
                                        <button onclick="editProduct({{ $product->id }}, '{{ $product->nama_kopi }}', {{ $product->harga }})"
                                                class="action-btn px-3 py-1.5 bg-yellow-50 text-yellow-700 rounded-lg text-xs font-semibold hover:bg-yellow-100 border border-yellow-200">
                                            Edit
                                        </button>
                                        <form method="POST" action="/admin/products/{{ $product->id }}" onsubmit="return confirm('Hapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="action-btn px-3 py-1.5 bg-red-50 text-red-600 rounded-lg text-xs font-semibold hover:bg-red-100 border border-red-200">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-12 text-center text-coffee-400">
                                    <span class="text-4xl block mb-2">📋</span>
                                    Belum ada produk. Tambahkan produk pertama Anda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function editProduct(id, nama_kopi, harga) {
            const form = document.getElementById('productForm');
            form.action = '/admin/products/' + id;
            let methodInput = form.querySelector('input[name="_method"]');
            if (!methodInput) {
                methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                form.appendChild(methodInput);
            }
            methodInput.value = 'PUT';

            document.getElementById('nama_kopi').value = nama_kopi;
            document.getElementById('harga').value = harga;
            document.getElementById('formTitle').textContent = 'Edit Produk';
            document.getElementById('submitBtn').textContent = 'Perbarui';
            document.getElementById('cancelBtn').classList.remove('hidden');
        }

        function resetForm() {
            const form = document.getElementById('productForm');
            form.action = '/admin/products';
            const methodInput = form.querySelector('input[name="_method"]');
            if (methodInput) methodInput.value = 'POST';

            document.getElementById('productForm').reset();
            document.getElementById('formTitle').textContent = 'Tambah Produk Baru';
            document.getElementById('submitBtn').textContent = 'Simpan';
            document.getElementById('cancelBtn').classList.add('hidden');
        }
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tokokopi - Kasir Kopi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;500;600;700&family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
        .cart-item-enter { animation: slide-in-right 0.3s ease-out both; }
        .btn-pay:not(:disabled):hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(251,191,36,0.4); }
        .btn-pay:not(:disabled):active { transform: translateY(0); }
        .product-card:hover { transform: translateY(-6px); box-shadow: 0 16px 40px rgba(120,53,15,0.15); border-color: #FBBF24; }
        .product-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .product-card:active { transform: scale(0.97); }
        .qty-btn { transition: all 0.2s ease; }
        .qty-btn:hover { background: #FBBF24; color: #451A03; }
        .qty-btn:active { transform: scale(0.9); }
        .badge-pop { animation: bounce-in 0.4s ease-out; }
    </style>
</head>
<body class="bg-coffee-50 font-sans min-h-screen">
    <nav class="bg-coffee-800 shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center gap-3 animate-fade-in">
                <span class="text-3xl font-caveat text-coffee-200 font-bold">☕</span>
                <div>
                    <h1 class="text-xl font-caveat text-coffee-100 leading-none">Tokokopi</h1>
                    <p class="text-[10px] text-coffee-300 tracking-widest uppercase">Kasir Kopi</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="/admin" class="text-coffee-200 hover:text-coffee-100 text-sm transition-colors duration-200 px-3 py-1.5 rounded-lg hover:bg-coffee-700/50">Admin</a>
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" class="text-red-300 hover:text-red-200 text-sm transition-colors duration-200 px-3 py-1.5 rounded-lg hover:bg-red-800/30">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-6 flex gap-6 items-start">
        <div class="flex-1">
            <div class="flex items-center gap-3 mb-6">
                <div class="h-1 flex-1 bg-gradient-to-r from-coffee-300 via-coffee-400 to-coffee-300 rounded-full"></div>
                <h2 class="text-sm font-semibold text-coffee-700 tracking-widest uppercase">Menu Kopi</h2>
                <div class="h-1 flex-1 bg-gradient-to-r from-coffee-300 via-coffee-400 to-coffee-300 rounded-full"></div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @forelse ($products as $i => $product)
                    <button onclick="addToCart({{ $product->id }}, '{{ $product->nama_kopi }}', {{ $product->harga }})"
                            class="product-card bg-white rounded-2xl shadow-md p-5 text-left border-2 border-transparent cursor-pointer group">
                        <div class="w-full aspect-square bg-coffee-100 rounded-xl flex items-center justify-center mb-3 group-hover:bg-coffee-200 transition-colors duration-300 overflow-hidden border border-coffee-100">
                            @if($product->foto)
                                <img src="{{ asset('storage/' . $product->foto) }}" alt="{{ $product->nama_kopi }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-3xl">☕</span>
                            @endif
                        </div>
                        <h3 class="font-bold text-coffee-900 text-sm group-hover:text-coffee-700 transition-colors">{{ $product->nama_kopi }}</h3>
                        <p class="text-coffee-500 font-bold mt-1 text-lg">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                        <div class="mt-2 flex items-center gap-1 text-xs text-coffee-400">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            <span>Klik untuk tambah</span>
                        </div>
                    </button>
                @empty
                    <div class="col-span-full text-center py-16 animate-fade-up">
                        <span class="text-6xl">☕</span>
                        <p class="text-coffee-500 mt-4">Belum ada menu kopi.</p>
                        <a href="/login" class="mt-3 inline-block bg-coffee-700 text-white px-6 py-2 rounded-full text-sm hover:bg-coffee-600 transition">Login Admin</a>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="w-80 lg:w-96 sticky top-24">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-coffee-100">
                <div class="bg-coffee-800 px-5 py-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-coffee-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                        <h2 class="font-bold text-coffee-100">Pesanan</h2>
                    </div>
                </div>
                <div id="cartItems" class="p-5 min-h-[160px] space-y-3">
                    <div id="emptyCart" class="text-center py-8">
                        <span class="text-4xl block mb-2 opacity-30">🛒</span>
                        <p class="text-coffee-300 text-sm">Belum ada item.</p>
                        <p class="text-coffee-200 text-xs mt-1">Klik menu kopi untuk mulai</p>
                    </div>
                    <div id="cartList" class="space-y-3 hidden"></div>
                </div>

                <div class="border-t border-coffee-100 px-5 py-4">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-coffee-600 font-semibold">Total</span>
                        <span id="totalDisplay" class="text-2xl font-bold text-coffee-800">Rp 0</span>
                    </div>
                    <form method="POST" action="/nota" id="notaForm" target="_blank">
                        @csrf
                        <input type="hidden" name="cart" id="cartInput">
                        <button type="submit" id="bayarBtn" disabled
                                class="btn-pay w-full bg-gradient-to-r from-coffee-600 to-coffee-700 text-white py-3.5 px-6 rounded-xl font-bold text-sm tracking-wider transition-all duration-300 disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:transform-none disabled:hover:shadow-none flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            Bayar Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let cart = [];
        let itemId = 0;

        function addToCart(id, nama_kopi, harga) {
            const existing = cart.find(item => item.id === id);
            if (existing) {
                existing.qty++;
            } else {
                cart.push({ id, uniqueId: ++itemId, nama_kopi, harga, qty: 1 });
            }
            renderCart();
            flashBadge(id);
        }

        function flashBadge(id) {
            const btn = document.querySelector(`button[onclick*="addToCart(${id},"]`);
            if (btn) {
                btn.classList.remove('product-card');
                void btn.offsetWidth;
                btn.classList.add('product-card');
            }
        }

        function updateQty(uniqueId, delta) {
            const item = cart.find(item => item.uniqueId === uniqueId);
            if (!item) return;
            item.qty += delta;
            if (item.qty <= 0) {
                cart = cart.filter(item => item.uniqueId !== uniqueId);
            }
            renderCart();
        }

        function renderCart() {
            const empty = document.getElementById('emptyCart');
            const list = document.getElementById('cartList');
            const totalSpan = document.getElementById('totalDisplay');
            const bayarBtn = document.getElementById('bayarBtn');
            const cartInput = document.getElementById('cartInput');

            if (cart.length === 0) {
                empty.classList.remove('hidden');
                list.classList.add('hidden');
                list.innerHTML = '';
                totalSpan.textContent = 'Rp 0';
                bayarBtn.disabled = true;
                cartInput.value = '';
                return;
            }

            empty.classList.add('hidden');
            list.classList.remove('hidden');

            let total = 0;
            let html = '';
            cart.forEach((item, idx) => {
                const subtotal = item.harga * item.qty;
                total += subtotal;
                html += `
                    <div class="cart-item-enter flex justify-between items-center p-3 bg-coffee-50 rounded-xl" style="animation-delay: ${idx * 0.05}s">
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-coffee-900 text-sm truncate">${item.nama_kopi}</p>
                            <p class="text-xs text-coffee-500">Rp ${numberFormat(item.harga)}</p>
                        </div>
                        <div class="flex items-center gap-2 ml-3">
                            <button onclick="updateQty(${item.uniqueId}, -1)"
                                    class="qty-btn w-7 h-7 bg-white rounded-lg flex items-center justify-center text-sm font-bold text-coffee-600 shadow-sm border border-coffee-200">−</button>
                            <span class="w-6 text-center font-bold text-coffee-800 text-sm">${item.qty}</span>
                            <button onclick="updateQty(${item.uniqueId}, 1)"
                                    class="qty-btn w-7 h-7 bg-white rounded-lg flex items-center justify-center text-sm font-bold text-coffee-600 shadow-sm border border-coffee-200">+</button>
                        </div>
                    </div>
                `;
            });

            list.innerHTML = html;
            totalSpan.textContent = 'Rp ' + numberFormat(total);
            bayarBtn.disabled = false;
            cartInput.value = JSON.stringify(cart.map(({ id, nama_kopi, harga, qty }) => ({ id, nama_kopi, harga, qty })));
        }

        function numberFormat(n) {
            return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }
    </script>
</body>
</html>

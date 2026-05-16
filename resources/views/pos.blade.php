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
            <div class="flex flex-col md:flex-row md:items-center gap-4 mb-6">
                <div class="flex items-center gap-3 flex-1">
                    <div class="h-1 flex-1 bg-gradient-to-r from-coffee-300 via-coffee-400 to-coffee-300 rounded-full"></div>
                    <h2 class="text-sm font-semibold text-coffee-700 tracking-widest uppercase">Menu Kopi</h2>
                    <div class="h-1 flex-1 bg-gradient-to-r from-coffee-300 via-coffee-400 to-coffee-300 rounded-full"></div>
                </div>
                <div class="flex items-center gap-3">
                    <span id="resultCount" class="text-xs text-coffee-400 hidden shrink-0"></span>
                    <div class="relative md:w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-coffee-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="text" id="searchInput"
                               class="w-full pl-9 pr-10 py-2.5 bg-white border border-coffee-200 rounded-xl text-sm text-coffee-900 placeholder-coffee-400 shadow-sm focus:ring-2 focus:ring-coffee-400 focus:border-coffee-400 outline-none transition-all"
                               placeholder="Cari nama atau harga...">
                        <button id="clearSearch" onclick="clearSearch()"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-coffee-300 hover:text-coffee-600 transition-colors hidden">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @forelse ($products as $i => $product)
                    <button type="button"
                             data-id="{{ $product->id }}"
                             data-nama="{{ $product->nama_kopi }}"
                             data-harga="{{ $product->harga }}"
                             data-search="{{ strtolower($product->nama_kopi) }} {{ $product->harga }}"
                             onclick="addToCart(this.dataset.id, this.dataset.nama, this.dataset.harga)"
                             class="product-card bg-white rounded-2xl shadow-md p-5 text-left border-2 border-transparent cursor-pointer group">
                        <div class="w-full aspect-square bg-coffee-100 rounded-xl flex items-center justify-center mb-3 group-hover:bg-coffee-200 transition-colors duration-300 overflow-hidden border border-coffee-100">
                            @if($product->foto)
                                <img src="{{ asset('storage/' . $product->foto) }}" alt="{{ $product->nama_kopi }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-3xl">☕</span>
                            @endif
                        </div>
                        <h3 class="product-name font-bold text-coffee-900 text-sm group-hover:text-coffee-700 transition-colors">{{ $product->nama_kopi }}</h3>
                        <p class="product-price text-coffee-500 font-bold mt-1 text-lg">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                        <div class="mt-2 flex items-center gap-1 text-xs text-coffee-400">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            <span>Klik untuk tambah</span>
                        </div>
                    </button>
                @empty
                    <div id="emptyProducts" class="col-span-full text-center py-16 animate-fade-up">
                        <span class="text-6xl">☕</span>
                        <p class="text-coffee-500 mt-4">Belum ada menu kopi.</p>
                        <a href="/login" class="mt-3 inline-block bg-coffee-700 text-white px-6 py-2 rounded-full text-sm hover:bg-coffee-600 transition">Login Admin</a>
                    </div>
                @endforelse
                <div id="searchNotFound"
                     class="col-span-full text-center py-16 animate-fade-up hidden">
                    <div class="w-20 h-20 mx-auto bg-coffee-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-coffee-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <p class="text-coffee-700 font-semibold" id="searchNotFoundText">Menu tidak ditemukan</p>
                    <p class="text-coffee-400 text-sm mt-1">Coba kata kunci lain</p>
                </div>
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

                    <div class="mb-4 space-y-2">
                        <p class="text-xs font-semibold text-coffee-600 tracking-wider uppercase">Metode Pembayaran</p>
                        <div class="flex gap-2">
                            <label class="flex-1 relative">
                                <input type="radio" name="payment_method" value="tunai" checked
                                       onchange="togglePaymentDetail('tunai')"
                                       class="peer sr-only">
                                <div class="flex items-center justify-center gap-1.5 px-3 py-2.5 rounded-xl border-2 border-coffee-200 bg-coffee-50 text-coffee-700 text-xs font-bold cursor-pointer transition-all peer-checked:border-coffee-600 peer-checked:bg-coffee-100 peer-checked:text-coffee-900 hover:border-coffee-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    Tunai
                                </div>
                            </label>
                            <label class="flex-1 relative">
                                <input type="radio" name="payment_method" value="transfer"
                                       onchange="togglePaymentDetail('transfer')"
                                       class="peer sr-only">
                                <div class="flex items-center justify-center gap-1.5 px-3 py-2.5 rounded-xl border-2 border-coffee-200 bg-coffee-50 text-coffee-700 text-xs font-bold cursor-pointer transition-all peer-checked:border-coffee-600 peer-checked:bg-coffee-100 peer-checked:text-coffee-900 hover:border-coffee-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-7 5-7-5m14 0a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V7z"/></svg>
                                    Transfer
                                </div>
                            </label>
                            <label class="flex-1 relative">
                                <input type="radio" name="payment_method" value="qris"
                                       onchange="togglePaymentDetail('qris')"
                                       class="peer sr-only">
                                <div class="flex items-center justify-center gap-1.5 px-3 py-2.5 rounded-xl border-2 border-coffee-200 bg-coffee-50 text-coffee-700 text-xs font-bold cursor-pointer transition-all peer-checked:border-coffee-600 peer-checked:bg-coffee-100 peer-checked:text-coffee-900 hover:border-coffee-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M5.5 12H4m3.5-6.5L6 7M18 17l-2 2m2-9l-2-2M6 5l-2 2m12 12l-2-2"/></svg>
                                    QRIS
                                </div>
                            </label>
                        </div>
                    </div>

                    <div id="paymentDetail" class="mb-4 p-3 bg-coffee-50 rounded-xl border border-coffee-200 text-center hidden">
                        <div id="transferDetail" class="hidden">
                            <p class="text-xs text-coffee-500 mb-1">Transfer ke rekening:</p>
                            <p class="font-bold text-coffee-800 text-sm" id="bankInfo">
                                @if($paymentSettings->bank_name)
                                    {{ $paymentSettings->bank_name }}
                                @endif
                                @if($paymentSettings->account_number)
                                    - {{ $paymentSettings->account_number }}
                                @endif
                            </p>
                            @if($paymentSettings->account_name)
                                <p class="text-xs text-coffee-500">a.n. {{ $paymentSettings->account_name }}</p>
                            @endif
                        </div>
                        <div id="qrisDetail" class="hidden">
                            <p class="text-xs text-coffee-500 mb-2">Scan QRIS berikut:</p>
                            @if($paymentSettings->qris_path)
                                <img src="{{ asset('storage/' . $paymentSettings->qris_path) }}" alt="QRIS" class="w-32 h-32 mx-auto rounded-xl border border-coffee-200 object-cover">
                            @else
                                <p class="text-xs text-coffee-400">QRIS belum diatur</p>
                            @endif
                        </div>
                    </div>

                    <form method="POST" action="/nota" id="notaForm" target="_blank">
                        @csrf
                        <input type="hidden" name="cart" id="cartInput">
                        <input type="hidden" name="payment_method" id="paymentMethodInput" value="tunai">
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
        let searchTimer = null;

        document.getElementById('searchInput').addEventListener('input', function(e) {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => filterProducts(e.target.value), 150);
        });

        function clearSearch() {
            document.getElementById('searchInput').value = '';
            filterProducts('');
            document.getElementById('searchInput').focus();
        }

        function filterProducts(term) {
            const raw = term.trim().toLowerCase();
            const cards = document.querySelectorAll('.product-card');
            const notFound = document.getElementById('searchNotFound');
            const emptyProducts = document.getElementById('emptyProducts');
            const countEl = document.getElementById('resultCount');
            const clearBtn = document.getElementById('clearSearch');
            const total = cards.length;

            if (emptyProducts) return;

            let visible = 0;

            cards.forEach(card => {
                const searchData = (card.dataset.search || '').toLowerCase();
                const match = !raw || searchData.includes(raw);
                if (match) {
                    card.classList.remove('hidden', 'opacity-0', 'scale-95');
                    card.classList.add('opacity-100', 'scale-100');
                    visible++;
                } else {
                    card.classList.add('hidden', 'opacity-0', 'scale-95');
                    card.classList.remove('opacity-100', 'scale-100');
                }
            });

            clearBtn.classList.toggle('hidden', !raw);
            notFound.classList.toggle('hidden', visible > 0 || total === 0);

            if (total > 0) {
                countEl.classList.remove('hidden');
                countEl.textContent = visible === total
                    ? total + ' menu'
                    : visible + ' dari ' + total + ' menu';
            }

            if (raw) {
                highlightText(raw);
            } else {
                removeHighlight();
            }
        }

        function highlightText(term) {
            const names = document.querySelectorAll('.product-name');
            const prices = document.querySelectorAll('.product-price');
            const words = term.split(/\s+/).filter(w => w);

            names.forEach(el => {
                let text = el.textContent;
                words.forEach(word => {
                    const regex = new RegExp('(' + word.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'gi');
                    text = text.replace(regex, '<mark class="bg-coffee-300 text-coffee-900 rounded px-0.5">$1</mark>');
                });
                el.innerHTML = text;
            });

            prices.forEach(el => {
                let text = el.textContent.toLowerCase();
                let original = el.textContent;
                words.forEach(word => {
                    const numWord = word.replace(/[^0-9]/g, '');
                    if (numWord && original.toLowerCase().includes(numWord)) {
                        const regex = new RegExp('(' + numWord.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'gi');
                        original = original.replace(regex, '<mark class="bg-coffee-300 text-coffee-900 rounded px-0.5">$1</mark>');
                    }
                });
                if (original !== el.textContent) {
                    el.innerHTML = original;
                }
            });
        }

        function removeHighlight() {
            document.querySelectorAll('.product-name, .product-price').forEach(el => {
                el.innerHTML = el.textContent;
            });
        }

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
            const btn = document.querySelector(`button[data-id="${id}"]`);
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

        function togglePaymentDetail(method) {
            const detail = document.getElementById('paymentDetail');
            const transfer = document.getElementById('transferDetail');
            const qris = document.getElementById('qrisDetail');
            const input = document.getElementById('paymentMethodInput');

            input.value = method;

            if (method === 'tunai') {
                detail.classList.add('hidden');
                return;
            }

            detail.classList.remove('hidden');
            transfer.classList.toggle('hidden', method !== 'transfer');
            qris.classList.toggle('hidden', method !== 'qris');
        }

        function numberFormat(n) {
            return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }
    </script>
</body>
</html>

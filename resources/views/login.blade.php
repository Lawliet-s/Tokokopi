<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Tokokopi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;500;600;700&family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="bg-coffee-50 font-sans min-h-screen flex items-center justify-center p-4">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-72 h-72 bg-coffee-200/20 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-coffee-300/10 rounded-full blur-3xl animate-float" style="animation-delay: -1.5s"></div>
    </div>

    <div class="relative w-full max-w-md animate-fade-up">
        <div class="text-center mb-8">
            <span class="text-6xl block mb-3 animate-bounce-in">☕</span>
            <h1 class="text-4xl font-caveat text-coffee-800 font-bold">Tokokopi</h1>
            <p class="text-coffee-500 mt-1">Login Admin</p>
        </div>

        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl p-8 border border-coffee-100 animate-scale-in">
            <form method="POST" action="/login">
                @csrf

                <div class="mb-5">
                    <label for="email" class="block text-sm font-semibold text-coffee-700 mb-1.5">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-coffee-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                               class="w-full pl-10 pr-4 py-3 bg-coffee-50 border border-coffee-200 rounded-xl text-coffee-900 placeholder-coffee-400 focus:ring-2 focus:ring-coffee-400 focus:border-coffee-400 outline-none transition-all duration-200"
                               placeholder="admin@tokokopi.com" required autofocus>
                    </div>
                </div>

                <div class="mb-5">
                    <label for="password" class="block text-sm font-semibold text-coffee-700 mb-1.5">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-coffee-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <input type="password" name="password" id="password"
                               class="w-full pl-10 pr-4 py-3 bg-coffee-50 border border-coffee-200 rounded-xl text-coffee-900 placeholder-coffee-400 focus:ring-2 focus:ring-coffee-400 focus:border-coffee-400 outline-none transition-all duration-200"
                               placeholder="••••••••" required>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="mb-5 p-3 bg-red-50 border border-red-200 rounded-xl text-red-600 text-sm animate-fade-in flex items-center gap-2">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $errors->first('email') }}
                    </div>
                @endif

                <button type="submit"
                        class="w-full bg-gradient-to-r from-coffee-700 to-coffee-800 text-white py-3 px-6 rounded-xl font-bold text-sm tracking-wider transition-all duration-300 hover:from-coffee-600 hover:to-coffee-700 hover:shadow-lg hover:shadow-coffee-300/30 active:scale-[0.98]">
                    Masuk
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="/" class="text-sm text-coffee-500 hover:text-coffee-700 transition-colors">
                    ← Kembali ke Kasir
                </a>
            </div>
        </div>
    </div>
</body>
</html>

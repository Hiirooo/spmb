<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'SPMB - ' . config('app.name') }}</title>

    @filamentStyles
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <style>
        body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
    </style>
</head>
<body class="min-h-full bg-gradient-to-br from-slate-50 via-white to-amber-50 text-slate-900 antialiased">
    <header class="border-b border-slate-200/60 bg-white/80 backdrop-blur sticky top-0 z-30">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4 sm:px-6">
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-lg font-bold text-slate-900">
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-amber-500 text-white">S</span>
                <span>SPMB</span>
            </a>
            <nav class="flex items-center gap-3 text-sm">
                <a href="{{ route('home') }}" class="text-slate-600 hover:text-slate-900">Beranda</a>
                <a href="{{ route('daftar') }}" class="rounded-lg bg-amber-500 px-4 py-2 font-semibold text-white hover:bg-amber-400">Daftar Sekarang</a>
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-4 py-8 sm:px-6 sm:py-12">
        {{ $slot }}
    </main>

    <footer class="border-t border-slate-200/60 bg-white/60 mt-16">
        <div class="mx-auto max-w-6xl px-4 py-6 text-center text-sm text-slate-500 sm:px-6">
            &copy; {{ date('Y') }} SPMB &mdash; Sistem Penerimaan Mahasiswa Baru
        </div>
    </footer>

    @filamentScripts
    @livewireScripts
</body>
</html>

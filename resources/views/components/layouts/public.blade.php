<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'SPMB - Sistem Penerimaan Mahasiswa Baru' }}</title>
    <meta name="description" content="Sistem Penerimaan Mahasiswa Baru. Daftar online dengan cepat, dapatkan nomor pendaftaran instan.">

    @filamentStyles
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=crimson-pro:400,500,600,700|inter:400,500,600,700&display=swap" rel="stylesheet" />
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ink: { 50: '#f8fafc', 100: '#f1f5f9', 200: '#e2e8f0', 300: '#cbd5e1', 400: '#94a3b8', 500: '#64748b', 600: '#475569', 700: '#334155', 800: '#1e293b', 900: '#0f172a', 950: '#020617' },
                        gold: { 50: '#fffbeb', 100: '#fef3c7', 200: '#fde68a', 400: '#fbbf24', 500: '#d4a017', 600: '#b8860b', 700: '#92740a' },
                        paper: '#fafaf9',
                    },
                    fontFamily: {
                        serif: ['"Crimson Pro"', 'ui-serif', 'Georgia', 'serif'],
                        sans: ['"Inter"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                    boxShadow: {
                        'soft': '0 1px 2px 0 rgba(15,23,42,0.05), 0 1px 3px 0 rgba(15,23,42,0.04)',
                        'card': '0 1px 3px 0 rgba(15,23,42,0.06), 0 4px 12px -2px rgba(15,23,42,0.04)',
                        'lift': '0 20px 25px -5px rgba(15,23,42,0.1), 0 10px 10px -5px rgba(15,23,42,0.04)',
                    },
                },
            },
        };
    </script>
    <style>
        body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; -webkit-font-smoothing: antialiased; }
        h1, h2, h3, .font-serif { font-family: 'Crimson Pro', ui-serif, Georgia, serif; letter-spacing: -0.01em; }
        .grain {
            background-image: radial-gradient(rgba(15,23,42,0.04) 1px, transparent 1px);
            background-size: 24px 24px;
        }
        .gold-line {
            background: linear-gradient(90deg, transparent, #b8860b 20%, #b8860b 80%, transparent);
        }
    </style>
</head>
<body class="min-h-full bg-paper text-ink-900 antialiased">

    <header class="sticky top-0 z-40 border-b border-ink-200/60 bg-paper/90 backdrop-blur-xl">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4 sm:px-6">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <span class="relative inline-flex h-9 w-9 items-center justify-center rounded-md bg-ink-900 font-serif text-base font-bold text-paper">
                    <span class="relative">S</span>
                    <span class="absolute -bottom-0.5 left-1/2 h-0.5 w-4 -translate-x-1/2 bg-gold-600"></span>
                </span>
                <div class="leading-tight">
                    <p class="font-serif text-lg font-semibold text-ink-900">SPMB</p>
                    <p class="text-[10px] uppercase tracking-[0.2em] text-ink-500">Penerimaan Mahasiswa Baru</p>
                </div>
            </a>

            <nav class="hidden items-center gap-8 text-sm md:flex">
                <a href="{{ route('home') }}#program" class="text-ink-600 hover:text-ink-900">Program</a>
                <a href="{{ route('home') }}#jalur" class="text-ink-600 hover:text-ink-900">Jalur</a>
                <a href="{{ route('home') }}#timeline" class="text-ink-600 hover:text-ink-900">Timeline</a>
                <a href="{{ route('home') }}#faq" class="text-ink-600 hover:text-ink-900">FAQ</a>
            </nav>

            <a href="{{ route('daftar') }}" class="inline-flex items-center gap-2 rounded-md bg-ink-900 px-4 py-2.5 text-sm font-medium text-paper shadow-soft hover:bg-ink-800 transition">
                Daftar
                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer class="mt-32 border-t border-ink-200/60 bg-paper">
        <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6">
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                <div class="lg:col-span-2">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-md bg-ink-900 font-serif text-base font-bold text-paper">S</span>
                        <p class="font-serif text-lg font-semibold">SPMB</p>
                    </div>
                    <p class="mt-4 max-w-md text-sm leading-relaxed text-ink-500">
                        Sistem Penerimaan Mahasiswa Baru — pintu gerbang menuju pendidikan tinggi yang berkualitas.
                        Pendaftaran online, transparan, dan terverifikasi.
                    </p>
                </div>
                <div>
                    <p class="font-serif text-sm font-semibold uppercase tracking-wider text-ink-700">Tautan</p>
                    <ul class="mt-4 space-y-2 text-sm text-ink-500">
                        <li><a href="{{ route('home') }}#program" class="hover:text-ink-900">Program Studi</a></li>
                        <li><a href="{{ route('home') }}#jalur" class="hover:text-ink-900">Jalur Pendaftaran</a></li>
                        <li><a href="{{ route('home') }}#timeline" class="hover:text-ink-900">Timeline PMB</a></li>
                        <li><a href="{{ route('daftar') }}" class="hover:text-ink-900">Mulai Daftar</a></li>
                    </ul>
                </div>
                <div>
                    <p class="font-serif text-sm font-semibold uppercase tracking-wider text-ink-700">Kontak</p>
                    <ul class="mt-4 space-y-2 text-sm text-ink-500">
                        <li>Email: pmb@example.ac.id</li>
                        <li>WhatsApp: 0812-3456-7890</li>
                        <li>Senin–Jumat, 08.00–16.00 WIB</li>
                    </ul>
                </div>
            </div>
            <div class="mt-10 flex flex-col items-start justify-between gap-2 border-t border-ink-200/60 pt-6 text-xs text-ink-500 sm:flex-row sm:items-center">
                <p>&copy; {{ date('Y') }} SPMB. Semua hak dilindungi.</p>
                <p>Sistem Penerimaan Mahasiswa Baru</p>
            </div>
        </div>
    </footer>

    @filamentScripts
    @livewireScripts
</body>
</html>

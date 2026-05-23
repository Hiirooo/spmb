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

        /* === Form input refinement (Filament inputs + native form fields) === */
        .fi-input,
        .fi-select-input-btn,
        .fi-input-wrp,
        input[type="text"]:not(.fi-input):not([class*="bg-"]),
        input[type="email"]:not(.fi-input):not([class*="bg-"]),
        input[type="password"]:not(.fi-input):not([class*="bg-"]),
        input[type="tel"]:not(.fi-input):not([class*="bg-"]),
        input[type="number"]:not(.fi-input):not([class*="bg-"]),
        input[type="search"]:not(.fi-input):not([class*="bg-"]),
        select:not(.fi-select-input-btn):not([class*="bg-"]),
        textarea:not(.fi-input):not([class*="bg-"]) {
            border-radius: 0.5rem;
            font-size: 0.9375rem;
            line-height: 1.5;
            transition: border-color 150ms ease, box-shadow 150ms ease, background-color 150ms ease;
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
        }

        /* Filament input wrapper (border container) */
        .fi-input-wrp {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 2px 0 rgba(15,23,42,0.04);
        }

        .fi-input-wrp:hover {
            border-color: #cbd5e1;
        }

        .fi-input-wrp:focus-within {
            border-color: #0f172a;
            box-shadow: 0 0 0 3px rgba(184,134,11,0.15), 0 1px 2px 0 rgba(15,23,42,0.04);
        }

        .fi-input-wrp.fi-invalid,
        .fi-input-wrp[aria-invalid="true"] {
            border-color: #f43f5e;
        }

        .fi-input-wrp.fi-invalid:focus-within {
            box-shadow: 0 0 0 3px rgba(244,63,94,0.15);
        }

        /* Inner input itself: remove its default border/ring (wrapper handles it) */
        .fi-input,
        .fi-select-input-btn {
            border: 0 !important;
            box-shadow: none !important;
            background: transparent !important;
            padding: 0.625rem 0.875rem;
            color: #0f172a;
            outline: none !important;
        }

        .fi-input::placeholder {
            color: #94a3b8;
        }

        .fi-input:focus,
        .fi-select-input-btn:focus {
            box-shadow: none !important;
            outline: none !important;
        }

        /* Native (non-Filament) inputs */
        input[type="text"]:not(.fi-input):not([class*="bg-"]),
        input[type="email"]:not(.fi-input):not([class*="bg-"]),
        input[type="password"]:not(.fi-input):not([class*="bg-"]),
        input[type="tel"]:not(.fi-input):not([class*="bg-"]),
        input[type="number"]:not(.fi-input):not([class*="bg-"]),
        input[type="search"]:not(.fi-input):not([class*="bg-"]),
        select:not(.fi-select-input-btn):not([class*="bg-"]),
        textarea:not(.fi-input):not([class*="bg-"]) {
            border: 1px solid #e2e8f0;
            background: #ffffff;
            padding: 0.625rem 0.875rem;
            color: #0f172a;
            box-shadow: 0 1px 2px 0 rgba(15,23,42,0.04);
        }

        input[type="text"]:not(.fi-input):not([class*="bg-"]):hover,
        input[type="email"]:not(.fi-input):not([class*="bg-"]):hover,
        select:not(.fi-select-input-btn):not([class*="bg-"]):hover,
        textarea:not(.fi-input):not([class*="bg-"]):hover {
            border-color: #cbd5e1;
        }

        input[type="text"]:not(.fi-input):not([class*="bg-"]):focus,
        input[type="email"]:not(.fi-input):not([class*="bg-"]):focus,
        input[type="password"]:not(.fi-input):not([class*="bg-"]):focus,
        input[type="tel"]:not(.fi-input):not([class*="bg-"]):focus,
        input[type="number"]:not(.fi-input):not([class*="bg-"]):focus,
        input[type="search"]:not(.fi-input):not([class*="bg-"]):focus,
        select:not(.fi-select-input-btn):not([class*="bg-"]):focus,
        textarea:not(.fi-input):not([class*="bg-"]):focus {
            border-color: #0f172a;
            outline: none;
            box-shadow: 0 0 0 3px rgba(184,134,11,0.15);
        }

        /* Select dropdown chevron */
        .fi-select-input {
            position: relative;
        }

        /* Native select chevron upgrade */
        select:not(.fi-select-input-btn):not([class*="bg-"]) {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.6' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1.25rem;
            padding-right: 2.5rem;
        }

        /* Textarea: minimum height + comfortable line-height */
        textarea:not(.fi-input):not([class*="bg-"]),
        .fi-input[rows] {
            min-height: 5.5rem;
            line-height: 1.55;
            resize: vertical;
        }

        /* Filament textarea wrapper specific */
        .fi-fo-textarea-wrp .fi-input-wrp {
            padding: 0;
        }

        .fi-input[rows] {
            padding: 0.75rem 0.875rem;
        }

        /* Checkbox + Radio refinement */
        input[type="checkbox"]:not([class*="bg-"]),
        input[type="radio"]:not([class*="bg-"]) {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            width: 1.125rem;
            height: 1.125rem;
            border: 1.5px solid #cbd5e1;
            background: #ffffff;
            cursor: pointer;
            transition: all 150ms ease;
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        input[type="checkbox"]:not([class*="bg-"]) {
            border-radius: 0.3125rem;
        }

        input[type="radio"]:not([class*="bg-"]) {
            border-radius: 50%;
        }

        input[type="checkbox"]:not([class*="bg-"]):hover,
        input[type="radio"]:not([class*="bg-"]):hover {
            border-color: #94a3b8;
        }

        input[type="checkbox"]:not([class*="bg-"]):focus-visible,
        input[type="radio"]:not([class*="bg-"]):focus-visible {
            outline: none;
            box-shadow: 0 0 0 3px rgba(184,134,11,0.15);
        }

        input[type="checkbox"]:not([class*="bg-"]):checked,
        input[type="radio"]:not([class*="bg-"]):checked {
            background-color: #0f172a;
            border-color: #0f172a;
        }

        input[type="checkbox"]:not([class*="bg-"]):checked::before {
            content: '';
            display: block;
            width: 0.625rem;
            height: 0.625rem;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 16 16'%3e%3cpath stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='M3.5 8.5l3 3 6-7'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-size: contain;
            background-position: center;
        }

        input[type="radio"]:not([class*="bg-"]):checked::before {
            content: '';
            display: block;
            width: 0.4375rem;
            height: 0.4375rem;
            border-radius: 50%;
            background: #ffffff;
        }

        /* File input refinement (uploads) */
        input[type="file"]::file-selector-button {
            font-family: inherit;
            font-weight: 600;
            transition: background-color 150ms ease, box-shadow 150ms ease;
            border-radius: 0.5rem;
            border: 0;
            cursor: pointer;
        }

        input[type="file"]::file-selector-button:hover {
            background-color: #1e293b;
        }

        input[type="file"] {
            font-size: 0.8125rem;
            color: #475569;
            cursor: pointer;
        }

        input[type="file"]:focus {
            outline: none;
        }

        input[type="file"]:focus::file-selector-button {
            box-shadow: 0 0 0 3px rgba(184,134,11,0.15);
        }

        /* Filament label refinement */
        .fi-fo-field-label-content {
            font-size: 0.8125rem;
            font-weight: 600;
            color: #1e293b;
            letter-spacing: 0.005em;
        }

        .fi-fo-field-label-required-mark {
            color: #b8860b;
            margin-left: 2px;
        }

        /* Field hint/helper text */
        .fi-fo-field-wrp-hint {
            font-size: 0.75rem;
            color: #64748b;
            margin-top: 0.375rem;
            line-height: 1.4;
        }

        /* Validation error message */
        .fi-fo-field-wrp-error-message,
        p[data-validation-error] {
            font-size: 0.75rem;
            color: #e11d48;
            margin-top: 0.375rem;
            font-weight: 500;
        }

        /* Spacing between fields */
        .fi-sc-section-content > .fi-grid > .fi-grid-col > .fi-sc-component {
            margin-bottom: 0.25rem;
        }

        /* === Button refinements === */
        button[type="submit"]:not([class*="bg-amber"]):not([class*="bg-emerald"]):not([class*="bg-rose"]),
        a.inline-flex,
        button.inline-flex {
            transition: all 150ms ease;
            letter-spacing: 0.005em;
        }

        button[type="submit"]:not(:disabled):active,
        button.inline-flex:not(:disabled):active,
        a.inline-flex:active {
            transform: translateY(1px);
        }

        button:disabled,
        button[disabled] {
            cursor: not-allowed;
        }

        /* Filament native buttons */
        .fi-btn {
            transition: all 150ms ease !important;
            letter-spacing: 0.005em;
        }

        .fi-btn:not(:disabled):active {
            transform: translateY(1px);
        }

        /* Date picker trigger button (Filament) */
        .fi-fo-date-time-picker-trigger {
            cursor: pointer;
        }

        /* Date picker calendar panel */
        .fi-fo-date-time-picker-panel {
            position: absolute !important;
            z-index: 50;
            background: #ffffff !important;
            border-radius: 0.625rem !important;
            box-shadow: 0 10px 25px -5px rgba(15,23,42,0.12), 0 4px 10px -3px rgba(15,23,42,0.08);
            border: 1px solid #e2e8f0;
            padding: 0.875rem;
            min-width: 18rem;
        }

        .fi-fo-date-time-picker-panel-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
        }

        .fi-fo-date-time-picker-month-select,
        .fi-fo-date-time-picker-year-input {
            border: 1px solid #e2e8f0;
            background: #ffffff;
            border-radius: 0.5rem;
            padding: 0.375rem 0.625rem;
            font-size: 0.8125rem;
            color: #0f172a;
        }

        .fi-fo-date-time-picker-month-select {
            flex: 1;
            -webkit-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.6' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.5rem center;
            background-size: 1rem;
            padding-right: 1.75rem;
        }

        .fi-fo-date-time-picker-year-input {
            width: 5rem;
            text-align: center;
        }

        .fi-fo-date-time-picker-calendar-header {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 0.125rem;
            margin-bottom: 0.25rem;
        }

        .fi-fo-date-time-picker-calendar-header-day {
            text-align: center;
            font-size: 0.6875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #94a3b8;
            padding: 0.25rem 0;
        }

        .fi-fo-date-time-picker-calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 0.125rem;
        }

        .fi-fo-date-time-picker-calendar-day {
            transition: all 100ms ease;
            border-radius: 0.375rem;
            text-align: center;
            padding: 0.5rem 0;
            font-size: 0.8125rem;
            cursor: pointer;
            color: #1e293b;
            min-height: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .fi-fo-date-time-picker-calendar-day:hover:not(.fi-disabled) {
            background-color: #f1f5f9;
        }

        .fi-fo-date-time-picker-calendar-day.fi-selected {
            background-color: #0f172a !important;
            color: #ffffff !important;
        }

        .fi-fo-date-time-picker-calendar-day-today {
            font-weight: 700;
            color: #b8860b;
        }

        .fi-fo-date-time-picker-calendar-day.fi-disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

        .fi-fo-date-time-picker-calendar-day.fi-focused {
            outline: 2px solid #b8860b;
            outline-offset: -2px;
        }

        /* Filament Select (custom dropdown) */
        .fi-select-input-btn {
            min-height: 2.5rem;
        }

        /* Filament dropdown panel (select, datepicker, etc.) */
        .fi-dropdown-panel {
            position: absolute !important;
            z-index: 50;
            background: #ffffff !important;
            border-radius: 0.625rem !important;
            box-shadow: 0 10px 25px -5px rgba(15,23,42,0.12), 0 4px 10px -3px rgba(15,23,42,0.08) !important;
            border: 1px solid #e2e8f0 !important;
            padding: 0.25rem !important;
            min-width: 10rem;
            max-height: 16rem;
            overflow-y: auto;
        }

        .fi-dropdown-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .fi-dropdown-list-item {
            padding: 0.5rem 0.75rem !important;
            font-size: 0.875rem;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: background-color 100ms ease;
            color: #1e293b;
            display: block;
        }

        .fi-dropdown-list-item:hover {
            background-color: #f8fafc;
        }

        .fi-dropdown-list-item.fi-selected,
        .fi-dropdown-list-item[aria-selected="true"] {
            background-color: #0f172a !important;
            color: #ffffff !important;
            font-weight: 500;
        }

        .fi-dropdown-list-item.fi-disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Filament select trigger button visual */
        .fi-select-input-btn {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 0.625rem 0.875rem;
            text-align: left;
            color: #0f172a;
            cursor: pointer;
        }

        .fi-select-input-btn[aria-expanded="true"] {
            background: rgba(15,23,42,0.02);
        }

        /* Date picker reveal/clear icon button inside trigger */
        .fi-icon-btn {
            transition: background-color 150ms ease;
        }

        .fi-icon-btn:hover {
            background-color: #f1f5f9;
            border-radius: 0.375rem;
        }

        /* === Card hover refinements === */
        a.group {
            transition: transform 200ms cubic-bezier(0.4, 0, 0.2, 1),
                        box-shadow 200ms cubic-bezier(0.4, 0, 0.2, 1),
                        border-color 200ms ease;
        }

        /* Smooth scroll for anchor links */
        html {
            scroll-behavior: smooth;
        }

        /* Improved focus visible (keyboard nav) */
        a:focus-visible,
        button:focus-visible {
            outline: 2px solid #b8860b;
            outline-offset: 2px;
            border-radius: 0.375rem;
        }

        /* Table row hover */
        tbody tr {
            transition: background-color 100ms ease;
        }

        tbody tr:hover {
            background-color: #fafaf9;
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
                <a href="{{ route('sekolah.index') }}" class="text-ink-600 hover:text-ink-900">Sekolah</a>
                <a href="{{ route('cek-status') }}" class="text-ink-600 hover:text-ink-900">Cek Status</a>
                <a href="{{ route('pengumuman.index') }}" class="text-ink-600 hover:text-ink-900">Pengumuman</a>
                <a href="{{ route('home') }}#faq" class="text-ink-600 hover:text-ink-900">FAQ</a>
            </nav>

            @auth
                <div class="flex items-center gap-3">
                    @if(auth()->user()->isAdmin())
                        <a href="/admin" class="hidden text-sm text-ink-600 hover:text-ink-900 sm:inline">Admin Panel</a>
                    @endif
                    <a href="{{ route('portal') }}" class="inline-flex items-center gap-2 rounded-md border border-ink-300 bg-white px-3 py-2 text-sm text-ink-700 hover:bg-paper">
                        <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-ink-900 text-xs font-semibold text-paper">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        <span class="hidden sm:inline max-w-[100px] truncate">{{ auth()->user()->name }}</span>
                    </a>
                </div>
            @else
                <div class="flex items-center gap-2">
                    <a href="{{ route('login') }}" class="hidden rounded-md px-3 py-2 text-sm font-medium text-ink-700 hover:text-ink-900 sm:inline-block">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-md bg-ink-900 px-4 py-2.5 text-sm font-medium text-paper shadow-soft hover:bg-ink-800 transition">
                        Daftar
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            @endauth
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
                        <li><a href="{{ route('sekolah.index') }}" class="hover:text-ink-900">Pilih Sekolah</a></li>
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

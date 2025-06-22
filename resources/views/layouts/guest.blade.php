<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'LaporCepat') }} - Autentikasi</title>
    <link rel="icon" href="{{ asset('favicon-laporcepat.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .portal-bg {
            background-color: #f0f7ff;
            background-image: linear-gradient(160deg, #f0f7ff 0%, #dbeafe 100%);
        }
        /* Styling untuk input dengan ikon */
        .input-portal {
            background-color: #F3F4F6; /* bg-gray-100 */
            border: 1px solid #F3F4F6;
            color: #1F2937;
            /* INI KUNCINYA: Memberi ruang 2.75rem (44px) di kiri untuk ikon */
            padding-left: 2.75rem;
            transition: all 0.3s;
        }
        .input-portal:focus {
            background-color: #FFFFFF;
            border-color: #3B82F6; /* border-blue-500 */
            outline: none;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
        }
        /* Styling untuk tombol utama */
        .btn-portal {
            background-color: #2563EB; /* bg-blue-600 */
            color: white;
            transition: background-color 0.3s;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .btn-portal:hover {
            background-color: #1D4ED8; /* bg-blue-700 */
        }
        /* Styling untuk navigasi tab */
        .tab-nav {
            display: inline-flex;
            background-color: #E5E7EB; /* bg-gray-200 */
            border-radius: 0.75rem; /* rounded-xl */
            padding: 0.25rem;
        }
        .tab-link {
            padding: 0.5rem 1.25rem;
            border-radius: 0.6rem; /* rounded-lg */
            font-weight: 500;
            font-size: 0.875rem;
            color: #4B5563; /* text-gray-600 */
            transition: all 0.3s;
        }
        .tab-link.active {
            background-color: #2563EB; /* bg-blue-600 */
            color: #FFFFFF;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }
    </style>
</head>
<body class="antialiased portal-bg">
    <main class="min-h-screen w-full flex flex-col items-center justify-center p-4">

        <div class="w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="p-8 md:p-12">
                {{ $slot }}
            </div>
        </div>

    <div class="mt-6 text-center text-sm text-gray-600">
        Butuh bantuan untuk masuk?
        <a href="{{ route('panduan.bantuan') }}" class="font-medium text-blue-600 hover:underline">Panduan Bantuan</a>
        |
        <a href="mailto:dukungan@laporcepat.com" class="font-medium text-blue-600 hover:underline">Hubungi Dukungan</a>
    </div>

    </main>
</body>
</html>

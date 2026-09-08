<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

   <link rel="icon" type="image/png" href="{{ asset('assets/favicon.png') }}?v=1.0">
   

    <title>@yield('title', 'Alfarizki – Beli Sepatu Impianmu')</title>

    <!-- 1. PERBAIKAN UTAMA: Panggil aset Laravel Vite Anda di sini -->
    <!-- Ini akan memuat Tailwind v4 dari resources/css/app.css secara otomatis -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Catatan: Tag script cdn.tailwindcss.com dan link flowbite cdn DIHAPUS karena sudah di-handle oleh Vite & npm -->

    <!-- Icons Pack -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Sora:wght@600;700;800&display=swap" rel="stylesheet"/>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

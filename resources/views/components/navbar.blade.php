<!-- START NAVBAR -->
<nav class="bg-white fixed w-full z-50 top-0 shadow transition-all duration-300 ">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
    
    <!-- PERBAIKAN 1: BUNGKUS LOGO/NAMA DENGAN ROUTE HOME -->
    <a href="{{ route('home') }}" class="self-center text-xl md:text-2xl font-bold whitespace-nowrap inline-block transition-transform duration-150 active:scale-90 cursor-pointer select-none">
        <span class="text-heading">Alfarizki</span><span class="text-yellow-500">Store</span>
    </a>

    <div class="flex md:order-2 space-x-1 md:space-x-0 rtl:space-x-reverse flex gap-4 items-center">

      <!-- PERBAIKAN PADA LINK KERANJANG -->
      <a href="{{ route('cart.index') }}" class="relative inline-block">
        <!-- Kontainer Ikon: Mengunci ruang 24px (w-6 h-6) dan memberi background abu-abu tipis saat loading -->
        <div class="w-6 h-6 bg-slate-100 rounded animate-pulse" id="cart-icon-container">
          <img
            src="{{ asset('assets/cart-large.png') }}"
            class="w-6 h-6 opacity-0 transition-opacity duration-300"
            loading="eager"
            fetchpriority="high"
            onload="this.classList.remove('opacity-0'); document.getElementById('cart-icon-container').classList.remove('animate-pulse', 'bg-slate-100')"
          >
        </div>

        @if($cartCount > 0)
            <span class="absolute -top-2 -right-2 bg-[#0D2031] text-white text-xs w-5 h-5 flex items-center justify-center rounded-full">
                {{ $cartCount }}
            </span>
        @endif
      </a>

    <div x-data="{ openSearch: false }">
        <!-- Tombol Ikon Search Utama -->
        <button 
            @click="openSearch = true; $nextTick(() => $refs.searchInput.focus())"
            type="button"
            class="flex h-12 w-12 items-center justify-center rounded-full
            aria-label="Cari Produk"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.85-5.15a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
            </svg>
        </button>

        <!-- Pop-up Modal Search -->
        <div 
            x-show="openSearch" 
            x-cloak
            @keydown.escape.window="openSearch = false"
            class="fixed inset-0 z-50 flex items-start justify-center pt-20 px-4"
        >
            <!-- Backdrop Overlay (Klik di luar untuk menutup) -->
            <div 
                x-show="openSearch"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click="openSearch = false" 
                class="fixed inset-0 bg-black/50 backdrop-blur-sm"
            ></div>

            <!-- Box Modal -->
            <div 
                x-show="openSearch"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 -translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 -translate-y-4"
                class="relative z-10 w-full max-w-2xl rounded-2xl bg-white p-4 shadow-2xl"
            >
                <form action="{{ route('product.search') }}" method="GET">
                    <div class="flex items-center rounded-full bg-[#e9e9ee] p-2">
                        <input
                            x-ref="searchInput"
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari sepatu Nike, Adidas, atau ukuran..."
                            autocomplete="off"
                            class="w-full bg-transparent px-6 py-3 text-lg text-gray-700 border-none outline-none ring-0 focus:ring-0 focus:outline-none"
                        />

                        <button
                            type="submit"
                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-[#11131a] text-white transition hover:scale-105"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.85-5.15a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                            </svg>
                        </button>
                    </div>
                </form>

                <!-- Hint Tekan ESC untuk Tutup -->
                <div class="mt-2 flex justify-between px-4 text-xs text-gray-400">
                    <span>Tekan <kbd class="rounded bg-gray-100 px-1.5 py-0.5 text-gray-600 border">ESC</kbd> untuk menutup</span>
                </div>
            </div>
        </div>
    </div>

    <!-- CHECK LOGIN MULTI-GUARD (USER BIASA & FILAMENT ADMIN) -->
    @if(Auth::check())
      @php
          // Mengambil data user yang sedang login di sesi web
          $user = Auth::user();
      @endphp

      <!-- TAMPILAN PROFIL DROPDOWN JIKA USER SUDAH LOGIN -->
      <div class="relative inline-block text-left">
          <!-- Tombol Pemicu Menu Profil -->
          <button type="button" onclick="toggleProfileMenu()" id="profileMenuBtn"
              class="flex items-center gap-2 bg-gray-50 hover:bg-gray-100 text-[#0D2031] px-4 py-1.5 rounded-md font-semibold transition duration-200 text-sm border border-gray-800">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-gray-500">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
              </svg>
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3 h-3 text-gray-400 transition-transform duration-200" id="profileMenuArrow">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
              </svg>
          </button>

          <!-- Kontainer Dropdown -->
          <div id="profileDropdown" 
              class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-100 rounded-2xl shadow-xl z-50 overflow-hidden transform opacity-0 scale-95 transition-all duration-200 origin-top-right">
              
              <!-- Informasi Email Akun -->
              <div class="px-4 py-2.5 border-b border-gray-100 bg-gray-50/50">
                  <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Akun Anda</p>
                  <p class="text-xs font-bold text-[#0D2031] truncate">{{ $user->email }}</p>
              </div>

              <!-- List Menu Pilihan -->
              <div class="p-1.5 space-y-0.5">
                  <a href="/admin/orders" 
                     class="flex items-center gap-2 w-full text-left px-3 py-2 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-[#0D2031] transition">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-gray-400">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                      </svg>
                      Pesanan 
                  </a>

                  <!-- Menu Tambahan ke Admin Dashboard (Khusus Admin) -->
                  @if($user->is_admin || $user->role === 'admin' || (method_exists($user, 'canAccessPanel') && $user->canAccessPanel(filament()->getCurrentPanel() ?? filament()->getPanel('admin'))))
                  <a href="/admin" 
                     class="flex items-center gap-2 w-full text-left px-3 py-2 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-[#0D2031] transition">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-gray-400">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                          <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                      </svg>
                      Dashboard
                  </a>
                  @endif

                  <hr class="border-gray-100 my-1 mx-2">

                  <!-- Form Logout -->
                  <form method="POST" action="{{ route('logout') }}" class="block w-full">
                      @csrf
                      <button type="submit" 
                              class="flex items-center gap-2 w-full text-left px-3 py-2 rounded-xl text-sm font-semibold text-red-600 hover:bg-red-50 transition">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                          </svg>
                          Logout
                      </button>
                  </form>
              </div>
          </div>
      </div>
    @else
      <!-- TAMPILAN JIKA PENGUNJUNG BELUM LOGIN -->
      <div class="flex gap-2">
        <a href="/admin/login"
          class="px-4 py-1.5 border border-[#0D2031] text-[#0D2031] rounded hover:bg-[#0D2031]/10 transition text-sm font-medium">
          Masuk
        </a>
        <a href="/admin/register"
          class="px-4 py-1.5 bg-[#0D2031] text-white rounded shadow hover:bg-[#0D2031]/80 transition text-sm font-medium">
          Daftar
        </a>
      </div>
    @endif

      <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-body rounded-base md:hidden" aria-controls="navbar-sticky" aria-expanded="false">
          <span class="sr-only">Open main menu</span>
          <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14"/></svg>
      </button>
    </div>

    <!-- PERBAIKAN 2: LINK NAVIGASI DIBAWAH INI DIBERIKAN ROUTE HOME MELEKAT DENGAN ANCHOR-NYA -->
    <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
      <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium rounded-base bg-neutral-secondary-soft md:space-x-4 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-neutral-primary">
        <li>
          <a href="{{ route('home') }}" class="block py-2 px-1 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent relative after:absolute after:bottom-0 after:left-0 after:h-[2px] after:w-full after:origin-center after:scale-x-0 after:bg-[#0D2031] after:transition-transform after:duration-300 hover:after:scale-x-100" aria-current="page">Home</a>
        </li>
        <li>
          <a href="{{ route('home') }}#Recommendations" class="block py-2 px-1 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent relative after:absolute after:bottom-0 after:left-0 after:h-[2px] after:w-full after:origin-center after:scale-x-0 after:bg-[#0D2031] after:transition-transform after:duration-300 hover:after:scale-x-100">Recommendations</a>
        </li>
        <li>
          <a href="{{ route('home') }}#OurServices" class="block py-2 px-1 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent relative after:absolute after:bottom-0 after:left-0 after:h-[2px] after:w-full after:origin-center after:scale-x-0 after:bg-[#0D2031] after:transition-transform after:duration-300 hover:after:scale-x-100">Our Services</a>
        </li>
        <li>
          <a href="{{ route('viewproduct') }}" class="block py-2 px-1 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent relative after:absolute after:bottom-0 after:left-0 after:h-[2px] after:w-full after:origin-center after:scale-x-0 after:bg-[#0D2031] after:transition-transform after:duration-300 hover:after:scale-x-100">Product</a>
        </li>
        <li>
          <a href="{{ route('home') }}#Contact" class="block py-2 px-1 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent relative after:absolute after:bottom-0 after:left-0 after:h-[2px] after:w-full after:origin-center after:scale-x-0 after:bg-[#0D2031] after:transition-transform after:duration-300 hover:after:scale-x-100">Contact</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- END OF NAVBAR -->

<!-- MODAL DAFTAR -->
<div id="authModal" class="hidden fixed inset-0 bg-black/50 z-[9999] flex items-center justify-center p-4" onclick="if(event.target === this) closeAuthModal()">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">

    <button onclick="closeAuthModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700">&times;</button>

    <h2 class="text-lg font-semibold mb-6 text-[#0D2031]">Buat Akun Baru</h2>

    @if ($errors->any())
      <div class="mb-4 text-sm text-red-600">
        @foreach ($errors->all() as $error)
          <p>{{ $error }}</p>
        @endforeach
      </div>
    @endif

    <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
      @csrf
      <input type="text" name="name" placeholder="Nama" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#0D2031]">
      <input type="email" name="email" placeholder="Email" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#0D2031]">
      <input type="password" name="password" placeholder="Password" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#0D2031]">
      <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#0D2031]">
      <button type="submit" class="w-full bg-[#0D2031] text-white py-2 rounded hover:bg-[#0D2031]/80 transition">Daftar</button>
    </form>

  </div>
</div>

<script>
  function openAuthModal() {
    document.getElementById('authModal').classList.remove('hidden');
  }
  
  function closeAuthModal() {
    document.getElementById('authModal').classList.add('hidden');
  }

  // LOGIK DROPDOWN MENU PROFIL USER
  function toggleProfileMenu() {
      const dropdown = document.getElementById('profileDropdown');
      const arrow = document.getElementById('profileMenuArrow');
      
      if(dropdown.classList.contains('hidden')) {
          dropdown.classList.remove('hidden');
          setTimeout(() => {
              dropdown.classList.remove('opacity-0', 'scale-95');
              dropdown.classList.add('opacity-100', 'scale-100');
              arrow.classList.add('rotate-180');
          }, 10);
      } else {
          closeProfileMenu();
      }
  }

  function closeProfileMenu() {
      const dropdown = document.getElementById('profileDropdown');
      const arrow = document.getElementById('profileMenuArrow');
      
      if(dropdown && !dropdown.classList.contains('hidden')) {
          dropdown.classList.remove('opacity-100', 'scale-100');
          dropdown.classList.add('opacity-0', 'scale-95');
          arrow.classList.remove('rotate-180');
          setTimeout(() => {
              dropdown.classList.add('hidden');
          }, 150);
      }
  }

  // Tutup otomatis jika user mengklik sembarang tempat di luar area dropdown profil
  window.addEventListener('click', function(e) {
      const dropdown = document.getElementById('profileDropdown');
      const button = document.getElementById('profileMenuBtn');
      
      if (dropdown && !dropdown.contains(e.target) && !button.contains(e.target)) {
          closeProfileMenu();
      }
  });

  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeAuthModal();
        closeProfileMenu();
    }
  });
</script>
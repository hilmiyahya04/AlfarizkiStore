<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-50">

    @include('components.header')
    @include('components.navbar')

    <section class="animate-fade-in-smooth bg-gray-50 py-8 antialiased md:py-16 mt-5">
        <div class="max-w-screen-xl mx-auto px-4 2xl:px-0">
            <div class="flex items-center mt-6">
                <h1 class="animate-fade-in-smooth text-2xl font-bold text-gray-900">
                    Keranjang |
                </h1>
                <button 
                    onclick="history.back()" 
                    class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium text-gray-700"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    Kembali
                </button>
            </div>

            @auth
            <div class="animate-fade-in-smooth bg-white border-2 border-gray-200 rounded-2xl p-6 mb-6 flex items-start justify-between gap-4 mt-5">
                @if($lastAddress && $lastAddress->recipient_name)
                    <div>
                        <p class="text-sm font-semibold text-[#0D2031] flex items-center gap-1.5">
                            📍 Alamat Pengiriman
                        </p>
                        <p class="mt-2 font-bold text-gray-900">
                            {{ $lastAddress->recipient_name }} ({{ $lastAddress->phone_number }})
                        </p>
                        <p class="text-sm text-gray-600 mt-1 leading-relaxed">
                            {{ $lastAddress->street_address }}{{ $lastAddress->address_detail ? ', ' . $lastAddress->address_detail : '' }},
                            {{ $lastAddress->district }}, {{ $lastAddress->city }}, {{ $lastAddress->province }} {{ $lastAddress->postal_code }}
                        </p>
                    </div>
                    <button type="button" onclick="openCheckoutModal()"
                        class="text-sm font-semibold text-blue-600 hover:underline shrink-0 whitespace-nowrap">
                        Ubah
                    </button>
                @else
                    <div>
                        <p class="text-sm font-semibold text-gray-500">📍 Belum ada alamat pengiriman</p>
                        <p class="text-sm text-gray-400 mt-1">Tambahkan alamat sebelum checkout</p>
                    </div>
                    <button type="button" onclick="openCheckoutModal()"
                        class="text-sm font-semibold text-blue-600 hover:underline shrink-0 whitespace-nowrap">
                        + Tambah Alamat
                    </button>
                @endif
            </div>
            @endauth

            <div class="animate-fade-in-smooth mt-6 sm:mt-8 lg:flex lg:items-start lg:justify-center gap-8 pb-16">

                <!-- LEFT -->
                <div class="animate-fade-in-smooth w-full lg:max-w-2xl xl:max-w-4xl space-y-6">

                    @if($cart && count($cart) > 0)

                        @foreach($cart as $id => $item)

                            <div class="animate-fade-in-smooth rounded-2xl border border-gray-200 bg-white p-4 sm:p-6 shadow-sm hover:shadow-md transition">

                                <div class="flex flex-col md:flex-row md:items-center gap-6">

                                    <!-- IMAGE -->
                                     <div class="animate-fade-in-smooth shrink-0">

                                        <img
                                            src="{{ $item['image']
                                                ? asset('storage/' . $item['image'])
                                                : 'https://placehold.co/200x200/F3F4F6/F3F4F6' }}"
                                            alt="{{ $item['name'] }}"
                                            class="w-24 h-24 object-cover rounded-xl"
                                        >
                                    </div>

                                    <!-- INFO -->
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-lg text-gray-900">
                                            {{ $item['name'] }}
                                        </h3>

                                        @if(!empty($item['color']) || !empty($item['size']))
                                            <p class="text-sm text-gray-500 mt-1">
                                                @if(!empty($item['color']))
                                                    Warna: <span class="font-medium text-gray-700">{{ $item['color'] }}</span>
                                                @endif
                                                @if(!empty($item['color']) && !empty($item['size']))
                                                    &nbsp;|&nbsp;
                                                @endif
                                                @if(!empty($item['size']))
                                                    Ukuran: <span class="font-medium text-gray-700">{{ $item['size'] }}</span>
                                                @endif
                                            </p>
                                        @endif

                                        <p class="text-sm text-gray-500 mt-1">
                                            Harga:
                                            Rp {{ number_format($item['price'], 0, ',', '.') }}
                                        </p>
                                    </div>

                                    <!-- RIGHT -->
                                    <div class="flex flex-col items-end gap-4">

                                        <!-- SUBTOTAL -->
                                        <p class="font-bold text-lg text-gray-900">
                                            Rp {{ number_format($item['price'] * ($item['quantity'] ?? 1), 0, ',', '.') }}
                                        </p>

                                        <div class="flex items-center gap-4">

                                            <!-- QTY -->
                                            <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">

                                                <!-- MINUS -->
                                                <button
                                                    type="button"
                                                    class="btn-qty-decrease px-3 py-2 text-gray-600 hover:bg-gray-100 transition"
                                                    data-id="{{ $id }}"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke-width="2"
                                                        stroke="currentColor"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M5 12h14" />
                                                    </svg>
                                                </button>

                                                <!-- QTY NUMBER -->
                                                <span
                                                    id="qty-{{ $id }}"
                                                    class="px-4 py-2 text-sm font-medium min-w-[40px] text-center"
                                                >
                                                    {{ $item['quantity'] ?? 1 }}
                                                </span>

                                                <!-- PLUS -->
                                                <button
                                                    type="button"
                                                    class="btn-qty-increase px-3 py-2 text-gray-600 hover:bg-gray-100 transition"
                                                    data-id="{{ $id }}"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke-width="2"
                                                        stroke="currentColor"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M12 4.5v15m7.5-7.5h-15" />
                                                    </svg>
                                                </button>
                                            </div>
                                           <form action="{{ route('cart.remove', $id) }}" method="POST" class="form-delete-cart">
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="button" 
                                                    onclick="confirmDeleteCart(this)"
                                                    class="text-red-600 hover:text-red-800 transition"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach

                    @else

                        <div class="animate-fade-in-smooth bg-white border-2 border-gray-200 rounded-2xl p-10 text-center text-gray-500 hover:shadow-lg transition space-y-5">
                            Keranjang kosong
                        </div>

                    @endif

                </div>

                <!-- RIGHT -->
                <div class="animate-fade-in-smooth w-full max-w-md mt-6 lg:mt-0">

                    @php
                        $total = 0;

                        if($cart){
                            foreach($cart as $item){
                                $qty = $item['quantity'] ?? 1;
                                $price = $item['price'] ?? 0;

                                $total += $price * $qty;
                            }
                        }
                    @endphp

                    <div class="bg-white border-2 border-gray-200 rounded-2xl p-8 shadow-sm hover:shadow-lg transition space-y-5">

                        <h3 class="text-xl font-semibold text-gray-900">
                            Ringkasan Belanja
                        </h3>

                        <div class="flex items-center justify-between text-lg font-bold">
                            <span>Total</span>
                            <span>
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </span>
                        </div>

                        <form action="{{ route('orders.store') }}" method="POST">
                            @csrf
                            
                            @auth
                                <button
                                    type="button"
                                    onclick="openCheckoutModal()"
                                    class="w-full bg-[#0D2031] text-white py-3 rounded-xl hover:bg-gray-700 transition"
                                >
                                    Checkout
                                </button>
                            @endauth

                            @guest
                                 <button
                                    type="button"
                                    onclick="alert('Silakan login terlebih dahulu untuk checkout')"
                                    class="w-full bg-[#0D2031] text-white py-3 rounded-xl hover:bg-gray-700 transition"
                                >
                                    Checkout
                                </button>
                            @endguest
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </section>

    @include('components.product')
    @include('components.footer')

    @vite(['resources/js/cart.js'])

    @auth
<!-- ======================================================== -->
<!-- MODAL CHECKOUT: ISI ALAMAT & METODE PEMBAYARAN            -->
<!-- ======================================================== -->
<div id="checkoutModal" class="hidden fixed inset-0 bg-black/60 z-[9999] items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg p-6 border border-gray-100 max-h-[90vh] overflow-y-auto">

        <h3 class="text-xl font-extrabold text-[#0D2031] mb-1">Alamat Pengiriman</h3>
        <p class="text-sm text-gray-500 mb-6">Lengkapi data di bawah sebelum melanjutkan checkout.</p>

        <form action="{{ route('orders.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="recipient_name" required
                    value="{{ old('recipient_name', $lastAddress->recipient_name ?? '') }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0D2031]/20">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                <input type="text" name="phone_number" required
                    value="{{ old('phone_number', $lastAddress->phone_number ?? '') }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0D2031]/20">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi</label>
                    <input type="text" name="province" required
                        value="{{ old('province', $lastAddress->province ?? '') }}"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0D2031]/20">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kota</label>
                    <input type="text" name="city" required
                        value="{{ old('city', $lastAddress->city ?? '') }}"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0D2031]/20">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
                    <input type="text" name="district" required
                        value="{{ old('district', $lastAddress->district ?? '') }}"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0D2031]/20">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode Pos</label>
                    <input type="text" name="postal_code" required
                        value="{{ old('postal_code', $lastAddress->postal_code ?? '') }}"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0D2031]/20">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Jalan, Gedung, No. Rumah</label>
                <textarea name="street_address" required rows="2"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0D2031]/20">{{ old('street_address', $lastAddress->street_address ?? '') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Detail Lainnya <span class="text-gray-400 font-normal">(cth: patokan, blok/unit)</span></label>
                <textarea name="address_detail" rows="2"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0D2031]/20">{{ old('address_detail', $lastAddress->address_detail ?? '') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Label Alamat</label>
                <select name="address_label" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0D2031]/20">
                    <option value="Rumah" @selected(old('address_label', $lastAddress->address_label ?? 'Rumah') == 'Rumah')>Rumah</option>
                    <option value="Kantor" @selected(old('address_label', $lastAddress->address_label ?? 'Rumah') == 'Kantor')>Kantor</option>
                    <option value="Lainnya" @selected(old('address_label', $lastAddress->address_label ?? 'Rumah') == 'Lainnya')>Lainnya</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Metode Pembayaran</label>
                <select name="payment_method" required class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0D2031]/20">
                    <option value="COD" @selected(old('payment_method', $lastAddress->paymentMethod ?? '') == 'COD')>COD (Bayar di Tempat)</option>
                    <option value="Transfer Bank" @selected(old('payment_method', $lastAddress->paymentMethod ?? '') == 'Transfer Bank')>Transfer Bank</option>
                </select>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeCheckoutModal()"
                    class="flex-1 border border-gray-300 text-gray-700 py-3 rounded-xl font-semibold hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit"
                    class="flex-1 bg-[#0D2031] text-white py-3 rounded-xl font-semibold hover:bg-opacity-90 transition">
                    Konfirmasi & Checkout
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openCheckoutModal() {
        const modal = document.getElementById('checkoutModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    function closeCheckoutModal() {
        const modal = document.getElementById('checkoutModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endauth

<!-- ======================================================== -->
<!-- POP UP CHECKOUT KERANJANG BERHASIL (MODAL)               -->
<!-- ======================================================== -->
@if(session('checkout_success'))
<div id="successCartModal" class="fixed inset-0 bg-black/60 z-[9999] flex items-center justify-center p-4 backdrop-blur-sm transition-opacity duration-300">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-6 text-center border border-gray-100 transform scale-100 transition-transform duration-300">
        
        <!-- Animasi Icon Centang Belanjaan -->
        <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-emerald-50 mb-6">
            <svg class="h-10 w-10 text-emerald-500 animate-bounce" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
            </svg>
        </div>

        <!-- Judul & Deskripsi -->
        <h3 class="text-2xl font-extrabold text-[#0D2031] mb-2">Checkout Berhasil!</h3>
        <p class="text-sm text-gray-500 leading-relaxed px-2 mb-6">
            {{ session('checkout_success') }}
        </p>

        <!-- Tombol Aksi -->
        <button onclick="closeSuccessCartModal()" 
            class="w-full bg-[#0D2031] text-white py-3 rounded-xl font-bold hover:bg-opacity-90 active:scale-[0.98] transition duration-200 shadow-md shadow-[#0D2031]/20">
            Selesai & Lihat Produk
        </button>
    </div>
</div>

<script>
    function closeSuccessCartModal() {
        const modal = document.getElementById('successCartModal');
        if (modal) {
            modal.classList.add('opacity-0');
            setTimeout(() => {
                modal.remove();
                @if(session('checkout_product_id'))
                    window.location.href = "{{ route('product.detail', session('checkout_product_id')) }}";
                @else
                    window.location.href = "{{ url('/products') }}";
                @endif
            }, 250);
        }
    }
</script>
@endif

    <!-- ======================================================== -->
<!-- POP UP KONFIRMASI HAPUS KERANJANG (MODAL)                -->
<!-- ======================================================== -->
<div id="confirmDeleteModal" class="hidden fixed inset-0 bg-black/60 z-[9999] flex items-center justify-center p-4 backdrop-blur-sm opacity-0 transition-opacity duration-300">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-6 text-center border border-gray-100 transform scale-95 transition-transform duration-300">
        
        <!-- Animasi Icon Peringatan Merah -->
        <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-red-50 mb-6">
            <svg class="h-10 w-10 text-red-500 animate-pulse" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
            </svg>
        </div>

        <!-- Judul & Deskripsi -->
        <h3 class="text-2xl font-extrabold text-[#0D2031] mb-2">Hapus Produk?</h3>
        <p class="text-sm text-gray-500 leading-relaxed px-2 mb-6">
            Apakah Anda yakin ingin menghapus produk ini dari keranjang belanja Anda?
        </p>

        <!-- Tombol Aksi Bersandingan -->
        <div class="flex gap-3">
            <button onclick="closeDeleteModal()" 
                class="w-1/2 bg-gray-100 text-gray-700 py-3 rounded-xl font-bold hover:bg-gray-200 active:scale-[0.98] transition duration-200">
                Batal
            </button>
            <button id="btnExecuteDelete" 
                class="w-1/2 bg-red-600 text-white py-3 rounded-xl font-bold hover:bg-red-700 active:scale-[0.98] transition duration-200 shadow-md shadow-red-600/20">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

<script>
    let activeFormToDelete = null;

    function confirmDeleteCart(button) {
        // Cari form pembungkus dari tombol yang diklik
        activeFormToDelete = button.closest('.form-delete-cart');
        
        const modal = document.getElementById('confirmDeleteModal');
        
        // Tampilkan modal dengan efek transisi halus
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modal.querySelector('.transform').classList.remove('scale-95');
            modal.querySelector('.transform').classList.add('scale-100');
        }, 10);
    }

    function closeDeleteModal() {
        const modal = document.getElementById('confirmDeleteModal');
        if (modal) {
            modal.classList.add('opacity-0');
            modal.querySelector('.transform').classList.remove('scale-100');
            modal.querySelector('.transform').classList.add('scale-95');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                activeFormToDelete = null; // Reset form aktif
            }, 250);
        }
    }

    // Aksi ketika tombol "Ya, Hapus" ditekan di dalam modal
    document.getElementById('btnExecuteDelete').addEventListener('click', function() {
        if (activeFormToDelete) {
            activeFormToDelete.submit(); // Kirim form ke server
        }
    });
</script>


    <script src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.js"></script>

    @vite(['resources/js/cart.js'])

</body>
</html>

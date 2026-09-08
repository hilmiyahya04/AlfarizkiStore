<!DOCTYPE html>
<html lang="en">
<body>

<section class="animate-fade-in-smooth pt-24 py-8 bg-white mt-3">

<div class="px-4 mx-auto max-w-7xl 2xl:px-0">

        <div class="flex w-full">

            <h1 class="animate-fade-in-smooth text-2xl font-bold text-gray-900 ml-7">
                Produk Detail |
            </h1>

                <button 
                    onclick="history.back()" 
                    class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-100 transition"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    Kembali
                </button>

        </div>

    <!-- GRID UTAMA: Berubah dari 1 kolom (mobile) menjadi 3 kolom (lg/desktop) -->
    <div class="animate-fade-in-smooth grid grid-cols-1 lg:grid-cols-3 gap-8 xl:gap-12 mt-8">

        <!-- KOLOM 1: IMAGE (Otomatis ke tengah di mobile dengan mx-auto) -->
        <div class="animate-fade-in-smooth shrink-0 max-w-[350px] mx-auto lg:ml-auto w-full">
            <img 
                class="w-full h-[350px] object-cover rounded-xl shadow-sm"
                src="{{ $product->productImage1 
                    ? asset('storage/' . $product->productImage1) 
                    : 'https://placehold.co/600x600/F3F4F6/F3F4F6' }}"
                alt="{{ $product->productName }}"
            >
        </div>

        <!-- KOLOM 2: DETAIL PRODUK (Lebar penuh di mobile, mengambil sisa ruang di desktop) -->
        <div class="animate-fade-in-smooth max-w-none lg:max-w-none">
            <!-- TITLE -->
            <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">
                {{ $product->productName }}
            </h1>

            <!-- KODE -->
            <p class="text-sm text-gray-500 mt-2">
                Kode: {{ $product->productCode }}
            </p>

            <!-- RATING -->
            <div class="flex items-center gap-1 mt-2">
                @php
                    $avgRating = round($product->reviews_avg_rating ?? 0);
                @endphp

                @for ($i = 1; $i <= 5; $i++)
                    <svg class="w-4 h-4 {{ $i <= $avgRating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.958a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.368 2.447a1 1 0 00-.363 1.118l1.287 3.957c.3.921-.755 1.688-1.538 1.118l-3.367-2.447a1 1 0 00-1.176 0l-3.367 2.447c-.783.57-1.838-.197-1.538-1.118l1.287-3.957a1 1 0 00-.364-1.118L2.983 9.385c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.951-.69l1.286-3.958z" />
                    </svg>
                @endfor

                <span class="text-sm text-gray-500 ml-1">
                    @if($product->reviews_count > 0)
                        {{ number_format($product->reviews_avg_rating, 1) }} ({{ $product->reviews_count }} ulasan)
                    @else
                        Belum ada ulasan
                    @endif
                </span>
            </div>

            <!-- PRICE -->
            <div class="mt-4 flex items-center gap-4">
                <p class="text-2xl font-extrabold text-gray-900">
                    Rp {{ number_format($product->productPrice, 0, ',', '.') }}
                </p>
            </div>

            <!-- PILIHAN WARNA -->
            <div class="flex flex-wrap gap-2 mt-4">
                @foreach($product->variants->unique('color') as $variant)
                    <button
                        type="button"
                        class="color-option border border-gray-300 rounded-md px-2.5 py-1 text-xs hover:border-[#0D2031] hover:bg-[#0D2031] hover:text-white transition"
                        data-color="{{ $variant->color }}"
                    >
                        {{ $variant->color }}
                    </button>
                @endforeach
            </div>

            <!-- PILIHAN UKURAN -->
            <div class="flex flex-wrap gap-2 mt-4">
                @foreach($product->variants->unique('size') as $variant)
                    <button
                        type="button"
                        class="size-option border border-gray-300 rounded-md px-2.5 py-1 text-xs hover:border-[#0D2031] hover:bg-[#0D2031] hover:text-white transition"
                        data-size="{{ $variant->size }}"
                    >
                        {{ $variant->size }}
                    </button>
                @endforeach
            </div>

            <div class="mt-2">
                <span id="stock-info" class="text-red-500 font-medium">
                    Silahkan pilih variasi terlebih dahulu
                </span>
            </div>

            <hr class="w-full lg:w-3/4 my-6 border-gray-200" />

            <!-- DESCRIPTION -->
            <p class="text-sm text-gray-600 leading-relaxed">
                {{ $product->category->categoryDescription ?? 'Tidak ada deskripsi kategori.' }}
            </p>
        </div>

        <!-- KOLOM 3: KARTU DI PALING KANAN (Otomatis ke tengah di mobile) -->
        <div class="animate-fade-in-smooth mb-16 flex justify-center lg:justify-start">
            <div class="animate-fade-in-smooth bg-white w-full max-w-[350px] lg:max-w-[300px] p-6 rounded-3xl border border-gray-200 shadow-md hover:shadow-xl transition duration-300 flex flex-col justify-between gap-6">

                <!-- CONTENT -->
                <div class="space-y-5">
                    <!-- TITLE -->
                    <h5 class="animate-fade-in-smooth text-lg font-bold text-black">
                        Atur jumlah dan catatan
                    </h5>

                    <!-- IMAGE & TITLE MINI -->
                    <div class="flex items-center gap-4">
                        <img
                            class="w-16 h-16 object-cover rounded-xl border border-gray-200"
                            src="{{ $product->productImage1
                                ? asset('storage/' . $product->productImage1)
                                : 'https://placehold.co/200x200/F3F4F6/F3F4F6' }}"
                            alt="{{ $product->productName }}"
                        >
                        <h1 class="text-sm font-medium text-gray-900 line-clamp-2">
                            {{ $product->productName }}
                        </h1>
                    </div>

                    <div>
                        <div class="inline-flex border border-gray-300 rounded-xl overflow-hidden">
                            <button
                                type="button"
                                id="btn-qty-decrease"
                                class="px-4 py-2 text-gray-600 hover:bg-gray-100 transition"
                            >
                                -
                            </button>

                            <span
                                id="qty-{{ $product->id }}"
                                class="px-5 py-2 text-sm font-semibold min-w-[50px] text-center border-x border-gray-300 flex items-center justify-center"
                            >
                                1
                            </span>

                            <button
                                type="button"
                                id="btn-qty-increase"
                                class="px-4 py-2 text-gray-600 hover:bg-gray-100 transition"
                            >
                                +
                            </button>
                        </div>
                    </div>
                                        
                    <!-- STOCK -->
                    <div class="text-sm text-gray-600">
                        Stock : <span class="font-semibold text-black">{{ $product->productAvailability }}</span> Pcs
                    </div>

                    <!-- TOTAL -->
                    <div class="animate-fade-in-smooth flex items-center justify-between pt-2 border-t border-gray-100">
                        <span class="text-md font-semibold text-gray-900">Subtotal</span>
                        <p class="font-bold text-gray-900 text-lg">
                            <span class="text-sm font-semibold text-gray-900">Rp </span>
                            <span id="price-{{ $product->id }}">
                                {{ number_format($product->productPrice * ($item['quantity'] ?? 1), 0, ',', '.') }}
                            </span>
                        </p>
                    </div>
                </div>

                <!-- BUTTON GROUP -->
                <div class="pt-2 flex gap-3">
                @auth
                <!-- Tombol Keranjang -->
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="cart-add-form">
                    @csrf
                    <input type="hidden" name="product_variant_id" class="js-variant-id" value="">
                    <input type="hidden" name="quantity" class="js-qty-input" value="1">
                    <button
                        type="submit"
                        class="px-4 py-3 border border-[#0D2031] text-[#0D2031] rounded-xl hover:bg-gray-100 transition"
                    >
                        🛒
                    </button>
                </form>

                <!-- Tombol Pesan -->
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="w-full cart-add-form">
                    @csrf
                    <input type="hidden" name="product_variant_id" class="js-variant-id" value="">
                    <input type="hidden" name="quantity" class="js-qty-input" value="1">
                    <button
                        type="submit"
                        class="w-full bg-[#0D2031] text-white py-3 rounded-xl hover:bg-opacity-90 transition duration-300 font-semibold"
                    >
                    Beli Sekarang
                    </button>
                </form>
            @else

            <button
                type="button"
                onclick="showVariantWarningModal('Silakan login terlebih dahulu untuk menambahkan produk ke keranjang.')"
                class="px-4 py-3 border border-[#0D2031] text-[#0D2031] rounded-xl hover:bg-gray-100 transition"
            >
                🛒
            </button>

            <button
                type="button"
                onclick="showVariantWarningModal('Silakan login terlebih dahulu untuk memesan produk.')"
                class="flex-1 bg-[#0D2031] text-white py-3 rounded-xl hover:bg-opacity-90 transition duration-300 font-semibold"
            >
                Pesan
            </button>

    @endauth
</div>

            </div>
        </div>

    </div>
</div>

</section>

<!-- ======================================================== -->
<!-- POP UP BERHASIL TAMBAH KERANJANG (MODAL)                -->
<!-- ======================================================== -->
<div id="cartSuccessModal" class="hidden fixed inset-0 bg-black/60 z-[9999] flex items-center justify-center p-4 backdrop-blur-sm opacity-0 transition-opacity duration-300">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-6 text-center border border-gray-100 transform scale-95 transition-transform duration-300">
        
        <!-- Animasi Icon Centang Hijau / Emerald -->
        <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-emerald-50 mb-6">
            <svg class="h-10 w-10 text-emerald-500 animate-bounce" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 10 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>

        <!-- Judul & Pesan -->
        <h3 class="text-2xl font-extrabold text-[#0D2031] mb-2">Berhasil Masuk Keranjang!</h3>
        <p class="text-sm text-gray-500 leading-relaxed px-2 mb-6">
            Produk pilihanmu sudah berhasil ditambahkan ke keranjang belanja.
        </p>

        <!-- Tombol Pilihan -->
        <div class="flex gap-3">
            <button onclick="closeCartSuccessModal()" 
                class="flex-1 border border-gray-300 text-gray-700 py-3 rounded-xl font-bold hover:bg-gray-50 active:scale-[0.98] transition duration-200 text-sm">
                Lanjut Belanja
            </button>
            <a href="{{ route('cart.index') }}" 
                class="flex-1 bg-[#0D2031] text-white py-3 rounded-xl font-bold hover:bg-opacity-90 active:scale-[0.98] transition duration-200 text-sm text-center shadow-md shadow-[#0D2031]/20 flex items-center justify-center">
                Lihat Keranjang
            </a>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- POP UP PERINGATAN VARIANT BELUM DIPILIH (MODAL)           -->
<!-- ======================================================== -->
<div id="variantWarningModal" class="hidden fixed inset-0 bg-black/60 z-[9999] flex items-center justify-center p-4 backdrop-blur-sm opacity-0 transition-opacity duration-300">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-6 text-center border border-gray-100 transform scale-95 transition-transform duration-300">
        
        <!-- Animasi Icon Peringatan Amber/Kuning -->
        <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-amber-50 mb-6">
            <svg class="h-10 w-10 text-amber-500 animate-bounce" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
            </svg>
        </div>

        <!-- Judul & Pesan -->
        <h3 class="text-2xl font-extrabold text-[#0D2031] mb-2">Pilihan Belum Lengkap</h3>
        <p id="variantWarningMessage" class="text-sm text-gray-500 leading-relaxed px-2 mb-6">
            Silakan pilih warna dan ukuran produk terlebih dahulu.
        </p>

        <!-- Tombol Mengerti -->
        <button onclick="{{ auth()->guest() ? "window.location.href='" . route('filament.admin.auth.login') . "'" : 'closeVariantWarningModal()' }}"
            class="w-full bg-[#0D2031] text-white py-3 rounded-xl font-bold hover:bg-opacity-90 active:scale-[0.98] transition duration-200 shadow-md shadow-[#0D2031]/20">
            {{ auth()->guest() ? 'Login untuk Melanjutkan' : 'Mengerti & Pilih Varian' }}
        </button>
    </div>
</div>

    @include('components.header')

    @include('components.navbar')

    @include('components.footer')

    <script src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.js"></script>
    <script>
    // Fungsi Menampilkan Modal Pop-up Warning
    function showVariantWarningModal(message) {
        const modal = document.getElementById('variantWarningModal');
        const messageEl = document.getElementById('variantWarningMessage');
        const modalCard = modal.querySelector('div');

        if (messageEl) messageEl.innerText = message;

        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modalCard.classList.remove('scale-95');
            modalCard.classList.add('scale-100');
        }, 10);
    }

    // Fungsi Menutup Modal Pop-up Warning
    function closeVariantWarningModal() {
        const modal = document.getElementById('variantWarningModal');
        const modalCard = modal.querySelector('div');

        modal.classList.add('opacity-0');
        modalCard.classList.remove('scale-100');
        modalCard.classList.add('scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
function showVariantWarningModal(message) {
        const modal = document.getElementById('variantWarningModal');
        const messageEl = document.getElementById('variantWarningMessage');
        const modalCard = modal.querySelector('div');

        if (messageEl) messageEl.innerText = message;

        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modalCard.classList.remove('scale-95');
            modalCard.classList.add('scale-100');
        }, 10);
    }

    function closeVariantWarningModal() {
        const modal = document.getElementById('variantWarningModal');
        const modalCard = modal.querySelector('div');

        modal.classList.add('opacity-0');
        modalCard.classList.remove('scale-100');
        modalCard.classList.add('scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    // --- QTY HANDLER ---
    const productId = {{ $product->id }};
    const basePrice = {{ $product->productPrice }};
    let qty = 1;
    const qtyDisplay = document.getElementById(`qty-${productId}`);
    const priceDisplay = document.getElementById(`price-${productId}`);
    const qtyInputs = document.querySelectorAll('.js-qty-input');

    function updateQtyUI() {
        qtyDisplay.textContent = qty;
        qtyInputs.forEach(input => input.value = qty);
        if (priceDisplay) {
            priceDisplay.textContent = (basePrice * qty).toLocaleString('id-ID');
        }
    }

    document.getElementById('btn-qty-increase').addEventListener('click', () => {
        qty++;
        updateQtyUI();
    });

    document.getElementById('btn-qty-decrease').addEventListener('click', () => {
        if (qty > 1) {
            qty--;
            updateQtyUI();
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        const variants = @json($product->variants);

        let selectedColor = null;
        let selectedSize = null;

        const colorButtons = document.querySelectorAll('.color-option');
        const sizeButtons = document.querySelectorAll('.size-option');
        const variantIdInputs = document.querySelectorAll('.js-variant-id');
        const stockInfo = document.getElementById('stock-info');

        function updateSelectedVariant() {
            const matched = variants.find(v =>
                v.color === selectedColor && v.size === selectedSize
            );

            variantIdInputs.forEach(input => {
                input.value = matched ? matched.id : '';
            });

            if (!selectedColor || !selectedSize) {
                stockInfo.textContent = 'Silahkan pilih variasi terlebih dahulu';
                stockInfo.classList.add('text-red-500');
            } else if (!matched) {
                stockInfo.textContent = 'Kombinasi warna & ukuran ini tidak tersedia';
                stockInfo.classList.add('text-red-500');
            } else {
                stockInfo.textContent = `Stok tersedia: ${matched.stock ?? matched.variantStock ?? '-'} pcs`;
                stockInfo.classList.remove('text-red-500');
            }
        }

        colorButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                colorButtons.forEach(b => b.classList.remove('bg-[#0D2031]', 'text-white'));
                btn.classList.add('bg-[#0D2031]', 'text-white');
                selectedColor = btn.dataset.color;
                updateSelectedVariant();
            });
        });

        sizeButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                sizeButtons.forEach(b => b.classList.remove('bg-[#0D2031]', 'text-white'));
                btn.classList.add('bg-[#0D2031]', 'text-white');
                selectedSize = btn.dataset.size;
                updateSelectedVariant();
            });
        });

        document.querySelectorAll('.cart-add-form').forEach(form => {
            form.addEventListener('submit', (e) => {
                const variantInput = form.querySelector('.js-variant-id');
                if (!variantInput.value) {
                    e.preventDefault();

                    if (!selectedColor && !selectedSize) {
                        showVariantWarningModal('Silakan pilih warna dan ukuran produk terlebih dahulu.');
                    } else if (!selectedColor) {
                        showVariantWarningModal('Silakan pilih warna produk terlebih dahulu.');
                    } else if (!selectedSize) {
                        showVariantWarningModal('Silakan pilih ukuran produk terlebih dahulu.');
                    } else {
                        showVariantWarningModal('Kombinasi warna dan ukuran ini tidak tersedia.');
                    }
                }
            });
        });
    });
</script>
</body>
</html>
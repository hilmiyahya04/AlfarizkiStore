    <!-- Mengubah lg:grid-cols-4 menjadi lg:grid-cols-3 agar pas untuk 3 produk -->
    <div class="animate-fade-in-smooth grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-10  ">

        <!-- Menambahkan ->take(3) untuk membatasi perulangan hanya 3 kali -->
        @foreach($products->take(3) as $product)
            <!-- PRODUCT CARD (SERAGAM) -->
            <a href="{{ route('product.detail', $product->id) }}"
                class="animate-fade-in-smooth group relative flex flex-col justify-between bg-[#f3f4f6] rounded-[2rem] p-6 transition-all duration-300 hover:shadow-xl min-h-[340px] sm:min-h-[360px]">

                <!-- HEADER CARD: Nama, Harga, Wishlist -->
                <div class="flex items-start justify-between z-10">
                    <div>
                        <!-- KATEGORI -->
                        <span class="text-[10px] sm:text-xs font-semibold uppercase tracking-wider text-gray-400 block mb-1">
                            {{ $product->category->categoryName ?? 'Kategori' }}
                        </span>

                        <!-- NAMA PRODUK -->
                        <h3 class="font-bold text-gray-900 text-base sm:text-lg line-clamp-1">
                            {{ $product->productName }}
                        </h3>

                        <!-- HARGA PRODUK -->
                        <p class="font-bold text-[#f25c38] text-sm sm:text-base mt-1">
                            Rp {{ number_format($product->productPrice, 0, ',', '.') }}
                        </p>
                    </div>

                    <!-- Wishlist Heart Button -->
                    <button type="button" class="flex items-center justify-center rounded-full bg-white/80 p-2 text-[#f25c38] hover:bg-white transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </div>

                <!-- IMAGE PRODUCT -->
                <div class="relative w-full my-4 flex items-center justify-center flex-1">
                    <img
                        class="w-full h-full object-contain max-h-[200px] group-hover:scale-105 transition duration-500"
                        src="{{ $product->productImage1
                            ? asset('storage/' . $product->productImage1)
                            : 'https://placehold.co/600x600/F3F4F6/F3F4F6' }}"
                        alt="{{ $product->productName }}"
                        loading="lazy"
                    >
                </div>

                <!-- FOOTER CARD: Size/Color Badge & Action Arrow -->
                <div class="flex items-end justify-between z-10 mt-auto">
                    
                    <!-- Sizes & Color Dots Placeholder -->
                    <div class="flex flex-col gap-2">
                        <!-- Size Badges -->
                        <div class="flex items-center gap-1">
                            <span class="px-2 py-0.5 text-[10px] sm:text-xs font-semibold bg-white text-gray-700 rounded-full border border-gray-200">42</span>
                            <span class="px-2 py-0.5 text-[10px] sm:text-xs font-semibold bg-white text-gray-700 rounded-full border border-gray-200">43</span>
                            <span class="px-2 py-0.5 text-[10px] sm:text-xs font-semibold bg-white text-gray-700 rounded-full border border-gray-200">44</span>
                        </div>

                        <!-- Color Dots -->
                        <div class="flex items-center gap-1.5">
                            <span class="w-3.5 h-3.5 rounded-full bg-black block border border-white"></span>
                            <span class="w-3.5 h-3.5 rounded-full bg-slate-500 block border border-white"></span>
                            <span class="w-3.5 h-3.5 rounded-full bg-sky-500 block border border-white"></span>
                            <span class="w-3.5 h-3.5 rounded-full bg-orange-500 block border border-white"></span>
                        </div>
                    </div>

                    <!-- Action Button (Orange Arrow) -->
                    <div class="rounded-full bg-[#f25c38] text-white flex items-center justify-center w-9 h-9 group-hover:bg-[#d94a27] transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </div>

                </div>

            </a>
        @endforeach
    </div>
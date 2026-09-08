<!-- START REKOMENDASI PRODUCT -->
<div id="Recommendations" class="animate-fade-in-smooth pt-12 sm:pt-24 lg:pt-32 py-12 md:py-16 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- HEADER -->
    <div class="text-center">
        <h1 class="animate-fade-in-smooth text-xl sm:text-2xl md:text-5xl font-bold text-gray-900">
            Recommendations
        </h1>
    </div>

    @auth
        @if($recommendations->isNotEmpty())
            <!-- GRID PRODUCT BENTO STYLE -->
            <div class="animate-fade-in-smooth grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mt-10">

                @foreach($recommendations as $product)
                    @php
                        $isFirst = $loop->first;
                    @endphp

                    <!-- PRODUCT CARD CONTAINER -->
                    <div class="animate-fade-in-smooth group relative flex flex-col justify-between bg-[#f3f4f6] rounded-[2rem] p-6 transition-all duration-300 hover:shadow-xl
                        {{ $isFirst ? 'md:col-span-2 md:row-span-2 min-h-[500px] md:min-h-[600px]' : 'col-span-1 min-h-[280px] sm:min-h-[320px]' }}">
                        
                        <!-- STRETCHED LINK (Membuat seluruh card bisa diklik tanpa bentrok) -->
                        <a href="{{ route('product.detail', $product->id) }}" class="absolute inset-0 z-0 rounded-[2rem]">
                            <span class="sr-only">Lihat Detail {{ $product->productName }}</span>
                        </a>

                        <!-- HEADER CARD: Nama, Harga, Wishlist -->
                        <div class="flex items-start justify-between z-10 pointer-events-none">
                            <div class="pointer-events-auto">
                                <h3 class="font-bold text-gray-900 line-clamp-1 {{ $isFirst ? 'text-2xl sm:text-3xl md:text-4xl' : 'text-base sm:text-lg' }}">
                                    {{ $product->productName }}
                                </h3>
                                <p class="font-bold text-[#f25c38] mt-1 {{ $isFirst ? 'text-xl sm:text-2xl' : 'text-sm sm:text-base' }}">
                                    Rp {{ number_format($product->productPrice, 0, ',', '.') }}
                                </p>
                            </div>

                            <!-- Wishlist Heart Button (Z-Index di atas Stretched Link) -->
                            <button type="button" 
                                class="z-20 pointer-events-auto flex items-center justify-center rounded-full bg-white/80 p-2 text-[#f25c38] hover:bg-white hover:scale-110 transition-all shadow-sm">
                                <svg class="{{ $isFirst ? 'w-6 h-6' : 'w-4 h-4' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                        </div>

                        <!-- IMAGE PRODUCT -->
                        <div class="relative w-full my-4 flex items-center justify-center flex-1 pointer-events-none">
                            <img
                                class="w-full h-full object-contain group-hover:scale-105 transition duration-500 {{ $isFirst ? 'max-h-[380px]' : 'max-h-[180px] sm:max-h-[200px]' }}"
                                src="{{ $product->productImage1 ? asset('storage/' . $product->productImage1) : 'https://placehold.co/600x600/F3F4F6/F3F4F6' }}"
                                alt="{{ $product->productName }}"
                                loading="lazy"
                            >
                        </div>

                        <!-- FOOTER CARD: Size/Color Badge & Action Arrow -->
                        <div class="flex items-end justify-between z-10 mt-auto pointer-events-none">
                            
                            <!-- Sizes & Color Dots Placeholder -->
                            <div class="flex flex-col gap-2 pointer-events-auto">
                                <!-- Size Badges -->
                                <div class="flex items-center gap-1">
                                    <span class="px-2 py-0.5 text-[10px] sm:text-xs font-semibold bg-white text-gray-700 rounded-full border border-gray-200">42</span>
                                    <span class="px-2 py-0.5 text-[10px] sm:text-xs font-semibold bg-white text-gray-700 rounded-full border border-gray-200">43</span>
                                    <span class="px-2 py-0.5 text-[10px] sm:text-xs font-semibold bg-white text-gray-700 rounded-full border border-gray-200">44</span>
                                </div>

                                <!-- Color Dots -->
                                <div class="flex items-center gap-1.5">
                                    <span class="w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-black block border border-white"></span>
                                    <span class="w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-slate-500 block border border-white"></span>
                                    <span class="w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-sky-500 block border border-white"></span>
                                    <span class="w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-orange-500 block border border-white"></span>
                                </div>
                            </div>

                            <!-- Action Button (Orange Arrow) -->
                            <div class="rounded-full bg-[#f25c38] text-white flex items-center justify-center group-hover:bg-[#d94a27] transition-colors {{ $isFirst ? 'w-14 h-14' : 'w-8 h-8 sm:w-9 sm:h-9' }}">
                                <svg class="{{ $isFirst ? 'w-7 h-7' : 'w-4 h-4' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </div>

                        </div>

                    </div>
                @endforeach
            </div>
        @else
            <div class="animate-fade-in-smooth py-16 text-center text-gray-400">
                <p>Belum ada rekomendasi untukmu saat ini.</p>
                <p class="text-sm mt-2">
                    Coba beli atau rating beberapa produk terlebih dahulu.
                </p>
            </div>
        @endif
        @else
        @include('components.beforerecomendation')
        @endauth

</div>
<!-- END REKOMENDASI PRODUCT -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alfarizki Shop</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 flex flex-col min-h-screen">

<section class="animate-fade-in-smooth flex-grow bg-white">

        <div id="default-carousel" class="relative w-full max-w-7xl mx-auto px-4 sm:px-6 rounded-xl mt-24" data-carousel="slide">
    <!-- CAROUSEL -->
    <div id="default-carousel" class="relative w-full rounded-2xl mt-24 overflow-hidden border-2 border-gray-200" data-carousel="slide">
        <div class="relative h-56 overflow-hidden md:h-96">
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="{{ asset('assets/carouselclassic.png') }}" class="absolute inset-0 w-full h-full object-cover" alt="Carousel Slide 1">
            </div>
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="{{ asset('assets/carouselemon.png') }}" class="absolute inset-0 w-full h-full object-cover" alt="Carousel Slide 2">
            </div>
        </div>

        <!-- Indicator Buttons -->
        <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
            <button type="button" class="w-3 h-3 rounded-full bg-white/50 hover:bg-white" aria-current="true" aria-label="Slide 1" data-carousel-slide-to="0"></button>
            <button type="button" class="w-3 h-3 rounded-full bg-white/50 hover:bg-white" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
        </div>

                <!-- Slider controls -->
        <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-base bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-5 h-5 text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 19-7-7 7-7"/></svg>
                <span class="sr-only">Previous</span>
            </span>
        </button>
        <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-base bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-5 h-5 text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/></svg>
                <span class="sr-only">Next</span>
            </span>
        </button>
    </div>
        
        @if($products->isEmpty())
            <div class="text-center py-12">
                <p class="text-xl text-gray-500 font-medium">Produk tidak ditemukan 🌟</p>
            </div>
        @else
<div id="Product" class="animate-fade-in-smooth pt-20 pb-20">

        <!-- GRID 3 KOLOM SERAGAM -->
        <div class="animate-fade-in-smooth grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 ">

            @foreach($products as $product)
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
        </div>
    </div>
</div>
@endif

</section>

@include('components.header')
@include('components.navbar')
@include('components.footer')

<script src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.js"></script>
</body>
</html>
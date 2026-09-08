
<!-- START SEARCH -->
  <div class="animate-fade-in-smooth bg-#FFFFFF p-8 md:p-12 lg:px-16 lg:py-24 mt-24">
    <div class="mx-auto max-w-lg text-center">
        <h1 class="animate-fade-in-smooth text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 text-center">
            All About
        </h1>

        <p class="animate-fade-in-smoothhidden text-black sm:mt-4 sm:block">
            Beli sepatu impianmu di Alfarizki! Temukan koleksi sepatu terbaru
            dengan harga terbaik. Daftar sekarang untuk penawaran eksklusif dan
            diskon menarik!
        </p>
    </div>

 <div class="mx-auto mt-8 max-w-4xl">
    <form action="{{ route('product.search') }}" method="GET">

        <div class="flex items-center rounded-full bg-[#e9e9ee] p-2 shadow-sm">

        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            autocomplete="off"
            class="w-full bg-transparent px-6 py-3 text-lg text-gray-700 border-none outline-none focus:outline-none focus:ring-0 focus:shadow-none"
        />


            <button
                type="submit"
                class="flex h-14 w-14 items-center justify-center rounded-full bg-[#11131a] text-white transition hover:scale-105"
            >
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m21 21-4.35-4.35m1.85-5.15a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                </svg>
            </button>

        </div>

    </form>
</div>
</div>
<!-- END SEARCH -->



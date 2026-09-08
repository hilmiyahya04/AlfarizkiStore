<!-- Container Utama -->
<div id="OurServices" class="animate-fade-in-smooth w-full min-h-screen bg-white py-8 px-4 flex flex-col gap-4 mt-12">

    <div class="text-center">
        <h1 class="animate-fade-in-smooth text-xl sm:text-2xl md:text-5xl font-bold text-gray-900">
            Our Services
        </h1>
    </div>

    <div class="flex flex-col md:flex-row justify-center items-center mx-auto w-fit gap-16 mt-16">
        
        <div class="flex flex-col items-center gap-3 text-center">
            <img src="{{ asset('assets/shield.png') }}" alt="brand" class="w-32 h-auto object-contain">
            <div class="flex flex-col gap-2">
                <h3 class="text-2xl font-bold leading-tight tracking-tight text-black md:text-2xl">
                    Safe & Secure
                </h3>
                <p class="text-base text-gray-600 leading-normal md:text-lg">
                    Secure transactions with advanced protection
                </p>
            </div>
        </div>
        
        <div class="flex flex-col items-center gap-3 text-center">
            <img src="{{ asset('assets/quality-assurance.png') }}" alt="brand" class="w-32 h-auto object-contain">
            <div class="flex flex-col gap-2">
                <h3 class="text-2xl font-bold leading-tight tracking-tight text-black md:text-2xl">
                    Your Most Reliable Choice
                </h3>
                <p class="text-base text-gray-600 leading-normal md:text-lg">
                    With years of experience, we've become a trusted name
                </p>
            </div>
        </div>
        
        <div class="flex flex-col items-center gap-3 text-center">
            <img src="{{ asset('assets/offer.png') }}" alt="brand" class="w-32 h-auto object-contain">
            <div class="flex flex-col gap-2">
                <h3 class="text-2xl font-bold leading-tight tracking-tight text-black md:text-2xl">
                    Daily Exclusive Deals
                </h3>
                <p class="text-base text-gray-600 leading-normal md:text-lg">
                    Never miss out on limited-time offers
                </p>
            </div>
        </div>
    </div>

    <form action="#" class="bg-[#0D2031] block w-full max-w-6xl mx-auto p-8 md:p-20 rounded-3xl border border-gray-800 shadow-md hover:shadow-xl transition duration-300 mt-32">

        <!-- Layout 2 Kolom: Gambar Kiri, Konten Kanan -->
        <div class="flex flex-col md:flex-row items-center gap-8 md:gap-12">
            
            <!-- Kolom Kiri: Gambar -->
            <div class="shrink-0">
                <img 
                    src="assets/Container.png"
                    class="w-48 sm:w-80 h-auto object-cover transition-opacity duration-500 ease-in-out opacity-0"
                    alt="shopping illustration"
                    fetchpriority="high"
                    loading="eager"
                    onload="this.classList.remove('opacity-0'); document.getElementById('hero-img-container')?.classList.remove('animate-pulse', 'bg-slate-800')" 
                />
            </div>

            <!-- Kolom Kanan: Judul, Deskripsi & Input Form -->
            <div class="flex-1 text-left w-full">
                <h1 class="animate-fade-in-smooth text-xl sm:text-2xl md:text-5xl font-bold text-white mb-2">
                    Find Your Perfect Fit
                </h1>

                <p class="animate-fade-in-smooth text-sm sm:text-md md:text-lg font-normal text-gray-200 mb-6">
                    Get the latest trends delivered right to your inbox.
                </p>

                <!-- Input Section -->
                <div class="w-full max-w-lg">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-200">
                        Your Email
                    </label>
                    
                    <div class="flex flex-col sm:flex-row gap-3">
                        <input type="email" id="email" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-3" placeholder="email" required>
                        
                        <button type="submit" class="bg-white text-[#0D2031] hover:bg-gray-100 font-semibold text-sm px-6 py-3 rounded-lg transition duration-200 whitespace-nowrap">
                            Subscribe
                        </button>
                    </div>
                </div>
            </div>

        </div>

    </form>
</div> 
<!-- START HERO -->
<section class="animate-fade-in-smooth bg-white py-12 min-h-[70vh] antialiased mt-12">
  <div class="mx-auto grid max-w-screen-xl px-4 pb-8 md:grid-cols-12 gap-8 items-center">

    <!-- HERO IMAGE (Mobile: Atas) -->
    <div class="order-1 md:order-2 w-full md:col-span-5 flex justify-center">
      <div 
        id="hero-img-container" 
        class="w-full max-w-md md:max-w-lg aspect-square bg-slate-800 rounded-2xl animate-pulse flex items-center justify-center overflow-hidden"
      >
        <img 
          src="assets/Container.png"
          class="w-full h-full object-cover transition-opacity duration-500 ease-in-out opacity-0"
          alt="shopping illustration"
          fetchpriority="high"
          loading="eager"
          onload="this.classList.remove('opacity-0'); document.getElementById('hero-img-container').classList.remove('animate-pulse', 'bg-slate-800')" 
        />
      </div>
    </div>

    <!-- TEXT & CONTENT (Mobile: Bawah) -->
    <div class="order-2 md:order-1 md:col-span-7 text-center md:text-left">
      <h1 class="mb-4 text-7xl font-bold leading-none tracking-tight text-black md:max-w-4xl md:text-8xl xl:text-7xl">
        Run With <br />Confidence
      </h1>

      <p class="mb-6 max-w-2xl text-black md:text-lg lg:text-xl">
        Experience maximum comfort with the latest innovation
        in running technology. Designed for athletes who
        demand the best in performance and style.
      </p>

      <!-- CTA Buttons -->
      <div class="flex flex-wrap items-center justify-center md:justify-start gap-4">
        <a href="#" class="inline-block rounded-2xl bg-[#FFC000] px-6 py-3.5 font-bold text-black hover:bg-[#e6ad00] transition-colors">
          Order Now &gt;
        </a>
        <a href="#" class="inline-block rounded-2xl border-2 border-black px-6 py-3.5 font-bold text-black hover:bg-black hover:text-white transition-colors">
          Explore More
        </a>
      </div>

      <!-- Statistics -->
      <div class="flex flex-col md:flex-row items-center justify-center md:justify-start gap-8 mt-8 mb-4">
        <div class="flex items-center gap-5">
          <p class="text-4xl font-bold leading-none tracking-tight text-black md:text-2xl">
            1K+ <br /><span class="text-sm font-normal md:text-base">BRAND</span>
          </p>
        </div>

        <div class="flex items-center gap-5">
          <p class="text-4xl font-bold leading-none tracking-tight text-black md:text-2xl">
            10+ <br /><span class="text-sm font-normal md:text-base">SHOPS</span>
          </p>
        </div>

        <div class="flex items-center gap-5">
          <p class="text-4xl font-bold leading-none tracking-tight text-black md:text-2xl">
            190k+ <br /><span class="text-sm font-normal md:text-base">CUSTOMER</span>
          </p>
        </div>
      </div>
    </div>

  </div>

  <!-- BRAND LOGOS / LIST -->
  <div class="mx-auto grid max-w-screen-xl grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 sm:gap-8 lg:gap-12 px-4 w-full mt-8">
    <a href="#" class="flex items-center justify-center p-2">
      <span class="font-extrabold text-lg sm:text-xl md:text-2xl lg:text-3xl text-gray-400 hover:text-gray-900 dark:text-gray-500 dark:hover:text-white transition-colors duration-200">JORDAN</span>
    </a>
    <a href="#" class="flex items-center justify-center p-2">
      <span class="font-extrabold text-lg sm:text-xl md:text-2xl lg:text-3xl text-gray-400 hover:text-gray-900 dark:text-gray-500 dark:hover:text-white transition-colors duration-200">NIKE</span>
    </a>
    <a href="#" class="flex items-center justify-center p-2">
      <span class="font-extrabold text-lg sm:text-xl md:text-2xl lg:text-3xl text-gray-400 hover:text-gray-900 dark:text-gray-500 dark:hover:text-white transition-colors duration-200">SUPREME</span>
    </a>
    <a href="#" class="flex items-center justify-center p-2">
      <span class="font-extrabold text-lg sm:text-xl md:text-2xl lg:text-3xl text-gray-400 hover:text-gray-900 dark:text-gray-500 dark:hover:text-white transition-colors duration-200">FILA</span>
    </a>
    <a href="#" class="flex items-center justify-center p-2">
      <span class="font-extrabold text-lg sm:text-xl md:text-2xl lg:text-3xl text-gray-400 hover:text-gray-900 dark:text-gray-500 dark:hover:text-white transition-colors duration-200">ADIDAS</span>
    </a>
    <a href="#" class="flex items-center justify-center p-2">
      <span class="font-extrabold text-lg sm:text-xl md:text-2xl lg:text-3xl text-gray-400 hover:text-gray-900 dark:text-gray-500 dark:hover:text-white transition-colors duration-200">VANS</span>
    </a>
  </div> 
</section>
<!-- END OF HERO -->
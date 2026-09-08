{{-- resources/views/components/footer.blade.php --}}

<footer class="animate-fade-in-smooth w-full bg-black text-white mt-12">

    <div id="Contact" class="mx-auto max-w-[1700px] px-8 md:px-16 py-24">

        {{-- Top Footer --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-16">

            {{-- Brand --}}
            <div class="space-y-8">

                <h2 class="animate-fade-in-smooth text-2xl font-black tracking-tight">
                    Alfarizki
                </h2>

                <p class="max-w-md text-lg leading-relaxed text-zinc-200">
                    Kami menjual berbagai macam produk kebutuhan Anda
                </p>

            </div>

            {{-- Brand Menu --}}
            <div class="space-y-8">

                <h4 class="animate-fade-in-smooth text-sm font-bold uppercase tracking-[0.25em]">
                    Brand
                </h4>

                <ul class="space-y-4 text-zinc-300">

                    <li>
                        <a href="#" class="animate-fade-in-smooth hover:text-white transition">
                            Tentang Kami
                        </a>
                    </li>

                    <li>
                        <a href="#" class="animate-fade-in-smooth hover:text-white transition">
                            Inovasi
                        </a>
                    </li>

                    <li>
                        <a href="#" class="animate-fade-in-smooth hover:text-white transition">
                            Karir
                        </a>
                    </li>

                </ul>

            </div>

            {{-- Support --}}
            <div class="space-y-8">

                <h4 class="animate-fade-in-smooth text-sm font-bold uppercase tracking-[0.25em]">
                    Support
                </h4>

                <ul class="space-y-4 text-zinc-300">

                    <li>
                        <a href="#" class="animate-fade-in-smooth hover:text-white transition">
                            Kebijakan Privasi
                        </a>
                    </li>

                    <li>
                        <a href="#" class="animate-fade-in-smooth hover:text-white transition">
                            Ketentuan Layanan
                        </a>
                    </li>

                    <li>
                        <a href="#" class="animate-fade-in-smooth hover:text-white transition">
                            Pengiriman & Pengembalian
                        </a>
                    </li>

                </ul>

            </div>

            {{-- Contact --}}
            <div class="space-y-8">

                <h4 class="animate-fade-in-smooth text-sm font-bold uppercase tracking-[0.25em]">
                    Contact
                </h4>

                <div class="space-y-4 text-zinc-200">

                    <p class="animate-fade-in-smooth font-semibold">
                        Alfarizki@gmail.com
                    </p>

                    <p class="animate-fade-in-smooth font-semibold">
                        +628123456789
                    </p>

                </div>

            </div>

        </div>

        {{-- Divider --}}
        <div class="animate-fade-in-smooth mt-24 border-t border-white/20"></div>

        {{-- Bottom Footer --}}
        <div class="animate-fade-in-smooth mt-10 flex flex-col md:flex-row items-center justify-between gap-6">

            <p class="animate-fade-in-smooth text-sm font-semibold tracking-wide text-zinc-300 uppercase">
                © {{ date('Y') }} Alfarizki. ALL RIGHTS RESERVED.
            </p>

            <div class="flex items-center gap-10">

                <span class="animate-fade-in-smooth text-sm font-semibold text-zinc-300">
                    Designed in Indonesia
                </span>

                <span class="animate-fade-in-smooth text-sm font-semibold text-zinc-300">
                    Made for the Future
                </span>

            </div>

        </div>

    </div>

</footer>

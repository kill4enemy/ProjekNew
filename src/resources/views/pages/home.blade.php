@extends('layouts.app')

@section('content')

<div class="-mx-4 sm:-mx-6 lg:-mx-10 -mt-6">
    <section
        class="relative overflow-hidden min-h-[750px]
        bg-gradient-to-br
        from-slate-100 via-blue-100 to-cyan-100
        dark:from-slate-950 dark:via-blue-950 dark:to-slate-900"
    >
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(59,130,246,0.25),transparent_35%)]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_right,rgba(6,182,212,0.20),transparent_35%)]"></div>

        <div class="absolute top-20 left-20 w-72 h-72 bg-blue-500/10 dark:bg-blue-500/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 right-20 w-72 h-72 bg-cyan-500/10 dark:bg-cyan-500/20 rounded-full blur-3xl"></div>

        <div class="absolute inset-0 dark:bg-black/40"></div>

<div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-10 min-h-[620px] items-stretch px-8 md:px-28 pt-10 py-16">

    {{-- Left Card --}}
    <div class="w-full h-full rounded-2xl bg-white/80 dark:bg-white/10 backdrop-blur-sm border border-white/30 dark:border-white/20 p-7 md:p-8 shadow-2xl flex flex-col justify-center">
        <p class="text-blue-600 dark:text-blue-300 font-semibold tracking-widest uppercase mb-4">
            Hans Padel
        </p>

        <h1 class="text-4xl md:text-6xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
            Booking Lapangan Padel Jadi Lebih Mudah
        </h1>

        <p class="text-gray-700 dark:text-gray-200 text-lg mb-8 leading-relaxed">
            Sistem Informasi Penyewaan Lapangan Padel Berbasis Web membantu pengguna
            melihat lapangan, memilih jadwal, dan melakukan pemesanan secara online.
        </p>

        <div class="grid grid-cols-3 gap-4 mb-8">
            <div>
                <h3 class="text-3xl font-bold text-gray-900 dark:text-white">
                    {{ $totalBookings }}+
                </h3>
                <p class="text-gray-600 dark:text-gray-300">Booking</p>
            </div>

            <div>
                <h3 class="text-3xl font-bold text-gray-900 dark:text-white">
                    {{ $totalCourts }}
                </h3>
                <p class="text-gray-600 dark:text-gray-300">Lapangan</p>
            </div>

            <div>
                <h3 class="text-3xl font-bold text-gray-900 dark:text-white">
                    24/7
                </h3>
                <p class="text-gray-600 dark:text-gray-300">Akses Online</p>
            </div>
        </div>

        <div class="flex flex-wrap gap-4">
            <a
                href="/booking"
                class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition"
            >
                Booking Sekarang
            </a>

            <a
                href="/courts"
                class="bg-gray-900/10 dark:bg-white/20 text-gray-900 dark:text-white px-6 py-3 rounded-lg border border-gray-900/10 dark:border-white/30 hover:bg-gray-900/20 dark:hover:bg-white/30 transition"
            >
                Lihat Lapangan
            </a>
        </div>
    </div>

    {{-- Right Slideshow --}}
    <div class="relative w-full h-full min-h-[460px] rounded-2xl overflow-hidden border border-white/20 shadow-2xl">
        @forelse ($courts as $index => $court)
            <div class="court-slide absolute inset-0 transition-opacity duration-700 {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}">
                <img
                    src="{{ str_starts_with($court->image, 'images/')
                        ? asset($court->image)
                        : asset('storage/' . $court->image) }}"
                    alt="{{ $court->name }}"
                    class="w-full h-full object-cover"
                >

                <div class="absolute bottom-0 left-0 right-0 bg-black/60 p-5 text-white">
                    <h3 class="text-xl font-bold">
                        {{ $court->name }}
                    </h3>

                    <p class="text-sm text-gray-200">
                        Rp {{ number_format($court->price_per_hour) }} / jam
                    </p>
                </div>
            </div>
        @empty
            <div class="w-full h-full flex items-center justify-center bg-white/10 text-white">
                Belum ada gambar lapangan
            </div>
        @endforelse

        @if ($courts->count() > 1)
            <button
                type="button"
                id="prev-slide"
                class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/50 text-white w-10 h-10 rounded-full hover:bg-black/70"
            >
                ‹
            </button>

            <button
                type="button"
                id="next-slide"
                class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/50 text-white w-10 h-10 rounded-full hover:bg-black/70"
            >
                ›
            </button>

            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
                @foreach ($courts as $index => $court)
                    <button
                        type="button"
                        class="slide-dot w-3 h-3 rounded-full {{ $index === 0 ? 'bg-white' : 'bg-white/40' }}"
                        data-slide="{{ $index }}"
                    ></button>
                @endforeach
            </div>
        @endif
    </div>
</section>
</div>

{{-- Card About --}}
<section id="about" class="max-w-6xl mx-auto mt-12 px-4 scroll-mt-24">
    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow overflow-hidden">

        <div class="grid grid-cols-1 md:grid-cols-2">

            {{-- Gambar About --}}
            <div>
                @if($about && $about->image)
                    <img
                        src="{{ str_starts_with($about->image, 'images/')
                            ? asset($about->image)
                            : asset('storage/' . $about->image) }}"
                        alt="{{ $about->title }}"
                        class="w-full h-full min-h-[350px] object-cover"
                    >
                @endif
            </div>

            {{-- Isi About --}}
            <div class="p-8 flex flex-col justify-center">

                <h2 class="text-3xl font-bold mb-6 text-gray-900 dark:text-white">
                    {{ $about->title }}
                </h2>

                <p class="text-lg leading-relaxed text-gray-700 dark:text-white">
                    {{ $about->description }}
                </p>

            </div>

        </div>

    </div>
</section>

<section class="max-w-6xl mx-auto mt-10 px-4">

    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow overflow-hidden">

        <div class="grid grid-cols-1 md:grid-cols-2">

            {{-- MAPS --}}
            <div class="min-h-[350px] bg-gray-200 dark:bg-gray-700">

                {{-- ISI IFRAME --}}
                <div class="w-full h-full flex items-center justify-center text-gray-500">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.9269004526786!2d106.52337707475105!3d-6.27334259371544!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e420768746c45fb%3A0x192fcb02ae7a563f!2sUniversitas%20Esa%20Unggul%20Kampus%20Tangerang!5e0!3m2!1sid!2sid!4v1781577384829!5m2!1sid!2sid"
                        width="100%"
                        height="100%"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

            </div>

            {{-- INFO LOKASI --}}
            <div class="p-8 flex flex-col justify-center">

                <h2 class="text-3xl font-bold mb-6 text-gray-900 dark:text-white">
                    Lokasi Kami
                </h2>

                <div class="space-y-5 text-gray-700 dark:text-white leading-relaxed">

                    <div>
                        <span class="font-semibold text-gray-900 dark:text-white">
                            Alamat:
                        </span>

                        <p class="text-gray-700 dark:text-gray-100">
                            Jl. Contoh No. 123, Tangerang, Banten
                        </p>
                    </div>

                    <div>
                        <span class="font-semibold text-gray-900 dark:text-white">
                            WhatsApp:
                        </span>

                        <p class="text-gray-700 dark:text-gray-100">
                            +62 812-8421-6264
                        </p>
                    </div>

                    <div>
                        <span class="font-semibold text-gray-900 dark:text-white">
                            Email:
                        </span>

                        <p class="text-gray-700 dark:text-gray-100">
                            raihanisad2007@gmail.com
                        </p>
                    </div>

                    <div>
                        <span class="font-semibold text-gray-900 dark:text-white">
                            Jam Operasional:
                        </span>

                        <p class="text-gray-700 dark:text-gray-100">
                            Senin - Jumat : 08.00 - 22.00
                        </p>

                        <p class="text-gray-700 dark:text-gray-100">
                            Sabtu - Minggu : 07.00 - 23.00
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </div>

</section>


<script>
    const slides = document.querySelectorAll('.court-slide');
    const dots = document.querySelectorAll('.slide-dot');
    const nextButton = document.getElementById('next-slide');
    const prevButton = document.getElementById('prev-slide');

    let currentSlide = 0;
    let slideInterval;

    function showSlide(index) {
        if (!slides.length) return;

        slides[currentSlide].classList.remove('opacity-100');
        slides[currentSlide].classList.add('opacity-0');

        dots[currentSlide]?.classList.remove('bg-white');
        dots[currentSlide]?.classList.add('bg-white/40');

        currentSlide = (index + slides.length) % slides.length;

        slides[currentSlide].classList.remove('opacity-0');
        slides[currentSlide].classList.add('opacity-100');

        dots[currentSlide]?.classList.remove('bg-white/40');
        dots[currentSlide]?.classList.add('bg-white');
    }

    function nextSlide() {
        showSlide(currentSlide + 1);
    }

    function prevSlide() {
        showSlide(currentSlide - 1);
    }

    function startSlideShow() {
        slideInterval = setInterval(nextSlide, 3000);
    }

    function resetSlideShow() {
        clearInterval(slideInterval);
        startSlideShow();
    }

    nextButton?.addEventListener('click', () => {
        nextSlide();
        resetSlideShow();
    });

    prevButton?.addEventListener('click', () => {
        prevSlide();
        resetSlideShow();
    });

    dots.forEach((dot) => {
        dot.addEventListener('click', () => {
            showSlide(Number(dot.dataset.slide));
            resetSlideShow();
        });
    });

    if (slides.length > 1) {
        startSlideShow();
    }
</script>
@endsection
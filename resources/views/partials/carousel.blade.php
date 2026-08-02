@if($alumnis && count($alumnis) > 0)
<div x-data="{
        alumnis: @js($alumnis),
        autoplay: null,
        init() {
            this.startAutoplay();
        },
        startAutoplay() {
            this.autoplay = setInterval(() => {
                this.next();
            }, 3500);
        },
        stopAutoplay() {
            clearInterval(this.autoplay);
        },
        next() {
            const slider = this.$refs.slider;
            // Jika sudah di akhir, kembali ke awal
            if (Math.ceil(slider.scrollLeft) + slider.clientWidth >= slider.scrollWidth) {
                slider.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                // Pindah ke 'halaman' berikutnya
                slider.scrollBy({ left: slider.clientWidth, behavior: 'smooth' });
            }
        },
        prev() {
            const slider = this.$refs.slider;
            slider.scrollBy({ left: -slider.clientWidth, behavior: 'smooth' });
        }
    }"
    @mouseenter="stopAutoplay"
    @mouseleave="startAutoplay"
    class="relative w-full text-white px-4 md:px-0">

    <!-- Carousel Items (Container yang bisa di-scroll) -->
    <!-- 'scrollbar-hide' adalah class custom untuk menyembunyikan scrollbar, tambahkan di CSS Anda jika belum ada -->
    <div x-ref="slider" class="flex gap-4 md:gap-8 overflow-x-auto snap-x snap-mandatory scroll-smooth scrollbar-hide">
        <template x-for="alumni in alumnis" :key="alumni.id">
            <!-- Setiap Kartu Alumni -->
            <!-- Dibuat responsif: 1 kartu di mobile, 2 di tablet, 3 di desktop -->
            <div class="snap-center flex-shrink-0 w-[90%] sm:w-[48%] lg:w-[31%]">
                <div class="border-solid border-white border-8 text-black rounded-2xl shadow-lg overflow-hidden w-full">
                    <div class="relative">
                        <img :src="'/storage/' + alumni.image" :alt="alumni.name"
                            class="w-full h-96 object-cover">
                        <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-60 px-4 py-3">
                            <h3 class="text-lg font-bold text-white" x-text="alumni.name"></h3>
                            <p class="text-sm text-gray-200" x-text="alumni.achievement"></p>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- Navigation Arrows -->
    <!-- Tombol panah sekarang tersembunyi di mobile dan muncul di layar lebih besar -->
    <div class="absolute left-0 sm:left-4 top-1/2 transform -translate-y-1/2 z-10 hidden sm:block">
        <button @click="prev()" aria-label="Previous alumni"
            class="bg-gray-200 bg-opacity-50 text-2xl text-black w-12 h-12 rounded-full flex items-center justify-center hover:bg-opacity-75 transition-opacity">
            <span aria-hidden="true">&larr;</span>
        </button>
    </div>
    <div class="absolute right-0 sm:right-4 top-1/2 transform -translate-y-1/2 z-10 hidden sm:block">
        <button @click="next()" aria-label="Next alumni"
            class="bg-gray-200 bg-opacity-50 text-2xl text-black w-12 h-12 rounded-full flex items-center justify-center hover:bg-opacity-75 transition-opacity">
            <span aria-hidden="true">&rarr;</span>
        </button>
    </div>
</div>

<!-- Tambahkan ini ke file CSS Anda jika belum punya class untuk menyembunyikan scrollbar -->
<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
</style>
@endif

@if($alumnis && count($alumnis) > 0)
<div x-data="{
    activeIndex: 0,
    get visibleAlumnis() {
        return this.alumnis.slice(this.activeIndex, this.activeIndex + 3);
    },
    alumnis: @js($alumnis)
}" class="relative w-full overflow-hidden text-white">

    <!-- Carousel Items -->
    <div class="flex gap-4 justify-center transition-all duration-300">
        <template x-for="alumni in visibleAlumnis" :key="alumni.id">
            <div class="bg-white text-black rounded-2xl shadow-lg overflow-hidden w-full max-w-xs flex-shrink-0">
                <div class="relative">
                    <img :src="'/storage/' + alumni.image" alt="alumni.name"
                        class="w-full h-60 object-cover">
                    <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-60 px-4 py-3">
                        <h3 class="text-lg font-bold text-white" x-text="alumni.name"></h3>
                        <p class="text-sm text-gray-200" x-text="alumni.achievement"></p>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- Navigation Arrows -->
    <div class="absolute left-4 top-1/2 transform -translate-y-1/2 z-10">
        <button @click="activeIndex = (activeIndex - 1 + alumnis.length) % alumnis.length"
            class="bg-gray-700 text-white w-9 h-9 rounded-full flex items-center justify-center hover:bg-gray-600">
            &larr;
        </button>
    </div>
    <div class="absolute right-4 top-1/2 transform -translate-y-1/2 z-10">
        <button @click="activeIndex = (activeIndex + 1) % alumnis.length"
            class="bg-gray-700 text-white w-9 h-9 rounded-full flex items-center justify-center hover:bg-gray-600">
            &rarr;
        </button>
    </div>

    <!-- Autoplay -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('carousel', () => ({
                activeIndex: 0,
                alumnis: @js($alumnis),
                init() {
                    setInterval(() => {
                        this.activeIndex = (this.activeIndex + 1) % this.alumnis.length;
                    }, 3500);
                },
                get visibleAlumnis() {
                    return this.alumnis.slice(this.activeIndex, this.activeIndex + 3);
                }
            }))
        })
    </script>
</div>
@endif

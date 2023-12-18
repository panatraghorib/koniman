<script setup>
import { ref } from "vue";
import { Head, Link } from "@inertiajs/vue3";
import PublicLayout from "@/Layouts/PublicLayout.vue";

defineProps({
    hero: Object,
    allposts: Object,
});
// Import Swiper Vue.js components
import { Swiper, SwiperSlide } from "swiper/vue";
import {
    Autoplay,
    Navigation,
    Pagination,
    Scrollbar,
    A11y,
} from "swiper/modules";

// Import Swiper styles
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";
import "swiper/css/scrollbar";

// const swiperx = useSwiper();

const progressCircle = ref(null);
const progressContent = ref(null);
const onAutoplayTimeLeft = (s, time, progress) => {
    progressCircle.value.style.setProperty("--progress", 1 - progress);
    progressContent.value.textContent = `${Math.ceil(time / 1000)}s`;
};

const onSwiper = (swiper) => {
    console.log(swiper);
};
const onSlideChange = () => {
    console.log("slide change");
};

const swiperTextSlide = ref([]);
</script>

<template>
    <Head title="Welcome" />

    <PublicLayout>
        <div
            id="home"
            class="relative overflow-hidden bg-blue-dark pt-[80px] md:pt-[80px] lg:pt-[80px]"
        >
            <div class="-mx-0 flex flex-wrap items-center">
                <swiper
                    :style="{
                        '--swiper-navigation-color': '#fff',
                        '--swiper-pagination-color': '#fff',
                    }"
                    class="border-b-2 cursor-grap border-t-8 border-t-blue-800/80"
                    :modules="[
                        Autoplay,
                        Navigation,
                        Pagination,
                        Scrollbar,
                        A11y,
                    ]"
                    :spaceBetween="30"
                    :centeredSlides="true"
                    :autoplay="{
                        delay: 5000,
                        disableOnInteraction: false,
                    }"
                    :pagination="{
                        clickable: true,
                    }"
                    :navigation="true"
                    @autoplayTimeLeft="onAutoplayTimeLeft"
                >
                    <swiper-slide
                        v-for="(item, index) in hero"
                        :key="index"
                        class="sm:flex sm:justify-evenly max-h-[494px]"
                    >
                        <div>
                            <img
                                :src="item.featured_image"
                                class="max-h-screen object-cover max-sm:h-[484px] w-full"
                            />

                            <div
                                class="absolute bottom-0 left-0 md:left-36 right-0 px-4 py-2 bg-gray-800 opacity-70"
                            >
                                <h3 class="text-xl text-white font-bold">
                                    {{ item.name }}
                                </h3>
                                <p class="mt-2 text-sm text-gray-300">
                                    {{ item.intro }}
                                </p>
                            </div>
                        </div>
                    </swiper-slide>
                    <template #container-end>
                        <div
                            class="flex absolute right-16 bottom-16 z-10 w-40 h-w-40 items-center justify-center font-medium text-[color:var(--swiper-theme-color)] autoplay-progress"
                        >
                            <svg
                                viewBox="0 0 48 48"
                                ref="progressCircle"
                                class="[--progress: 0]"
                            >
                                <circle cx="24" cy="24" r="20"></circle>
                            </svg>
                            <span ref="progressContent"></span>
                        </div>
                    </template>
                </swiper>
            </div>
        </div>
    </PublicLayout>
</template>

<style scoped>
.autoplay-progress svg {
    --progress: 0;
    position: absolute;
    left: 0;
    top: 0px;
    z-index: 10;
    width: 100%;
    height: 100%;
    stroke-width: 4px;
    stroke: var(--swiper-theme-color);
    fill: none;
    stroke-dashoffset: calc(125.6 * (1 - var(--progress)));
    stroke-dasharray: 125.6;
    transform: rotate(-90deg);
}
</style>

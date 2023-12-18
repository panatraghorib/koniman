<script setup>
import { reactive, watch } from "vue";
import { usePage } from "@inertiajs/vue3";
const props = defineProps({
    type: String,
});
</script>

<template>
    <transition name="slide-fade">
        <div
            v-if="props.type"
            class="absolute top-4 right-4 w-8/12 md:w-6/12 lg:w-3/12 z-[100]"
        >
            <div
                class="flex items-center justify-between p-4 bg-green-600 rounded-lg"
            >
                <div>
                    <BaseIcon
                        :path="mdiAccountGroup"
                        class="w-4 h-4 me-2 group-hover:text-gray-500 dark:group-hover:text-gray-300"
                        :size="15"
                    />
                </div>
                <div
                    class="mx-3 text-sm font-medium text-white"
                    v-html="flash.success"
                ></div>
                <button
                    @click="toggle"
                    type="button"
                    class="ml-auto bg-white/20 text-white rounded-lg focus:ring-2 focus:ring-white/50 p-1.5 hover:bg-white/30 h-8 w-8"
                >
                    <span class="sr-only">Close</span>
                    <BaseIcon
                        :path="mdiAccountGroup"
                        class="w-4 h-4 me-2 group-hover:text-gray-500 dark:group-hover:text-gray-300"
                        :size="15"
                    />
                </button>
            </div>
        </div>
    </transition>
</template>

<style scoped>
/*
    Enter and leave animations can use different
    durations and timing functions.
    */
.slide-fade-enter-active {
    transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
    transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    transform: translateX(10px);
    opacity: 0;
}
</style>

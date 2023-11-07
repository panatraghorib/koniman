<script setup>
import { computed, ref, watch, nextTick } from "vue";
import BaseIcon from "@/Components/BaseIcon.vue";

const props = defineProps({
    searchInputs: {
        type: Object,
        required: true,
    },
    forcedVisibleSearchInputs: {
        type: Array,
        required: true,
    },
    slotProps: {
        type: [Array, Object],
        required: true,
    },
});

import { mdiFilterVariantPlus } from "@mdi/js";

const inputElClass = computed(() => {
    const base = [
        "block w-full px-4 text-sm text-gray-900 border border-gray-300 rounded-sm bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500",
        props.borderless ? "border-0" : "border",
        props.transparent ? "bg-transparent" : "bg-white dark:bg-slate-800",
        props.error ? "border border-red-700" : "border",
    ];

    if (props.icon) {
        base.push("pl-10");
    }

    return base;
});

function isForcedVisible(key) {
    return props.forcedVisibleSearchInputs.includes(key);
}
</script>

<template>
    <div
        v-for="(searchInput, key) in searchInputs"
        v-show="searchInput.value !== null || isForcedVisible(searchInput.key)"
        :key="key"
        class="px-4 sm:px-0"
    >
        <div class="flex shadow-sm relative mt-3 mx-3">
            <label
                :for="searchInput.key"
                class="inline-flex items-center px-2 text-xs italic border border-r-0 border-gray-300 bg-gray-50 text-blue-500"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 mr-1 text-blue-400"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                >
                    <path
                        fill-rule="evenodd"
                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                        clip-rule="evenodd"
                    />
                </svg>
                <span>{{ searchInput.label }}</span></label
            >
            <input
                :id="searchInput.key"
                :key="searchInput.key"
                :name="searchInput.key"
                :value="searchInput.value"
                type="text"
                class="flex-1 min-w-0 block w-full px-3 py-2 focus:ring-indigo-200 focus:border-indigo-500 text-sm border-gray-300"
                @input="
                    slotProps.onChange(searchInput.key, $event.target.value)
                "
            />
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                <button
                    class="text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-red-200"
                    :dusk="`remove-search-row-${searchInput.key}`"
                    @click.prevent="slotProps.onRemove(searchInput.key)"
                >
                    <span class="sr-only">Remove search</span>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>

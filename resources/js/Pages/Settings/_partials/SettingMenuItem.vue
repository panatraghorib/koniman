<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";
import BaseIcon from "@/Components/BaseIcon.vue";

const props = defineProps({
    item: {
        type: Object,
        required: true,
    },
});

const itemHref = computed(() =>
    props.item.route ? route(props.item.route) : props.item.href
);

const activeInactiveStyle = computed(() =>
    props.item.route && route().current(props.item.route)
        ? "border-b-2 border-t-2 border-b-blue-600 border-t-gray-200 dark:border-b-purple-300 dark:border-t-purple-700 text-blue-600 dark:text-purple-700"
        : "text-gray-600 dark:text-gray-300"
);
</script>
<template>
    <li class="me-2">
        <component
            :is="item.route ? Link : 'a'"
            :href="itemHref"
            :target="item.target ?? null"
            class="inline-flex items-center justify-center px-4 py-3 border-b-2 border-gray-300 hover:text-gray-600 hover:border-blue-500 dark:hover:text-gray-300 group"
            :class="activeInactiveStyle"
        >
            <BaseIcon
                v-if="item.icon"
                :path="item.icon"
                class="w-4 h-4 me-2 group-hover:text-gray-500 dark:group-hover:text-gray-300"
                :size="15"
            />
            {{ item.label }}
        </component>
    </li>

    <!-- <li
        v-for="(menuSetting, index) in settingMenu"
        :key="index"
        class="border-r"
    >
        <Link
            preserve-scroll
            :href="menuSetting.route"
            class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
        >
            <BaseIcon
                :path="menuSetting.icon"
                class="flex-none"
                :class="activeInactiveStyle"
                w="w-12"
            />

            {{ menuSetting.label }} {{ $page.url }}
        </Link>
    </li> -->
</template>

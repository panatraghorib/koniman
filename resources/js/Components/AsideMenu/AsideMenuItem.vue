<script setup>
import { ref, computed } from "vue";
// import { RouterLink } from 'vue-router'
import { Link } from "@inertiajs/vue3";
import { mdiMinus, mdiPlus } from "@mdi/js";
import { getButtonColor } from "@/colors.js";
import BaseIcon from "@/Components/BaseIcon.vue";
import AsideMenuList from "@/Components/AsideMenu/AsideMenuList.vue";
import { useDarkModeStore } from "@/Stores/darkMode.js";

const props = defineProps({
    item: {
        type: Object,
        required: true,
    },
    isDropdownList: Boolean,
});

const itemHref = computed(() =>
    props.item.route ? route(props.item.route) : props.item.href
);

const darkModeStore = useDarkModeStore();

const asideMenuItemActiveStyle = computed(() =>
    hasColor.value ? "" : "aside-menu-item-active font-medium"
);

const activeInactiveStyle = computed(() =>
    props.item.route && route().current(props.item.route)
        ? "font-medium text-white"
        : "text-gray-600 dark:text-gray-300"
);

const activeInactiveLiStyle = computed(() =>
    props.item.route && route().current(props.item.route)
        ? "border-t border-b border-l border-slate-50 dark:border-slate-800 shadow-inner text-gray-800 font-medium bg-blue-700 mb-1 rounded-l-lg dark:bg-blue-700"
        : "font-normal shadow"
);

const emit = defineEmits(["menu-click"]);

const hasColor = computed(() => props.item && props.item.color);

const isDropdownActive = ref(false);

const componentClass = computed(() => [
    props.isDropdownList ? "py-3 px-6 text-sm" : "py-3",
    hasColor.value
        ? getButtonColor(props.item.color, false, true)
        : `aside-menu-item dark:text-slate-300 dark:hover:text-white`,
]);

const hasDropdown = computed(() => !!props.item.menu);

const menuClick = (event) => {
    emit("menu-click", event, props.item);

    if (hasDropdown.value) {
        isDropdownActive.value = !isDropdownActive.value;
    }
};
</script>

<template>
    <li :class="activeInactiveLiStyle" class="ml-1">
        <component
            :is="item.route ? Link : 'a'"
            :href="itemHref"
            :target="item.target ?? null"
            class="flex cursor-pointer"
            :class="componentClass"
            @click="menuClick"
        >
            <BaseIcon
                v-if="item.icon"
                :path="item.icon"
                class="flex-none"
                :class="activeInactiveStyle"
                w="w-16"
                :size="18"
            />
            <span
                class="grow text-ellipsis line-clamp-1"
                :class="[
                    { 'pr-12': !hasDropdown },
                    activeInactiveStyle,
                    asideMenuItemActiveStyle,
                ]"
                >{{ item.label }}</span
            >
            <BaseIcon
                v-if="hasDropdown"
                :path="isDropdownActive ? mdiMinus : mdiPlus"
                class="flex-none"
                :class="activeInactiveStyle"
                w="w-12"
            />
        </component>
        <AsideMenuList
            v-if="hasDropdown"
            :menu="item.menu"
            :class="[
                'aside-menu-dropdown',
                isDropdownActive ? 'block dark:bg-slate-800/50' : 'hidden',
            ]"
            is-dropdown-list
        />
    </li>
</template>

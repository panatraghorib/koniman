<script setup>
import { ref, computed } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
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

const hasColor = computed(() => props.item && props.item.color);

const itemHref = computed(() =>
    props.item.route ? route(props.item.route) : props.item.href
);

const asideMenuItemActiveStyle = computed(() =>
    hasColor.value ? "" : "aside-menu-item-active"
);

const activeInactiveStyle = computed(() =>
    props.item.route && route().current(props.item.route)
        ? "font-medium text-[#075783]"
        : "dark:text-gray-300"
);

const activeInactiveLiStyle = computed(() =>
    props.item.route && route().current(props.item.route)
        ? "border-t border-b-2 border-l border-b-[#075783] dark:border-slate-800 mb-1 rounded-l-lg shadow"
        : "shadow"
);

const emit = defineEmits(["menu-click"]);

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

const isAdmin = usePage().props.isAdmin;
const userPermissions = usePage().props.user_permissions;

// filter menu berdasarkan permissions
const subMenuFiltered = computed(() => {
    if (props.item.hasOwnProperty("menu")) {
        return props.item.menu.filter((subMenuItem) => {
            if (isAdmin) {
                return true;
            } else if (subMenuItem.hasOwnProperty("default")) {
                return true;
            } else {
                if (subMenuItem.hasOwnProperty("permission")) {
                    return subMenuItem.permission.some((permission) => {
                        console.log(userPermissions.includes(permission));
                        return userPermissions.includes(permission);
                    });
                }
            }
        });
    }
});
</script>

<template>
    <li :class="activeInactiveLiStyle" class="ml-1">
        <component
            :is="item.route ? Link : 'a'"
            :href="itemHref"
            :target="item.target ?? null"
            class="flex font-sans font-normal cursor-pointer hover:text-blue-700"
            :class="[componentClass]"
            @click="menuClick"
        >
            <BaseIcon
                v-if="item.icon"
                :path="item.icon"
                class="flex-none -mr-3"
                :class="activeInactiveStyle"
                w="w-16"
                :size="18"
            />
            <span
                class="grow text-ellipsis line-clamp-1"
                :class="[
                    { 'pr-1': !hasDropdown },
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
            :menu="subMenuFiltered"
            :class="[
                'aside-menu-dropdown',
                isDropdownActive ? 'block dark:bg-slate-800/50' : 'hidden',
            ]"
            is-dropdown-list
        />
    </li>
</template>

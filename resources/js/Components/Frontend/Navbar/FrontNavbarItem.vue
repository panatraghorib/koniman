<script setup>
import { ref, computed } from "vue";
import { Link } from "@inertiajs/vue3";

// import { useDarkModeStore } from "@/Stores/darkMode.js";
// import { getButtonColor } from "@/colors.js";
import NavbarList from "@/Components/Frontend/Navbar/FrontNavbarList.vue";

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

// const darkModeStore = useDarkModeStore();

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

const menuClick = (event) => {
    emit("menu-click", event, props.item);

    if (hasDropdown.value) {
        isDropdownActive.value = !isDropdownActive.value;
    }
};

const componentClass = computed(() => [
    !!props.item.menu
        ? "relative items-center justify-between lg:pl-0 py-2 lg:py-6 xl:ml-5"
        : "ud-menu-scroll lg:px-0 py-2 lg:py-6 xl:ml-5",
]);

const hasDropdown = computed(() => !!props.item.menu);

const liClass = computed(() => [
    props.isDropdownList ? "submenu-item group relative" : "group relative",
]);
</script>

<template>
    <li>
        <component
            :is="item.route ? Link : 'a'"
            :href="itemHref"
            :target="item.target ?? null"
            :class="componentClass"
            class="flex font-medium text-base text-dark dark:text-white group-hover:text-primary lg:mr-0 lg:inline-flex lg:text-white lg:group-hover:text-white lg:group-hover:opacity-70"
            @click="menuClick"
        >
            <span>
                {{ item.label }}
            </span>

            <svg
                v-if="hasDropdown"
                class="fill-current ml-2"
                width="16"
                height="20"
                viewBox="0 0 16 20"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    d="M7.99999 14.9C7.84999 14.9 7.72499 14.85 7.59999 14.75L1.84999 9.10005C1.62499 8.87505 1.62499 8.52505 1.84999 8.30005C2.07499 8.07505 2.42499 8.07505 2.64999 8.30005L7.99999 13.525L13.35 8.25005C13.575 8.02505 13.925 8.02505 14.15 8.25005C14.375 8.47505 14.375 8.82505 14.15 9.05005L8.39999 14.7C8.27499 14.825 8.14999 14.9 7.99999 14.9Z"
                />
            </svg>
        </component>

        <div
            v-if="hasDropdown"
            class="submenu relative top-full left-0 hidden w-[250px] rounded-sm bg-white dark:bg-dark-2 p-4 transition-[top] duration-300 group-hover:opacity-100 lg:invisible lg:absolute lg:top-[110%] lg:block lg:opacity-0 lg:shadow-lg lg:group-hover:visible lg:group-hover:top-full"
        >
            <div
                v-for="(item, index) in item.menu"
                :key="index"
                class="border-b border-b-slate-200 dark:border-b-slate-700"
            >
                <Link
                    v-if="item.route"
                    :href="route(item.route)"
                    preserve-state
                    class="block rounded py-[7px] px-4 text-md text-body-color dark:text-dark-6 hover:text-primary dark:hover:text-primary"
                >
                    {{ item.label }}
                </Link>
                <a
                    v-else
                    href="#"
                    class="block rounded py-[7px] px-4 text-md text-body-color dark:text-dark-6 hover:text-primary dark:hover:text-primary"
                >
                    {{ item.label }}
                </a>
            </div>
            <!-- <a
                href="about.html"
                class="block rounded py-[7px] px-4 text-sm text-body-color dark:text-dark-6 hover:text-primary dark:hover:text-primary"
            >
                About Page
            </a>
            <a
                href="about.html"
                class="block rounded py-[7px] px-4 text-sm text-body-color dark:text-dark-6 hover:text-primary dark:hover:text-primary"
            >
                About Page
            </a> -->
            <!-- <NavbarList
                :menu="item.menu"
                :class="['text-gray-500']"
                is-dropdown-list
            /> -->
        </div>
    </li>
</template>

<script setup>
import { ref } from "vue";
import { containerMaxW } from "@/config.js";
import BaseIcon from "@/Components/BaseIcon.vue";
import NavBarMenuList from "@/Components/Navbar/NavBarMenuList.vue";
import NavBarItemPlain from "@/Components/Navbar/NavBarItemPlain.vue";
import { mdiClose, mdiDotsVertical } from "@mdi/js";

defineProps({
    menu: {
        type: Array,
        required: true,
    },
});

const emit = defineEmits(["menu-click"]);

const menuClick = (event, item) => {
    emit("menu-click", event, item);
};

const isMenuNavBarActive = ref(false);
</script>

<template>
    <nav
        class="top-0 inset-x-0 fixed bg-gray-50 h-14 z-30 transition-position w-screen lg:w-auto border-b-[#075783] dark:border-b-purple-800 dark:bg-slate-700 border-b-2 shadow-md shadow-slate-300 dark:shadow-gray-900/50"
    >
        <div class="flex lg:items-stretch" :class="containerMaxW">
            <div class="flex items-stretch flex-1 h-14">
                <slot />
            </div>
            <div class="flex items-stretch flex-none h-14 lg:hidden">
                <NavBarItemPlain
                    @click.prevent="isMenuNavBarActive = !isMenuNavBarActive"
                >
                    <BaseIcon
                        :path="isMenuNavBarActive ? mdiClose : mdiDotsVertical"
                        size="24"
                    />
                </NavBarItemPlain>
            </div>
            <div
                class="absolute left-0 w-screen overflow-y-auto rounded-tl-lg shadow-lg max-h-screen-menu lg:overflow-visible top-14 bg-slate-200 lg:w-auto lg:flex lg:static lg:shadow-none dark:bg-slate-800"
                :class="[isMenuNavBarActive ? 'block' : 'hidden']"
            >
                <NavBarMenuList :menu="menu" @menu-click="menuClick" />
            </div>
        </div>
    </nav>
</template>

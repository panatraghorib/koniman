<script setup>
import { mdiForwardburger, mdiBackburger, mdiMenu } from "@mdi/js";
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import { useDarkModeStore } from "@/Stores/darkMode.js";
import menuNavBar from "@/menuNavBar.js";
import NavBar from "@/Components/Navbar/NavBar.vue";
import NavBarItemPlain from "@/Components/Navbar/NavBarItemPlain.vue";
import BaseIcon from "@/Components/BaseIcon.vue";
import menuAside from "@/menuAside.js";
import AsideMenu from "@/Components/AsideMenu/AsideMenu.vue";
import FooterBar from "@/Components/FooterBar.vue";
import ToastNotification from "@/Components/ToastNotification.vue";

import FormControl from "@/Components/FormControl.vue";

const layoutAsidePadding = "xl:pl-60";

const darkModeStore = useDarkModeStore();

const isAsideMobileExpanded = ref(false);
const isAsideLgActive = ref(false);

router.on("navigate", () => {
    isAsideMobileExpanded.value = false;
    isAsideLgActive.value = false;
});

const menuClick = (event, item) => {
    if (item.isToggleLightDark) {
        darkModeStore.set();
    }

    if (item.isLogout) {
        router.post(route("logout"));
    }
};
</script>

<template>
    <div
        :class="{
            'overflow-hidden lg:overflow-visible': isAsideMobileExpanded,
        }"
    >
        <div
            :class="[
                layoutAsidePadding,
                { 'ml-60 lg:ml-0': isAsideMobileExpanded },
            ]"
            class="w-screen min-h-screen pt-14 transition-position lg:w-auto bg-gray-50 dark:bg-slate-800 dark:text-slate-100"
        >
            <ToastNotification :flash="$page.props.flash" />

            <NavBar
                :menu="menuNavBar"
                :class="[
                    layoutAsidePadding,
                    { 'ml-60 lg:ml-0': isAsideMobileExpanded },
                ]"
                @menu-click="menuClick"
            >
                <NavBarItemPlain
                    display="flex lg:hidden"
                    @click.prevent="
                        isAsideMobileExpanded = !isAsideMobileExpanded
                    "
                >
                    <BaseIcon
                        :path="
                            isAsideMobileExpanded
                                ? mdiBackburger
                                : mdiForwardburger
                        "
                        size="24"
                    />
                </NavBarItemPlain>
                <NavBarItemPlain
                    display="hidden lg:flex xl:hidden"
                    @click.prevent="isAsideLgActive = true"
                >
                    <BaseIcon :path="mdiMenu" size="24" />
                </NavBarItemPlain>
                <!-- <NavBarItemPlain use-margin>
                    <FormControl
                        placeholder="Search (ctrl+k)"
                        ctrl-k-focus
                        transparent
                        borderless
                        class="border rounded-md border-slate-200 dark:border-slate-50/5 focus:border-slate-100"
                    />
                </NavBarItemPlain> -->
            </NavBar>
            <AsideMenu
                :is-aside-mobile-expanded="isAsideMobileExpanded"
                :is-aside-lg-active="isAsideLgActive"
                :menu="menuAside"
                @menu-click="menuClick"
                @aside-lg-close-click="isAsideLgActive = false"
            />
            <slot />
            <FooterBar />
        </div>
    </div>
</template>

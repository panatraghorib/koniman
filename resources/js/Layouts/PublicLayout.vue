<script setup>
import { onMounted } from "vue";
import stickyHeader from "@/play.js";
// import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link, router } from "@inertiajs/vue3";
import frontendMenu from "@/frontendMenu.js";

import Navbar from "@/Components/Frontend/Navbar/FrontNavbar.vue";
import FooterSection from "@/Components/Frontend/FooterSection.vue";

const menuClick = (event, item) => {
    if (item.isToggleLightDark) {
        darkModeStore.set();
    }

    if (item.isLogout) {
        router.post(route("login"));
    }
};

onMounted(() => {
    stickyHeader();
    // AOS.init();
});
</script>

<template>
    <div
        class="ud-header absolute top-0 left-0 z-40 flex w-full items-center bg-transparent"
    >
        <Navbar :menu="frontendMenu" @menu-click="menuClick" />
    </div>

    <main>
        <slot />
    </main>

    <footer
        class="relative z-10 bg-[#090E34] pt-20 lg:pt-[100px]"
        data-wow-delay=".15s"
    >
        <footer-section />
    </footer>

    <a
        href="javascript:void(0)"
        class="back-to-top fixed bottom-8 right-8 left-auto z-[999] hidden h-10 w-10 items-center justify-center rounded-md bg-primary text-white shadow-md transition duration-300 ease-in-out hover:bg-dark dark:bg-gray-800"
    >
        <span
            class="mt-[6px] h-3 w-3 rotate-45 border-t border-l border-white"
        ></span>
    </a>
</template>

<style scoped></style>

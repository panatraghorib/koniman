<script setup>
import { mdiLogout, mdiClose } from "@mdi/js";
import { computed } from "vue";
import AsideMenuList from "@/Components/AsideMenu/AsideMenuList.vue";
import AsideMenuItem from "@/Components/AsideMenu/AsideMenuItem.vue";
import BaseIcon from "@/Components/BaseIcon.vue";

defineProps({
    menu: {
        type: Array,
        required: true,
    },
});

const emit = defineEmits(["menu-click", "aside-lg-close-click"]);

const logoutItem = computed(() => ({
    label: "Logout",
    icon: mdiLogout,
    color: "info",
    isLogout: true,
}));

const menuClick = (event, item) => {
    emit("menu-click", event, item);
};

const asideLgCloseClick = (event) => {
    emit("aside-lg-close-click", event);
};
</script>

<template>
    <aside
        id="aside"
        class="lg:py-1 lg:pl-0 w-60 fixed flex z-40 top-0 h-screen transition-position overflow-hidden"
    >
        <div
            class="aside lg:rounded-lg border border-l-0 border-gray-200 dark:rounded-l-none dark:border-l-0 dark:border-gray-50/20 flex-1 flex flex-col overflow-hidden bg-white dark:bg-slate-900"
        >
            <div
                class="aside-brand shadow-inner flex flex-row mb-5 h-14 items-center justify-between bg-gray-200 dark:bg-slate-800"
            >
                <div
                    class="text-center flex-1 lg:text-left lg:pl-6 xl:text-center xl:pl-0"
                >
                    <b class="font-black text-blue-600 dark:text-purple-600">
                        {{ $page.props.nameInstansi }}
                    </b>
                </div>
                <button
                    class="hidden lg:inline-block xl:hidden p-3"
                    @click.prevent="asideLgCloseClick"
                >
                    <BaseIcon :path="mdiClose" />
                </button>
            </div>
            <div
                class="flex-1 overflow-y-auto overflow-x-hidden aside-scrollbars dark:aside-scrollbars-[slate]"
            >
                <AsideMenuList :menu="menu" @menu-click="menuClick" />
            </div>

            <!-- <ul>
                <AsideMenuItem :item="logoutItem" @menu-click="menuClick" />
            </ul> -->
        </div>
    </aside>
</template>

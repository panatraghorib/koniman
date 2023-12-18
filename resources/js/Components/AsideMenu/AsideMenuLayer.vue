<script setup>
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";

import { mdiLogout, mdiClose, mdiCogBox } from "@mdi/js";
import AsideMenuList from "@/Components/AsideMenu/AsideMenuList.vue";
import AsideMenuItem from "@/Components/AsideMenu/AsideMenuItem.vue";
import BaseIcon from "@/Components/BaseIcon.vue";

const props = defineProps({
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

const settingItem = computed(() => ({
    label: "Setting",
    icon: mdiCogBox,
    color: "bg-blue-600 text-white",
    route: "general.edit",
}));

const menuClick = (event, item) => {
    emit("menu-click", event, item);
};

const asideLgCloseClick = (event) => {
    emit("aside-lg-close-click", event);
};

// Show Menu Based Permissions
const isAdmin = usePage().props.isAdmin;
const userPermissions = usePage().props.user_permissions;

const menuFiltered = computed(() => {
    return props.menu.filter((item) => {
        if (isAdmin) {
            return true;
        } else if (item.hasOwnProperty("default")) {
            return true;
        } else {
            if (item.hasOwnProperty("permission")) {
                return item.permission.some((permission) => {
                    return userPermissions.includes(permission);
                });
            }
            // Menampilkan menu sesuai dengan izin yang dimiliki oleh pengguna non-admin
        }
    });
});
</script>

<template>
    <aside
        id="aside"
        class="fixed top-0 z-40 flex h-screen overflow-hidden lg:py-1 lg:pl-0 w-60 transition-position"
    >
        <div
            class="flex flex-col flex-1 overflow-hidden bg-white border border-l-0 border-gray-200 aside dark:border-l-0 dark:border-gray-50/20 dark:bg-slate-900"
        >
            <div
                class="flex flex-row items-center justify-between h-20 mb-5 shadow aside-brand bg-gradient-to-r from-sky-800 to-slate-800 dark:bg-slate-800"
            >
                <div
                    class="flex-1 pt-5 text-center shadow-md lg:text-left lg:pl-6 xl:text-center xl:pl-0"
                >
                    <a
                        :href="route('dashboard')"
                        class="flex items-center ps-2.5 mb-5"
                    >
                        <img
                            :src="$page.props.setting.website_logo"
                            class="hidden py-3 lg:inline-block h-50 me-3 sm:h-20"
                            alt="Website Logo"
                        />
                        <span
                            class="self-center text-xl font-semibold uppercase drop-shadow-lg whitespace-nowrap dark:text-white"
                        >
                            <b
                                class="font-black text-white dark:text-yellow-500"
                            >
                                {{ $page.props.setting.website_name }}
                            </b>
                            <sub class="text-white"> v.1 </sub>
                        </span>
                    </a>
                </div>
                <button
                    class="hidden p-3 lg:inline-block xl:hidden"
                    @click.prevent="asideLgCloseClick"
                >
                    <BaseIcon :path="mdiClose" />
                </button>
            </div>
            <div
                class="flex-1 overflow-y-auto overflow-x-hidden aside-scrollbars dark:aside-scrollbars-[slate]"
            >
                <AsideMenuList :menu="menuFiltered" @menu-click="menuClick" />
                <!-- <AsideMenuList :menu="menu" @menu-click="menuClick" /> -->
            </div>

            <!-- <ul>
                <AsideMenuItem :item="logoutItem" @menu-click="menuClick" />
            </ul> -->

            <ul v-if="isAdmin">
                <AsideMenuItem :item="settingItem" @menu-click="menuClick" />
            </ul>
        </div>
    </aside>
</template>

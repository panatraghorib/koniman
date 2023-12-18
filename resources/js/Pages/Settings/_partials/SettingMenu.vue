<script setup>
import settingMenu from "../settingMenu.js";
import SettingMenuItem from "./SettingMenuItem.vue";
</script>
<template>
    <div class="border-b border-gray-200 dark:border-gray-700 mb-2">
        <ul
            class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400"
        >
            <SettingMenuItem
                v-for="(item, index) in settingMenu"
                :key="index"
                :item="item"
            />
        </ul>
    </div>
</template>

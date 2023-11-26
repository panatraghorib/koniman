<script setup>
import { computed } from "vue";
import NavbarItem from "@/Components/Frontend/Navbar/FrontNavbarItem.vue";

const props = defineProps({
    isDropdownList: Boolean,
    menu: {
        type: Array,
        required: true,
    },
});

const emit = defineEmits(["menu-click"]);

const menuClick = (event, item) => {
    emit("menu-click", event, item);
};

const ulClass = computed(() => [
    props.isDropdownList
        ? "transition duration-150 ease-in-out origin-top-left min-w-32"
        : "blcok lg:flex 2xl:ml-20",
]);
</script>

<template>
    <ul :class="ulClass">
        <NavbarItem
            v-for="(item, index) in menu"
            :key="index"
            :item="item"
            :is-dropdown-list="isDropdownList"
            @menu-click="menuClick"
            :class="[
                !!item.menu ? 'submenu-item group relative' : 'group relative',
            ]"
        />
    </ul>
</template>

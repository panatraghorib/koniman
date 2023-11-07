<template>
    <ButtonWithDropdown
        ref="dropdown"
        dusk="add-search-row-dropdown"
        :disabled="!hasSearchInputsWithoutValue"
        class="w-auto"
    >
        <template #button>
            <BaseIcon :path="mdiFileSearch" :size="`16`" />
        </template>

        <div
            role="menu"
            aria-orientation="horizontal"
            aria-labelledby="add-search-input-menu"
            class="min-w-max"
        >
            <button
                v-for="(searchInput, key) in items"
                :key="key"
                :dusk="`add-search-row-${searchInput.key}`"
                class="text-left w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                role="menuitem"
                @click.prevent="slotProps.onAdd(searchInput.key)"
            >
                {{ searchInput.label }}
            </button>
        </div>
    </ButtonWithDropdown>
</template>
<script setup>
import { ref } from "vue";

import ButtonWithDropdown from "@/Components/Datatables/DropdownButton/ButtonWithDropdown.vue";
import BaseIcon from "@/Components/BaseIcon.vue";
import { mdiFileSearch } from "@mdi/js";

defineProps({
    items: {
        type: [Array, Object],
        required: true,
    },
    hasSearchInputsWithoutValue: {
        type: Boolean,
        required: true,
    },
    slotProps: {
        type: [Array, Object],
        required: true,
    },
});
</script>

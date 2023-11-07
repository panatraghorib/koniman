<template>
    <ButtonWithDropdown
        placement="bottom-end"
        dusk="columns-dropdown"
        :active="hasHiddenColumns"
    >
        <template #button>
            <BaseIcon :path="mdiFilterVariantPlus" :size="`16`" />
        </template>

        <div
            role="menu"
            aria-orientation="horizontal"
            aria-labelledby="toggle-columns-menu"
            class="mw-max"
        >
            <div class="px-2">
                <ul class="divide-y divide-gray-200">
                    <li
                        v-for="(column, key) in items"
                        v-show="column.can_be_hidden"
                        :key="key"
                        class="py-1 flex items-center justify-between"
                    >
                        <p class="text-sm text-gray-900">
                            {{ column.label }}
                        </p>

                        <button
                            type="button"
                            class="ml-4 relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-light-blue-500"
                            :class="{
                                'bg-green-500': !column.hidden,
                                'bg-gray-200': column.hidden,
                            }"
                            :aria-pressed="!column.hidden"
                            :aria-labelledby="`toggle-column-${column.key}`"
                            :aria-describedby="`toggle-column-${column.key}`"
                            :dusk="`toggle-column-${column.key}`"
                            @click.prevent="
                                slotProps.onChange(column.key, column.hidden)
                            "
                        >
                            <span class="sr-only">Column status</span>
                            <span
                                aria-hidden="true"
                                :class="{
                                    'translate-x-5': !column.hidden,
                                    'translate-x-0': column.hidden,
                                }"
                                class="inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"
                            />
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </ButtonWithDropdown>
</template>
<script setup>
import { ref } from "vue";

import ButtonWithDropdown from "@/Components/Datatables/DropdownButton/ButtonWithDropdown.vue";
import BaseIcon from "@/Components/BaseIcon.vue";
import { mdiFilterVariantPlus } from "@mdi/js";

defineProps({
    items: {
        type: [Array, Object],
        required: true,
    },
    slotProps: {
        type: [Array, Object],
        required: true,
    },
    hasHiddenColumns: {
        type: Boolean,
        required: true,
    },
});
</script>

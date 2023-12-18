<script setup>
import { computed, useSlots } from "vue";

const props = defineProps({
    label: {
        type: String,
        default: null,
    },
    labelFor: {
        type: String,
        default: null,
    },
    help: {
        type: String,
        default: null,
    },
    required: {
        type: Boolean,
        default: false,
    },
});

const slots = useSlots();

const wrapperClass = computed(() => {
    const base = [];
    const slotsLength = slots.default().length;

    if (slotsLength > 1) {
        base.push("grid grid-cols-1 gap-3");
    }

    if (slotsLength === 2) {
        base.push("md:grid-cols-2");
    }

    return base;
});

const displayLabel = computed(() => {
    if (props.required) {
        return props.label + " *";
    }
    return props.label;
});
</script>

<template>
    <div class="mb-6 last:mb-0">
        <label
            v-if="label"
            :for="labelFor"
            class="block mb-2 text-sm font-medium"
            >{{ displayLabel }}</label
        >
        <div :class="wrapperClass">
            <slot />
        </div>
        <div
            v-if="help"
            class="mt-1 text-xs italic text-gray-400 underline dark:text-slate-400"
        >
            {{ help }}
        </div>
    </div>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
    name: {
        type: String,
        required: true,
    },
    type: {
        type: String,
        default: "checkbox",
        validator: (value) => ["checkbox", "radio", "switch"].includes(value),
    },
    label: {
        type: String,
        default: null,
    },
    modelValue: {
        type: [Array, String, Number, Boolean],
        default: null,
    },
    inputValue: {
        type: [String, Number, Boolean],
        required: true,
    },
});

const emit = defineEmits(["update:modelValue"]);

const computedValue = computed({
    get: () => props.modelValue,
    set: (value) => {
        emit("update:modelValue", value);
    },
});

const inputType = computed(() =>
    props.type === "radio" ? "radio" : "checkbox"
);
</script>

<template>
    <div class="flex items-center">
        <input
            v-model="computedValue"
            :id="inputValue"
            :type="inputType"
            :name="name"
            :value="inputValue"
            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
        />
        <label
            :for="inputValue"
            class="text-sm font-medium text-gray-900 capitalize ms-2 dark:text-gray-300"
            :class="type"
        >
            {{ label }}
        </label>
    </div>
</template>

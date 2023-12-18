<template>
    <div :class="$attrs.class">
        <div class="md:w-1/4">
            <label
                v-if="label"
                :for="id"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white pl-5"
            >
                {{ label }}
            </label>
        </div>
        <div class="md:w-full ml-5">
            <input
                :id="id"
                ref="input"
                v-bind="{ ...$attrs, class: null }"
                class="bg-gray-100 dark:bg-slate-800 appearance-none border border-gray-200 dark:boder-red-900 rounded w-full text-sm py-2 px-4 text-gray-700 dark:text-gray-300 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                :class="{ error: error }"
                :type="type"
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value)"
            />
            <div v-if="error" class="text-xs ml-5 text-red-700 italic">
                *{{ error }}
            </div>
        </div>
    </div>
</template>

<script>
import { v4 as uuid } from "uuid";

export default {
    inheritAttrs: false,
    props: {
        id: {
            type: String,
            default() {
                return `text-input-${uuid()}`;
            },
        },
        type: {
            type: String,
            default: "text",
        },
        error: String,
        label: String,
        modelValue: String,
    },
    emits: ["update:modelValue"],
    methods: {
        focus() {
            this.$refs.input.focus();
        },
        select() {
            this.$refs.input.select();
        },
        setSelectionRange(start, end) {
            this.$refs.input.setSelectionRange(start, end);
        },
    },
};
</script>

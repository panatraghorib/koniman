<template>
    <div :class="$attrs.class">
        <div class="md:w-1/4">
            <label
                v-if="label"
                :for="id"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white pl-5"
                >{{ label }}</label
            >
        </div>
        <div class="md:w-full">
            <textarea
                :id="id"
                ref="input"
                v-bind="{ ...$attrs, class: null }"
                rows="4"
                class="border ml-5 border-gray-200 rounded w-full px-2 text-sm text-gray-900 bg-white dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400"
                placeholder="Write somethings..."
                :class="{ error: error }"
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value)"
            ></textarea>
            <div v-if="error" class="text-xs ml-5 text-red-700 italic">
                {{ error }}
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
                return `textarea-input-${uuid()}`;
            },
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
    },
};
</script>

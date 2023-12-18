<template>
    <div :class="$attrs.class">
        <div class="md:w-1/4">
            <label
                v-if="label"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white pl-5"
                :for="id"
                >{{ label }}</label
            >
        </div>
        <div class="md:w-full">
            <div
                class="border border-gray-200 rounded ml-4"
                :class="{ error: errors.length }"
            >
                <input
                    :id="id"
                    class="hidden w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                    aria-describedby="file_input_help"
                    ref="file"
                    type="file"
                    :accept="accept"
                    @change="change"
                />

                <div v-if="!modelValue" class="p-1 border-0">
                    <button
                        type="button"
                        class="px-4 py-1 text-white text-xs font-medium bg-gray-500 hover:bg-gray-700 rounded-sm"
                        @click="browse"
                    >
                        Browse
                    </button>
                </div>
                <div v-else class="flex items-center justify-between p-1">
                    <div class="flex-1 pr-1">
                        {{ modelValue.name }}
                        <span class="text-gray-500 text-xs"
                            >({{ filesize(modelValue.size) }})</span
                        >
                    </div>
                    <button
                        type="button"
                        class="px-4 py-1 text-white text-xs font-medium bg-gray-500 hover:bg-gray-700 rounded-sm"
                        @click="remove"
                    >
                        Remove
                    </button>
                </div>
            </div>
            <div v-if="errors.length" class="text-xs ml-5 text-red-700 italic">
                {{ errors }}
            </div>
        </div>
    </div>
</template>

<script>
import { v4 as uuid } from "uuid";

export default {
    props: {
        id: {
            type: String,
            default() {
                return `file-input-${uuid()}`;
            },
        },
        modelValue: {
            type: [File, String],
        },
        label: String,
        accept: String,
        errors: {
            type: Array,
            default: () => [],
        },
    },
    emits: ["update:modelValue"],
    mounted() {
        if (typeof this.modelValue == "string") {
            this.remove();
        }
    },
    watch: {
        modelValue(value) {
            if (!value && typeof value == "string") {
                this.$refs.file.value = "";
            }
        },
    },
    methods: {
        filesize(size) {
            var i = Math.floor(Math.log(size) / Math.log(1024));
            return (
                (size / Math.pow(1024, i)).toFixed(2) * 1 +
                " " +
                ["B", "kB", "MB", "GB", "TB"][i]
            );
        },
        browse() {
            this.$refs.file.click();
        },
        change(e) {
            this.$emit("update:modelValue", e.target.files[0]);
        },
        remove() {
            this.$emit("update:modelValue", null);
        },
    },
};
</script>

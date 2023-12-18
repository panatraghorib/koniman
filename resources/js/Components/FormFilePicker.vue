<script setup>
import { mdiUpload } from "@mdi/js";
import { computed, ref, watch } from "vue";
import BaseButton from "@/Components/BaseButton.vue";
import DefaultAvatar from "/public/img/user-avatar.png";
import DefaultImage from "/public/img/default-image.png";
import DefaultLogo from "/public/img/default-logo.png";

const props = defineProps({
    modelValue: {
        type: [Object, File, Array, String],
        default: null,
    },
    label: {
        type: String,
        default: null,
    },
    icon: {
        type: String,
        default: mdiUpload,
    },
    accept: {
        type: String,
        default: null,
    },
    color: {
        type: String,
        default: "info",
    },
    imageType: {
        type: String,
        default: "image",
    },
    isRoundIcon: Boolean,
    small: Boolean,
    preview: Boolean,
    error: String,
});

const emit = defineEmits(["update:modelValue"]);

const root = ref(null);

const file = ref(props.modelValue);

const showFilename = computed(() => !props.isRoundIcon && file.value);

const modelValueProp = computed(() => props.modelValue);

watch(modelValueProp, (value) => {
    file.value = value;

    if (!value) {
        root.value.input.value = null;
    }
});

const filePreview = ref(null);

const uploadImageType = computed(() => {
    var imageBase = DefaultImage;

    if (props.imageType == "logo") {
        imageBase = DefaultLogo;
    }

    if (props.imageType == "avatar") {
        imageBase = DefaultAvatar;
    }

    return imageBase;
});

const upload = (event) => {
    const value = event.target.files || event.dataTransfer.files;

    file.value = value[0];

    if (props.preview) {
        var input = event.target;
        if (input.files) {
            var reader = new FileReader();
            reader.onload = (e) => {
                filePreview.value = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    emit("update:modelValue", file.value);

    // Use this as an example for handling file uploads
    // let formData = new FormData()
    // formData.append('file', file.value)

    // const mediaStoreRoute = `/your-route/`

    // axios
    //   .post(mediaStoreRoute, formData, {
    //     headers: {
    //       'Content-Type': 'multipart/form-data'
    //     },
    //     onUploadProgress: progressEvent
    //   })
    //   .then(r => {
    //
    //   })
    //   .catch(err => {
    //
    //   })
};

// if (typeof props.modelValue == "string") {
//     console.log(typeof props.modelValue == "string");
//     emit("update:modelValue", null);
// }

// const uploadPercent = ref(0)
//
// const progressEvent = progressEvent => {
//   uploadPercent.value = Math.round(
//     (progressEvent.loaded * 100) / progressEvent.total
//   )
// }
</script>

<template>
    <div>
        <div class="relative flex items-stretch justify-start">
            <div
                class="flex flex-col items-center justify-center w-40 p-2 rounded-sm bg-slate-100 dark:bg-slate-700"
            >
                <div
                    class="inline-flex items-center justify-center w-full p-3 mb-5 rounded-lg h-36 bg-slate-200 dark:bg-slate-500"
                >
                    <img
                        :src="[
                            typeof modelValue === 'string' &&
                            modelValue !== null
                                ? modelValue
                                : filePreview
                                ? filePreview
                                : uploadImageType,
                        ]"
                        class="w-full h-full rounded-md"
                        alt="File Preview"
                    />
                </div>

                <label class="inline-flex">
                    <BaseButton
                        as="a"
                        :class="{
                            'w-12 h-12': isRoundIcon,
                            'rounded-r-none': showFilename,
                        }"
                        :icon-size="isRoundIcon ? 24 : undefined"
                        :label="isRoundIcon ? null : label"
                        :icon="icon"
                        :color="color"
                        :rounded-full="isRoundIcon"
                        :small="small"
                    />
                    <input
                        ref="root"
                        type="file"
                        class="absolute top-0 left-0 w-full h-full outline-none opacity-0 cursor-pointer -z-1"
                        :accept="accept"
                        @input="upload"
                    />
                </label>
            </div>

            <div
                v-if="showFilename"
                class="px-4 py-2 bg-gray-100 border border-gray-200 rounded-r dark:bg-slate-800 dark:border-slate-700"
            >
                <span class="text-ellipsis line-clamp-1">
                    {{ file.name }}
                </span>
            </div>
        </div>
        <div v-if="error" class="form-error">
            <span class="text-xs italic text-red-500"> {{ error }}</span>
        </div>
    </div>
</template>

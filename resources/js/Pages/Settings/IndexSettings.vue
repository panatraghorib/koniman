<script setup>
import { watch, reactive } from "vue";
import { Head, usePage, useForm, router } from "@inertiajs/vue3";
import CardBox from "@/Components/CardBox.vue";
import { useToast, TYPE } from "vue-toastification";
import { mdiAccountGroup, mdiBallotOutline } from "@mdi/js";

import SectionMain from "@/Components/SectionMain.vue";
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import ToastNotification from "@/Components/ToastNotification.vue";

import TextField from "./fields/InputText.vue";
import FileField from "./fields/InputFile.vue";
import TextAreaField from "./fields/InputTextarea.vue";

import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";

const data = defineProps({ defaultSettings: Object });

const form = useForm({
    _method: "put",
    configurations: data.defaultSettings,
});

const configs = reactive({
    _method: "put",
    configurations: data.defaultSettings,
});

const toast = useToast();
watch(
    () => usePage().props.flash,
    (flash) => {
        let toastId = null;
        if (flash.message) {
            switch (flash.message.type) {
                case "success":
                    toastId = toast({
                        component: ToastNotification,
                        props: {
                            type: TYPE.SUCCESS,
                            title: flash.message.text,
                        },
                    });
                    break;
                case "error":
                    toastId = toast({
                        component: ToastNotification,
                        props: { type: TYPE.ERROR, title: flash.message.text },
                    });
                    break;
                default:
                    toastId = toast({
                        component: ToastNotification,
                        props: {
                            type: TYPE.DEFAULT,
                            title: flash.message.text,
                        },
                    });
                    break;
            }
        }

        if (toastId !== null) {
            setTimeout(() => toast.dismiss(toastId), 5000);
        }
    },
    { deep: true }
);

function submit() {
    form.transform((data) => ({
        ...data,
    })).post(`settings/update`, {
        preserveScroll: true,
        onSuccess: () => {
            router.reload({ only: ["setting"] });
        },
    });
}
</script>

<template>
    <LayoutAuthenticated>
        <Head :title="$page.props.module_name" />

        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiAccountGroup"
                :title="$page.props.module_name"
                main
            />

            <CardBox @submit.prevent="submit" has-outline is-form>
                <!-- <pre>{{ configs.configurations }}</pre> -->

                <div v-for="(item, index) in form.configurations" :key="index">
                    <div
                        class="flex py-3 pl-2 bg-gray-200 mb-2 dark:bg-slate-700 rounded-md"
                    >
                        <span class="font-medium">{{ item.title }}</span>
                    </div>

                    <div v-if="item.elements.length">
                        <div
                            v-for="(field, fieldsIndex) in item.elements"
                            :key="fieldsIndex"
                        >
                            <text-field
                                class="md:flex md:items-start justify-start mb-6"
                                v-if="field.type == 'text'"
                                :type="field.type"
                                :label="field.label"
                                :name="field.name"
                                v-model="field.value"
                                :error="form.errors[field.name]"
                            />

                            <file-field
                                class="md:flex md:items-start justify-start mb-6"
                                v-if="field.type == 'file'"
                                :type="field.type"
                                :label="field.label"
                                :name="field.name"
                                v-model="field.value"
                                :errors="form.errors[field.name]"
                            />

                            <text-area-field
                                class="md:flex md:items-start justify-start mb-6"
                                v-if="field.type == 'textarea'"
                                :type="field.type"
                                :label="field.label"
                                :name="field.name"
                                v-model="field.value"
                                :error="form.errors[field.name]"
                            />
                        </div>
                    </div>
                </div>

                <template #footer>
                    <BaseButtons>
                        <BaseButton
                            type="submit"
                            color="text-white bg-emerald-600 border-emerald-700 shadow-md dark:bg-purple-600 dark:border-purple-700"
                            label="Submit"
                            small
                        />
                    </BaseButtons>
                </template>
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>

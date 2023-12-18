<script setup>
import { Head, useForm, Link, usePage, router } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import { SwalButtonStyle } from "@/colors.js";

import {
    mdiBallotOutline,
    mdiAccountMultiplePlusOutline,
    mdiArrowLeftCircle,
    mdiSearchWeb,
} from "@mdi/js";

import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import CardBox from "@/Components/CardBox.vue";
import BaseButton from "@/Components/BaseButton.vue";
import SectionMain from "@/Components/SectionMain.vue";
import FormFilePicker from "@/Components/FormFilePicker.vue";
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import FormCheckRadioGroup from "@/Components/FormCheckRadioGroup.vue";

const category = usePage().props.category;

const form = useForm({
    _method: "put",
    id: category.id,
    name: category.name,
    description: category.description,
    group_name: category.group_name,
    image: category.image,
    meta_title: category.meta_title,
    meta_description: category.meta_description,
    meta_keyword: category.meta_keyword,
    status: category.status,
});

function submit() {
    form.transform((data) => ({
        ...data,
    })).post(`/blog/category/update/${category.id}`);
}

// DELETE
const confirmDelete = (id) => {
    const swalButtons = Swal.mixin({
        customClass: {
            confirmButton: SwalButtonStyle.confirmButton,
            cancelButton: SwalButtonStyle.cancelButton,
        },
        buttonsStyling: false,
    });
    swalButtons
        .fire({
            title: "Do you want to Delete item?",
            showCancelButton: true,
            confirmButtonText: "Ya",
            cancelButtonText: `Batal`,
        })
        .then((result) => {
            if (result.isConfirmed) {
                router.delete(`/blog/category/delete/${id}`, {
                    preserveScroll: true,
                    onSuccess: (page) => {
                        const message = page.props.flash;
                        if (message.error) {
                            console.log(message);
                            swalButtons.fire(message.error);
                        } else {
                            swalButtons.fire("Deleted!", "", "success");
                        }
                    },
                });
            }
        });
};
</script>

<template>
    <LayoutAuthenticated>
        <Head :title="`${$page.props.module_name}`" />

        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiAccountMultiplePlusOutline"
                :title="`Edit Data ${$page.props.module_name}`"
                main
            >
                <BaseButton
                    route-name="category.index"
                    :icon="mdiArrowLeftCircle"
                    :label="`Back to ${$page.props.module_name} Data`"
                    color="bg-gray-300 border border-gray-400/30 dark:bg-slate-800 dark:border-slate-900/30"
                    rounded-full
                    small
                />
            </SectionTitleLineWithButton>

            <div class="flex justify-start max-w-3xl mb-3">
                <h3 class="text-xl font-bold">
                    <Link
                        class="text-indigo-400 hover:text-indigo-600"
                        href="/blog/category"
                        >Blog</Link
                    >
                    <span class="font-medium text-indigo-400">/</span>
                    {{ form.name }}
                </h3>
                <img
                    v-if="category.image"
                    class="block w-8 h-8 ml-4 border border-gray-300 rounded-full shadow dark:border-gray-600/70"
                    :src="category.image"
                />
            </div>

            <CardBox @submit.prevent="submit" is-form>
                <div>
                    <BaseButton
                        as="button"
                        color="danger"
                        outline
                        label="Hapus Data"
                        small
                        @click="confirmDelete(form.id)"
                    />
                </div>
                <BaseDivider />
                <FormField label="Judul">
                    <FormControl
                        v-model="form.name"
                        :icon="mdiBallotOutline"
                        :error="form.errors.name"
                    />
                </FormField>
                <FormField label="Gambar">
                    <FormFilePicker
                        v-model="form.image"
                        label="Upload"
                        accept=".jpg,.png"
                        small
                        preview
                        isRoundIcon
                        type="image"
                    />
                </FormField>

                <FormField label="Tampil">
                    <FormCheckRadioGroup
                        v-model="form.status"
                        name="status"
                        type="switch"
                        :options="{
                            1:
                                form.status === true
                                    ? 'Ya'
                                    : form.status === false
                                    ? 'Tidak'
                                    : 'Tidak',
                        }"
                    />
                </FormField>

                <BaseDivider />

                <header>
                    <h2 class="text-lg font-medium text-blue-700">SEO</h2>

                    <p class="mt-1 mb-3 text-sm text-gray-500">
                        Search Engine Optimization, untuk optimasi agar website
                        berada di hasil teratas mesin pencari.
                    </p>
                </header>

                <FormField label="Meta Title">
                    <FormControl
                        v-model="form.meta_title"
                        :icon="mdiSearchWeb"
                        :error="form.errors.meta_title"
                    />
                </FormField>

                <FormField label="Meta Keyword">
                    <FormControl
                        v-model="form.meta_keyword"
                        :icon="mdiSearchWeb"
                        :error="form.errors.meta_keyword"
                    />
                </FormField>

                <FormField label="Meta Dscription">
                    <FormControl
                        v-model="form.meta_description"
                        :icon="mdiSearchWeb"
                        :error="form.errors.meta_description"
                    />
                </FormField>

                <template #footer>
                    <BaseButtons>
                        <BaseButton
                            type="submit"
                            color="text-white bg-emerald-600 border-emerald-700 shadow-md dark:bg-purple-600 dark:border-purple-700"
                            label="Submit"
                            small
                            :disabled="form.processing"
                        />
                        <BaseButton
                            type="reset"
                            color="danger"
                            outline
                            label="Reset"
                            small
                        />
                        <BaseButton
                            route-name="category.index"
                            color="info"
                            outline
                            label="Batal"
                            small
                        />
                    </BaseButtons>
                </template>
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>

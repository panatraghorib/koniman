<script setup>
import { Head, useForm } from "@inertiajs/vue3";
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
import FormCheckRadioGroup from "@/Components/FormCheckRadioGroup.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";

const form = useForm({
    name: "",
    description: "",
    group_name: "",
    image: null,
    meta_title: "",
    meta_description: "",
    meta_keyword: "",
    status: false,
});

function submit() {
    form.transform((data) => ({
        ...data,
    })).post(route("category.store"));
}
</script>

<template>
    <LayoutAuthenticated>
        <Head :title="`${$page.props.module_name}`" />

        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiAccountMultiplePlusOutline"
                :title="`Create new ${$page.props.module_name}`"
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

            <CardBox @submit.prevent="submit" is-form>
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
                        image-type="image"
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

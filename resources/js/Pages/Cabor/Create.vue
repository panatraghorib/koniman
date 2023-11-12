<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import {
    mdiBallotOutline,
    mdiAccount,
    mdiAccountMultiplePlusOutline,
    mdiArrowLeftCircle,
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

const form = useForm({
    cabor_name: "",
    initial: "",
    logo: null,
});

function submit() {
    form.transform((data) => ({
        ...data,
    })).post(route("cabor.store"));
}
</script>

<template>
    <LayoutAuthenticated>
        <Head title="Create Cabor Name" />

        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiAccountMultiplePlusOutline"
                title="Create Cabor Name"
                main
            >
                <BaseButton
                    route-name="cabor.index"
                    :icon="mdiArrowLeftCircle"
                    label="Back to Data"
                    color="bg-gray-300 border border-gray-400/30 dark:bg-slate-800 dark:border-slate-900/30"
                    rounded-full
                    small
                />
            </SectionTitleLineWithButton>

            <CardBox @submit.prevent="submit" is-form>
                <FormField label="Nama Cabor/Organisasi">
                    <FormControl
                        v-model="form.cabor_name"
                        :icon="mdiBallotOutline"
                        ref="caborName"
                        :error="form.errors.cabor_name"
                    />
                </FormField>

                <FormField label="Inisial">
                    <FormControl
                        v-model="form.initial"
                        :icon="mdiAccount"
                        :error="form.errors.initial"
                    />
                </FormField>

                <FormField label="Logo">
                    <FormFilePicker
                        v-model="form.logo"
                        label="Upload"
                        accept=".jpg,.png"
                        small
                        preview
                        isRoundIcon
                    />
                </FormField>

                <BaseDivider />

                <template #footer>
                    <BaseButtons>
                        <BaseButton
                            type="submit"
                            color="text-white bg-emerald-600 border-emerald-700 shadow-md dark:bg-purple-600 dark:border-purple-700"
                            label="Submit"
                            small
                        />
                        <BaseButton
                            type="reset"
                            color="danger"
                            outline
                            label="Reset"
                            small
                        />
                    </BaseButtons>
                </template>
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>

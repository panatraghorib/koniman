<script setup>
import { Head, useForm, Link, usePage } from "@inertiajs/vue3";
import {
    mdiBallotOutline,
    mdiAccount,
    mdiAccountMultiplePlusOutline,
    mdiArrowLeftCircle,
    mdiMail,
} from "@mdi/js";

import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import CardBox from "@/Components/CardBox.vue";
import BaseButton from "@/Components/BaseButton.vue";
import SectionMain from "@/Components/SectionMain.vue";
import FormFilePicker from "@/Components/FormFilePicker.vue";
import FormDatePicker from "@/Components/FormDatePicker.vue";
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";

const cabor = usePage().props.cabor.data;

const form = useForm({
    _method: "put",
    id: cabor.id,
    cabor_name: cabor.cabor_name,
    initial: cabor.initial,
    logo: cabor.logo,
});

function submit() {
    form.transform((data) => ({
        ...data,
    })).post(`/data-cabor/update/${cabor.id}`);
}
</script>

<template>
    <LayoutAuthenticated>
        <Head :title="`${form.cabor_name}`" />

        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiAccountMultiplePlusOutline"
                title="Edit Data Cabor"
            >
                <BaseButton
                    route-name="cabor.index"
                    :icon="mdiArrowLeftCircle"
                    label="Back to Data"
                    color="light"
                    rounded-full
                    small
                />
            </SectionTitleLineWithButton>

            <div class="flex justify-start mb-3 max-w-3xl">
                <h3 class="text-xl font-bold">
                    <Link
                        class="text-indigo-400 hover:text-indigo-600"
                        href="/data-cabor"
                        >Cabor</Link
                    >
                    <span class="text-indigo-400 font-medium">/</span>
                    {{ form.cabor_name }}
                    <span class="text-sm text-blue-700 dark:text-red-400">
                        (@{{ form.initial }})
                    </span>
                </h3>
                <img
                    v-if="cabor.logo"
                    class="block ml-4 w-8 h-8 rounded-full border border-gray-300 shadow dark:border-gray-600/70"
                    :src="cabor.logo"
                />
            </div>
            <CardBox @submit.prevent="submit" is-form>
                <FormField label="Nama Cabor">
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
                        :error="form.errors.caborname"
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
                        <BaseButton
                            route-name="cabor.index"
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

<script setup>
import { ref } from "vue";
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
import FormCheckRadioGroup from "@/Components/FormCheckRadioGroup.vue";

const data = defineProps({ roles: Object, cabor: Object });

const form = useForm({
    name: "",
    username: "",
    email: "",
    password: "",
    password_confirmation: "",
    mobile: "",
    dateOfBirth: null,
    gender: "",
    avatar: null,
    roles: "",
    cabor: "",
});

function submit() {
    // form.post(`/users/update/${user.id}`, {
    //     preserveScroll: true,
    //     onSuccess: () => form.reset(),
    // });
    const role = [];
    form.transform((data) => ({
        ...data,
        roles: [data.roles] ?? "",
    })).post(route("user.store"));
}

const showF = ref(false);
</script>

<template>
    <LayoutAuthenticated>
        <Head title="Create New User" />

        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiAccountMultiplePlusOutline"
                title="Create New User"
                main
            >
                <BaseButton
                    route-name="user.index"
                    :icon="mdiArrowLeftCircle"
                    label="Back to Data"
                    color="bg-gray-300 border border-gray-400/30 dark:bg-slate-800 dark:border-slate-900/30"
                    rounded-full
                    small
                />
            </SectionTitleLineWithButton>

            <CardBox @submit.prevent="submit" is-form>
                <FormField label="Nama Lengkap">
                    <FormControl
                        v-model="form.name"
                        :icon="mdiBallotOutline"
                        ref="namaLengkap"
                        :error="form.errors.name"
                    />
                </FormField>

                <FormField label="Username">
                    <FormControl
                        v-model="form.username"
                        :icon="mdiAccount"
                        :error="form.errors.username"
                    />
                </FormField>

                <FormField label="Email">
                    <FormControl
                        v-model="form.email"
                        :icon="mdiMail"
                        :error="form.errors.email"
                    />
                </FormField>

                <div class="grid gap-6 md:grid-cols-2">
                    <FormField
                        label="Kata sandi"
                        help="Sertakan karekter Huruf Kapital, Angka, dan Karakter Spesial"
                    >
                        <FormControl
                            v-model="form.password"
                            type="password"
                            placeholder="kata sandi baru"
                            :error="form.errors.password"
                        />
                    </FormField>

                    <FormField label="Konfirmasi Kata sandi">
                        <FormControl
                            v-model="form.password_confirmation"
                            type="password"
                            placeholder="konfirmasi kata sandi"
                            :error="form.errors.password_confirmation"
                        />
                    </FormField>
                </div>
                <div class="grid gap-6 md:grid-cols-2">
                    <FormField label="Kontak">
                        <FormControl
                            v-model="form.mobile"
                            :error="form.errors.mobile"
                        />
                    </FormField>
                    <FormField label="Tanggal Lahir">
                        <FormDatePicker
                            v-model="form.dateOfBirth"
                            :enableTimePicker="false"
                            :error="form.errors.dateOfBirth"
                        />
                    </FormField>
                </div>
                <FormField label="Jenis Kelamin" class="w-1/2">
                    <FormControl
                        v-model="form.gender"
                        :options="[
                            { id: 'LK', label: 'Laki-Laki' },
                            { id: 'PR', label: 'Perempuan' },
                        ]"
                        name="Jenis Kelamin"
                        :error="form.errors.gender"
                    />
                </FormField>

                <FormField label="Foto">
                    <FormFilePicker
                        v-model="form.avatar"
                        label="Upload"
                        accept=".jpg,.png"
                        small
                        preview
                        isRoundIcon
                        image-type="avatar"
                    />
                </FormField>

                <BaseDivider />
                <FormField label="Instansi">
                    <FormControl
                        v-model="form.roles"
                        :options="data.roles"
                        name="hak akses"
                        :error="form.errors.roles"
                    />
                </FormField>

                <div v-if="form.roles == 3">
                    <FormField label="Organisasi/Cabor">
                        <FormControl
                            v-model="form.cabor"
                            :options="data.cabor"
                            name="Cabor"
                            :error="form.errors.cabor"
                        />
                    </FormField>
                </div>

                <BaseDivider />

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
                            route-name="user.index"
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

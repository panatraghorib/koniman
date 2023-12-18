<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import { SwalButtonStyle } from "@/colors.js";

import {
    mdiBallotOutline,
    mdiAccountSwitch,
    mdiArrowLeftCircle,
} from "@mdi/js";

import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import CardBox from "@/Components/CardBox.vue";
import BaseButton from "@/Components/BaseButton.vue";
import SectionMain from "@/Components/SectionMain.vue";
import RoleCheckbox from "./_partials/RoleCheckbox.vue";
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";

defineProps({ group_permissions: Object });

const form = useForm({
    name: "",
    permissions: [],
});

function submit() {
    form.transform((data) => ({
        ...data,
    })).post(route("role.store"));
}
</script>

<template>
    <LayoutAuthenticated>
        <Head :title="`${$page.props.module_name}`" />

        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiAccountSwitch"
                :title="`Tambah Data ${$page.props.module_name}`"
                main
            >
                <BaseButton
                    route-name="role.index"
                    :icon="mdiArrowLeftCircle"
                    :label="`Back to ${$page.props.module_name} Data`"
                    color="bg-gray-300 border border-gray-400/30 dark:bg-slate-800 dark:border-slate-900/30"
                    rounded-full
                    small
                />
            </SectionTitleLineWithButton>

            <CardBox @submit.prevent="submit" is-form>
                <FormField label="Nama Role">
                    <FormControl
                        v-model="form.name"
                        :icon="mdiBallotOutline"
                        :error="form.errors.name"
                    />
                </FormField>

                <BaseDivider />

                <div
                    class="w-full bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700"
                >
                    <div
                        class="p-4 border-b border-gray-200 rounded-t-lg bg-gray-50 dark:border-slate-700 dark:bg-slate-700"
                    >
                        <h1
                            class="text-sm font-medium text-blue-700 dark:text-white"
                        >
                            Permissions
                        </h1>
                    </div>
                    <div class="p-4 bg-white rounded-lg dark:bg-gray-800">
                        <div class="grid grid-cols-4 gap-4">
                            <div
                                class="w-full bg-white border border-gray-200 shadow dark:bg-gray-800 dark:border-gray-700"
                                v-for="(item, index) in group_permissions"
                                :key="index"
                            >
                                <div
                                    class="p-2 border-b border-gray-200 shadow bg-gradient-to-t from-blue-600 via-blue-500 to-blue-600 dark:border-slate-700 dark:bg-slate-700"
                                >
                                    <h1
                                        class="text-sm font-medium text-white capitalize dark:text-white"
                                    >
                                        {{ index }}
                                    </h1>
                                </div>
                                <div
                                    class="px-2 py-4 bg-white rounded-lg dark:bg-gray-800"
                                >
                                    <ul
                                        class="space-y-4 text-left text-gray-500 dark:text-gray-400"
                                    >
                                        <li
                                            class="flex items-center space-x-3 rtl:space-x-reverse"
                                            v-for="(permission, idx) in item"
                                            :key="idx"
                                        >
                                            <role-checkbox
                                                name="permissions"
                                                type="checkbox"
                                                :input-value="idx"
                                                :label="permission"
                                                v-model="form.permissions"
                                            />
                                        </li>
                                    </ul>
                                </div>
                            </div>
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
                            route-name="role.index"
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

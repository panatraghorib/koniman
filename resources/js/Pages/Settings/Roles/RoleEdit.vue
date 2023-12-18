<script setup>
import { Head, useForm, Link, usePage, router } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import { SwalButtonStyle } from "@/colors.js";

import {
    mdiBallotOutline,
    mdiAccountSwitch,
    mdiArrowLeftCircle,
    mdiChevronRightBox,
} from "@mdi/js";

import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import CardBox from "@/Components/CardBox.vue";
import BaseButton from "@/Components/BaseButton.vue";
import BaseIcon from "@/Components/BaseIcon.vue";
import SectionMain from "@/Components/SectionMain.vue";
import RoleCheckbox from "./_partials/RoleCheckbox.vue";
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";

defineProps({ group_permissions: Object });
const roleItem = usePage().props.role.data;

const form = useForm({
    _method: "put",
    id: roleItem.id,
    name: roleItem.name,
    permissions: [...roleItem.permissions.map((permission) => permission.name)],
});

function submit() {
    form.transform((data) => ({
        ...data,
    })).post(`/settings/roles/update/${roleItem.id}`, {
        preserveScroll: true,
    });
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
                router.delete(`/settings/roles/delete/${id}`, {
                    preserveScroll: true,
                    onSuccess: (page) => {
                        const message = page.props.flash.message;
                        if (message && message.type == "error") {
                            console.log(message);
                            swalButtons.fire("Gagal!", message.text, "error");
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
                :icon="mdiAccountSwitch"
                :title="`Edit Data ${$page.props.module_name}`"
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

            <div class="flex items-start justify-start w-full mb-3">
                <BaseIcon
                    :path="mdiChevronRightBox"
                    size="18"
                    class="text-gray-400"
                />
                <h3 class="font-medium text-md">
                    <Link
                        class="text-blue-600 hover:text-blue-700"
                        href="/settings/roles"
                        >Roles</Link
                    >

                    <span class="font-medium text-blue-600">/</span>
                    <span class="lowercase">
                        {{ roleItem.name }}
                    </span>
                </h3>
            </div>

            <CardBox @submit.prevent="submit" is-form>
                <div>
                    <BaseButton
                        as="button"
                        color="danger"
                        label="Hapus Data"
                        small
                        @click="confirmDelete(form.id)"
                    />
                </div>
                <BaseDivider />
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
                                    class="flex bg-blue-600 border-b border-gray-200 dark:border-slate-700 dark:bg-slate-700"
                                >
                                    <div
                                        class="py-2 pl-2 pr-4 bg-orange-400 rounded-r-full shadow-1 shadow-gray-600"
                                    >
                                        <h1
                                            class="text-sm font-medium text-white capitalize dark:text-white"
                                        >
                                            {{ index }}
                                        </h1>
                                    </div>
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

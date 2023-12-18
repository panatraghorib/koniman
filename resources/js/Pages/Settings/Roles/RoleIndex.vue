<script setup>
import { watch, reactive } from "vue";
import { Head, router, usePage, useForm, Link } from "@inertiajs/vue3";
import { useToast, TYPE } from "vue-toastification";

import {
    mdiAccountGroup,
    mdiFileSearch,
    mdiPlusCircleMultipleOutline,
    mdiPencilCircle,
    mdiDeleteCircle,
    mdiRefresh,
    mdiEye,
} from "@mdi/js";
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import CardBox from "@/Components/CardBox.vue";
import SettingMenu from "@/Pages/Settings/_partials/SettingMenu.vue";

import SectionMain from "@/Components/SectionMain.vue";
import BaseButton from "@/Components/BaseButton.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import ToastNotification from "@/Components/ToastNotification.vue";

import pickBy from "lodash/pickBy";
import mapValues from "lodash/mapValues";

import { debouncedWatch } from "@vueuse/core";
import _ from "lodash";

import Icon from "@/Components/Shared/Icon.vue";
import Pagination from "@/Components/Shared/Pagination.vue";
import SearchFilter from "@/Components/Shared/SearchFilter.vue";
const props = defineProps({ filters: Object, roles: Object });

let form = reactive({
    search: props.filters.search,
    trashed: props.filters.trashed,
});

const reset = () =>
    _.mapValues(form, () => {
        console.log(form);
        return null;
    });

const toast = useToast();

debouncedWatch(
    () => _.cloneDeep(form),
    () => {
        router.get("/settings/roles/", pickBy(form), {
            preserveState: true,
        });
    },
    { debounce: 500 }
);
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

            <div>
                <SettingMenu />
            </div>

            <CardBox has-outline has-table>
                <div class="flex flex-row justify-end p-2 border-b">
                    <BaseButton
                        route-name="role.create"
                        color="bg-blue-700 border-transparent my-3 mx-3"
                        label="Tambah Data"
                        class="text-white"
                        :icon="mdiPlusCircleMultipleOutline"
                        small
                    />
                </div>

                <div class="flex flex-row justify-end p-2 border-b">
                    <search-filter
                        v-model="form.search"
                        class="w-full mr-4"
                        @reset="reset"
                    >
                        <label class="block text-gray-700">Trashed:</label>
                        <select
                            v-model="form.trashed"
                            class="w-full mt-1 form-select"
                        >
                            <option :value="null" />
                            <option value="with">With Trashed</option>
                            <option value="only">Only Trashed</option>
                        </select>
                    </search-filter>
                </div>

                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr
                            class="font-medium text-left text-gray-800 bg-slate-300 dark:bg-slate-700 dark:text-slate-300 text-md"
                        >
                            <th class="px-6 pt-6 pb-4">Role</th>
                            <th class="px-6 pt-6 pb-4">Act</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="role in roles.data"
                            :key="role.id"
                            class="hover:bg-blue-100 focus-within:bg-blue-100"
                        >
                            <td class="border-t">
                                <Link
                                    class="flex items-center px-6 focus:text-indigo-500"
                                    :href="`/settings/roles/${role.id}/edit`"
                                >
                                    {{ role.name }}
                                    <icon
                                        v-if="role.deleted_at"
                                        name="trash"
                                        class="flex-shrink-0 w-3 h-3 ml-2 fill-gray-400"
                                    />
                                </Link>
                            </td>

                            <td class="w-px border-t">
                                <Link
                                    class="flex items-center px-4"
                                    :href="`/settings/roles/${role.id}/edit`"
                                    tabindex="-1"
                                >
                                    <icon
                                        name="cheveron-right"
                                        class="block w-6 h-6 fill-gray-400"
                                    />
                                </Link>
                            </td>
                        </tr>
                        <tr v-if="roles.data.length === 0">
                            <td class="px-6 py-4 border-t" colspan="4">
                                No category found.
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="p-2">
                    <pagination class="mt-6" :links="roles.links" />
                </div>
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>

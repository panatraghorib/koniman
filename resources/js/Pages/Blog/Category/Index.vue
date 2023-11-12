<script setup>
import { watch, reactive } from "vue";
import { Head, router, usePage, useForm, Link } from "@inertiajs/vue3";
import Swal from "sweetalert2";
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
import SectionMain from "@/Components/SectionMain.vue";
import BaseButton from "@/Components/BaseButton.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import ToastNotification from "@/Components/ToastNotification.vue";

import pickBy from "lodash/pickBy";
import mapValues from "lodash/mapValues";

import { debouncedWatch } from "@vueuse/core";
import _ from "lodash";

import Icon from "@/Components/Shared/Icon.vue";
// import Layout from "@/Components/Shared/Layout.vue";
import Pagination from "@/Components/Shared/Pagination.vue";
import SearchFilter from "@/Components/Shared/SearchFilter.vue";

import BaseButtons from "@/Components/BaseButtons.vue";
import BaseIcon from "@/Components/BaseIcon.vue";
import TableColumn from "@/Components/Datatables/TableColumn.vue";
import DropdownAddSearch from "@/Components/Datatables/DropdownAddSearch.vue";
import TableSearchRows from "@/Components/Datatables/TableSearchRows.vue";

const props = defineProps({ filters: Object, categories: Object });

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
        router.get("/blog/category", pickBy(form), {
            preserveState: true,
        });
    },
    { debounce: 500 }
);

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

const confirmDelete = (id) => {
    const swalButtons = Swal.mixin({
        customClass: {
            confirmButton:
                "text-gray-900 w-28 bg-red-400 border border-gray-300 focus:outline-none hover:bg-red-700 hover:text-white focus:ring-1 focus:ring-gray-200 font-medium rounded-full text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700",
            cancelButton:
                "text-gray-900 w-28 bg-gray-300 border border-gray-300 focus:outline-none hover:bg-gray-400 hover:text-white focus:ring-1 focus:ring-gray-200 font-medium rounded-full text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700",
        },
        buttonsStyling: false,
    });
    swalButtons
        .fire({
            title: "Do you want to Delete cabor?",
            showCancelButton: true,
            confirmButtonText: "Ya",
            cancelButtonText: `Batal`,
        })
        .then((result) => {
            if (result.isConfirmed) {
                router.delete(`data-cabor/delete/${id}`, {
                    preserveScroll: true,
                    onSuccess: (page) => {
                        console.log(page);
                        const message = page.props.flash.message;
                        if (message && message.type == "error") {
                            console.log(message);
                            swalButtons.fire("Gagal!", "", "error");
                        } else {
                            swalButtons.fire("Deleted!", "", "success");
                        }
                    },
                });
            }
        });
};

const PageName = "Kategori Artikel";
import DefaultAvatar from "/public/img/user-avatar.png";
</script>

<template>
    <LayoutAuthenticated>
        <Head :title="PageName" />

        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiAccountGroup"
                :title="PageName"
                main
            />

            {{ $page.props.filters }}
            {{ form }}
            <CardBox has-outline has-table>
                <div class="flex flex-row p-2 justify-end border-b">
                    <BaseButton
                        route-name="cabor.create"
                        color="bg-blue-700 border-transparent my-3 mx-3"
                        label="Tambah data"
                        class="text-white"
                        :icon="mdiPlusCircleMultipleOutline"
                        small
                    />
                </div>

                <div class="flex flex-row p-2 justify-end border-b">
                    <search-filter
                        v-model="form.search"
                        class="mr-4 w-full"
                        @reset="reset"
                    >
                        <label class="block text-gray-700">Trashed:</label>
                        <select
                            v-model="form.trashed"
                            class="form-select mt-1 w-full"
                        >
                            <option :value="null" />
                            <option value="with">With Trashed</option>
                            <option value="only">Only Trashed</option>
                        </select>
                    </search-filter>
                </div>

                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr class="text-left font-medium text-gray-800 text-md">
                            <th class="pb-4 pt-6 px-6">Kategori</th>
                            <th class="pb-4 pt-6 px-6">Grup</th>
                            <th class="pb-4 pt-6 px-6">Image</th>
                            <th class="pb-4 pt-6 px-6">Act</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="category in categories.data"
                            :key="category.id"
                            class="hover:bg-blue-100 focus-within:bg-blue-100"
                        >
                            <td class="border-t">
                                <Link
                                    class="flex items-center px-6 focus:text-indigo-500"
                                    :href="`/category/${category.id}/edit`"
                                >
                                    {{ category.name }}
                                    <icon
                                        v-if="category.deleted_at"
                                        name="trash"
                                        class="flex-shrink-0 ml-2 w-3 h-3 fill-gray-400"
                                    />
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link
                                    class="flex items-center px-6"
                                    :href="`/category/${category.id}/edit`"
                                    tabindex="-1"
                                >
                                    {{ category.group_name }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link
                                    class="flex items-center px-6"
                                    :href="`/category/${category.id}/edit`"
                                    tabindex="-1"
                                >
                                    {{ category.image }}
                                </Link>
                            </td>
                            <td class="w-px border-t">
                                <Link
                                    class="flex items-center px-4"
                                    :href="`/category/${category.id}/edit`"
                                    tabindex="-1"
                                >
                                    <icon
                                        name="cheveron-right"
                                        class="block w-6 h-6 fill-gray-400"
                                    />
                                </Link>
                            </td>
                        </tr>
                        <tr v-if="categories.data.length === 0">
                            <td class="px-6 py-4 border-t" colspan="4">
                                No category found.
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="p-2">
                    <pagination class="mt-6" :links="categories.links" />
                </div>
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>

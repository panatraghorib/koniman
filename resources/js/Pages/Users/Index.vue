<script setup>
import { ref, computed, watch } from "vue";
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import CardBox from "@/Components/CardBox.vue";
import { useToast, TYPE } from "vue-toastification";
import {
    Table,
    setTranslations,
} from "@protonemedia/inertiajs-tables-laravel-query-builder";

import {
    mdiAccountGroup,
    mdiFileSearch,
    mdiPlusCircleMultipleOutline,
    mdiPencilCircle,
    mdiDeleteCircle,
    mdiRefresh,
    mdiCloseCircleOutline,
} from "@mdi/js";
import SectionMain from "@/Components/SectionMain.vue";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import BaseIcon from "@/Components/BaseIcon.vue";
import ToastNotification from "@/Components/ToastNotification.vue";
import DropdownButton from "@/Components/Datatables/DropdownButton.vue";
import DropdownAddSearch from "@/Components/Datatables/DropdownAddSearch.vue";
import TableSearchRows from "@/Components/Datatables/TableSearchRows.vue";

defineProps(["users"]);

const formStatusWithHeader = ref(true);
setTranslations({
    next: "Next",
    no_results_found: "No results found",
    per_page: "/page",
    previous: "Prev",
    results: "",
    of: "",
    to: "",
});

const page = usePage();
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

        // if (flash.message.type.default) {
        //     toastId = toast({
        //         component: ToastNotification,
        //         props: { type: TYPE.DEFAULT, title: flash.message.text },
        //     });
        // }
        // if (flash.message.type.success) {
        //     toastId = toast({
        //         component: ToastNotification,
        //         props: { type: TYPE.SUCCESS, title: flash.message.text },
        //     });
        // }
        // if (flash.message.type.error) {
        //     toastId = toast({
        //         component: ToastNotification,
        //         props: { type: TYPE.ERROR, title: flash.message.text },
        //     });
        // }

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
            title: "Do you want to Delete user?",
            showCancelButton: true,
            confirmButtonText: "Ya",
            cancelButtonText: `Batal`,
        })
        .then((result) => {
            if (result.isConfirmed) {
                router.delete(`users/delete/${id}`, {
                    preserveScroll: true,
                    onSuccess: (page) => {
                        console.log(page);
                        swalButtons.fire("Deleted!", "", "success");
                    },
                });
            }
        });
};
</script>

<template>
    <LayoutAuthenticated>
        <Head title="Users" />

        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiAccountGroup"
                title="Pengguna"
                main
            />

            <CardBox has-outline has-table>
                <BaseButton
                    route-name="user.create"
                    color="bg-blue-700 border-transparent my-3 mx-3"
                    label="Tambah data"
                    class="text-white"
                    :icon="mdiPlusCircleMultipleOutline"
                    small
                />

                <BaseDivider />
                <!-- <template #table-wrapper>
                    <div class="flex flex-col bg-red-300 pt-40">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div
                                class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8"
                            >
                                <div
                                    class="shadow border-b border-gray-200 relative"
                                ></div>
                            </div>
                        </div>
                    </div>
                </template> -->
                <!-- <pre> {{ users }} </pre> -->
                <Table
                    :resource="users"
                    :striped="true"
                    :prevent-overlapping-requests="false"
                    :input-debounce-ms="1000"
                    preserve-scroll="table-top"
                    class="w-full"
                >
                    <template v-slot:tableReset="slotProps">
                        <button
                            class="bg-slate-200 border rounded-md shadow-sm p-1 inline-flex justify-center text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mx-1 my-2"
                            @click.prevent="slotProps.onClick"
                        >
                            <BaseIcon :path="mdiRefresh" :size="`16`" />
                        </button>
                    </template>
                    <template v-slot:tableSearchRows="slotProps">
                        <table-search-rows
                            :search-inputs="slotProps.searchInputs"
                            :forced-visible-search-inputs="
                                slotProps.forcedVisibleSearchInputs
                            "
                            :slotProps="slotProps"
                        />
                    </template>
                    <template v-slot:tableAddSearchRow="slotProps">
                        <DropdownAddSearch
                            :items="slotProps.searchInputs"
                            :slotProps="slotProps"
                            :has-search-inputs-without-value="
                                slotProps.hasSearchInputsWithoutValue
                            "
                        />
                    </template>
                    <template v-slot:tableColumns="slotProps">
                        <DropdownButton
                            :items="slotProps.columns"
                            :slotProps="slotProps"
                            :has-hidden-columns="slotProps.hasHiddenColumns"
                            class="z-10"
                        />
                    </template>
                    <template v-slot:tableGlobalSearch="slotProps">
                        <div class="flex flex-row w-full">
                            <div
                                class="relative text-gray-600 focus-within:text-gray-400 w-full"
                            >
                                <span
                                    class="absolute inset-y-0 left-0 flex items-center pl-2 pt-3"
                                >
                                    <BaseIcon
                                        :path="mdiFileSearch"
                                        class="w-6 h-6"
                                    />
                                </span>
                                <input
                                    placeholder="pencarian..."
                                    @input="
                                        slotProps.onChange($event.target.value)
                                    "
                                    class="mt-2 block w-full pl-9 text-sm rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 dark:bg-slate-700 dark:border-slate-600"
                                    autocomplete="off"
                                />
                            </div>
                        </div>
                    </template>

                    <template #cell(actions)="{ item: user }">
                        <!-- TODO: <DropdownButton /> -->
                        <div class="flex flex-row justify-end">
                            <BaseButtons>
                                <BaseButton
                                    :inertia-link="`/users/${user.id}/edit`"
                                    color="bg-blue-700 dark:bg-purple-800 border-none"
                                    class="text-white"
                                    :icon="mdiPencilCircle"
                                    small
                                />
                                <BaseButton
                                    as="button"
                                    color="bg-red-400 dark:bg-red-900 border-none"
                                    class="text-white"
                                    :icon="mdiDeleteCircle"
                                    small
                                    @click="confirmDelete(user.id)"
                                />
                            </BaseButtons>
                        </div>
                    </template>

                    <template #pagination> </template>
                </Table>
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>

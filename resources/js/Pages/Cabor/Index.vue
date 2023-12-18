<script setup>
import { ref, watch } from "vue";
import { Head, router, usePage } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import { SwalButtonStyle } from "@/colors.js";

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
    mdiEye,
} from "@mdi/js";
import SectionMain from "@/Components/SectionMain.vue";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import BaseIcon from "@/Components/BaseIcon.vue";
import ToastNotification from "@/Components/ToastNotification.vue";
import TableColumn from "@/Components/Datatables/TableColumn.vue";
import DropdownAddSearch from "@/Components/Datatables/DropdownAddSearch.vue";
import TableSearchRows from "@/Components/Datatables/TableSearchRows.vue";

defineProps(["cabor"]);

setTranslations({
    next: "Next",
    no_results_found: "No results found",
    per_page: "/hal",
    previous: "Prev",
    results: "data",
    of: "-",
    to: "dari",
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

        if (toastId !== null) {
            setTimeout(() => toast.dismiss(toastId), 5000);
        }
    },
    { deep: true }
);

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

const PageName = "Cabor/Organisasi";
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

            <CardBox has-outline has-table>
                <div class="flex flex-row justify-end p-2 border-b">
                    <BaseButton
                        route-name="cabor.create"
                        color="bg-blue-700 border-transparent my-3 mx-3"
                        label="Tambah data"
                        class="text-white"
                        :icon="mdiPlusCircleMultipleOutline"
                        small
                        v-if="can('add_cabor')"
                    />
                </div>
                <Table
                    :resource="cabor"
                    :striped="true"
                    :prevent-overlapping-requests="false"
                    :input-debounce-ms="1000"
                    preserve-scroll="table-top"
                    class="w-full"
                >
                    <template v-slot:tableReset="slotProps">
                        <button
                            class="inline-flex justify-center p-1 mx-1 my-2 text-sm font-medium text-gray-700 border rounded-md shadow-sm bg-slate-200 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
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
                        <TableColumn
                            :items="slotProps.columns"
                            :slotProps="slotProps"
                            :has-hidden-columns="slotProps.hasHiddenColumns"
                            class="z-10"
                        />
                    </template>
                    <template v-slot:tableGlobalSearch="slotProps">
                        <div class="flex flex-row w-full mx-1">
                            <div
                                class="relative w-full text-gray-600 focus-within:text-gray-400"
                            >
                                <span
                                    class="absolute inset-y-0 left-0 flex items-center pt-3 pl-2"
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
                                    class="block w-full mt-2 text-sm border-gray-300 rounded-md shadow-sm pl-9 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-700 dark:border-slate-600"
                                    autocomplete="off"
                                />
                            </div>
                        </div>
                    </template>

                    <template #cell(logo)="{ item: cabor }">
                        <img
                            :src="cabor.logo ?? DefaultAvatar"
                            class="w-10 h-10 rounded-md"
                            alt="Logo"
                        />
                    </template>

                    <template #cell(actions)="{ item: cabor }">
                        <!-- TODO: buat <DropdownButton /> -->
                        <div class="flex flex-row justify-end">
                            <BaseButtons>
                                <BaseButton
                                    :inertia-link="`/data-cabor/${cabor.id}/edit`"
                                    color="bg-blue-700 dark:bg-blue-800 border-none"
                                    class="text-white"
                                    :icon="mdiPencilCircle"
                                    small
                                    v-if="can('edit_cabor')"
                                />
                                <BaseButton
                                    as="button"
                                    color="bg-red-400 dark:bg-red-600 border-none"
                                    class="text-white"
                                    :icon="mdiDeleteCircle"
                                    small
                                    v-if="can('delete_cabor')"
                                    @click="confirmDelete(cabor.id)"
                                />
                                <BaseButton
                                    :inertia-link="`/data-cabor/${cabor.id}/show`"
                                    color="bg-gray-600 dark:bg-gray-700 border-none"
                                    class="text-white"
                                    :icon="mdiEye"
                                    small
                                    v-if="can('read_cabor')"
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

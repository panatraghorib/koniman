<script setup>
import { ref, computed, watch } from "vue";
import { Head, Link, router, usePage } from "@inertiajs/vue3";
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
    mdiCloseCircleOutline,
    mdiArrowRightBoldCircleOutline,
    mdiInformationSlabBoxOutline,
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

defineProps(["posts"]);

const formStatusWithHeader = ref(true);
setTranslations({
    next: "Next",
    no_results_found: "No results found",
    per_page: "/hal",
    previous: "Prev",
    results: "",
    of: "dari",
    to: "-",
});

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
            confirmButton: SwalButtonStyle.confirmButton,
            cancelButton: SwalButtonStyle.cancelButton,
        },
        buttonsStyling: false,
    });
    swalButtons
        .fire({
            title: "Do you want to Delete post?",
            showCancelButton: true,
            confirmButtonText: "Ya",
            cancelButtonText: `Batal`,
        })
        .then((result) => {
            if (result.isConfirmed) {
                router.delete(`post/delete/${id}`, {
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
        <Head title="Artikel" />

        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiAccountGroup"
                title="Artikel"
                main
            />

            <CardBox has-outline has-table>
                <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                    <ul
                        class="flex flex-wrap -mb-px text-sm font-medium text-center"
                        id="default-tab"
                        data-tabs-toggle="#default-tab-content"
                        role="tablist"
                    >
                        <li class="me-2" role="presentation">
                            <button
                                class="inline-block p-4 border-b-2 rounded-t-lg"
                                id="profile-tab"
                                data-tabs-target="#profile"
                                type="button"
                                role="tab"
                                aria-controls="profile"
                                aria-selected="false"
                            >
                                Semua
                            </button>
                        </li>
                        <li class="me-2" role="presentation">
                            <button
                                class="text-blue-600 inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                id="dashboard-tab"
                                data-tabs-target="#dashboard"
                                type="button"
                                role="tab"
                                aria-controls="dashboard"
                                aria-selected="false"
                            >
                                Perlu Verivikasi
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="flex flex-row p-2 justify-end border-b">
                    <BaseButton
                        route-name="post.create"
                        color="bg-blue-700 border-transparent mb-2 -mt-3 mx-3"
                        label="Tambah data"
                        class="text-white"
                        :icon="mdiPlusCircleMultipleOutline"
                        small
                    />
                </div>

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

                <Table
                    :resource="posts"
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

                    <template #cell(name)="{ item: post }">
                        <span class="text-blue-800"> {{ post.name }} </span>
                        <div
                            class="flex flex-row"
                            v-if="post.approval_formated"
                        >
                            <BaseIcon
                                :path="mdiInformationSlabBoxOutline"
                                size="15"
                                class="text-gray-400"
                            />
                            <span class="text-xs text-gray-400 py-1 italic">{{
                                post.approval_formated
                            }}</span>
                        </div>
                    </template>

                    <template #cell(status_foramted)="{ item: post }">
                        <div v-html="post.status_formated"></div>
                    </template>

                    <template #cell(category)="{ item: post }">
                        {{ post.category.name }}
                    </template>

                    <template #cell(actions)="{ item: post }">
                        <div
                            class="flex flex-row rounded-md shadow-sm justify-end items-end"
                            role="group"
                        >
                            <BaseButtons>
                                <BaseButton
                                    :inertia-link="`post/${post.id}/edit`"
                                    color="bg-blue-700 border-none text-white"
                                    :icon="mdiPencilCircle"
                                    small
                                />
                                <BaseButton
                                    :inertia-link="`post/${post.id}/show`"
                                    color="bg-gray-700 border-none text-white"
                                    :icon="mdiArrowRightBoldCircleOutline"
                                    small
                                />
                                <BaseButton
                                    as="button"
                                    color="bg-red-400 border-none text-white"
                                    :icon="mdiDeleteCircle"
                                    small
                                    @click="confirmDelete(post.id)"
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

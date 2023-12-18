<script setup>
import { Head, router } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import { SwalButtonStyle } from "@/colors.js";

import CardBox from "@/Components/CardBox.vue";
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
    mdiArrowRightBoldCircleOutline,
    mdiInformationSlabBoxOutline,
} from "@mdi/js";
import SectionMain from "@/Components/SectionMain.vue";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import BaseIcon from "@/Components/BaseIcon.vue";
import TableColumn from "@/Components/Datatables/TableColumn.vue";
import DropdownAddSearch from "@/Components/Datatables/DropdownAddSearch.vue";
import TableSearchRows from "@/Components/Datatables/TableSearchRows.vue";

const props = defineProps({
    title: String,
    posts: Object,
});

setTranslations({
    next: "Next",
    no_results_found: "No results found",
    per_page: "/hal",
    previous: "Prev",
    results: "",
    of: "dari",
    to: "-",
});

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
        <Head :title="props.title" />

        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiAccountGroup"
                :title="props.title"
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
                                class="inline-block p-4 text-blue-600 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                id="dashboard-tab"
                                data-tabs-target="#dashboard"
                                type="button"
                                role="tab"
                                aria-controls="dashboard"
                                aria-selected="false"
                            >
                                Perlu Verifikasi
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="flex flex-row justify-end p-2 border-b">
                    <BaseButton
                        route-name="post.create"
                        color="bg-blue-700 border-transparent mb-2 -mt-3 mx-3"
                        label="Tambah data"
                        class="text-white"
                        :icon="mdiPlusCircleMultipleOutline"
                        small
                        v-if="can('add_post')"
                    />
                </div>

                <!-- <template #table-wrapper>
                    <div class="flex flex-col pt-40 bg-red-300">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div
                                class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8"
                            >
                                <div
                                    class="relative border-b border-gray-200 shadow"
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
                            <span class="py-1 text-xs italic text-gray-400">{{
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
                            class="flex flex-row items-end justify-end rounded-md shadow-sm"
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

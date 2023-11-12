<script setup>
import { watch } from "vue";
import { Head, Link, useForm, router } from "@inertiajs/vue3";
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import CardBox from "@/Components/CardBox.vue";

import pickBy from "lodash/pickBy";
import throttle from "lodash/throttle";
import mapValues from "lodash/mapValues";
import Icon from "@/Components/Shared/Icon.vue";
import Layout from "@/Components/Shared/Layout.vue";
import Pagination from "@/Components/Shared/Pagination.vue";
import SearchFilter from "@/Components/Shared/SearchFilter.vue";

const props = defineProps({ filters: Object, categories: Object });

const form = useForm({
    search: props.filters.search,
    trashed: props.filters.trashed,
});

const reset = () => {
    form = mapValues(form, () => null);
};

watch(
    form,
    (newVal) => {
        return throttle(function () {
            router.get("/blog/category", pickBy(newVal), {
                preserveState: true,
            });
        }, 150);
    },
    { deep: true }
);
</script>

<template>
    <LayoutAuthenticated>
        <Head title="Kategori" />

        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiAccountMultiplePlusOutline"
                title="Blog/Kategori"
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

            <CardBox has-outline has-table>
                <div class="flex items-center justify-between mb-6">
                    <search-filter
                        v-model="form.search"
                        class="mr-4 w-full max-w-md"
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
                    <Link class="btn-indigo" href="/category/create">
                        <span>Create</span>
                        <span class="hidden md:inline">&nbsp;category</span>
                    </Link>
                </div>

                <div class="bg-white rounded-md shadow overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="text-left font-bold">
                                <th class="pb-4 pt-6 px-6">Name</th>
                                <th class="pb-4 pt-6 px-6">City</th>
                                <th class="pb-4 pt-6 px-6" colspan="2">
                                    Phone
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="category in categories.data"
                                :key="category.id"
                                class="hover:bg-gray-100 focus-within:bg-gray-100"
                            >
                                <td class="border-t">
                                    <Link
                                        class="flex items-center px-6 py-2 focus:text-indigo-500"
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
                                        class="flex items-center px-6 py-2"
                                        :href="`/category/${category.id}/edit`"
                                        tabindex="-1"
                                    >
                                        {{ category.city }}
                                    </Link>
                                </td>
                                <td class="border-t">
                                    <Link
                                        class="flex items-center px-6 py-2"
                                        :href="`/category/${category.id}/edit`"
                                        tabindex="-1"
                                    >
                                        {{ category.phone }}
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
                </div>
                <pagination class="mt-6" :links="categories.links" />
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>

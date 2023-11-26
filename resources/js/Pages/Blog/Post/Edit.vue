<script setup>
import { Head, usePage, useForm } from "@inertiajs/vue3";
import CKEditor from "@/Components/CKEditor.vue";
import {
    mdiBallotOutline,
    mdiAccount,
    mdiNewspaperVariantMultipleOutline,
    mdiArrowLeftCircle,
    mdiMail,
    mdiSearchWeb,
} from "@mdi/js";

import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import CardBox from "@/Components/CardBox.vue";
import BaseButton from "@/Components/BaseButton.vue";
import SectionMain from "@/Components/SectionMain.vue";
import FormFilePicker from "@/Components/FormFilePicker.vue";
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import FormCheckRadio from "@/Components/FormCheckRadio.vue";
import FormCheckRadioGroup from "@/Components/FormCheckRadioGroup.vue";

const data = defineProps({ categories: Object });

const post = usePage().props.post.data;
const form = useForm({
    _method: "put",
    id: post.id,
    name: post.name,
    intro: post.intro,
    content: post.content,
    type: post.type,
    isFeatured: post.isFeatured,
    featured_image: post.featured_image,
    status: post.status,
    created_by_alias: post.created_by_alias,
    category_id: post.category_id,
    meta_title: post.meta_title,
    meta_keywords: post.meta_keywords,
    meta_description: post.meta_description,
    meta_og_image: post.meta_og_image,
    meta_og_url: post.meta_og_url,
    published_at: post.published_at,
    approval: post.approval,
});

function submit() {
    form.transform((data) => ({
        ...data,
    })).post(`/blog/post/update/${form.id}`, {
        preserveScroll: true,
    });
}
</script>

<template>
    <LayoutAuthenticated>
        <Head :title="`Edit ${$page.props.module_name}`" />

        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiNewspaperVariantMultipleOutline"
                :title="`Edit ${$page.props.module_name}`"
                main
            >
                <BaseButton
                    route-name="post.index"
                    :icon="mdiArrowLeftCircle"
                    :label="`Back to ${$page.props.module_name} Data`"
                    color="bg-gray-300 border border-gray-400/30 dark:bg-slate-800 dark:border-slate-900/30"
                    rounded-full
                    small
                />
            </SectionTitleLineWithButton>

            <!-- {{ form }} -->
            <!-- <pre>
                <code>
                    {{ $page.props }}
                </code>
            </pre> -->

            <CardBox @submit.prevent="submit" is-form>
                <FormField label="Judul" required>
                    <FormControl
                        v-model="form.name"
                        :icon="mdiBallotOutline"
                        ref="artikelName"
                        :error="form.errors.name"
                    />
                </FormField>

                <FormField
                    label="Nama Author (alias)"
                    help="Kosongkan jika ingin menggunakan nama Akun"
                >
                    <FormControl
                        v-model="form.created_by_alias"
                        :icon="mdiAccount"
                        :error="form.errors.created_by_alias"
                    />
                </FormField>

                <FormField label="Gambar">
                    <FormFilePicker
                        v-model="form.featured_image"
                        label="Upload"
                        accept=".jpg,.png"
                        small
                        preview
                        isRoundIcon
                        :error="form.errors.featured_image"
                    />
                </FormField>

                <FormField label="Intro">
                    <FormControl
                        v-model="form.intro"
                        :icon="mdiMail"
                        :error="form.errors.intro"
                    />
                </FormField>

                <FormField label="Konten">
                    <CKEditor
                        v-model="form.content"
                        :error="form.errors.content"
                    />
                </FormField>

                <FormField label="Kategory" class="w-1/2">
                    <FormControl
                        v-model="form.category_id"
                        :options="data.categories"
                        name="kategori"
                        :error="form.errors.category_id"
                    />
                </FormField>

                <FormField label="Atikel Unggulan">
                    <FormCheckRadioGroup
                        v-model="form.isFeatured"
                        name="isFeatured"
                        type="switch"
                        :options="{
                            1:
                                form.isFeatured === true
                                    ? 'Ya'
                                    : form.isFeatured === false
                                    ? 'Tidak'
                                    : 'Tidak',
                        }"
                    />
                </FormField>

                <FormField label="Status" class="w-1/3">
                    <FormControl
                        v-model="form.status"
                        :options="[
                            { id: 0, label: 'Unpublish' },
                            { id: 1, label: 'Publish' },
                            { id: 2, label: 'Draft' },
                        ]"
                        name="status"
                        :error="form.errors.gender"
                    />
                </FormField>

                <div v-if="$page.props.user.roles == 'Superadmin'">
                    <FormField label="Persetujuan">
                        <FormCheckRadioGroup
                            v-model="form.approval"
                            name="approval"
                            type="switch"
                            :options="{
                                1:
                                    form.approval === true
                                        ? 'Ya'
                                        : form.approval === false
                                        ? 'Tidak'
                                        : 'Tidak',
                            }"
                        />
                    </FormField>
                </div>

                <BaseDivider />

                <header>
                    <h2 class="text-lg font-medium text-blue-700">SEO</h2>

                    <p class="mt-1 mb-3 text-sm text-gray-500">
                        Search Engine Optimization, untuk optimasi agar website
                        berada di hasil teratas mesin pencari.
                    </p>
                </header>

                <FormField label="Meta Title">
                    <FormControl
                        v-model="form.meta_title"
                        :icon="mdiSearchWeb"
                        :error="form.errors.meta_title"
                    />
                </FormField>

                <FormField label="Meta Keyword">
                    <FormControl
                        v-model="form.meta_keywords"
                        :icon="mdiSearchWeb"
                        :error="form.errors.meta_keywords"
                    />
                </FormField>

                <FormField label="Meta Og Image">
                    <FormControl
                        v-model="form.meta_og_image"
                        :icon="mdiSearchWeb"
                        :error="form.errors.meta_og_image"
                    />
                </FormField>

                <FormField label="Meta OG Url">
                    <FormControl
                        v-model="form.meta_og_url"
                        :icon="mdiSearchWeb"
                        :error="form.errors.meta_og_url"
                    />
                </FormField>

                <FormField label="Meta Dscription">
                    <FormControl
                        v-model="form.meta_description"
                        :icon="mdiSearchWeb"
                        :error="form.errors.meta_description"
                    />
                </FormField>

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
                            route-name="post.index"
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

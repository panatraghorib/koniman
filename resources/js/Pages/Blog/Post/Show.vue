<script setup>
import { Head, usePage } from "@inertiajs/vue3";
import {
    mdiNewspaperVariantMultipleOutline,
    mdiArrowLeftCircle,
} from "@mdi/js";

import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import CardBox from "@/Components/CardBox.vue";
import BaseButton from "@/Components/BaseButton.vue";
import SectionMain from "@/Components/SectionMain.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";

const post = usePage().props.post;
</script>

<template>
    <LayoutAuthenticated>
        <Head :title="`Detail ${$page.props.module_name}`" />

        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiNewspaperVariantMultipleOutline"
                :title="`Detail ${$page.props.module_name}`"
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

            <CardBox>
                <div class="flex flex-row items-start">
                    <BaseButtons>
                        <BaseButton
                            :inertia-link="`/blog/post/${post.id}/edit`"
                            color="text-white bg-emerald-600 border-emerald-700 shadow-md dark:bg-purple-600 dark:border-purple-700"
                            :label="`Edit ${$page.props.module_name}`"
                            small
                        />
                        <BaseButton
                            route-name="post.index"
                            color="danger"
                            outline
                            label="Delete"
                            small
                        />
                    </BaseButtons>
                </div>
                <BaseDivider />
                <article
                    class="mx-auto w-full format format-sm sm:format-base lg:format-lg format-blue dark:format-invert"
                >
                    <header class="mb-4 lg:mb-6 not-format">
                        <address class="flex items-center mb-6 not-italic">
                            <div
                                class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white"
                            >
                                <img
                                    v-if="post.avatar"
                                    class="mr-4 w-16 h-16 rounded-full"
                                    :src="post.avatar"
                                    :alt="post.user.name"
                                />
                                <div>
                                    <a
                                        href="#"
                                        rel="author"
                                        class="text-xl font-bold text-gray-900 dark:text-white"
                                    >
                                        {{
                                            post.created_by_name ??
                                            post.created_by_alias
                                        }}
                                    </a>
                                    <p
                                        class="text-sm text-blue-700 dark:text-gray-400"
                                    >
                                        {{ post.user.roles[0].name ?? null }}

                                        <span v-if="post.user.cabor">
                                            {{ post.user.cabor }}
                                        </span>
                                    </p>
                                    <p
                                        class="text-sm italic text-gray-500 dark:text-gray-400"
                                    >
                                        <time
                                            pubdate
                                            :datetime="post.created_at"
                                            :title="post.created_at"
                                        >
                                            {{ post.created_at }}
                                        </time>
                                    </p>
                                </div>
                            </div>
                        </address>
                        <h1
                            class="mb-4 text-3xl font-extrabold leading-tight text-gray-900 lg:mb-6 lg:text-4xl dark:text-white"
                        >
                            {{ post.name }}
                        </h1>
                    </header>
                    <div v-html="post.content"></div>
                </article>
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>

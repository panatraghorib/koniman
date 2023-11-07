<script setup>
import { mdiCog } from "@mdi/js";
import { useSlots, computed } from "vue";
import BaseIcon from "@/Components/BaseIcon.vue";
import BaseButton from "@/Components/BaseButton.vue";
import IconRounded from "@/Components/IconRounded.vue";

defineProps({
    icon: {
        type: String,
        default: null,
    },
    title: {
        type: String,
        required: true,
    },
    main: Boolean,
});

const hasSlot = computed(() => useSlots().default);
</script>

<template>
    <section
        :class="{ 'pt-6 ': !main }"
        class="mb-4 flex items-center justify-between bg-gray-200 p-3 rounded-lg shadow-md dark:bg-slate-700"
    >
        <div class="flex items-center justify-start">
            <IconRounded
                v-if="icon && main"
                :icon="icon"
                color="light"
                class="mr-3"
                bg
                h="13"
                w="13"
            />
            <BaseIcon v-else-if="icon" :path="icon" class="mr-2" size="20" />
            <h1 :class="main ? 'text-xl' : 'text-2xl'" class="leading-tight">
                {{ title }}
            </h1>
        </div>
        <slot v-if="hasSlot" />
        <!-- <BaseButton v-else :icon="mdiCog" color="whiteDark" /> -->
    </section>
</template>

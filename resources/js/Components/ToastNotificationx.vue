<script setup>
defineProps({
    type: {
        type: String,
        default: "",
    },
    title: {
        type: String,
        default: "notification",
    },
});
</script>

<template>
    <component
        :is="type"
        class="lg:w-1"
        :class="[type == 'error' ? 'bg-red-700' : 'bg-green-500']"
    >
        <div>{{ title }} {{ type }}</div>
    </component>
</template>

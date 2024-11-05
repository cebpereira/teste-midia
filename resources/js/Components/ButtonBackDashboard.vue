<!-- ButtonBackDashboard.vue -->
<script setup>
import { Link } from "@inertiajs/vue3";
import { ArrowLeftIcon } from "@heroicons/vue/24/outline";

const props = defineProps({
    to: {
        type: String,
        default: "/dashboard",
    },
});
</script>

<template>
    <Link
        :href="to"
        class="inline-flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300"
    >
        <ArrowLeftIcon class="h-5 w-5 mr-2" />
        {{ label }}
    </Link>
</template>

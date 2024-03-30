<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DisabledButton from "@/Components/DisabledButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { Link, Head, usePage } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    answer: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <Head title="Answer" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-center font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                {{ answer.data }}
            </h2>
        </template>
    </AuthenticatedLayout>
</template>

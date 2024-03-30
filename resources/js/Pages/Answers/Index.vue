<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, Head } from "@inertiajs/vue3";

const props = defineProps({
    answers: {
        type: Array,
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
                As Minhas Respostas
            </h2>
        </template>

        <div class="flex m-5 p-10">
            {{ answers }}
        </div>
    </AuthenticatedLayout>
</template>

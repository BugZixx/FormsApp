<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, Head } from "@inertiajs/vue3";

const props = defineProps({
    answer: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <Head title="New" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-center font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Answer {{ answer }}
            </h2>
        </template>

        <div class="flex m-5 p-10">
            <div
                v-for="a in answer"
                :key="answer.id"
                class="ms-5 bg-white max-w-sm rounded-lg overflow-hidden shadow-lg"
            >
                <img class="w-full" src="img/disc.png" alt="DISC Diagram" />
                <div class="px-6 py-4">
                    <div class="font-bold text-xl mb-2">{{ answer.name }}</div>
                </div>
                <div class="m-2 px-6 pt-4 pb-2">
                    Go
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

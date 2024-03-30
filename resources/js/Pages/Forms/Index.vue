<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, Head } from "@inertiajs/vue3";

const props = defineProps({
    forms: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <Head title="Forms" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-center font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Testes
            </h2>
        </template>

        <div class="flex m-5 p-10">
            <div
                v-for="form in forms"
                :key="form.id"
                class="ms-5 bg-white max-w-sm rounded-lg overflow-hidden shadow-lg"
            >
                <img class="w-full" src="img/disc.png" alt="DISC Diagram" />
                <div class="px-6 py-4">
                    <div class="font-bold text-xl mb-2">{{ form.name }}</div>
                    <p class="text-gray-700 text-base">{{ form.description }}</p>
                </div>
                <div class="m-2 px-6 pt-4 pb-2">
                    <Link :href="route('answeringform', { form })">
                        <div
                            class="text-white bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"
                        >
                            Começar!
                        </div>
                    </Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

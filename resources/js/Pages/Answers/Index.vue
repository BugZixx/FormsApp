<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, Head } from "@inertiajs/vue3";

const props = defineProps({
    answers: {
        type: Array,
        required: true,
    },
});

const getDate = (created_at) => {
    var date = new Date(created_at);
    return (
        date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear()
    );
};

const getProfile = (profile) => {
    var parsed = JSON.parse(profile);
    var p = Object.keys(parsed);
    var text = p[0];
    text = text.charAt(0).toUpperCase() + text.slice(1);

    if (p.length <= 1) {
        return text;
    } else {
        for (var i = 1; i < p.length; i++) {
            if (p[i + 1]) text += ", " + p[i];
            else text += " e " + p[i];
        }

        return text;
    }
};
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

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div
                            class="relative overflow-x-auto shadow-md sm:rounded-lg"
                        >
                            <table
                                class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                            >
                                <thead
                                    class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-200"
                                >
                                    <tr>
                                        <th class="px-6 py-4">#</th>
                                        <th class="px-6 py-4">Título</th>
                                        <th class="px-6 py-4">Perfil Principal</th>
                                        <th class="px-6 py-4">Data</th>
                                        <th class="px-6 py-4 text-center">
                                            Respostas
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(answer, index) in answers"
                                        :key="index"
                                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 text-gray-900 dark:text-white"
                                    >
                                        <td class="px-6 py-4">{{ index + 1 }}</td>
                                        <td class="px-6 py-4">{{ answer.title }}</td>
                                        <td class="px-6 py-4">
                                            {{ getProfile(answer.profile) }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ getDate(answer.created_at) }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <Link
                                                :href="
                                                    route('answers.show', {
                                                        answer,
                                                    })
                                                "
                                            >
                                                <div
                                                    class="text-white bg-[#1da1f2] hover:bg-[#1da1f2]/90 focus:ring-4 focus:outline-none focus:ring-[#1da1f2]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#1da1f2]/55"
                                                >
                                                    Ver mais
                                                </div>
                                            </Link>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

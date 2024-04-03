<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import BarChart from "@/Components/BarChart.vue";

const props = defineProps({
    answer: {
        type: Object,
        required: true,
    },
});

const defaultBackgroundColors = {
    Azul: "#36a2eb",
    Verde: "#4bc098",
    Amarelo: "#ffcd56",
    Vermelho: "#ff6384",
};

const getDate = (created_at) => {
    var date = new Date(created_at);
    return (
        date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear()
    );
};

const getAnswer = (answer) => {
    if (!answer) return "Não respondeu";

    if (typeof answer == "string") {
        if (answer.startsWith("no-")) return "Não";
        else return "Sim";
    }
};

const getText = (profile) => {
    if (!profile) return "Não tem um perfil associado";

    var parsed = JSON.parse(profile);
    var profiles = Object.keys(parsed);

    if (profiles.length == 1) return "O teu perfil é " + profiles[0] + ".";

    var text =
        "As tuas respostas mostraram que te encaixas em mais do que um perfil, sendo estes " +
        [profiles[0]];

    for (var i = 1; i < profiles.length; i++) {
        if (profiles[i + 1]) text += ", " + profiles[i];
        else text += " e " + profiles[i] + ". As descrições destes perfis são:";
    }

    return text;
};

const getChartData = (answer) => {
    var answers = Object.values(answer.data);
    var unique = new Set();
    var uniqueColors = new Set();
    var counter = [];
    var percentages = [];
    var iterator;

    for (var i = 0; i < answers.length; i++) {
        if (!answers[i].startsWith("no-")) {
            var str = answers[i].split("-")[0];
            unique.add(str.charAt(0).toUpperCase() + str.slice(1));
            if (counter[str]) counter[str]++;
            else counter[str] = 1;
        } else {
            var str = answers[i].split("-")[1];
            unique.add(str.charAt(0).toUpperCase() + str.slice(1));
            if (!counter[str]) counter[str] = 0;
        }
    }

    iterator = unique.values();
    for (var i = 0; i < unique.size; i++) {
        percentages.push(
            (Object.values(counter)[i] / (answers.length / unique.size)) * 100
        );

        uniqueColors.add(defaultBackgroundColors[iterator.next().value]);
    }

    console.log(uniqueColors);

    return {
        labels: Array.from(unique),
        datasets: [
            {
                data: percentages,
                backgroundColor: Array.from(uniqueColors),
            },
        ],
    };
};

const getOptions = () => {
    return {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
            y: {
                type: "linear",
                max: 100,
                grid: {
                    color: "rgba(150, 150, 150, 0.5)",
                },
                ticks: {
                    color: "#fff",
                },
            },
            x: {
                grid: {
                    color: "rgba(150, 150, 150, 0.5)",
                },
                ticks: {
                    color: "#fff",
                },
            },
        },
        plugins: {
            title: {
                display: true,
                text: "Percentagem que te enquadras com cada perfil",
                color: "#fff",
                font: {
                    size: 14,
                },
            },
            legend: false,
        },
    };
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
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <template
                    class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex flex-col text-gray-700 dark:text-gray-300"
                >
                    <div class="mb-2">
                        <div class="text-center text-xl">
                            {{ answer.title }}
                        </div>
                        <div class="text-center">
                            Respondido dia {{ getDate(answer.created_at) }}
                        </div>
                    </div>
                    <div class="flex collumns-2 my-3">
                        <div class="w-full m-2">
                            <BarChart
                                aria-label="Percentagem que te enquadras com cada perfil"
                                :chartData="getChartData(answer)"
                                :chartOptions="getOptions()"
                            />
                        </div>
                        <div class="w-full m-2">
                            <p>{{ getText(answer.profile) }}</p>
                            <p
                                v-for="p in Object.values(
                                    JSON.parse(answer.profile)
                                )"
                            >
                                <br />
                                {{ p }}
                                <br />
                            </p>
                        </div>
                    </div>
                    <div
                        class="relative overflow-x-auto shadow-md sm:rounded-lg my-3"
                    >
                        <table
                            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                        >
                            <thead
                                class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-200"
                            >
                                <tr>
                                    <th class="px-6 py-3">Pergunta</th>
                                    <th class="px-6 py-3">Resposta</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 text-gray-900 dark:text-white"
                                    v-for="(answer, question) in answer.data"
                                    :key="question"
                                >
                                    <td class="px-6 py-4">
                                        {{ question }}
                                    </td>
                                    <td
                                        class="px-6 py-4 text-gray-900 dark:text-white"
                                    >
                                        {{ getAnswer(answer) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </template>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

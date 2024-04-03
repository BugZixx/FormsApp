<template>
    <Bar class="w-full" :data="chartData" :options="chartOptions" />
</template>

<script>
import { Bar } from "vue-chartjs";
import {
    Chart as ChartJS,
    Colors,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
} from "chart.js";

ChartJS.register(
    Colors,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale    
);

export default {
    name: "BarChart",
    components: { Bar },
    props: {
        chartData: {
            type: Object,
            required: true,
        },
        chartOptions: {
            type: Object,
            required: true,
        }
    },
};
</script>

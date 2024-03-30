<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DisabledButton from "@/Components/DisabledButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { Link, Head, usePage, router } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    form: {
        type: Object,
        required: true,
    },
});

const questionsData = JSON.parse(props.form.fields);
var questions = {};
var arr = [];
const count = ref(1);
const currentPick = ref("");
const user = usePage().props.auth.user;
var json = {};
var ans = {};

var keys = Object.keys(questionsData);

// randomizes the position of the questions
while (arr.length < questionsData.length) {
    var r = Math.floor(Math.random() * questionsData.length);
    if (arr.indexOf(r) === -1) arr.push(r);
}

for (var i = 0; i < questionsData.length; i++) {
    questions[keys[arr[i]]] = questionsData[i];
}

// updates the json with the answer to the current question
const changePick = (qst) => {
    json[qst] = currentPick.value;
};

// updates json if no answer is given
// updates counter
const counter = (val, qst) => {
    var pickedKeys = Object.keys(json);

    if (pickedKeys.length <= count.value) json[qst] = "";

    count.value += val;

    currentPick.value = json[pickedKeys[count.value - 1]];
};

// submits the form
const submit = () => {
    ans = { user_id: user.id, data: json };

    console.log(ans);

    router.post('/answers/' + ans, { 
        user_id: user.id,
        data: json
     });
};
</script>

<template>
    <Head title="Form" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-center font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                {{ form.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <form
                    method="POST"
                    class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex justify-center"
                >
                    <template v-for="(question, index) in questions">
                        <div
                            @change="changePick(question.question)"
                            v-if="index == count - 1"
                            :key="index"
                            class="max-w-xl mt-1 block w-full text-gray-700 dark:text-gray-300"
                        >
                            <h6
                                class="text-md font-medium text-gray-900 dark:text-gray-100 text-center"
                            >
                                Pergunta {{ count }}
                            </h6>
                            <h5 class="text-center text-xl mt-2 min-h-14">
                                {{ question.question }}
                            </h5>
                            <div class="grid gap-6 grid-cols-2 my-5">
                                <div
                                    class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700"
                                >
                                    <input
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                        type="radio"
                                        id="yes"
                                        name="yes"
                                        :value="question.key"
                                        v-model="currentPick"
                                    />
                                    <label
                                        class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                        for="yes"
                                        >Sim</label
                                    ><br />
                                </div>
                                <div
                                    class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700"
                                >
                                    <input
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                        type="radio"
                                        id="no"
                                        name="yes"
                                        :value="'no-' + question.key"
                                        v-model="currentPick"
                                    />
                                    <label
                                        class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                        for="no"
                                        >Não</label
                                    ><br />
                                </div>
                            </div>
                            <div class="flex justify-center" no-gutters>
                                <SecondaryButton
                                    @click="counter(-1, question.question)"
                                    class="ms-2"
                                    v-bind:style="[
                                        count > 1
                                            ? { visibility: 'visible' }
                                            : { visibility: 'hidden' },
                                    ]"
                                >
                                    <
                                </SecondaryButton>
                                <DisabledButton class="ms-2 aria-disabled">
                                    {{ count }}
                                </DisabledButton>
                                <SecondaryButton
                                    v-if="count < arr.length"
                                    @click="counter(1, question.question)"
                                    class="ms-2"
                                >
                                    >
                                </SecondaryButton>
                                <SecondaryButton
                                    class="ms-2"
                                    @click="submit()"
                                    v-if="count >= arr.length"
                                >
                                    Submeter
                                </SecondaryButton>
                            </div>
                        </div>
                    </template>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
import {ref} from "vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const form = useForm({
    amount: '',
    email: ''
});

const submit = () => {
    form.post(route('account.transfer'), {
        onFinish: (res) => {
            form.reset(['transaction', 'currentBalance'])
        },
    });
};

defineProps({
    transaction: {
        type: Object,
        required: false,
        default: null
    },
    currentBalance: {
        type: Number,
        required: true
    }
})
</script>

<template>
    <Head title="Transfer" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-300 leading-tight">Transfer Money</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-sm sm:rounded-lg">
                    <form @submit.prevent="submit" class="h-fit mt-5 bg-base-100 px-8 py-5 rounded-lg">
                        <div class="bg-green-200 px-2 py-2 mb-3" v-if="transaction">
                            Success on transferring the funds! A total of ${{transaction.amount}} were transferred. Your current balance is at: ${{transaction.current_balance}}
                        </div>
                        <div class="w-full">
                            <InputLabel for="amount" class="text-xl dark:text-white" value="Amount" />

                            <TextInput
                                id="amount"
                                type="number"
                                step=".01"
                                class="mt-1 block w-full"
                                v-model="form.amount"
                                required
                                autofocus
                            />

                            <InputError class="mt-2" :message="form.errors.amount" />
                            <div>
                                Your current balance: ${{currentBalance}}
                            </div>
                        </div>
                        <div class="w-full mt-4">
                            <InputLabel for="amount" class="text-xl dark:text-white" value="Email" />

                            <TextInput
                                id="email"
                                type="email"
                                class="mt-1 block w-full"
                                v-model="form.email"
                                required
                                autofocus
                            />

                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Transfer Funds
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<template>
    <Head title="Statements" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-300 leading-tight">Transfer Money</h2>
        </template>
        <div class="py-12 flex">
            <div class="w-[90%] xl:w-[60%] mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-sm sm:rounded-lg dark:bg-base-100 text-black dark:text-white">
                    <div class="container mt-5">
                        <div class="overflow-x-auto">
                            <table class="table">
                                <!-- head -->
                                <thead>
                                <tr class="text-lg">
                                    <th></th>
                                    <th>Amount</th>
                                    <th>Balance</th>
                                    <th>Description</th>
                                    <th>Created At</th>
                                </tr>
                                </thead>
                                <tbody>
                                <!-- row 1 -->
                                <tr v-for="item in transactions.data" :key="item.id" class="text-lg">
                                    <td>{{ item.id }}</td>
                                    <td>${{ item.amount }}</td>
                                    <td>${{ item.current_balance }}</td>
                                    <td>{{ item.description }}</td>
                                    <td>{{ item.created_at }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <Pagination class="mt-6" :links="transactions.links" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";

defineProps({
    transactions: {
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

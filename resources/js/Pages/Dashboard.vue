<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Home" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-300 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="dark:bg-base-100 dark:text-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 dark:text-white text-2xl">
                        Welcome <span class="capitalize">{{ $page.props.auth.user.name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
const appName = import.meta.env.VITE_APP_NAME
</script>

<template>
    <div class="w-screen h-screen flex flex-col items-center justify-center content-center">
        <h1 class="text-3xl text-center bg-gray-100 dark:bg-base-200 px-2 py-2">
            {{ appName }}
        </h1>
        <slot />
    </div>
</template>
<style>
#app {
    width: 100vw;
    height: 100vh;
}
</style>

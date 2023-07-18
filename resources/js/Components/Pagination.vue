<script setup>
import {Link} from "@inertiajs/vue3";

defineProps({
    links: {
        type: Object,
        default: () => ({}),
    },
});
</script>


<template>
    <div v-if="links.length > 3" class="flex justify-center mt-4 space-x-4">
        <Link
            v-for="(link, k) in links"
            :key="k"
            class="px-4 py-3 text-sm leading-4 hover:bg-gray-800 hover:shadow"
            :class="{'bg-indigo-400 text-white': link.active}"
            :href="link.url"
            v-html="link.label"
        />
    </div>
</template>


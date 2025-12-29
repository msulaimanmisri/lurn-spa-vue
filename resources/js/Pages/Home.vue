<script setup>
    import { Head, Link } from '@inertiajs/vue3';
</script>

<template>

    <Head title="Homepage" />

    <div class="bg-gray-50 text-black/50">
        <div class="flex">
            <Link :href="route('page.index')">
                <button class="bg-red-500 px-6 py-3 rounded-md shadow-md m-6">
                    Login
                </button>
            </Link>
        </div>
    </div>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/vue3';
</script>

<template>

    <Head title="Homepage" />

    <div class="bg-gray-50 text-black/50 p-6">
        <div class="flex gap-2">
            <Link :href="route('login')" class="bg-red-500 text-white rounded-lg py-3 px-8">
                Login
            </Link>

            <Link :href="route('register')" class="bg-red-500 text-white rounded-lg py-3 px-8">
                Register
            </Link>
        </div>
    </div>
</template>

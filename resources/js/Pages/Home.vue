<script setup>
    import GuestLayout from '@/Layouts/GuestLayout.vue';
    import { Head, Link } from '@inertiajs/vue3';
</script>

<template>

    <Head title="Homepage" />

    <GuestLayout>
        <div class="flex gap-5 py-6 justify-center">
            <Link :href="route('login')" class="bg-red-500 text-white rounded-lg py-2.5 px-8">
                Login
            </Link>

            <Link :href="route('register')" class="bg-red-500 text-white rounded-lg py-2.5 px-8">
                Register
            </Link>
        </div>
    </GuestLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, Link, router } from '@inertiajs/vue3';

    defineProps({
        user: Object,
        products: Array,
    });

    const deleteProduct = (productId) => {
        if (confirm('Are you sure you want to delete this product?')) {
            router.delete(route('products.delete', productId));
        }
    };
</script>

<template>

    <Head title="Products" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Products
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">

                <div class="flex justify-end">
                    <Link :href="route('products.create')"
                        class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                        Add New Product
                    </Link>
                </div>

                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div v-if="products.length === 0" class="text-center text-gray-500">
                            No products found. <Link :href="route('products.create')" class="text-blue-500 hover:underline">Create one</Link>
                        </div>

                        <div v-else class="overflow-x-auto">
                            <table class="min-w-full border-collapse border border-gray-300">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="border border-gray-300 px-4 py-2 text-left">ID</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left">Name</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left">Description</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left">Price</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left">Status</th>
                                        <th class="border border-gray-300 px-4 py-2 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="product in products" :key="product.id" class="hover:bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-2">{{ product.id }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ product.name }}</td>
                                        <td class="border border-gray-300 px-4 py-2 truncate max-w-xs">{{ product.description || '-' }}</td>
                                        <td class="border border-gray-300 px-4 py-2 text-right">${{ parseFloat(product.price).toFixed(2) }}</td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <span :class="{
                                                'bg-green-100 text-green-800 px-2 py-1 rounded text-sm': product.status === 'active',
                                                'bg-red-100 text-red-800 px-2 py-1 rounded text-sm': product.status === 'inactive'
                                            }">
                                                {{ product.status }}
                                            </span>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2 text-center space-x-2">
                                            <Link :href="route('products.edit', product.id)" class="text-blue-500 hover:underline">
                                                Edit
                                            </Link>
                                            <button @click="deleteProduct(product.id)" class="text-red-500 hover:underline">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

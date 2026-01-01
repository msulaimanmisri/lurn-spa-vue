<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';
    import { Form } from '@inertiajs/vue3'
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import InputError from '@/Components/InputError.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
</script>

<template>

    <Head title="Products" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Products Create
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">

                <div class="flex justify-end">
                    <button type="submit" form="createProductForm"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Add Product
                    </button>
                </div>

                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <Form :action="route('products.store')" method="post" id="createProductForm"
                            #default="{ errors, processing }">
                            <div>
                                <InputLabel for="name" value="Name" />
                                <TextInput id="name" type="text" name="name" class="mt-1 block w-full" />
                                <InputError :message="errors.name" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="description" value="Description" />
                                <textarea id="description" name="description"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                                <InputError :message="errors.description" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="price" value="Price" />
                                <TextInput id="price" type="number" name="price" step="0.01" min="0"
                                    class="mt-1 block w-full" />
                                <InputError :message="errors.price" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="status" value="Status" />
                                <select id="status" name="status"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Select status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                <InputError :message="errors.status" class="mt-2" />
                            </div>
                        </Form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

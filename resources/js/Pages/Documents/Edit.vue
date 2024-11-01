<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import { Head, useForm } from "@inertiajs/vue3";

defineProps({
    document: Object,
});

const form = useForm({
    title: document.title,
    content: document.content,
});

const submit = () => {
    form.put(`/documents/${document.id}`);
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Editar Documento" />

        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Editar Documento
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden"
                >
                    <div
                        class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700"
                    >
                        <form @submit.prevent="submit">
                            <div>
                                <InputLabel for="title" value="Título" />
                                <TextInput
                                    id="title"
                                    v-model="form.title"
                                    class="block w-full mt-1"
                                    required
                                />
                                <InputError
                                    :message="form.errors.title"
                                    class="mt-2"
                                />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="content" value="Conteúdo" />
                                <textarea
                                    id="content"
                                    v-model="form.content"
                                    class="block w-full mt-1 rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300"
                                ></textarea>
                                <InputError
                                    :message="form.errors.content"
                                    class="mt-2"
                                />
                            </div>

                            <div class="mt-4">
                                <PrimaryButton :disabled="form.processing"
                                    >Atualizar Documento</PrimaryButton
                                >
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

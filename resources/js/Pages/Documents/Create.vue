<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DocumentForm from "@/Pages/Documents/DocumentForm.vue";
import Footer from "@/Components/Footer.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Novo Documento" />

    <AuthenticatedLayout>

        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Novo Documento
            </h2>
        </template>
        <DocumentForm />
        <Footer />
    </AuthenticatedLayout>
</template>

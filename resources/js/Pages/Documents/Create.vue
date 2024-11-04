<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DocumentForm from "@/Pages/Documents/DocumentForm.vue";
import Footer from "@/Components/Footer.vue";
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Dashboard" />

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

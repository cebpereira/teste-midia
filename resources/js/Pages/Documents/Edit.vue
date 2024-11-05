<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import DocumentForm from "@/Components/DocumentForm.vue";
import ButtonBackDashboard from "@/Components/ButtonBackDashboard.vue";
import Footer from "@/Components/Footer.vue";

const props = defineProps({
    documentData: Object,
});
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Editar Documento" />
        <template #header>
            <div class="flex justify-start">
                <ButtonBackDashboard />
                <h2
                    class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200 ml-2"
                >
                    Editar Documento
                </h2>
            </div>
        </template>

        <DocumentForm :documentData="documentData" :isEdit="true" />

        <Footer />
    </AuthenticatedLayout>
</template>

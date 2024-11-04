<script setup>
import { ref, onMounted } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useRoute } from "vue-router";
import DocumentForm from "@/Pages/Documents/DocumentForm.vue";
import axios from "@/axios";
import { Head } from "@inertiajs/vue3";

const route = useRoute();
const documentData = ref(null);

onMounted(async () => {
    try {
        const response = await axios.get(`/api/documents/${route.params.id}`);
        documentData.value = response.data;
    } catch (error) {
        console.error("Erro ao buscar documento:", error);
    }
});
</script>

<template>
    <Head title="Editar Documento" />

    <AuthenticatedLayout>

        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Editar Documento
            </h2>
        </template>
        <div v-if="documentData">
            <DocumentForm :documentData="documentData" :isEdit="true" />
        </div>
        <div v-else>Carregando...</div>
    </AuthenticatedLayout>
</template>

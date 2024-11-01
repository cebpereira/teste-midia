<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ConfirmDeleteModal from "@/Components/ConfirmDeleteModal.vue";
import { ref } from "vue";

defineProps({
    documents: Array,
});

function editDocument(id) {
    router.get(`/documents/${id}/edit`);
}

const showDeleteModal = ref(false);
const documentToDelete = ref(null);

const openDeleteModal = (id) => {
    documentToDelete.value = id;
    showDeleteModal.value = true;
};

const deleteDocument = () => {
    if (documentToDelete.value) {
        router.delete(`/documents/${documentToDelete.value}`);
        documentToDelete.value = null;
    }
    showDeleteModal.value = false;
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Dashboard" />

        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Documentos
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex justify-end mb-4">
                    <Link href="/documents/create">
                        <PrimaryButton>Criar Novo Documento</PrimaryButton>
                    </Link>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden"
                >
                    <div
                        class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700"
                    >
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th
                                        class="px-5 py-3 border-b border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider"
                                    >
                                        Título
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider"
                                    >
                                        Ações
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="document in documents"
                                    :key="document.document_id"
                                >
                                    <td
                                        class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 text-sm"
                                    >
                                        <Link
                                            :href="`/documents/${document.document_id}`"
                                            class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300"
                                        >
                                            {{ document.title }}
                                        </Link>
                                    </td>
                                    <td
                                        class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 text-sm"
                                    >
                                        <button
                                            @click="editDocument(document.document_id)"
                                            class="ml-4 text-sm text-blue-500 hover:underline"
                                        >
                                            Editar
                                        </button>
                                        <button
                                            @click="
                                                openDeleteModal(document.document_id)
                                            "
                                            class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-500"
                                        >
                                            Excluir
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <ConfirmDeleteModal
            :isOpen="showDeleteModal"
            title="Confirmar Exclusão"
            message="Tem certeza que deseja excluir este documento? Esta ação não pode ser desfeita."
            @close="showDeleteModal = false"
            :onConfirm="deleteDocument"
        />
    </AuthenticatedLayout>
</template>

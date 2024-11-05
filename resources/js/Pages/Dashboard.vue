<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ConfirmDeleteModal from "@/Components/ConfirmDeleteModal.vue";
import Footer from "@/Components/Footer.vue";
import { ref, onMounted } from "vue";
import axios from "@/axios";

const documents = ref([]);
const showDeleteModal = ref(false);
const documentToDelete = ref(null);

/**
 * Carrega os documentos do banco de dados e os armazena na variável de estado
 * "documents".
 *
 * @returns {Promise<void>}
 */
const fetchDocuments = async () => {
    try {
        const response = await axios.get("/documents/find");
        documents.value = response.data;
    } catch (error) {
        console.error("Erro ao carregar documentos:", error);
    }
};

/**
 * Navigate to the edit page for the specified document.
 *
 * @param {string} id - The ID of the document to edit.
 */
const editDocument = (id) => {
    router.get(`/documents/${id}/edit`);
};

/**
 * Navigate to the view page for the specified document.
 *
 * @param {string} id - The ID of the document to view.
 */
const viewDocument = (id) => {
    router.get(`/documents/${id}`);
};

/**
 * Abre o modal de confirma o para deletar um documento.
 *
 * @param {string} id - O ID do documento a ser deletado.
 */
const openDeleteModal = (id) => {
    documentToDelete.value = id;
    showDeleteModal.value = true;
};

/**
 * Deleta um documento do banco de dados e fecha o modal de confirma o.
 *
 * @returns {Promise<void>}
 */
const deleteDocument = async () => {
    try {
        if (documentToDelete.value) {
            await axios.delete(`/documents/delete/${documentToDelete.value}`);
            await fetchDocuments();
            documentToDelete.value = null;
        }
    } catch (error) {
        console.error("Erro ao deletar documento:", error);
    }
    showDeleteModal.value = false;
};

/**
 * Baixa um documento do banco de dados em um formato especificado.
 *
 * @param {string} id - O ID do documento a ser baixado.
 * @param {string} format - O formato do documento, deve ser 'docx' ou 'pdf'.
 *
 * @returns {Promise<void>}
 */
const downloadDocument = async (id, format) => {
    try {
        const response = await axios.get(`/documents/download/${id}`, {
            params: { format },
            responseType: "blob",
        });

        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement("a");
        link.href = url;
        link.setAttribute("download", `document_${id}.${format}`);
        document.body.appendChild(link);
        link.click();

        document.body.removeChild(link);
    } catch (error) {
        console.error(`Erro ao baixar o documento como ${format}:`, error);
    }
};

onMounted(() => {
    fetchDocuments();
});
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Dashboard" />

        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Meus Documentos
            </h2>
        </template>

        <div class="py-12 min-h-screen">
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
                                        Nome do Usuário
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider"
                                    >
                                        Cargo do Usuário
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider"
                                    >
                                        Produto
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
                                    class="hover:bg-gray-100 dark:hover:bg-gray-700"
                                >
                                    <td
                                        class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 text-sm"
                                    >
                                        <p
                                            class="text-gray-900 dark:text-gray-300"
                                        >
                                            {{ document.title }}
                                        </p>
                                    </td>
                                    <td
                                        class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 text-sm"
                                    >
                                        <p
                                            class="text-gray-900 dark:text-gray-300"
                                        >
                                            {{ document.user_name }}
                                        </p>
                                    </td>
                                    <td
                                        class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 text-sm"
                                    >
                                        <p
                                            class="text-gray-900 dark:text-gray-300"
                                        >
                                            {{ document.user_role }}
                                        </p>
                                    </td>
                                    <td
                                        class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 text-sm"
                                    >
                                        <p
                                            class="text-gray-900 dark:text-gray-300"
                                        >
                                            {{ document.product_brand }}
                                        </p>
                                    </td>
                                    <td
                                        class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 text-sm"
                                    >
                                        <div class="flex space-x-2">
                                            <Link
                                                @click="
                                                    viewDocument(
                                                        document.document_id
                                                    )
                                                "
                                                class="text-blue-500 hover:underline"
                                            >
                                                Visualizar
                                            </Link>
                                            <button
                                                @click="
                                                    editDocument(
                                                        document.document_id
                                                    )
                                                "
                                                class="text-yellow-500 hover:underline"
                                            >
                                                Editar
                                            </button>
                                            <button
                                                @click="
                                                    openDeleteModal(
                                                        document.document_id
                                                    )
                                                "
                                                class="text-red-500 hover:underline"
                                            >
                                                Excluir
                                            </button>
                                            <button
                                                @click="
                                                    downloadDocument(
                                                        document.document_id,
                                                        'pdf'
                                                    )
                                                "
                                                class="text-green-500 hover:underline"
                                            >
                                                PDF
                                            </button>
                                            <button
                                                @click="
                                                    downloadDocument(
                                                        document.document_id,
                                                        'docx'
                                                    )
                                                "
                                                class="text-indigo-500 hover:underline"
                                            >
                                                Word
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <Footer />

        <!-- Modal de Confirmação de Exclusão -->
        <ConfirmDeleteModal
            :isOpen="showDeleteModal"
            title="Confirmar Exclusão"
            message="Tem certeza que deseja excluir este documento? Esta ação não pode ser desfeita."
            @close="showDeleteModal = false"
            :onConfirm="deleteDocument"
        />
    </AuthenticatedLayout>
</template>

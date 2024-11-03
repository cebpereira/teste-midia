<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ConfirmDeleteModal from "@/Components/ConfirmDeleteModal.vue";
import { ref, onMounted } from "vue";
import axios from "@/axios";

const documents = ref([]);
const showDeleteModal = ref(false);
const documentToDelete = ref(null);

// Função para buscar documentos da API
const fetchDocuments = async () => {
    try {
        const response = await axios.get("/documents/find");
        documents.value = response.data;
    } catch (error) {
        console.error("Erro ao carregar documentos:", error);
    }
};


const getUser = async () => {
    try {
        const response = await axios.get("/auth/user");

        documents.value = response.data;
    } catch (error) {
        console.error("Erro ao buscar o usuário:", error);
    }
};

// Função para editar o documento
const editDocument = (id) => {
    router.get(`/documents/${id}/edit`);
};

// Abre o modal de confirmação para excluir
const openDeleteModal = (id) => {
    documentToDelete.value = id;
    showDeleteModal.value = true;
};

// Função para excluir o documento
const deleteDocument = async () => {
    try {
        if (documentToDelete.value) {
            await axios.delete(`/api/documents/${documentToDelete.value}`);
            await fetchDocuments();
            documentToDelete.value = null;
        }
    } catch (error) {
        console.error("Erro ao deletar documento:", error);
    }
    showDeleteModal.value = false;
};

const downloadDocument = async (id, format) => {
    try {
        const response = await axios.get(`/api/documents/${id}/download`, {
            params: { format },
            responseType: "blob",
        });

        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement("a");
        link.href = url;
        link.setAttribute("download", `document_${id}.${format}`);
        document.body.appendChild(link);
        link.click();
    } catch (error) {
        console.error(`Erro ao baixar o documento como ${format}:`, error);
    }
};

onMounted(() => {
    getUser();
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
                                    :key="document.id"
                                    class="hover:bg-gray-100 dark:hover:bg-gray-700"
                                >
                                    <td
                                        class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 text-sm"
                                    >
                                        <Link
                                            :href="`/documents/${document.id}`"
                                            class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300"
                                        >
                                            {{ document.title }}
                                        </Link>
                                    </td>
                                    <td
                                        class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 text-sm"
                                    >
                                        {{ document.user_name }}
                                    </td>
                                    <td
                                        class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 text-sm"
                                    >
                                        {{ document.user_role }}
                                    </td>
                                    <td
                                        class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 text-sm"
                                    >
                                        {{ document.product_brand }}
                                    </td>
                                    <td
                                        class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 text-sm"
                                    >
                                        <div class="flex space-x-2">
                                            <Link
                                                :href="`/documents/${document.id}`"
                                                class="text-blue-500 hover:underline"
                                            >
                                                Visualizar
                                            </Link>
                                            <button
                                                @click="
                                                    editDocument(document.id)
                                                "
                                                class="text-yellow-500 hover:underline"
                                            >
                                                Editar
                                            </button>
                                            <button
                                                @click="
                                                    openDeleteModal(document.id)
                                                "
                                                class="text-red-500 hover:underline"
                                            >
                                                Excluir
                                            </button>
                                            <button
                                                @click="
                                                    downloadDocument(
                                                        document.id,
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
                                                        document.id,
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

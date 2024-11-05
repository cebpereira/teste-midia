<script setup>
const props = defineProps({
    documentData: Object,
});
</script>

<template>
    <div class="py-12 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-8 dark:bg-gray-800">
                <h3
                    class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100"
                >
                    Informações do Documento
                </h3>

                <!-- Dados do Usuário -->
                <div class="mb-8">
                    <h4
                        class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-300"
                    >
                        Dados do Usuário
                    </h4>
                    <div class="space-y-2">
                        <p>
                            <span
                                class="font-medium text-gray-700 dark:text-gray-400"
                                >Nome:</span
                            >
                            {{ props.documentData.user_name }}
                        </p>
                        <p>
                            <span
                                class="font-medium text-gray-700 dark:text-gray-400"
                                >Cargo:</span
                            >
                            {{ props.documentData.user_role }}
                        </p>
                        <p>
                            <span
                                class="font-medium text-gray-700 dark:text-gray-400"
                                >Documento:</span
                            >
                            {{ props.documentData.user_document }}
                        </p>
                    </div>
                </div>

                <!-- Dados do Produto -->
                <div class="mb-8">
                    <h4
                        class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-300"
                    >
                        Dados do Produto
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <p>
                            <span
                                class="font-medium text-gray-700 dark:text-gray-400"
                                >Marca:</span
                            >
                            {{ props.documentData.product_brand }}
                        </p>
                        <p>
                            <span
                                class="font-medium text-gray-700 dark:text-gray-400"
                                >Modelo:</span
                            >
                            {{ props.documentData.product_model }}
                        </p>
                        <p>
                            <span
                                class="font-medium text-gray-700 dark:text-gray-400"
                                >Número de Série:</span
                            >
                            {{ props.documentData.product_serial_number }}
                        </p>
                        <p>
                            <span
                                class="font-medium text-gray-700 dark:text-gray-400"
                                >Processador:</span
                            >
                            {{ props.documentData.product_processor }}
                        </p>
                        <p>
                            <span
                                class="font-medium text-gray-700 dark:text-gray-400"
                                >Memória:</span
                            >
                            {{ props.documentData.product_memory }}
                        </p>
                        <p>
                            <span
                                class="font-medium text-gray-700 dark:text-gray-400"
                                >Armazenamento:</span
                            >
                            {{ props.documentData.product_disk }}
                        </p>
                        <p>
                            <span
                                class="font-medium text-gray-700 dark:text-gray-400"
                                >Preço (R$):</span
                            >
                            {{ props.documentData.product_price }}
                        </p>
                        <p>
                            <span
                                class="font-medium text-gray-700 dark:text-gray-400"
                                >Preço por Extenso:</span
                            >
                            {{ props.documentData.product_price_string }}
                        </p>
                    </div>
                </div>

                <!-- Outros Dados -->
                <div>
                    <h4
                        class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-300"
                    >
                        Outros Dados
                    </h4>
                    <p>
                        <span
                            class="font-medium text-gray-700 dark:text-gray-400"
                            >Local:</span
                        >
                        {{ props.documentData.local }}
                    </p>
                    <p>
                        <span
                            class="font-medium text-gray-700 dark:text-gray-400"
                            >Data:</span
                        >
                        {{ props.documentData.date }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

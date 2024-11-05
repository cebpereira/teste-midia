<script setup>
import { ref, onMounted, Text } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import axios from "@/axios";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import NumberInput from "@/Components/NumberInput.vue";
import DateInput from "@/Components/DateInput.vue";
import InputLabel from "@/Components/InputLabel.vue";

const props = defineProps({
    documentData: Object,
    isEdit: {
        type: Boolean,
        default: false,
    },
});

const form = useForm({
    title: "",
    user_name: "",
    user_role: "",
    user_document: "",
    product_brand: "",
    product_model: "",
    product_serial_number: "",
    product_processor: "",
    product_memory: "",
    product_disk: "",
    product_price: "",
    product_price_string: "",
    local: "",
    date: "",
});

onMounted(() => {
    if (props.isEdit && props.documentData) {
        for (const key in props.documentData) {
            if (Object.hasOwnProperty.call(props.documentData, key)) {
                form[key] = props.documentData[key];
            }
        }
    }
});

const submit = async () => {
    try {
        const auth_token = sessionStorage.getItem("auth_token");

        axios.defaults.headers.common["Authorization"] = `Bearer ${auth_token}`;

        if (props.isEdit) {
            await axios.put(
                `/documents/update/${props.documentData.document_id}`,
                form
            );
        } else {
            await axios.post("/documents/store", form);
        }

        router.get("/dashboard");
    } catch (error) {
        console.error("Erro ao processar o documento:", error);
    }
};
</script>

<template>
    <div
        class="max-w-3xl mx-auto p-6 my-8 bg-white rounded-lg shadow-sm dark:bg-gray-800"
    >
        <form @submit.prevent="submit">
            <!-- Título do Documento -->
            <div class="mb-4">
                <InputLabel for="title" value="Título" />
                <TextInput
                    id="title"
                    v-model="form.title"
                    class="block w-full mt-1"
                    required
                />
                <InputError :message="form.errors.title" class="mt-2" />
            </div>

            <!-- Seção de Dados do Usuário -->
            <div class="flex items-center my-8">
                <h4
                    class="mr-4 text-lg font-semibold text-gray-900 dark:text-gray-100"
                >
                    Dados do Usuário
                </h4>
                <hr
                    class="flex-grow border-t border-gray-300 dark:border-gray-700"
                />
            </div>

            <!-- Nome do Usuário -->
            <div class="mb-4">
                <InputLabel for="user_name" value="Nome do Usuário" />
                <TextInput
                    id="user_name"
                    v-model="form.user_name"
                    class="block w-full mt-1"
                    required
                />
                <InputError :message="form.errors.user_name" class="mt-2" />
            </div>

            <!-- Cargo e Documento do Usuário -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <InputLabel for="user_role" value="Cargo" />
                    <TextInput
                        id="user_role"
                        v-model="form.user_role"
                        class="block w-full mt-1"
                        required
                    />
                    <InputError :message="form.errors.user_role" class="mt-2" />
                </div>
                <div>
                    <InputLabel
                        for="user_document"
                        value="Documento do Usuário"
                    />
                    <TextInput
                        id="user_document"
                        v-model="form.user_document"
                        class="block w-full mt-1"
                        required
                    />
                    <InputError
                        :message="form.errors.user_document"
                        class="mt-2"
                    />
                </div>
            </div>

            <!-- Seção de Dados do Produto -->
            <div class="flex items-center my-8">
                <h4
                    class="mr-4 text-lg font-semibold text-gray-900 dark:text-gray-100"
                >
                    Dados do Produto
                </h4>
                <hr
                    class="flex-grow border-t border-gray-300 dark:border-gray-700"
                />
            </div>

            <!-- Marca e modelo do produto -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <InputLabel for="product_brand" value="Marca do Produto" />
                    <TextInput
                        id="product_brand"
                        v-model="form.product_brand"
                        class="block w-full mt-1"
                        required
                    />
                    <InputError
                        :message="form.errors.product_brand"
                        class="mt-2"
                    />
                </div>
                <div>
                    <InputLabel for="product_model" value="Modelo do Produto" />
                    <TextInput
                        id="product_model"
                        v-model="form.product_model"
                        class="block w-full mt-1"
                        required
                    />
                    <InputError
                        :message="form.errors.product_model"
                        class="mt-2"
                    />
                </div>
            </div>

            <!-- Numero de serie e Processador -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <InputLabel
                        for="product_serial_number"
                        value="Número de Série"
                    />
                    <TextInput
                        id="product_serial_number"
                        v-model="form.product_serial_number"
                        class="block w-full mt-1"
                        required
                    />
                    <InputError
                        :message="form.errors.product_serial_number"
                        class="mt-2"
                    />
                </div>
                <div>
                    <InputLabel for="product_processor" value="Processador" />
                    <TextInput
                        id="product_processor"
                        v-model="form.product_processor"
                        class="block w-full mt-1"
                        required
                    />
                    <InputError
                        :message="form.errors.product_processor"
                        class="mt-2"
                    />
                </div>
            </div>

            <!-- Memória e Armazenamento -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <InputLabel for="product_memory" value="Memória" />
                    <TextInput
                        id="product_memory"
                        v-model="form.product_memory"
                        class="block w-full mt-1"
                        required
                    />
                    <InputError
                        :message="form.errors.product_memory"
                        class="mt-2"
                    />
                </div>
                <div>
                    <InputLabel for="product_disk" value="Armazenamento" />
                    <TextInput
                        id="product_disk"
                        v-model="form.product_disk"
                        class="block w-full mt-1"
                        required
                    />
                    <InputError
                        :message="form.errors.product_disk"
                        class="mt-2"
                    />
                </div>
            </div>

            <!-- Preço e Preço por extenso -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <InputLabel for="product_price" value="Preço (R$)" />
                    <NumberInput
                        id="product_price"
                        v-model="form.product_price"
                        class="block w-full mt-1"
                        required
                    />
                    <InputError
                        :message="form.errors.product_price"
                        class="mt-2"
                    />
                </div>
                <div>
                    <InputLabel
                        for="product_price_string"
                        value="Preço (Por Extenso)"
                    />
                    <TextInput
                        id="product_price_string"
                        v-model="form.product_price_string"
                        class="block w-full mt-1"
                        required
                    />
                    <InputError
                        :message="form.errors.product_price_string"
                        class="mt-2"
                    />
                </div>
            </div>

            <!-- Outros -->
            <div class="flex items-center my-8">
                <h4
                    class="mr-4 text-lg font-semibold text-gray-900 dark:text-gray-100"
                >
                    Outros
                </h4>
                <hr
                    class="flex-grow border-t border-gray-300 dark:border-gray-700"
                />
            </div>

            <!-- Local e Data -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <InputLabel for="local" value="Local" />
                    <TextInput
                        id="local"
                        v-model="form.local"
                        class="block w-full mt-1"
                        required
                    />
                    <InputError :message="form.errors.local" class="mt-2" />
                </div>
                <div>
                    <InputLabel for="date" value="Data" />
                    <DateInput
                        id="date"
                        v-model="form.date"
                        class="block w-full mt-1"
                        required
                    />
                    <InputError :message="form.errors.date" class="mt-2" />
                </div>
            </div>

            <!-- Botão de Submissão -->
            <PrimaryButton :disabled="form.processing" class="mt-4">
                {{ isEdit ? "Salvar Alterações" : "Salvar Documento" }}
            </PrimaryButton>
        </form>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import axios from '@/axios';

const props = defineProps({
    documentData: {
        type: Object,
        default: null,
    },
});

const isEditMode = ref(!!props.documentData);

const form = ref({
    user_name: '',
    user_role: '',
    user_document: '',
    product_brand: '',
    product_model: '',
    product_serial_number: '',
    product_processor: '',
    product_memory: '',
    product_disk: '',
    product_price: '',
    product_price_string: '',
    local: '',
    date: new Date().toLocaleDateString(),
});

watch(
    () => props.documentData,
    (newData) => {
        if (newData) Object.assign(form.value, newData);
    },
    { immediate: true }
);

const submitForm = async () => {
    try {
        if (isEditMode.value) {
            await axios.put(`/api/documents/${form.value.id}`, form.value);
        } else {
            await axios.post('/api/documents', form.value);
        }
        window.location.href = '/dashboard';
    } catch (error) {
        console.error("Erro ao salvar o documento:", error);
    }
};
</script>

<template>
    <div>
        <h2>{{ isEditMode ? 'Editar Documento' : 'Criar Documento' }}</h2>
        <form @submit.prevent="submitForm">
            <div v-for="(value, key) in form" :key="key" class="mb-4">
                <label :for="key" class="block text-sm font-medium text-gray-700 capitalize">
                    {{ key.replace('_', ' ') }}
                </label>
                <input
                    v-model="form[key]"
                    :id="key"
                    type="text"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                />
            </div>
            <button type="submit" class="mt-4 bg-blue-600 text-white py-2 px-4 rounded-md">
                {{ isEditMode ? 'Salvar Alterações' : 'Criar Documento' }}
            </button>
        </form>
    </div>
</template>

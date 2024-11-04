<script setup>
const socialLinks = [
    {
        name: "GitHub",
        url: "https://github.com/cebpereira",
        icon: "mdi-github",
    },
    {
        name: "Instagram",
        url: "https://instagram.com/c_elandro",
        icon: "mdi-instagram",
    },
    {
        name: "LinkedIn",
        url: "https://linkedin.com/in/cebpereira",
        icon: "mdi-linkedin",
    },
];
</script>

<template>
    <footer class="bg-white dark:bg-gray-800 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col items-center justify-between md:flex-row">
                <p class="text-gray-500 dark:text-gray-400 text-sm">
                    © {{ new Date().getFullYear() }} - Todos os direitos
                    reservados
                </p>
                <div class="mt-4 md:mt-0 flex space-x-6">
                    <a
                        v-for="link in socialLinks"
                        :key="link.name"
                        :href="link.url"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="text-gray-500 hover:text-gray-900 dark:hover:text-white"
                    >
                        <i :class="`mdi ${link.icon} text-lg`"></i>
                        <span class="sr-only">{{ link.name }}</span>
                    </a>
                </div>
            </div>
        </div>
    </footer>
</template>

<style scoped>
@import url("https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css");
</style>

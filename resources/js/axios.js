import axios from "axios";

axios.defaults.baseURL = "/api";

axios.defaults.withCredentials = true;

axios.defaults.withXSRFToken = true;

const token = document.head.querySelector('meta[name="csrf-token"]');

if (!axios.defaults.headers.common["Content-Type"]) {
    axios.defaults.headers.common["Content-Type"] = "application/json";
}

if (!axios.defaults.headers.common["Accept"]) {
    axios.defaults.headers.common["Accept"] = "application/json";
}

const auth_token = sessionStorage.getItem('auth_token');

if (auth_token) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${auth_token}`;
}

if (token) {
    axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
} else {
    console.error("CSRF token não encontrado");
}

export default axios;

<template>
    <div class="max-w-sm mx-auto mt-10">
        <h2 class="text-xl font-semibold mb-4">Register</h2>
        <form @submit.prevent="register" class="space-y-4">
            <div>
                <label for="name" class="block mb-1">Name:</label>
                <input type="text" v-model="name" id="name" class="w-full border border-gray-300 rounded px-4 py-2">
            </div>
            <div>
                <label for="email" class="block mb-1">Email:</label>
                <input type="email" v-model="email" id="email" class="w-full border border-gray-300 rounded px-4 py-2">
            </div>
            <div>
                <label for="password" class="block mb-1">Password:</label>
                <input type="password" v-model="password" id="password"
                    class="w-full border border-gray-300 rounded px-4 py-2">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Register</button>
        </form>
        <div v-if="errorMessage" class="text-red-500">{{ errorMessage }}</div>
    </div>
</template>

<script>
import axios from '@/plugins/axios';

export default {
    data() {
        return {
            name: '',
            email: '',
            password: '',
            errorMessage: '' // Tambahkan properti errorMessage ke dalam data
        };
    },
    methods: {
        register() {
            // Kirim permintaan register menggunakan Axios
            axios.post('http://127.0.0.1:8000/api/register', {
                name: this.name,
                email: this.email,
                password: this.password
            })
            .then(response => {
                alert('Registrasi berhasil');
                window.location.href = '/login';
            })
            .catch(error => {
                if (error.response && error.response.data && error.response.data.message) {
                    this.errorMessage = error.response.data.message;
                } else {
                    this.errorMessage = 'Terjadi kesalahan saat melakukan registrasi.';
                }
            });
    }
    }

};
</script>

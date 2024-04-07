<template>
    <div class="max-w-sm mx-auto mt-10">
        <h2 class="text-xl font-semibold mb-4">Login</h2>
        <form @submit.prevent="login" class="space-y-4">
            <div>
                <label for="email" class="block mb-1">Email:</label>
                <input type="email" v-model="email" id="email" class="w-full border border-gray-300 rounded px-4 py-2">
            </div>
            <div>
                <label for="password" class="block mb-1">Password:</label>
                <input type="password" v-model="password" id="password" class="w-full border border-gray-300 rounded px-4 py-2">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Login</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            email: 'ustiedemann@example.com',
            password: 'password'
        };
    },
    methods: {
        login() {
            axios.post('http://127.0.0.1:8000/api/login', {
                email: this.email,
                password: this.password
            })
            .then(response => {
                alert('login berhasil')
            })
            .catch(error => {
                alert('login gagal');
            });
        }
    }
};
</script>

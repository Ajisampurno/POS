<template>
  <!-- Sidebar -->
  <div class="bg-gray-800 text-gray-100 w-64 flex flex-col">
    <div class="p-4 border-b border-gray-700">
      <h2 class="text-2xl font-bold">POS</h2>
    </div>
    <ul class="flex-1 overflow-y-auto">
      <li class="px-4 py-2 text-lg hover:bg-gray-700 cursor-pointer">
        <RouterLink to="/">Transaction</RouterLink>
      </li>
      <li class="px-4 py-2 text-lg hover:bg-gray-700 cursor-pointer">
        <RouterLink to="/inventori">Inventori</RouterLink>
      </li>
      <li class="px-4 py-2 text-lg hover:bg-gray-700 cursor-pointer">
        <RouterLink to="/report">Report</RouterLink>
      </li>
    </ul>
    <div class="p-4 border-t border-gray-700">
      <button @click="logout"
        class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-blue-500 hover:bg-white mt-4 lg:mt-0">Logout</button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
    };
  },
  methods: {
    logout() {
      axios.post('http://127.0.0.1:8000/api/logout')
        .then(response => {
          window.location.href = '/login';
        })
        .catch(error => {
          console.error('Logout failed:', error);
        });
    }
  }
};
</script>
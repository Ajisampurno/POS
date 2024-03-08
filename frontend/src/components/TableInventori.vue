<template>
  <div class="container mx-auto p-4 bg-gray-300">
    <div class="bg-white rounded-xl overflow-hidden shadow-md mx-10 p-5">
        <!-- Tombol Tambah Product -->
        <div class="mt-4">
            <button @click="addProduct" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Tambah Product
            </button>
        </div>
        <!-- Form pencarian -->
        <div class="mt-4">
            <label for="search" class="block text-sm font-medium text-gray-700">Search:</label>
            <div class="mt-1 flex rounded-md shadow-sm">
                <input type="text" v-model="searchQuery" @input="search" name="search" id="search" class="focus:ring-blue-500 focus:border-blue-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300">
            </div>
        </div>
        <!-- Filter Stock, Category, dan Price -->
        <div class="mt-4 flex flex-col sm:flex-row sm:space-x-4">
            <!-- Filter Stock -->
            <div class="flex-1">
                <label for="StockFilter" class="block text-sm font-medium text-gray-700">Filter by Stock:</label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <select v-model="StockFilter" @change="filterByStock" name="StockFilter" id="StockFilter" class="focus:ring-blue-500 focus:border-blue-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300">
                        <option value="">All</option>
                        <option v-for="quantity in quantities" :key="quantity" :value="quantity">{{ quantity }}</option>
                    </select>
                </div>
            </div>
            <!-- Filter Category -->
            <div class="flex-1">
                <label for="categoryFilter" class="block text-sm font-medium text-gray-700">Filter by Category:</label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <select v-model="categoryFilter" @change="filterByCategory" name="categoryFilter" id="categoryFilter" class="focus:ring-blue-500 focus:border-blue-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300">
                        <option value="">All</option>
                        <option v-for="category in categories" :key="category" :value="category">{{ category }}</option>
                    </select>
                </div>
            </div>
            <!-- Filter Price -->
            <div class="flex-1">
                <label for="priceFilter" class="block text-sm font-medium text-gray-700">Filter by Price:</label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <select v-model="priceFilter" @change="filterByPrice" name="priceFilter" id="priceFilter" class="focus:ring-blue-500 focus:border-blue-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300">
                        <option value="">All</option>
                        <option value="0-100000">Rp0-100000</option>
                        <option value="100000-200000">Rp100000-Rp200000</option>
                        <option value="200000-300000">Rp200000-Rp300000</option>
                        <option value="300000-400000">Rp300000-Rp400000</option>
                        <option value="400000-500000">Rp400000-Rp500000</option>
                        <option value="500000-600000">Rp500000-Rp600000</option>
                        <option value="600000-700000">Rp600000-Rp700000</option>
                        <option value="700000-800000">Rp700000-Rp800000</option>
                        <option value="800000-900000">Rp800000-Rp900000</option>
                        <option value="900000-1000000">Rp900000-Rp1000000</option>
                        <!-- Tambahkan opsi harga lainnya sesuai kebutuhan -->
                    </select>
                </div>
            </div>
        </div>
        <!-- Tabel hasil pencarian -->
        <div class="mt-4 overflow-x-auto overflow-y-auto max-h-[400px]">
            <table class="min-w-full bg-white border-collapse rounded-lg overflow-hidden">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-4 py-2 text-center">SKU</th>
                        <th class="px-4 py-2">Desc</th>
                        <th class="px-4 py-2">Category</th>
                        <th class="px-4 py-2 text-center">QTY</th>
                        <th class="px-4 py-2">Price</th>
                        <th class="px-4 py-2 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, index) in filteredItems" :key="index" class="text-gray-700 bg-gray-300">
                      <td class="border px-4 py-2 text-center">{{ item.id }}</td>
                      <td class="border px-4 py-2">{{ item.desc }}</td>
                      <td class="border px-4 py-2">{{ item.category }}</td>
                      <td class="border px-4 py-2 text-center">{{ item.stock }}</td>
                      <td class="border px-4 py-2">{{ formatCurrency(item.price) }}</td>
                      <td class="border px-4 py-2 text-center">
                          <button @click="editProduct(index)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">Edit</button>
                          <button @click="deleteProduct(index)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Delete</button>
                      </td>
                  </tr>
                </tbody>
            </table>
        </div>

    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      searchQuery: '',
      StockFilter: '',
      categoryFilter: '',
      priceFilter: '',
      items: []
    };
  },
  computed: {
    filteredItems() {
      let filteredItems = this.items;
      if (this.searchQuery) {
        const query = this.searchQuery.toLowerCase();
        filteredItems = filteredItems.filter(item => {
          return String(item.desc).toLowerCase().includes(query);
        });
      }
      if (this.StockFilter) {
        filteredItems = filteredItems.filter(item => {
          return item.stock === this.StockFilter;
        });
      }
      if (this.categoryFilter) {
        filteredItems = filteredItems.filter(item => {
          return item.category === this.categoryFilter;
        });
      }
      if (this.priceFilter) {
        const range = this.priceFilter.split('-');
        filteredItems = filteredItems.filter(item => {
          return item.price >= parseFloat(range[0]) && item.price <= parseFloat(range[1]);
        });
      }
      return filteredItems;
    },
    categories() {
      return [...new Set(this.items.map(item => item.category))];
    },
    quantities() {
      return [...new Set(this.items.map(item => item.stock))];
    }
  },
  methods: {
    fetchData() {
      axios.get('http://127.0.0.1:8000/api/products')
        .then(response => {
          this.items = response.data;
        })
        .catch(error => {
          console.error('Error fetching data:', error);
        });
    },
    addProduct() {
      // Logic to add a new product
      console.log('Add Product');
    },
    editProduct(index) {
      // Logic to edit a product
      console.log('Edit Product', index);
    },
    deleteProduct(index) {
      // Logic to delete a product
      console.log('Delete Product', index);
    },
    formatCurrency(value) {
      return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value);
    },
  },
  created() {
    this.fetchData();
  }
};
</script>


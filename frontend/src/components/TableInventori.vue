<template>
  <div class="container mt-20">
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
        <!-- Filter Qty, Category, dan Price -->
        <div class="mt-4 flex flex-col sm:flex-row sm:space-x-4">
            <!-- Filter Qty -->
            <div class="flex-1">
                <label for="qtyFilter" class="block text-sm font-medium text-gray-700">Filter by Qty:</label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <select v-model="qtyFilter" @change="filterByQty" name="qtyFilter" id="qtyFilter" class="focus:ring-blue-500 focus:border-blue-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300">
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
                        <option value="0-10">Rp0 - Rp10</option>
                        <option value="10-20">Rp10 - Rp20</option>
                        <!-- Tambahkan opsi harga lainnya sesuai kebutuhan -->
                    </select>
                </div>
            </div>
        </div>
        <!-- Tabel hasil pencarian -->
        <div class="mt-4">
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
                <tr v-for="(item, index) in filteredItems" :key="index" class="text-gray-700">
                    <td class="border px-4 py-2 text-center">{{ item.sku }}</td>
                    <td class="border px-4 py-2">{{ item.desc }}</td>
                    <td class="border px-4 py-2">{{ item.category }}</td>
                    <td class="border px-4 py-2 text-center">{{ item.qty }}</td>
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
export default {
  data() {
    return {
      searchQuery: '',
      qtyFilter: '',
      categoryFilter: '',
      priceFilter: '',
      items: [
        { sku: 'SKU001', desc: 'Product 1', category: 'Category 1', qty: 5, price: 10.99 },
        { sku: 'SKU002', desc: 'Product 2', category: 'Category 2', qty: 3, price: 15.99 },
        { sku: 'SKU003', desc: 'Product 3', category: 'Category 1', qty: 8, price: 20.49 }
        // Tambahkan item lainnya sesuai kebutuhan
      ]
    };
  },
  computed: {
    filteredItems() {
      let filteredItems = this.items;
      if (this.searchQuery) {
        const query = this.searchQuery.toLowerCase();
        filteredItems = filteredItems.filter(item => {
          return item.sku.toLowerCase().includes(query);
        });
      }
      if (this.qtyFilter) {
        filteredItems = filteredItems.filter(item => {
          return item.qty === this.qtyFilter;
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
      return [...new Set(this.items.map(item => item.qty))];
    }
  },
  methods: {
    search() {
      // Fungsi ini tidak perlu dilakukan karena pencarian sudah diimplementasikan menggunakan computed property filteredItems
    },
    filterByQty() {
      // Fungsi ini tidak perlu dilakukan karena filter berdasarkan Qty sudah diimplementasikan menggunakan computed property filteredItems
    },
    filterByCategory() {
      // Fungsi ini tidak perlu dilakukan karena filter berdasarkan Category sudah diimplementasikan menggunakan computed property filteredItems
    },
    filterByPrice() {
      // Fungsi ini tidak perlu dilakukan karena filter berdasarkan Price sudah diimplementasikan menggunakan computed property filteredItems
    },
    addProduct() {
      // Logika untuk menambahkan produk baru
      console.log('Tambah Product');
    },
    editProduct(index) {
      // Logika untuk mengedit produk
      console.log('Edit Product', index);
    },
    deleteProduct(index) {
      // Logika untuk menghapus produk
      console.log('Delete Product', index);
    },
    formatCurrency(value) {
      return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value);
    }
  }
};
</script>

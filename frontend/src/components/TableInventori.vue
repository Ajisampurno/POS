<template>
  <div class="container mx-auto p-4 bg-gray-300">
    <div class="bg-white rounded-xl overflow-hidden shadow-md mx-10 p-5">
        <!-- Tombol Tambah Product -->
        <div class="mt-4">
            <button @click="createModalOpen" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
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
                        <th class="px-4 py-2 text-center">Stock</th>
                        <th class="px-4 py-2">Price</th>
                        <th class="px-4 py-2 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, index) in filteredItems" :key="index" class="text-gray-700 bg-gray-100">
                      <td class="border px-4 py-2 text-center">{{ item.id }}</td>
                      <td class="border px-4 py-2">{{ item.desc }}</td>
                      <td class="border px-4 py-2">{{ item.category }}</td>
                      <td class="border px-4 py-2 text-center">{{ item.stock }}</td>
                      <td class="border px-4 py-2">{{ formatCurrency(item.price) }}</td>
                      <td class="border px-4 py-2 text-center">
                        <button @click="editModalOpen(index,item.id)" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded">Edit</button>  
                        <button @click="deleteItem(item.id)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Delete</button>
                      </td>
                  </tr>
                </tbody>
            </table>
        </div>

    </div>
  </div>

  <!-- Add Product Modal -->
  <div :class="{ 'hidden': !createModal }" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50">
    <div class="bg-white p-8 rounded-md w-[500px]">
      <h2 class="text-lg font-semibold">Add Product Modal</h2>
      <label for="desc" class="block mt-2">Desc</label>
      <input type="text" id="desc" name="desc" v-model="formData.desc" class=" border rounded-md shadow-md w-full p-1">
      <label for="category" class="block mt-2">Category</label>
      <select name="category" id="category" v-model="formData.category">
        <option value="">Pilih kategori</option>
        <option value="Makanan">Makanan</option>
        <option value="Minuman">Minuman</option>
        <option value="Cemilan">Cemilan</option>
      </select>
      <label for="stock" class="block mt-2">Stock</label>
      <input type="number" id="stock" name="stock" v-model="formData.stock" class=" border rounded w-full p-1">
      <label for="price" class="block mt-2">Price</label>
      <input type="number" id="price" name="price" v-model="formData.price" class=" border rounded w-full p-1">    
      <div class="flex my-2 justify-end mt-2">
        <button @click="createModalClose" class="bg-red-400 hover:bg-red-700 text-white px-5 py-2 me-2 rounded">Cancel</button>
        <button @click="submitFormProduct()" class="bg-blue-400 hover:bg-blue-700 text-white px-5 py-2 rounded">Simpan</button>
      </div>
    </div>
  </div>

  <!-- Edit Product Modal -->
  
  <div :class="{ 'hidden': !editModal }" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50">
    <div class="bg-white p-8 rounded-md w-[500px]">
      <h2 class="text-lg font-semibold">Edit Product Modal</h2>
      <label for="desc" class="block mt-2">Desc</label>
      <input type="text" id="desc" name="desc" v-model="formData.desc" class=" border rounded-md shadow-md w-full p-1">
      <label for="category" class="block mt-2">Category</label>
      <select name="category" id="category" v-model="formData.category">
        <option value="">Pilih kategori</option>
        <option value="Makanan">Makanan</option>
        <option value="Minuman">Minuman</option>
        <option value="Cemilan">Cemilan</option>
      </select>
      <label for="stock" class="block mt-2">Stock</label>
      <input type="number" id="stock" name="stock" v-model="formData.stock" class=" border rounded w-full p-1">
      <label for="price" class="block mt-2">Price</label>
      <input type="number" id="price" name="price" v-model="formData.price" class=" border rounded w-full p-1">    
      <div class="flex my-2 justify-end mt-2">
        <button @click="editModalClose" class="bg-red-400 hover:bg-red-700 text-white px-5 py-2 me-2 rounded">Cancel</button>
        <button @click="editModalSubmit(this.formData.id)" class="bg-blue-400 hover:bg-blue-700 text-white px-5 py-2 rounded">Simpan</button>
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
      createModal: false,
      editModal:false,
      items: [],
      formData: {
        desc: '',
        category: '',
        stock:'',
        price:''   
      }
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
    // Action create
    createModalOpen() {
      this.createModal = true;
    },
    createModalClose() {
      this.createModal = false;
    },
    // Action update
    editModalOpen(index,id) {
      this.formData = this.items[index];
      this.editModal = true;
    },
    editModalClose() {
      this.editModal = false;
    },
    editModalSubmit(id){
      axios.put('http://127.0.0.1:8000/api/products/'+id,this.formData)
        .then(response => {
            this.editModal = false;
            console.log(this.formData);
            this.fetchData();
        })
        .catch(error => {
            console.error('Error deleting data:', error);
        });
    },
    deleteItem(id) {
      axios.delete('http://127.0.0.1:8000/api/products/'+id)
        .then(response => {
          this.fetchData();
        })
        .catch(error => {
          console.error('Error deleting data:', error);
        });
      },
      formatCurrency(value) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value);
      },
      submitFormProduct() {
        axios.post('http://127.0.0.1:8000/api/products', this.formData)
        .then(ret => {
          this.fetchData();
          this.createModal = false;
        })
        .catch(error => {
            console.error('Error deleting data:', error);
        });
    },
    fetchData() {
      axios.get('http://127.0.0.1:8000/api/products')
        .then(response => {
          this.items = response.data;
        })
        .catch(error => {
          console.error('Error fetching data:', error);
        });
    },
  },
  created() {
    this.fetchData();
  }
};
</script>


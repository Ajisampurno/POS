<template>
  <div class="container mx-auto p-4 bg-gray-200">
    <div class="grid grid-cols-3 gap-4">
      <div class="...">
        <div class="bg-white rounded-xl overflow-hidden shadow-lg mx-10 px-8 mt-5">
          <div class="flex text-xl px-4 py-4">
            <label for="" class="block me-5">Total Qty: </label>
            <span class="font-bold text-6xl me-[100px]">{{ getTotalQty() }}</span>
          </div>
        </div>
      </div>
      <div class="col-span-2 ...">
        <div class="bg-white rounded-xl overflow-hidden shadow-lg me-10 px-8 mt-5">
          <div class="flex text-xl px-4 py-4">
            <label for="" class="block me-5">Total Price: </label>
            <span class="font-bold text-6xl">Rp. {{ getTotalPrice() }}</span>
          </div>
        </div>
      </div>
    </div>
    <br>
    <div class="bg-white rounded-xl overflow-hidden shadow-lg mx-10 p-5">
      <label>Scan Product</label>
      <input v-model="formDataCart.product_id" @keyup.enter="scanProduct" type="text" class="flex w-[500px] border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-center mb-5" />
      <div class="max-h-80 overflow-y-auto shadow-lg">
        <table class="min-w-full bg-white border-collapse rounded-lg table-responsive">
            <thead class="bg-gray-800 text-white">
              <tr>
                  <th class="px-4 py-2">SKU</th>
                  <th class="px-4 py-2">Desc</th>
                  <th class="px-4 py-2">Category</th>
                  <th class="px-4 py-2">QTY</th>
                  <th class="px-4 py-2">Price</th>
                  <th class="px-4 py-2">Total Price</th>
                  <th class="px-4 py-2">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in items" :key="index" class="text-gray-700 bg-gray-100">
                <td class="border px-4 py-2 text-center">{{ item.product_id }}</td>
                <td class="border px-4 py-2 text-center">{{ item.desc }}</td>
                <td class="border px-4 py-2 text-center">{{ item.category }}</td>
                <td class="border flex justify-center px-2 py-2">
                    <input type="number" :name="'qty_' + index" v-model="item.qty" min="1" class="flex w-[100px] border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-center">
                </td>
                <td class="border px-4 py-2 text-center">{{ item.price }}</td>
                <td class="border px-4 py-2 text-center">{{ item.price * item.qty }}</td>
                <td class="border px-4 py-2 text-center">
                  <div class="flex justify-center space-x-2">
                    <!-- Tombol Delete -->
                    <button @click="deleteItem(index)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Delete
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
        </table>
      </div>
      <div class="flex justify-end mt-4">
        <button @click="openPaymentModal" class="bg-blue-500 hover:bg-blue-700 text-[20px] text-white font-bold px-10 py-3 rounded">
          Bayar
        </button>
      </div>
    </div>
  </div>

  <!-- Add Product Modal -->
  <div :class="{ 'hidden': !isEditProductModalOpen }" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50">
      <div class="bg-white p-8 rounded-md">
          <h2 class="text-lg font-semibold">Edit Product Modal</h2>
          <!-- Form untuk menambahkan produk -->
          <form>
              <div class="mb-4">
                  <label for="sku" class="block text-sm font-medium text-gray-700">SKU:</label>
                  <select  id="sku" name="sku" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                  <option value="">Select SKU</option>
                  <option value="SKU001">SKU001</option>
                  <option value="SKU002">SKU002</option>
                  <option value="SKU003">SKU003</option>
                  <!-- Tambahkan opsi SKU lainnya sesuai kebutuhan -->
                  </select>
              </div>
              <div class="mb-4">
                  <label for="qty" class="block text-sm font-medium text-gray-700">Qty:</label>
                  <input  type="number" id="qty" name="qty" min="1" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
              </div>
              <div @click="closeEditProductModal" class="flex justify-end">
                  <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 mr-2 rounded">
                  Cancel
                  </button>
                  <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                  Add
                  </button>
              </div>
          </form>
      </div>
  </div>


  <!-- Payment Modal -->
  <div :class="{ 'hidden': !isPaymentModalOpen }" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50">
    <div class="bg-white p-8 rounded-md">
      <h2 class="text-lg font-semibold mb-4">Open Payment</h2>
        <!-- Formulir untuk pembayaran -->
        <form>
          <div class="mb-4">
            <label for="cardBank" class="block text-sm font-medium text-gray-700">Card Bank:</label>
            <select id="cardBank" name="cardBank" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
              <option value="">Select Card Bank</option>
              <option value="Cash">Cash</option>
              <option value="Debit BCA">Debit BCA</option>
              <option value="Debit BNI">Debit BNI</option>
              <option value="Debit BRI">Debit BRI</option>
              <option value="Credit BCA">Credit BCA</option>
              <option value="Credit BNI">Credit BNI</option>
              <option value="Credit BRI">Credit BRI</option>
              <option value="Qris">Qris</option>
              <!-- Tambahkan opsi bank lainnya sesuai kebutuhan -->
            </select>
          </div>
          <div class="mb-4">
            <label for="cash" class="block text-sm font-medium text-gray-700">Cash:</label>
            <input type="number" id="cash" name="cash" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
          </div>
          <div class="mb-4">
            <label for="cardNumber" class="block text-sm font-medium text-gray-700">Card Number:</label>
            <input type="number" id="cardNumber" name="cardNumber" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
          </div>
          <div class="mb-4">
            <label for="refCode" class="block text-sm font-medium text-gray-700">Ref Code:</label>
            <input type="number" id="refCode" name="refCode" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
          </div>
          <div class="flex justify-end">
            <button @click="closePaymentModal" type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 mr-2 rounded">
              Cancel
            </button>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
              Submit
            </button>
          </div>
        </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      items: [],
      search: '',
      isPaymentModalOpen: false,
      paymentInfo: {
          paymentMethod: '',
          cardBank: '',
          cardNumber: '',
          refCode: ''
      },
      formDataCart: {
        product_id: '',
        qty:1,
      },
      
    };
  },
  computed: {
    searchedItem() {
      return this.items.find(item => item.sku === this.search);
    },
  },
  methods: {
    openPaymentModal() {
      this.isPaymentModalOpen = true;
    },
    closePaymentModal() {
      this.isPaymentModalOpen = false;
    },
    getTotalPrice() {
        let totalPrice = 0;
        this.items.forEach(item => {
            totalPrice += item.price * item.qty;
        });
        return totalPrice;
    },
    getTotalQty() {
        let totalQty = 0;
        this.items.forEach(item => {
            totalQty += item.qty;
        });
        return totalQty;
    },
    scanProduct(){
      axios.post('http://127.0.0.1:8000/api/carts', this.formDataCart)
      .then(response => {
        this.fetchData();
      })
      .catch(error => {
        console.error(error);
      });
    },
    fetchData() {
      axios.get('http://127.0.0.1:8000/api/carts')
      .then(response => {
          this.items = response.data;
      })
      .catch(error => {
          console.error('Error fetching data:', error);
      });
    }
  },
  created() {
    this.fetchData();
  }
};
</script>

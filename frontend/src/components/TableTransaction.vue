<template>
  <div class="container mx-auto p-4 bg-gray-200">
    <div class="bg-white rounded-xl overflow-hidden shadow-md mx-10 p-5">
      <button @click="openAddProductModal" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 m-3 rounded">
        Add product
      </button>
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white border-collapse rounded-lg table-responsive">
            <thead class="bg-gray-800 text-white">
            <tr>
                <th class="px-4 py-2">SKU</th>
                <th class="px-4 py-2">Desc</th>
                <th class="px-4 py-2">QTY</th>
                <th class="px-4 py-2">Price</th>
                <th class="px-4 py-2">Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in items" :key="index" class="text-gray-700 bg-gray-300">
                <td class="border px-4 py-2 text-center">{{ item.sku }}</td>
                <td class="border px-4 py-2 text-center">{{ item.desc }}</td>
                <td class="border px-4 py-2 text-center">{{ item.qty }}</td>
                <td class="border px-4 py-2 text-center">{{ item.price }}</td>
                <td class="border px-4 py-2 text-center">
                    <div class="flex justify-center space-x-2">
                        <!-- Tombol Edit -->
                        <button @click="openEditProductModal" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            Edit
                        </button>
                        <!-- Tombol Delete -->
                        <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Delete
                        </button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
      </div>
    </div>
    <br>
    <div class="grid grid-cols-6">
      <div class="col-span-5">
        <div class="bg-white rounded-xl overflow-hidden shadow-md mx-10 p-2">
          <ul>
            <li>Total Qty: 5</li>
            <li>Total Price: 5</li>
          </ul>
        </div>
      </div>
      <div>
        <button @click="openPaymentModal" class="bg-blue-500 hover:bg-blue-700 text-[20px] text-white font-bold px-10 py-4 rounded">
          Bayar
        </button>
      </div>
    </div>
  </div>

  <!-- Add Product Modal -->
  <div :class="{ 'hidden': !isAddProductModalOpen }" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50">
      <div class="bg-white p-8 rounded-md">
          <h2 class="text-lg font-semibold">Add Product Modal</h2>
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
              <div @click="closeAddProductModal" class="flex justify-end">
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
            <label class="inline-flex items-center ml-6">
                <input type="radio" v-model="paymentInfo.paymentMethod" value="card" class="form-radio h-5 w-5 text-blue-600">
                <span class="m-2">Card</span>
                <input type="radio" v-model="paymentInfo.paymentMethod" value="cash" class="form-radio h-5 w-5 text-blue-600">
                <span class="m-2">Cash</span>
            </label>
            <hr>
            <br>
          <div v-if="paymentInfo.paymentMethod === 'cash'" class="mb-4">
            <label for="cash" class="block text-sm font-medium text-gray-700">Cash:</label>
            <input type="number" id="cash" name="cash" min="0" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
          </div>
          <div v-if="paymentInfo.paymentMethod === 'card'" class="mb-4">
            <label for="cardBank" class="block text-sm font-medium text-gray-700">Card Bank:</label>
            <select id="cardBank" name="cardBank" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
              <option value="">Select Card Bank</option>
              <option value="BCA">BCA</option>
              <option value="BNI">BNI</option>
              <option value="BRI">BRI</option>
              <!-- Tambahkan opsi bank lainnya sesuai kebutuhan -->
            </select>
          </div>
          <div v-if="paymentInfo.paymentMethod === 'card'" class="mb-4">
            <label for="cardNumber" class="block text-sm font-medium text-gray-700">Card Number:</label>
            <input type="number" id="cardNumber" name="cardNumber" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
          </div>
          <div v-if="paymentInfo.paymentMethod === 'card'" class="mb-4">
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
export default {
  data() {
    return {
      items: [
          { sku: 'SKU001', desc: 'Product 1', qty: 5, price: 10.99 },
          { sku: 'SKU002', desc: 'Product 2', qty: 3, price: 15.99 },
          { sku: 'SKU003', desc: 'Product 3', qty: 8, price: 20.49 }
          // Tambahkan item lainnya sesuai kebutuhan
      ],
      isAddProductModalOpen: false,
      isPaymentModalOpen: false,
      isEditProductModalOpen: false,
      paymentInfo: {
          paymentMethod: '',
          cardBank: '',
          cardNumber: '',
          refCode: ''
      }
    };
  },
  methods: {
    openAddProductModal() {
      this.isAddProductModalOpen = true;
    },
    closeAddProductModal() {
      this.isAddProductModalOpen = false;
    },
    openEditProductModal() {
      this.isEditProductModalOpen = true;
    },
    closeEditProductModal() {
      this.isEditProductModalOpen = false;
    },
    openPaymentModal() {
      this.isPaymentModalOpen = true;
    },
    closePaymentModal() {
      this.isPaymentModalOpen = false;
    },
  },
};
</script>

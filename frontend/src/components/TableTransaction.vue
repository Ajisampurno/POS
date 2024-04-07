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
      <input v-model="formDataCart.product_id" @keyup.enter="scanProduct" type="text" class="flex w-[500px] border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 mb-5" />
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
                <td class="border text-center">
                  <input v-model="item.product_id" type="disable" class="text-center text-gray-700 bg-gray-100"/>
                </td>
                <td class="border px-4 py-2 text-center">{{ item.desc }}</td>
                <td class="border px-4 py-2 text-center">{{ item.category }}</td>
                <td class="border px-4 py-2 text-center">
                    <input 
                      type="number" 
                      :name="'qty_' + index" 
                      v-model="item.qty" 
                      @input="updateQty(index, $event.target.value)"
                      min="1" 
                      class="flex w-[100px] border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-center">
                </td>
                <td class="border px-4 py-2 text-center">{{ item.price }}</td>
                <td class="border px-4 py-2 text-center">{{ item.price * item.qty }}</td>
                <td class="border px-4 py-2 text-center">
                  <div class="flex justify-center space-x-2">
                    <!-- Tombol Delete -->
                    <button @click="deleteItem(item.id)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
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
  <!-- Payment Modal -->
  <div :class="{ 'hidden': !isPaymentModalOpen }" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50">
    <div class="min-w-[300px] bg-white p-8 rounded-md">
      <h2 class="text-lg font-semibold mb-4">Open Payment</h2>
        <div class="mb-4">
          <label for="metode" class="block text-sm font-medium text-gray-700">Payment metode:</label>
          <select id="metode" name="metode" v-model="formDataPayment.metode" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            <option value="">Select Payment Metode</option>
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
        <div class="mb-4" v-if="formDataPayment.metode !== ''">
          <div class="mb-4" v-if="formDataPayment.metode == 'Cash'">
            <label for="cash" class="block text-sm font-medium text-gray-700">Cash:</label>
            <input type="number" id="cash" name="cash" v-model="cash" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
          </div>
          <div class="mb-4">
            <ul>
              <li>Total yang harus di bayar: <span class="font-bold text-lg">Rp. {{ getTotalPrice() }}</span> </li>
              <li v-if="formDataPayment.metode == 'Cash'">Kembali: <span class="font-bold text-lg">Rp. {{ getChange() }} </span></li>
            </ul>
          </div>
          <div class="mb-4" v-if="formDataPayment.metode !== 'Cash'">
            <label for="number_card" class="block text-sm font-medium text-gray-700">Card Number:</label>
            <input type="number" id="number_card" name="number_card" v-model="formDataPayment.number_card" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
          </div>
          <div class="mb-4" v-if="formDataPayment.metode !== 'Cash'">
            <label for="code_ref" class="block text-sm font-medium text-gray-700">Ref Code:</label>
            <input type="number" id="code_ref" name="code_ref" v-model="formDataPayment.code_ref" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
          </div>
        </div>
        <input v-model="formDataPayment.amount" type="hidden" />
        <div class="flex justify-end">
          <button @click="closePaymentModal" type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 mr-2 rounded">
            Cancel
          </button>
          <button type="submit" @click="submitFormDataPayment()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Submit
          </button>
        </div>
    </div>
  </div>
</template>

<script>
import axios from '@/plugins/axios';

export default {
  data() {
    return {
      items: [],
      search: '',
      isPaymentModalOpen: false,
      cash:'',
      formDataPayment:{
        amount: '',
        metode: '',
        number_card: '',
        code_ref:'',
        transactions:[]
      },
      formDataCart: {
        product_id: '',
        qty:1,
      },
    };
  },
  computed: {

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
    submitFormDataPayment(){
      if(confirm('Pastikan transaksi sudah sesuai, jika sesuai maka Gas aja!!')){
        if (!this.formDataPayment.amount) {
          this.formDataPayment.amount = this.getTotalPrice();
        }
        if (!this.formDataPayment.number_card) {
          this.formDataPayment.number_card = 0;
        }
        if (!this.formDataPayment.code_ref) {
          this.formDataPayment.code_ref = 0;
        }
        axios.post('http://127.0.0.1:8000/api/payments', this.formDataPayment)
        .then(response => {
          this.cash = '';
          this.formDataPayment={
            metode: '',
            number_card: '',
            code_ref:'',
          };
          this.isPaymentModalOpen = false;
          this.fetchData();
        })
        .catch(error => {
          console.error(error);
        });
      }
    },
    scanProduct(){
      axios.post('http://127.0.0.1:8000/api/carts', this.formDataCart)
      .then(response => {
        this.fetchData();
      })
      .catch(error => {
        if (error.response.status === 400) {
          alert('Stok produk kosong!');
        } else {
          alert('Terjadi kesalahan saat menambahkan produk ke keranjang');
        }
      });
    },
    getChange() {
      return this.cash - this.getTotalPrice();
    },
    deleteItem(id){
      if(confirm('Anda yakin ingin menghapus ini?')){
        axios.delete('http://127.0.0.1:8000/api/carts/'+id)
        .then(response => {
          this.fetchData();
        })
        .catch(error => {
          console.log(error);
        });
      }
    },
    updateQty(index, newValue) {
      this.items[index].qty = newValue;
      this.formDataPayment.transactions[index].qty = newValue;
    },
    fetchData() {
      axios.get('http://127.0.0.1:8000/api/carts')
      .then(response => {
        this.formDataCart.product_id = '';
        this.items = response.data;
        this.formDataPayment.transactions = [];

        response.data.forEach(cartItem => {
            const transaction = {
                product_id: cartItem.product_id,
                qty: cartItem.qty,
                price: cartItem.price
            };
            this.formDataPayment.transactions.push(transaction);
        });
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

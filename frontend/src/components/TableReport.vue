<template>
    <div class="container mx-auto p-4 bg-gray-300">
        <div class="bg-white rounded-xl overflow-hidden shadow-md mx-10 p-5">
            <div class="mb-4">
                <input type="text" v-model="searchQuery" class="border-gray-300 border rounded-md p-2 w-full" placeholder="Search...">
            </div>
            <div class="flex flex-wrap mb-4">
                <div class="mr-2 mb-2">
                    <label for="startDate" class="block mb-1">Start Date:</label>
                    <input type="date" id="startDate" v-model="startDateFilter" class="border-gray-300 border rounded-md p-2 max-w-xs">
                </div>
                <div class="mr-2 mb-2">
                    <label for="endDate" class="block mb-1">End Date:</label>
                    <input type="date" id="endDate" v-model="endDateFilter" class="border-gray-300 border rounded-md p-2 max-w-xs">
                </div>
                <div class="mr-2 mb-2">
                    <label for="status" class="block mb-1">Status:</label>
                    <select id="status" v-model="statusFilter" class="border-gray-300 border rounded-md p-2 max-w-xs">
                        <option value="">Filter by Status...</option>
                        <option v-for="statusOption in uniqueStatuses" :key="statusOption" :value="statusOption">{{ statusOption }}</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label for="paymentMethod" class="block mb-1">Payment Method:</label>
                    <select id="paymentMethod" v-model="paymentMethodFilter" class="border-gray-300 border rounded-md p-2 max-w-xs">
                        <option value="">Filter by Payment Method...</option>
                        <option v-for="paymentMethodOption in uniquePaymentMethods" :key="paymentMethodOption" :value="paymentMethodOption">{{ paymentMethodOption }}</option>
                    </select>
                </div>
            </div>
            <div class="overflow-x-auto whitespace-nowrap">
            
                <table class="min-w-full bg-white border-collapse rounded-lg">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="px-4 py-2 text-center">Kode Trx</th>
                            <th class="px-4 py-2 text-center">Date</th>
                            <th class="px-4 py-2 text-center">Status</th>
                            <th class="px-4 py-2 text-center">Metode Pembayaran</th>
                            <th class="px-4 py-2 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(transaction, index) in paginatedTransactions" :key="index" class="text-gray-700 bg-gray-100">
                            <td class="border px-4 py-2 text-center">{{ transaction.id }}</td>
                            <td class="border px-4 py-2 text-center">{{ transaction.date}}</td>
                            <td class="border px-4 py-2 text-center">{{ transaction.status }}</td>
                            <td class="border px-4 py-2 text-center">{{ transaction.metode }}</td>
                            <td class="border px-4 py-2 text-center">
                                <button @click="showModalOpen(transaction.id)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">Show</button>
                                <button @click="editModalOpen(transaction.id)" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded">Edit</button>
                                <button @click="deleteItem(transaction.id)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex justify-center mt-4">
                <button @click="previousPage" :disabled="currentPage === 1" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-l">
                    Previous
                </button>
                <button @click="nextPage" :disabled="currentPage === pageCount" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-r">
                    Next
                </button>
            </div>
        </div>
    </div>

<!-- Detail Modal -->
<div :class="{ 'hidden': !showModal }" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50">
    <div class="bg-white p-8 rounded-md w-[700px]">
        <h2 class="text-lg font-semibold">Add Product Modal</h2>
        <table class="min-w-full bg-white border-collapse rounded-lg">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-4 py-2 text-center">No</th>
                    <th class="px-4 py-2 text-center">Desc</th>
                    <th class="px-4 py-2 text-center">Category</th>
                    <th class="px-4 py-2 text-center">Qty</th>
                    <th class="px-4 py-2 text-center">Price</th>
                </tr>
            </thead>
            <tbody>
                <tr class="" v-for="(detail, index) in transactionDetail" :key="index">
                    <td class="border px-4 py-2 text-center">{{ index+1 }}</td>
                    <td class="border px-4 py-2">{{ detail.desc }}</td>
                    <td class="border px-4 py-2 text-center">{{ detail.category }}</td>
                    <td class="border px-4 py-2 text-center">{{ detail.qty }}</td>
                    <td class="border px-4 py-2 text-center">{{ detail.price }}</td>
                </tr>
            </tbody>
        </table>
        <div class="flex justify-end mt-4">
            <button @click="showModalClose()" type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 mr-2 rounded">
            Cancel
            </button>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div :class="{ 'hidden': !editModal }" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50">
    <div class="bg-white p-8 rounded-md w-[700px]">
        <h2 class="text-lg font-semibold">Add Product Modal</h2>
        <label for="date" class="block mt-2">Date</label>
        <input type="date" id="date" name="date" v-model="formData.date" class=" border rounded-md shadow-md w-full p-1">
        <label for="status" class="block mt-2">Status</label>
        <select name="status" id="status" v-model="this.formData.status">
            <option value="">Pilih metode pembayaran</option>
            <option value="Sale">Sale</option>
            <option value="Retur">Retur</option>
        </select>
        <label for="metode" class="block mt-2">Metode</label>
        <select name="metode" id="metode" v-model="formData.metode">
            <option value="">Pilih metode pembayaran</option>
            <option value="Debit">Debit</option>
            <option value="Credit">Credit</option>
            <option value="Qris">Qris</option>
            <option value="Cash">Cash</option>
        </select>
        <label for="number_card" class="block mt-2">Card number</label>
        <input type="number" id="number_card" name="number_card" v-model="formData.number_card" class=" border rounded-md shadow-md w-full p-1">
        <label for="code_ref" class="block mt-2">Code referensi</label>
        <input type="number" id="code_ref" name="code_ref" v-model="formData.code_ref" class=" border rounded-md shadow-md w-full p-1">
        <div class="flex my-2 justify-end mt-2">
            <button @click="editModalClose" class="bg-red-400 hover:bg-red-700 text-white px-5 py-2 me-2 rounded">Cancel</button>
            <button @click="editModalSubmit" class="bg-blue-400 hover:bg-blue-700 text-white px-5 py-2 rounded">Simpan</button>
        </div>
    </div>
</div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            data:[],
            transactions: [],
            transactionDetail: [],
            searchQuery: '',
            startDateFilter: '',
            endDateFilter: '',
            statusFilter: '',
            paymentMethodFilter: '',
            currentPage: 1,
            itemsPerPage: 10,
            showModal: false,
            editModal: false,
            formData: {
                date: "",
                status:[],
                metode:"",   
            }
        };
    },
    computed: {
        uniqueStatuses() {
            return Array.from(new Set(this.transactions.map(transaction => transaction.status)));
        },
        uniquePaymentMethods() {
            return Array.from(new Set(this.transactions.map(transaction => transaction.metode)));
        },
        filteredTransactions() {
            return this.transactions.filter(item =>
                String(item.id).toLowerCase().includes(this.searchQuery.toLowerCase()) &&
                (this.startDateFilter ? item.date >= this.startDateFilter : true) &&
                (this.endDateFilter ? item.date <= this.endDateFilter : true) &&
                (this.statusFilter ? item.status.toLowerCase() === this.statusFilter.toLowerCase() : true) &&
                (this.paymentMethodFilter ? item.metode.toLowerCase() === this.paymentMethodFilter.toLowerCase() : true)
            );
        },
        paginatedTransactions() {
            const startIndex = (this.currentPage - 1) * this.itemsPerPage;
            return this.filteredTransactions.slice(startIndex, startIndex + this.itemsPerPage);
        },
        pageCount() {
            return Math.ceil(this.filteredTransactions.length / this.itemsPerPage);
        },
    },
    methods: {
        //Action show modal
        showModalOpen(transaction_id) {
            axios.get('http://127.0.0.1:8000/api/payments/'+transaction_id)
            .then(response => {
                this.transactionDetail = response.data;
                this.showModal = true;
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
        },
        showModalClose() {
            this.showModal = false;
        },
        //Action edit modal
        editModalOpen(index) {
            this.editModal = true;
            this.formData = this.transactions[index];
            console.log('Edit item:', this.formData);
        },
        editModalClose(){
            this.editModal = false;
        },
        editModalSubmit() {
            axios.put('http://127.0.0.1:8000/api/payments', this.formData).then(ret => {
                this.formData = response.data;
                console.log('sukses')
            }).catch(err=>{
                console.log("GAGAL SUBMIT", err)
            })
        },
        //Action paginate
        previousPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
        },
        nextPage() {
            if (this.currentPage < this.pageCount) {
                this.currentPage++;
            }
        },
        // Action data main
        fetchData() {
            axios.get('http://127.0.0.1:8000/api/payments')
            .then(response => {
                this.transactions = response.data;
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
        },
        deleteItem(id) {
            //axios.delete('http://127.0.0.1:8000/payments/'+id)
            //    .then(response => {
            //        console.log('data berhasil di hapus');
            //    })
            //    .catch(error => {
            //        console.error('Error deleting data:', error);
            //    });
        },
    },
    mounted(){
        this.fetchData();       
    }
};
</script>

<template>
    <div class="container mx-auto p-4">
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
                        <tr v-for="(item, index) in paginatedTransactions" :key="index" class="bg-gray-100">
                            <td class="border px-4 py-2 text-center">{{ item.kodeTrx }}</td>
                            <td class="border px-4 py-2 text-center">{{ item.date }}</td>
                            <td class="border px-4 py-2 text-center">{{ item.status }}</td>
                            <td class="border px-4 py-2 text-center">{{ item.paymentMethod }}</td>
                            <td class="border px-4 py-2 text-center">
                                <button @click="showItem(index)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">Show</button>
                                <button @click="editItem(index)" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded">Edit</button>
                                <button @click="deleteItem(index)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Delete</button>
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
</template>

<script>
export default {
    data() {
        return {
            transactions: [
                { kodeTrx: 'TRX001', date: '2024-03-01', status: 'Pending', paymentMethod: 'Credit Card' },
                { kodeTrx: 'TRX002', date: '2024-03-02', status: 'Completed', paymentMethod: 'PayPal' },
                { kodeTrx: 'TRX003', date: '2024-03-03', status: 'Failed', paymentMethod: 'Bank Transfer' },
                { kodeTrx: 'TRX004', date: '2024-03-04', status: 'Pending', paymentMethod: 'Cash' },
                // Add more transactions as needed
            ],
            searchQuery: '',
            startDateFilter: '',
            endDateFilter: '',
            statusFilter: '',
            paymentMethodFilter: '',
            currentPage: 1,
            itemsPerPage: 10
        };
    },
    computed: {
        uniqueStatuses() {
            return Array.from(new Set(this.transactions.map(transaction => transaction.status)));
        },
        uniquePaymentMethods() {
            return Array.from(new Set(this.transactions.map(transaction => transaction.paymentMethod)));
        },
        filteredTransactions() {
            return this.transactions.filter(item =>
                item.kodeTrx.toLowerCase().includes(this.searchQuery.toLowerCase()) &&
                (this.startDateFilter ? item.date >= this.startDateFilter : true) &&
                (this.endDateFilter ? item.date <= this.endDateFilter : true) &&
                (this.statusFilter ? item.status.toLowerCase() === this.statusFilter.toLowerCase() : true) &&
                (this.paymentMethodFilter ? item.paymentMethod.toLowerCase() === this.paymentMethodFilter.toLowerCase() : true)
            );
        },
        paginatedTransactions() {
            const startIndex = (this.currentPage - 1) * this.itemsPerPage;
            return this.filteredTransactions.slice(startIndex, startIndex + this.itemsPerPage);
        },
        pageCount() {
            return Math.ceil(this.filteredTransactions.length / this.itemsPerPage);
        }
    },
    methods: {
        showItem(index) {
            // Action to show item
            console.log('Show item:', this.filteredTransactions[index]);
        },
        editItem(index) {
            // Action to edit item
            console.log('Edit item:', this.filteredTransactions[index]);
        },
        deleteItem(index) {
            // Action to delete item
            console.log('Delete item:', this.filteredTransactions[index]);
            this.transactions = this.transactions.filter((_, i) => i !== index); // Remove item from the list
        },
        previousPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
        },
        nextPage() {
            if (this.currentPage < this.pageCount) {
                this.currentPage++;
            }
        }
    }
};
</script>

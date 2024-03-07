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
      <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md">Logout</button>
    </div>
  </div>
</template>
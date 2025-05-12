<template>  <div class="order-search-form">
    <h1>Order Search</h1>
    <p>Track your order by entering any of the following details</p>

    <form @submit.prevent="searchOrders" class="space-y-4">
      <div class="form-group">
        <label for="order_number">Order Number</label>
        <input
          type="text"
          id="order_number"
          v-model="searchParams.order_number"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
          placeholder="Enter order number (e.g., ORD-12345)"
        />
      </div>

      <div class="form-group">
        <label for="customer_number">Customer Number</label>
        <input
          type="text"
          id="customer_number"
          v-model="searchParams.customer_number"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
          placeholder="Enter customer number"
        />
      </div>

      <div class="form-group">
        <label for="invoice_number">Invoice Number</label>
        <input
          type="text"
          id="invoice_number"
          v-model="searchParams.invoice_number"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
          placeholder="Enter invoice number (e.g., INV-12345)"
        />
      </div>

      <div class="button-group">
        <button
          type="submit"
          class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >
          Search Order
        </button>
      </div>
    </form>

    <!-- Results -->
    <div v-if="order" class="mt-8">
      <h2>Order Details</h2>
      <div class="order-info">
        <p><strong>Order Number:</strong> {{ order.order_number }}</p>
        <p><strong>Order Date:</strong> {{ formatDate(order.created_at) }}</p>
        <p><strong>Customer Name:</strong> {{ order.customer.name }}</p>
        <p><strong>Customer Number:</strong> {{ order.customer.customer_number }}</p>
        <p><strong>Status:</strong> {{ order.status }}</p>
        <p><strong>Delivery Address:</strong> {{ order.customer.address }}</p>
      </div>      <div class="products-table">
        <h3>Products</h3>
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Price</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="product in order.products" :key="product.id">
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ product.name }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ product.pivot.quantity }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ product.pivot.price }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ (product.pivot.quantity * product.pivot.price).toFixed(2) }}</td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="3" class="px-6 py-4 text-right"><strong>Total:</strong></td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ order.total_amount }}</td>
            </tr>
          </tfoot>
        </table>
      </div>

      <!-- Order Photos Section -->
      <div class="order-photos">
        <h3 class="mt-6 text-lg font-medium text-gray-900">Order Photos</h3>
        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Processing Photo -->
          <div class="photo-card bg-white p-4 rounded-lg shadow">
            <h4 class="mb-2 font-medium text-gray-700">Processing Photo</h4>
            <div v-if="order.image_path" class="photo-container">
              <img :src="getImageUrl(order.image_path)" alt="Processing Photo" class="rounded-md w-full object-cover max-h-64">
            </div>
            <div v-else class="empty-photo-container bg-gray-100 rounded-md p-8 flex items-center justify-center">
              <p class="text-gray-500 italic text-sm">No processing photo available</p>
            </div>
          </div>
          
          <!-- Delivery Photo -->
          <div class="photo-card bg-white p-4 rounded-lg shadow">
            <h4 class="mb-2 font-medium text-gray-700">Delivery Confirmation</h4>
            <div v-if="order.photo_delivered" class="photo-container">
              <img :src="getImageUrl(order.photo_delivered)" alt="Delivery Photo" class="rounded-md w-full object-cover max-h-64">
            </div>
            <div v-else class="empty-photo-container bg-gray-100 rounded-md p-8 flex items-center justify-center">
              <p class="text-gray-500 italic text-sm">No delivery photo available</p>
            </div>
          </div>
        </div>
      </div>

      <div class="notes">
        <h3>Additional Notes</h3>
        <p>{{ order.notes }}</p>
      </div>
    </div>

    <!-- Error Message -->
    <div v-if="error" class="error">{{ error }}</div>
  </div>
</template>

<script>
import axios from 'axios';
import apiService from '../services/api';

export default {
  name: 'OrderSearchForm',  data() {
    return {
      searchParams: {
        order_number: '',
        customer_number: '',
        invoice_number: ''
      },
      order: null,
      error: null
    };
  },
  methods: {    async searchOrders() {
      this.order = null;
      this.error = null;      
      
      // Check if at least one search parameter is provided
      if (!this.searchParams.order_number && 
          !this.searchParams.customer_number && 
          !this.searchParams.invoice_number) {
        this.error = 'Please enter at least one search criterion';
        return;
      }
      
      console.log('Searching with params:', this.searchParams);

      try {
        // Use our API service instead of direct axios call
        const response = await apiService.searchOrder({
          order_number: this.searchParams.order_number,
          customer_number: this.searchParams.customer_number,
          invoice_number: this.searchParams.invoice_number
        });
        
        console.log('Raw API Response:', response);
        console.log('Response Data:', response.data);

        if (response.data) {
          this.order = response.data;
          console.log('Order set to:', this.order);
        } else {
          this.error = 'No orders found matching the search criteria';
        }
      } catch (error) {
        console.error('Error details:', error);
        console.error('Error response:', error.response);
        this.error = error.response?.data?.error || 'Error fetching order. Please try again later.';
      }
    },    formatDate(date) {
      return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
      });
    },
    getImageUrl(path) {
      if (!path) return null;
      // If it's a mock path or testing URL, return a placeholder
      if (path.includes('mock')) {
        return 'https://placehold.co/600x400/e3f2fd/1976d2?text=Order+Photo';
      }
      // Otherwise return the actual image URL
      return `http://127.0.0.1:8000/storage/${path}`;
    }
  }
};
</script>

<style scoped>
.order-search-form {
  @apply p-6 bg-white rounded-lg shadow;
}

.form-group {
  @apply mb-4;
}

.form-group label {
  @apply block text-sm font-medium text-gray-700 mb-1;
}

.button-group {
  @apply flex justify-end mt-6;
}

.order-info {
  @apply bg-gray-50 p-4 rounded-lg mb-6;
}

.products-table {
  @apply mt-6;
}

.notes {
  @apply mt-6 p-4 bg-gray-50 rounded-lg;
}

.error {
  @apply mt-4 p-4 bg-red-50 text-red-700 rounded-lg;
}
</style> 
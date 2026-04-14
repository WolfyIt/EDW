<template>  <div class="order-search">
    <form @submit.prevent="searchOrders" class="search-form">
      <div class="form-group">
        <label for="order_number" class="form-label">Order Number</label>
        <input
          type="text"
          id="order_number"
          v-model="searchParams.order_number"
          class="form-input"
          placeholder="Enter order number (e.g., ORD-12345)"
        />
      </div>

      <div class="form-group">
        <label for="customer_number" class="form-label">Customer Number</label>
        <input
          type="text"
          id="customer_number"
          v-model="searchParams.customer_number"
          class="form-input"
          placeholder="Enter customer number"
        />
      </div>

      <div class="form-group">
        <label for="invoice_number" class="form-label">Invoice Number</label>
        <input
          type="text"
          id="invoice_number"
          v-model="searchParams.invoice_number"
          class="form-input"
          placeholder="Enter invoice number (e.g., INV-12345)"
        />
      </div>

      <button type="submit" class="search-button">Search Order</button>
    </form>

    <!-- Error Message -->
    <div v-if="error" class="error-message">
      {{ error }}
    </div>

    <!-- Results -->
    <div v-if="order" class="result-section">
      <h2 class="result-title">Order Details</h2>
      
      <div class="result-item">
        <span class="result-label">Order Number</span>
        <span class="result-value">{{ order.order_number }}</span>
      </div>
      
      <div class="result-item">
        <span class="result-label">Order Date</span>
        <span class="result-value">{{ formatDate(order.created_at) }}</span>
      </div>
      
      <div class="result-item">
        <span class="result-label">Customer Name</span>
        <span class="result-value">{{ order.customer.name }}</span>
      </div>
      
      <div class="result-item">
        <span class="result-label">Customer Number</span>
        <span class="result-value">{{ order.customer.customer_number }}</span>
      </div>
      
      <div class="result-item">
        <span class="result-label">Status</span>
        <span :class="['status-badge', 'status-' + order.status.toLowerCase()]">
          {{ order.status }}
        </span>
      </div>
      
      <div class="result-item">
        <span class="result-label">Delivery Address</span>
        <span class="result-value">{{ order.customer.address }}</span>
      </div>

      <hr class="divider" />

      <h3 class="result-subtitle">Products</h3>      <table class="product-table">
        <thead>
          <tr>
            <th>Name</th>
            <th style="text-align:right;">Qty</th>
            <th style="text-align:right;">Unit Price</th>
            <th style="text-align:right;">Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="product in order.products" :key="product.id">
            <td style="text-align:left;">{{ product.name }}</td>
            <td>{{ product.pivot.quantity }}</td>
            <td>${{ product.pivot.price }}</td>
            <td>${{ (product.pivot.quantity * product.pivot.price).toFixed(2) }}</td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="3" style="text-align:right;font-weight:600;">Total:</td>
            <td style="font-weight:600;">${{ order.total_amount }}</td>
          </tr>
        </tfoot>
      </table>

      <!-- Order Photos Section -->
      <div class="order-photos-section">
        <h3 class="result-subtitle">Order Photos</h3>
        <div class="photo-container">
          <!-- Processing Photo -->
          <div class="photo-card">
            <h4>Processing Photo</h4>
            <div v-if="order.image_path" class="photo-wrapper">
              <img :src="getImageUrl(order.image_path)" alt="Order Processing Image">
            </div>
            <div v-else class="no-photo">
              <p>No processing photo available</p>
            </div>
          </div>
          
          <!-- Delivery Photo -->
          <div class="photo-card">
            <h4>Delivery Confirmation</h4>
            <div v-if="order.photo_delivered" class="photo-wrapper">
              <img :src="getImageUrl(order.photo_delivered)" alt="Order Delivery Image">
            </div>
            <div v-else class="no-photo">
              <p>No delivery photo available</p>
            </div>
          </div>
        </div>
      </div>

      <div v-if="order.notes" class="result-item">
        <span class="result-label">Additional Notes</span>
        <span class="result-value">{{ order.notes }}</span>
      </div>
    </div>

    <a href="/" class="back-button">← Back to Home</a>
  </div>
</template>

<script>
import axios from 'axios';
import apiService from '../services/api';

export default {
  name: 'OrderSearch',  data() {
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
  methods: {
    async searchOrders() {
      this.order = null;
      this.error = null;

      // Check if at least one search parameter is provided
      if (!this.searchParams.order_number && 
          !this.searchParams.customer_number && 
          !this.searchParams.invoice_number) {
        this.error = 'Please enter at least one search criterion';
        return;
      }

      try {
        const response = await axios.get('http://127.0.0.1:8000/api/orders');
        
        if (response.data && Array.isArray(response.data)) {
          const foundOrder = response.data.find(order => 
            (this.searchParams.order_number && order.order_number === this.searchParams.order_number) ||
            (this.searchParams.customer_number && order.customer_number === this.searchParams.customer_number) ||
            (this.searchParams.invoice_number && order.invoice_number === this.searchParams.invoice_number)
          );

          if (foundOrder) {
            this.order = foundOrder;
          } else {
            this.error = 'No orders found matching the search criteria';
          }
        } else {
          this.error = 'Invalid response format from server';
        }
      } catch (error) {
        console.error('Error:', error);
        this.error = 'Error fetching order. Please try again later.';
      }
    },formatDate(date) {
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
.order-search {  max-width: 800px;
  margin: 0 auto;
}

.divider {
  border: none;
  height: 1px;
  background-color: #f5f5f7;
  margin: 2rem 0;
}

.order-photos-section {
  margin-top: 2rem;
}

.photo-container {
  display: flex;
  gap: 1.5rem;
  flex-wrap: wrap;
  margin-top: 1rem;
}

.photo-card {
  flex: 1;
  min-width: 250px;
  background: #f8f9fa;
  border-radius: 10px;
  padding: 1rem;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.photo-card h4 {
  margin-bottom: 0.8rem;
  font-size: 1rem;
  font-weight: 500;
  color: #2c3e50;
}

.photo-wrapper img {
  width: 100%;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.no-photo {
  padding: 2rem;
  background-color: #f1f1f1;
  border-radius: 8px;
  border: 1px dashed #d2d2d7;
  text-align: center;
}

.no-photo p {
  color: #6c757d;
  font-style: italic;
}
</style>
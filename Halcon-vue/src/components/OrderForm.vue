<template>
  <div class="order-form">
    <h2>{{ isEdit ? 'Edit Order' : 'Create New Order' }}</h2>
    
    <form @submit.prevent="submitForm">
      <!-- Customer Selection -->
      <div class="form-group">
        <label for="customer_id">Customer</label>
        <select 
          id="customer_id" 
          v-model="orderData.customer_id"
          class="form-select"
          required
        >
          <option value="" disabled>Select a customer</option>
          <option 
            v-for="customer in customers" 
            :key="customer.id" 
            :value="customer.id"
          >
            {{ customer.name }} ({{ customer.customer_number }})
          </option>
        </select>
      </div>
      
      <!-- Order Status -->
      <div class="form-group">
        <label for="status">Status</label>
        <select 
          id="status" 
          v-model="orderData.status"
          class="form-select"
          @change="updatePhotoSections"
          required
        >
          <option value="" disabled>Select a status</option>
          <option value="pending">Pending</option>
          <option value="processing">Processing</option>
          <option value="completed">Completed</option>
          <option value="cancelled">Cancelled</option>
        </select>
      </div>
      
      <!-- Products Selection -->
      <div class="products-section">
        <h3>Products</h3>
        <div class="add-product-form">
          <div class="form-row">
            <div class="form-group">
              <label for="product_select">Product</label>
              <select id="product_select" v-model="selectedProduct" class="form-select">
                <option value="" disabled>Select a product</option>
                <option 
                  v-for="product in availableProducts" 
                  :key="product.id" 
                  :value="product"
                >
                  {{ product.name }} - ${{ product.price }} (Stock: {{ product.stock }})
                </option>
              </select>
            </div>
            
            <div class="form-group">
              <label for="product_quantity">Quantity</label>
              <input 
                type="number" 
                id="product_quantity" 
                v-model.number="productQuantity" 
                min="1" 
                class="form-input"
                :max="selectedProduct ? selectedProduct.stock : 1"
              />
            </div>
            
            <button 
              type="button" 
              @click="addProduct" 
              class="add-product-btn"
              :disabled="!selectedProduct || !productQuantity"
            >
              Add Product
            </button>
          </div>
        </div>
        
        <!-- Added Products List -->
        <div v-if="orderProducts.length > 0" class="added-products">
          <h4>Added Products</h4>
          <table class="products-table">
            <thead>
              <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Subtotal</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(product, index) in orderProducts" :key="index">
                <td>{{ product.name }}</td>
                <td>{{ product.quantity }}</td>
                <td>${{ product.price }}</td>
                <td>${{ (product.quantity * product.price).toFixed(2) }}</td>
                <td>
                  <button 
                    type="button" 
                    @click="removeProduct(index)" 
                    class="remove-btn"
                  >
                    Remove
                  </button>
                </td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="3" class="total-label">Total:</td>
                <td colspan="2" class="total-amount">${{ calculateTotal() }}</td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
      
      <!-- Order Photos Section -->
      <div class="order-photos-section">
        <h3>Order Photos</h3>
        <p class="photos-info">Each order can have up to 2 photos: one during processing and one for delivery confirmation.</p>
        
        <!-- Processing Photo -->
        <div class="form-group">
          <label for="image_processing">Processing Photo</label>
          
          <div v-if="previewProcessingPhoto || (isEdit && orderData.image_path)" class="current-photo">
            <p>{{ isEdit ? 'Current processing photo:' : 'Selected photo:' }}</p>
            <img 
              :src="previewProcessingPhoto || (isEdit ? getImageUrl(orderData.image_path) : '')" 
              alt="Processing Photo" 
              class="photo-preview"
            />
          </div>
          
          <div v-if="showProcessingPhotoInput">
            <input 
              type="file" 
              id="image_processing" 
              @change="handleProcessingPhotoUpload" 
              accept="image/*"
              class="form-input"
            />
            <p class="help-text">Upload a photo of the order being processed.</p>
          </div>
          <div v-else class="disabled-upload">
            <p>Processing photo can only be added when order is in pending or processing status.</p>
          </div>
        </div>
        
        <!-- Delivery Photo -->
        <div class="form-group">
          <label for="image_delivered">Delivery Confirmation Photo</label>
          
          <div v-if="previewDeliveryPhoto || (isEdit && orderData.photo_delivered)" class="current-photo">
            <p>{{ isEdit ? 'Current delivery photo:' : 'Selected photo:' }}</p>
            <img 
              :src="previewDeliveryPhoto || (isEdit ? getImageUrl(orderData.photo_delivered) : '')" 
              alt="Delivery Photo" 
              class="photo-preview"
            />
          </div>
          
          <div v-if="showDeliveryPhotoInput">
            <input 
              type="file" 
              id="image_delivered" 
              @change="handleDeliveryPhotoUpload" 
              accept="image/*"
              class="form-input"
            />
            <p class="help-text">Upload a photo confirming delivery to the customer.</p>
          </div>
          <div v-else class="disabled-upload">
            <p>Delivery photo can only be added when order is in completed status.</p>
          </div>
        </div>
      </div>
      
      <!-- Notes -->
      <div class="form-group">
        <label for="notes">Notes</label>
        <textarea 
          id="notes" 
          v-model="orderData.notes" 
          rows="3" 
          class="form-textarea"
        ></textarea>
      </div>
      
      <!-- Form Actions -->
      <div class="form-actions">
        <button type="button" @click="$emit('cancel')" class="cancel-btn">Cancel</button>
        <button type="submit" class="submit-btn">{{ isEdit ? 'Update Order' : 'Create Order' }}</button>
      </div>
    </form>
  </div>
</template>

<script>
import apiService from '../services/api';

export default {
  name: 'OrderForm',
  props: {
    isEdit: {
      type: Boolean,
      default: false
    },
    orderToEdit: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      orderData: {
        customer_id: '',
        status: 'pending',
        notes: '',
        image_path: '',
        photo_delivered: ''
      },
      customers: [],
      products: [],
      orderProducts: [],
      selectedProduct: null,
      productQuantity: 1,
      processingPhoto: null,
      deliveryPhoto: null,
      previewProcessingPhoto: null,
      previewDeliveryPhoto: null,
      showProcessingPhotoInput: true,
      showDeliveryPhotoInput: false
    };
  },
  computed: {
    // Filter out products that have already been added
    availableProducts() {
      if (!this.products) return [];
      return this.products.filter(product => {
        return !this.orderProducts.some(p => p.id === product.id);
      });
    }
  },
  created() {
    this.fetchCustomers();
    this.fetchProducts();
    
    if (this.isEdit && this.orderToEdit) {
      this.populateFormData();
    }
    
    this.updatePhotoSections();
  },
  methods: {
    async fetchCustomers() {
      try {
        const response = await apiService.getCustomers();
        this.customers = response.data;
      } catch (error) {
        console.error('Error fetching customers:', error);
      }
    },
    async fetchProducts() {
      try {
        const response = await apiService.getProducts();
        this.products = response.data;
      } catch (error) {
        console.error('Error fetching products:', error);
      }
    },
    populateFormData() {
      // Copy basic order data
      this.orderData = {
        ...this.orderData,
        ...this.orderToEdit,
        customer_id: this.orderToEdit.customer_id || '',
        status: this.orderToEdit.status || 'pending',
        notes: this.orderToEdit.notes || ''
      };
      
      // Load products into orderProducts array
      if (this.orderToEdit.products && Array.isArray(this.orderToEdit.products)) {
        this.orderProducts = this.orderToEdit.products.map(product => ({
          id: product.id,
          name: product.name,
          quantity: product.pivot.quantity,
          price: product.pivot.price
        }));
      }
    },
    updatePhotoSections() {
      // Processing photo input shown only when status is 'pending' or 'processing'
      this.showProcessingPhotoInput = ['pending', 'processing'].includes(this.orderData.status);
      
      // Delivery photo input shown only when status is 'completed'
      this.showDeliveryPhotoInput = this.orderData.status === 'completed';
    },
    handleProcessingPhotoUpload(event) {
      const file = event.target.files[0];
      if (!file) return;
      
      // Store the file for form submission
      this.processingPhoto = file;
      
      // Create a preview
      this.previewProcessingPhoto = URL.createObjectURL(file);
    },
    handleDeliveryPhotoUpload(event) {
      const file = event.target.files[0];
      if (!file) return;
      
      // Store the file for form submission
      this.deliveryPhoto = file;
      
      // Create a preview
      this.previewDeliveryPhoto = URL.createObjectURL(file);
    },
    addProduct() {
      if (!this.selectedProduct || !this.productQuantity) return;
      
      this.orderProducts.push({
        id: this.selectedProduct.id,
        name: this.selectedProduct.name,
        quantity: this.productQuantity,
        price: this.selectedProduct.price
      });
      
      // Reset selection
      this.selectedProduct = null;
      this.productQuantity = 1;
    },
    removeProduct(index) {
      this.orderProducts.splice(index, 1);
    },
    calculateTotal() {
      return this.orderProducts
        .reduce((total, product) => total + (product.quantity * product.price), 0)
        .toFixed(2);
    },
    getImageUrl(path) {
      if (!path) return null;
      // If it's a mock path or testing URL, return a placeholder
      if (path.includes('mock')) {
        return 'https://placehold.co/600x400/e3f2fd/1976d2?text=Order+Photo';
      }
      // Otherwise return the actual image URL
      return `http://127.0.0.1:8000/storage/${path}`;
    },
    async submitForm() {
      try {
        // Prepare form data
        const formData = {
          ...this.orderData,
          total_amount: parseFloat(this.calculateTotal()),
          products: this.orderProducts.map(product => ({
            id: product.id,
            quantity: product.quantity
          }))
        };
        
        // Add photos if present
        if (this.processingPhoto) {
          formData.image_processing = this.processingPhoto;
        }
        
        if (this.deliveryPhoto) {
          formData.image_delivered = this.deliveryPhoto;
        }
        
        let response;
        if (this.isEdit) {
          response = await apiService.updateOrder(this.orderToEdit.id, formData);
        } else {
          response = await apiService.createOrder(formData);
        }
        
        this.$emit('success', response.data);
      } catch (error) {
        console.error('Error submitting form:', error);
        this.$emit('error', error.response?.data?.message || 'An error occurred while saving the order');
      }
    }
  }
};
</script>

<style scoped>
.order-form {
  max-width: 800px;
  margin: 0 auto;
  padding: 2rem;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

h2 {
  margin-bottom: 1.5rem;
  font-size: 1.5rem;
  font-weight: 600;
  color: #2c3e50;
}

.form-group {
  margin-bottom: 1.5rem;
}

label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: 500;
  color: #4b5563;
}

.form-select,
.form-input,
.form-textarea {
  width: 100%;
  padding: 0.5rem;
  border: 1px solid #d1d5db;
  border-radius: 0.375rem;
}

.form-row {
  display: flex;
  gap: 1rem;
  align-items: flex-end;
}

.add-product-btn,
.remove-btn,
.submit-btn,
.cancel-btn {
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 0.375rem;
  cursor: pointer;
}

.add-product-btn {
  background-color: #3b82f6;
  color: #fff;
}

.add-product-btn:disabled {
  background-color: #93c5fd;
  cursor: not-allowed;
}

.remove-btn {
  background-color: #ef4444;
  color: #fff;
}

.products-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 1rem;
}

.products-table th,
.products-table td {
  padding: 0.5rem;
  border-bottom: 1px solid #e5e7eb;
  text-align: left;
}

.total-label {
  text-align: right;
  font-weight: 600;
}

.total-amount {
  font-weight: 600;
}

.order-photos-section {
  margin-top: 2rem;
  margin-bottom: 2rem;
}

.photos-info {
  margin-bottom: 1rem;
  color: #6b7280;
}

.current-photo {
  margin-bottom: 1rem;
}

.photo-preview {
  max-width: 300px;
  max-height: 200px;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.help-text {
  margin-top: 0.5rem;
  font-size: 0.875rem;
  color: #6b7280;
}

.disabled-upload {
  padding: 0.75rem;
  background-color: #f3f4f6;
  border-radius: 0.375rem;
  font-style: italic;
  color: #6b7280;
}

.form-actions {
  display: flex;
  gap: 1rem;
  justify-content: flex-end;
  margin-top: 2rem;
}

.cancel-btn {
  background-color: #e5e7eb;
  color: #4b5563;
}

.submit-btn {
  background-color: #10b981;
  color: #fff;
}
</style>

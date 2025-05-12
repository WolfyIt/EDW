import axios from 'axios';

const API_URL = 'http://127.0.0.1:8000/api';

// Create an axios instance with default config
const apiClient = axios.create({
  baseURL: API_URL,
  headers: {
    'Accept': 'application/json'
  }
});

export default {
  // Get all customers
  getCustomers() {
    return apiClient.get('/customers');
  },
  
  // Get all products
  getProducts() {
    return apiClient.get('/products');
  },
  
  // Search orders
  searchOrder(params) {
    return apiClient.get('/orders/search', { params });
  },
  
  // Get order details
  getOrder(id) {
    return apiClient.get(`/orders/${id}`);
  },
  
  // Create a new order with photos
  createOrder(orderData) {
    // We need to use FormData for file uploads
    const formData = new FormData();
    
    // Add order data
    Object.keys(orderData).forEach(key => {
      if (key !== 'image_processing' && key !== 'image_delivered') {
        formData.append(key, orderData[key]);
      }
    });
    
    // Add products if present
    if (orderData.products && Array.isArray(orderData.products)) {
      orderData.products.forEach((product, index) => {
        Object.keys(product).forEach(key => {
          formData.append(`products[${index}][${key}]`, product[key]);
        });
      });
    }
    
    // Add photos if present
    if (orderData.image_processing) {
      formData.append('image_processing', orderData.image_processing);
    }
    
    if (orderData.image_delivered) {
      formData.append('image_delivered', orderData.image_delivered);
    }
    
    return apiClient.post('/orders', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      }
    });
  },
  
  // Update an order with photos
  updateOrder(id, orderData) {
    const formData = new FormData();
    
    // Add method for Laravel to handle PUT request
    formData.append('_method', 'PUT');
    
    // Add order data
    Object.keys(orderData).forEach(key => {
      if (key !== 'image_processing' && key !== 'image_delivered' && key !== 'products') {
        formData.append(key, orderData[key]);
      }
    });
    
    // Add products if present
    if (orderData.products && Array.isArray(orderData.products)) {
      orderData.products.forEach((product, index) => {
        Object.keys(product).forEach(key => {
          formData.append(`products[${index}][${key}]`, product[key]);
        });
      });
    }
    
    // Add photos if present
    if (orderData.image_processing) {
      formData.append('image_processing', orderData.image_processing);
    }
    
    if (orderData.image_delivered) {
      formData.append('image_delivered', orderData.image_delivered);
    }
    
    return apiClient.post(`/orders/${id}`, formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      }
    });
  }
};

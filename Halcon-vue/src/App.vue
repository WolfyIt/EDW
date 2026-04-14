<template>
  <div class="min-h-screen bg-white">
    <div class="container">
      <div class="search-header">
        <h1 class="search-title">Order Search</h1>
        <p class="search-subtitle">Enter your customer name and invoice number to track your order</p>
      </div>
      <OrderSearch />
    </div>
  </div>
</template>

<script>
import OrderSearch from './components/OrderSearch.vue'

export default {
  name: 'App',
  components: {
    OrderSearch
  }
}
</script>

<style>
@import './style.css';
</style>

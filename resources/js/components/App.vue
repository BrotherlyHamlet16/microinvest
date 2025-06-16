<template>
  <div>
    <NavBar />
    <div class="min-h-screen bg-gray-100 p-4">
      <router-view></router-view>
    </div>
  </div>
</template>

<script setup> 
  import NavBar from './NavBar.vue';
</script>

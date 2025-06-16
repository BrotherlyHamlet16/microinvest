<template>
  <nav class="bg-white shadow-md px-6 py-3 flex justify-between items-center">
    <div class="text-xl font-bold text-blue-700">💰 Micro-Invest</div>

    <div class="flex gap-4 items-center">
      <router-link to="/" class="nav-link" exact>Dashboard</router-link>
      <router-link to="/invest" class="nav-link">Invest</router-link>
      <button @click="logout" class="text-red-600 hover:underline text-sm">Logout</button>
    </div>
  </nav>
</template>

<script setup>
import { useRouter } from 'vue-router';

const router = useRouter();

const logout = () => {
  localStorage.removeItem('token');
  router.push('/login');
};
</script>

<style scoped>
.nav-link {
  color: #374151; /* text-gray-700 */
  font-size: 0.875rem; /* text-sm */
  transition: color 0.2s;
  text-decoration: none;
}

.nav-link:hover {
  color: #2563eb; /* text-blue-600 */
  text-decoration: underline;
}
</style>

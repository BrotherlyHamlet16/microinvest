<template>
  <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Login</h2>
    <form @submit.prevent="login">
      <input v-model="form.email" type="email" placeholder="Email" class="input" />
      <input v-model="form.password" type="password" placeholder="Password" class="input" />
      <button class="btn-primary mt-3">Login</button>
    </form>
    <p class="text-sm mt-2">No account? <router-link to="/register" class="text-blue-600">Register</router-link></p>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import api from '../../axios';

const router = useRouter();
const form = ref({
  email: '',
  password: ''
});

const login = async () => {
  try {
    const res = await api.post('/login', form.value);
    localStorage.setItem('token', res.data.token);
    router.push('/');
  } catch (e) {
    alert('Login failed');
  }
};
</script>

<style scoped>
.input {
  display: block;
  width: 100%;
  margin-bottom: 0.75rem;
  padding: 0.5rem;
  border: 1px solid #ccc;
  border-radius: 0.375rem;
}
.btn-primary {
  background-color: #2563eb;
  color: white;
  padding: 0.5rem 1.5rem;
  border-radius: 0.375rem;
}
</style>

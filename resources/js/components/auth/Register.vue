<template>
  <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Register</h2>
    <form @submit.prevent="register">
      <input v-model="form.name" type="text" placeholder="Name" class="input" />
      <input v-model="form.email" type="email" placeholder="Email" class="input" />
      <input v-model="form.password" type="password" placeholder="Password" class="input" />
      <input v-model="form.password_confirmation" type="password" placeholder="Confirm Password" class="input" />
      <button class="btn-primary mt-3">Register</button>
    </form>
    <p class="text-sm mt-2">Already have an account? <router-link to="/login" class="text-blue-600">Login</router-link></p>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import api from '../../axios';

const router = useRouter();
const form = ref({
  name: '',
  email: '',
  password: '',
  password_confirmation: ''
});

const register = async () => {
  try {
    const res = await api.post('/register', form.value);
    localStorage.setItem('token', res.data.token);
    router.push('/');
  } catch (e) {
    alert('Registration failed');
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

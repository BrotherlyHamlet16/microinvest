<template>
  <div class="max-w-lg mx-auto p-6 bg-white rounded-xl shadow">
    <h1 class="text-2xl font-bold mb-6 text-blue-700">🪙 Make an Investment</h1>

    <form @submit.prevent="submitInvestment">
      <label class="block mb-2 text-sm font-medium">Select Plan</label>
      <select v-model="form.plan_id" class="input mb-4">
        <option value="" disabled>Select a plan</option>
        <option v-for="plan in plans" :key="plan.id" :value="plan.id">
          {{ plan.name }} – {{ plan.return_rate }}% daily for {{ plan.lock_period }} days
        </option>
      </select>

      <label class="block mb-2 text-sm font-medium">Amount</label>
      <input type="number" v-model="form.amount" class="input mb-4" min="1" placeholder="Enter amount" required />

      <button class="btn-primary w-full">Invest</button>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import api from '../axios';
import { useRouter } from 'vue-router';

const router = useRouter();
const form = ref({ plan_id: '', amount: '' });
const plans = ref([]);

const fetchPlans = async () => {
  try {
    const token = localStorage.getItem('token');
    const res = await api.get('/plans', {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });
    plans.value = res.data.data;
  } catch (err) {
    alert('Failed to fetch plans');
  }
};

const submitInvestment = async () => {
  try {
    const token = localStorage.getItem('token');
    await api.post('/investments', form.value, {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });
    alert('Investment successful!');
    router.push('/');
  } catch (err) {
    alert('Investment failed');
  }
};

onMounted(fetchPlans);
</script>

<style scoped>
.input {
  display: block;
  width: 100%;
  padding: 0.5rem;
  border-radius: 0.375rem;
  border: 1px solid #ccc;
}
.btn-primary {
  background-color: #2563eb;
  color: white;
  padding: 0.5rem;
  border-radius: 0.375rem;
}
</style>

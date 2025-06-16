<template>
  <div class="max-w-7xl mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">📊 My Investments</h1>

    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
      <div
        v-for="investment in investments"
        :key="investment.id"
        class="bg-white p-6 rounded-xl shadow hover:shadow-md transition"
      >
        <h2 class="text-xl font-semibold text-blue-700">{{ investment.plan.name }}</h2>
        <p class="text-gray-600 mt-1">Invested: <strong>${{ investment.amount.toFixed(2) }}</strong></p>
        <p class="text-gray-600">Start: {{ formatDate(investment.start_date) }}</p>
        <p class="text-gray-600">Maturity: {{ formatDate(investment.maturity_date) }}</p>
        <p class="text-green-600 font-medium mt-2">Current Value: ${{ investment.current_value.toFixed(2) }}</p>

        <button
          v-if="investment.can_withdraw"
          class="mt-4 w-full bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700"
          @click="withdraw(investment.id)"
        >
          Withdraw
        </button>

        <div v-else class="mt-4 text-sm text-gray-400">Locked until maturity</div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import api from '../axios';
import { useRouter } from 'vue-router';

const investments = ref([]);
const router = useRouter();

const fetchInvestments = async () => {
  try {
    const token = localStorage.getItem('token');
    const res = await api.get('/investments', {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });
    investments.value = res.data.data;
  } catch (e) {
    alert('Session expired. Please log in again.');
    router.push('/login');
  }
};

const withdraw = async (id) => {
  if (!confirm('Are you sure you want to withdraw this investment?')) return;

  try {
    const token = localStorage.getItem('token');
    await api.post(`/investments/${id}/withdraw`, {}, {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });
    alert('Withdrawal successful!');
    fetchInvestments(); // Refresh
  } catch (e) {
    alert('Withdrawal failed. Please try again.');
  }
};

const formatDate = (dateStr) => new Date(dateStr).toLocaleDateString();

onMounted(fetchInvestments);
</script>

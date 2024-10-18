<template>
  <div class="p-6">
    <h2 class="text-2xl mb-4">Consulta de Estoque</h2>
    <form @submit.prevent="fetchStockData" class="space-y-4 mb-6">
      <input
        v-model="filters.user_id"
        type="number"
        placeholder="ID Usuário"
        class="block w-full p-2 border rounded-md shadow-sm focus:ring focus:border-blue-300"
      />
      <input
        v-model="filters.product_id"
        type="number"
        placeholder="ID Produto"
        class="block w-full p-2 border rounded-md shadow-sm focus:ring focus:border-blue-300"
      />
      <input
        v-model="filters.start_date"
        type="date"
        placeholder="Data de Início"
        class="block w-full p-2 border rounded-md shadow-sm focus:ring focus:border-blue-300"
      />
      <input
        v-model="filters.end_date"
        type="date"
        placeholder="Data de Término"
        class="block w-full p-2 border rounded-md shadow-sm focus:ring focus:border-blue-300"
      />
      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">
        Buscar
      </button>
    </form>

    <div v-if="loading" class="text-gray-600">Carregando dados do estoque...</div>
    <div v-else-if="error" class="text-red-600">Erro ao carregar dados: {{ error.message }}</div>

    <ul v-else class="space-y-2">
      <li v-for="item in stockData" :key="item && item.id" class="p-4 border rounded-md shadow-sm">
        <div><strong>ID:</strong> {{ item.id }}</div>
        <div><strong>Usuário ID:</strong> {{ item.user_id }}</div>
        <div><strong>Produto ID:</strong> {{ item.product_id }}</div>
        <div><strong>Data:</strong> {{ item.data }}</div>
        <div><strong>Quantidade:</strong> {{ item.quantity }}</div>
        <div><strong>Tipo:</strong> {{ item.type }}</div>
        <div><strong>Cancelado:</strong> {{ item.canceled ? 'Sim' : 'Não' }}</div>
      </li>
    </ul>
  </div>
</template>

<script>
import { ref } from 'vue';
import Swal from 'sweetalert2';
import { axiosInstance } from 'boot/axios';

export default {
  name: 'StockQuery',
  setup() {
    const filters = ref({
      user_id: '',
      product_id: '',
      start_date: '',
      end_date: ''
    });

    const stockData = ref([]);
    const error = ref(null);
    const loading = ref(false);

    const fetchStockData = async () => {
      loading.value = true;
      try {
        const response = await axiosInstance.post('/stock/filter', filters.value);
        console.log('data:', response.data.data);
        stockData.value = response.data.data;
        Swal.fire('Sucesso', 'Dados carregados com sucesso!', 'success');
      } catch (error) {
        console.error('Erro ao buscar stock:', error)
        Swal.fire('Erro', 'Resposta da API inválida ou dados não encontrados.', 'error');
        error.value = error;
      } finally {
        loading.value = false;
      }
    }

    return {
      filters,
      stockData,
      error,
      loading,
      fetchStockData,
    };
  },
};
</script>

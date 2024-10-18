<template>
  <div class="max-w-lg mx-auto mt-10 p-8 bg-white shadow-lg rounded-lg">
    <h2 class="text-3xl font-bold text-center mb-6 text-gray-800">Entrada de Estoque</h2>
    <form @submit.prevent="submitStockEntry" class="space-y-6">
      <div>
        <label for="product-id" class="block text-sm font-medium text-gray-700 mb-1">ID do Produto</label>
        <input
          id="product-id"
          v-model="newStock.product_id"
          type="text"
          placeholder="Digite o ID do Produto"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
        />
      </div>

      <div>
        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantidade</label>
        <input
          id="quantity"
          v-model="newStock.quantity"
          type="number"
          placeholder="Digite a Quantidade"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
        />
      </div>

      <div>
        <label for="type-id" class="block text-sm font-medium text-gray-700 mb-1">Type ID</label>
        <input
          id="type-id"
          v-model="newStock.type_id"
          type="text"
          placeholder="Digite o Type ID"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
        />
      </div>

      <div class="flex items-center">
        <input
          id="canceled"
          v-model="newStock.canceled"
          type="checkbox"
          class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
        />
        <label for="canceled" class="ml-2 block text-sm text-gray-700">Cancelado?</label>
      </div>

      <button
        type="submit"
        data-twe-ripple-init
        data-twe-ripple-color="light"
        class="inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-primary-3 transition duration-150 ease-in-out hover:bg-primary-accent-300 hover:shadow-primary-2 focus:bg-primary-accent-300 focus:shadow-primary-2 focus:outline-none focus:ring-0 active:bg-primary-600 active:shadow-primary-2 motion-reduce:transition-none dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-dark-strong"
      >
        Adicionar
      </button>
    </form>

    <div v-if="loading" class="mt-4 text-blue-600 text-center">Adicionando ao estoque...</div>
    <div v-if="error" class="mt-4 text-red-600 text-center">Erro ao adicionar: {{ error.message }}</div>
  </div>
</template>

<script>
import { ref } from 'vue';
import { useApi } from 'src/composables/useApi.js';
import Swal from 'sweetalert2';

export default {
  name: 'StockEntryForm',
  setup() {
    const newStock = ref({
      product_id: '',
      type_id: '',
      canceled: false,
      data: "2024-10-11",
      quantity: 0
    });

    const { response, error, loading } = useApi();

    const submitStockEntry = async () => {
      const result = await useApi('/stock', 'POST', newStock.value);
      if (result && !result.error) {
        Swal.fire({
          icon: 'success',
          title: 'Sucesso',
          text: 'Estoque adicionado com sucesso!',
          confirmButtonText: 'OK'
        });
      } else if (result && result.error) {
        Swal.fire({
          icon: 'error',
          title: 'Erro',
          text: 'Erro ao adicionar ao estoque: ' + result.error.message,
          confirmButtonText: 'Tentar novamente'
        });
      }
    };

    return {
      newStock,
      error,
      loading,
      submitStockEntry,
    };
  },
};
</script>

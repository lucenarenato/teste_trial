<template>
  <div class="max-w-lg mx-auto mt-10 p-8 bg-white shadow-lg rounded-lg">
    <h2 class="text-3xl font-bold text-center mb-6 text-gray-800">Cadastro de Produtos</h2>
    <form @submit.prevent="submitProductForm" class="space-y-6">
      <div>
        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Nome do Produto</label>
        <input
          id="title"
          v-model="productData.title"
          type="text"
          placeholder="Digite o nome do produto"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
        />
      </div>

      <div>
        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descrição</label>
        <input
          id="description"
          v-model="newStock.description"
          type="text"
          placeholder="Digite a descrição"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
        />
      </div>

      <div>
        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Preço</label>
        <input
          id="price"
          v-model="newStock.price"
          type="number"
          step="any"
          placeholder="Digite o preço"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
        />
      </div>

      <div>
        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Upload da Imagem</label>
        <input
          id="image"
          type="file"
          @change="handleFileUpload"
          class="w-full text-gray-700"
        />
      </div>

      <div>
        <label for="barcode" class="block text-sm font-medium text-gray-700 mb-1">Código de Barras</label>
        <input
          id="barcode"
          v-model="newStock.barcode"
          type="text"
          placeholder="Digite o código de barras"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
        />
      </div>

      <div>
        <label for="sku" class="block text-sm font-medium text-gray-700 mb-1">SKU</label>
        <input
          id="sku"
          v-model="newStock.SKU"
          type="text"
          placeholder="Digite o SKU"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
        />
      </div>

      <button
        type="submit"
        data-twe-ripple-init
        data-twe-ripple-color="light"
        class="inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-primary-3 transition duration-150 ease-in-out hover:bg-primary-accent-300 hover:shadow-primary-2 focus:bg-primary-accent-300 focus:shadow-primary-2 focus:outline-none focus:ring-0 active:bg-primary-600 active:shadow-primary-2 motion-reduce:transition-none dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-dark-strong"
      >
        Salvar
      </button>
    </form>

    <div v-if="loading" class="mt-4 text-blue-600 text-center">Salvando dados do produto...</div>
    <div v-if="error" class="mt-4 text-red-600 text-center">Erro ao salvar produto: {{ error.message }}</div>
  </div>
</template>

<script>
import { ref } from 'vue';
import { useApi } from 'src/composables/useApi.js';
import Swal from 'sweetalert2';

export default {
  name: 'ProductForm',
  setup() {
    const productData = ref({ title: '' });
    const newStock = ref({
      description: '',
      price: '',
      image: null,
      barcode: '',
      SKU: '',
    });
    const selectedImage = ref(null);
    const { response, error, loading } = useApi();

    const handleFileUpload = (event) => {
      selectedImage.value = event.target.files[0];
    };

    const submitProductForm = async () => {
      const formData = new FormData();
      formData.append('title', productData.value.title);
      formData.append('description', newStock.value.description);
      formData.append('price', newStock.value.price);
      formData.append('barcode', newStock.value.barcode);
      formData.append('SKU', newStock.value.SKU);

      if (selectedImage.value) {
        formData.append('image', selectedImage.value);
      }

      const result = await useApi('/products', 'POST', formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      });

      if (result && !result.error) {
        Swal.fire({
          title: 'Sucesso!',
          text: 'Produto salvo com sucesso!',
          icon: 'success',
          confirmButtonText: 'OK',
        });
      }
    };

    return {
      productData,
      newStock,
      selectedImage,
      error,
      loading,
      handleFileUpload,
      submitProductForm,
    };
  },
};
</script>

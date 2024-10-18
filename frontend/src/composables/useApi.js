import { axiosInstance } from 'boot/axios';
import { ref } from 'vue';

export const useApi = (url = '', method = 'GET', params = {}) => {
  const response = ref(null);
  const error = ref(null);
  const loading = ref(true);

  axiosInstance({
    url: url,
    method: method,
    data: params
  })
    .then((resp) => {
      response.value = {
        status: resp.status,
        data: resp.data
      };
    })
    .catch((err) => {
      /*error.value = {
        status: err.response?.status || 500,
        message: err.response?.data || 'Ocorreu um erro ao processar a solicitação.'
      };*/
      console.error('Erro na requisição:', error.value);
    })
    .finally(() => {
      loading.value = false;
    });

  return { response, loading };
};

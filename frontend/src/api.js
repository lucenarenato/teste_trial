import axios from 'axios';

const api = axios.create({
  baseURL: 'http://laravel.test/api', // URL da sua API Laravel
  headers: {
    'Content-Type': 'application/json',
  },
});

export default api;

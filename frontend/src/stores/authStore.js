import { defineStore } from 'pinia';
import api from '../api';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

export const useAuthStore = defineStore('auth', () => {
  const user = ref(null);
  const token = ref(null);
  const router = useRouter();

  const login = async (credentials) => {
    try {
      const response = await api.post('/auth/login', credentials);
      token.value = response.data.access_token;
      user.value = response.data.user;
      api.defaults.headers.common['Authorization'] = `Bearer ${token.value}`;
      router.push('/dashboard');
    } catch (error) {
      console.error('Erro no login:', error.response?.data || error.message);
    }
  };

  const register = async (userData) => {
    try {
      const response = await api.post('/auth/register', userData);
      token.value = response.data.access_token;
      user.value = response.data.user;
      api.defaults.headers.common['Authorization'] = `Bearer ${token.value}`;
      router.push('/dashboard');
    } catch (error) {
      console.error('Erro no registro:', error.response?.data || error.message);
    }
  };

  const logout = async () => {
    try {
      await api.post('/auth/logout');
      token.value = null;
      user.value = null;
      api.defaults.headers.common['Authorization'] = null;
      router.push('/login');
    } catch (error) {
      console.error('Erro no logout:', error.response?.data || error.message);
    }
  };

  return {
    user,
    token,
    login,
    register,
    logout,
  };
});

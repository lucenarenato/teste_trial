<template>
  <q-page class="flex flex-center">
    <q-card>
      <q-card-section>
        <div class="text-h6">Login</div>
      </q-card-section>

      <q-card-section>
        <q-input v-model="email" label="Email" type="email" />
        <q-input v-model="password" label="Senha" type="password" />
      </q-card-section>

      <q-card-actions align="right">
        <q-btn label="Entrar" color="primary" @click="handleLogin" />
      </q-card-actions>
    </q-card>
  </q-page>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useAuthStore } from '../stores/authStore';

const email = ref('');
const password = ref('');
const authStore = useAuthStore();

const handleLogin = async () => {
  try {
    await authStore.login({ email: email.value, password: password.value });
  } catch (error) {
    console.error('Erro ao fazer login:', error);
  }
};
</script>

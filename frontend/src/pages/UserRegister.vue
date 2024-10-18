<template>
  <q-page class="flex flex-center">
    <q-card>
      <q-card-section>
        <div class="text-h6">Registrar</div>
      </q-card-section>

      <q-card-section>
        <q-input v-model="name" label="Nome" />
        <q-input v-model="email" label="Email" type="email" />
        <q-input v-model="password" label="Senha" type="password" />
        <q-input
          v-model="password_confirmation"
          label="Confirme a Senha"
          type="password"
        />
      </q-card-section>

      <q-card-actions align="right">
        <q-btn label="Registrar" color="primary" @click="handleRegister" />
      </q-card-actions>
    </q-card>
  </q-page>
</template>

<script setup>
import { ref } from 'vue';
import { useAuthStore } from '../stores/authStore';

const name = ref('');
const email = ref('');
const password = ref('');
const password_confirmation = ref('');
const authStore = useAuthStore();

const handleRegister = () => {
  authStore.register({
    name: name.value,
    email: email.value,
    password: password.value,
    password_confirmation: password_confirmation.value,
  });
};
</script>

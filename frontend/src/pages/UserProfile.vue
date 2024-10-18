<template lang="pug">
q-page(class="q-pa-md")
    q-card
      q-card-section
        div(class="text-h6") User Profile
      q-card-section
        q-list
          q-item-label(v-for="(value, key) in userProfile" :key="key") {{ key }}: {{ value }}
</template>

  <script>
  import { computed } from 'vue';
  import { authStore } from 'src/stores/auth';

  export default {
    setup() {
      const auth = authStore();
      const userProfile = computed(() => auth.userProfile);

      return { userProfile };
    }
  }
  </script>

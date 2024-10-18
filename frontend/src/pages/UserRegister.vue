<template lang="pug">
q-page(class="flex flex-center")
    -card
      q-card-section
        q-avatar(size="80px" class="absolute-center shadow-10" icon="person_add" color="primary" v-if="!registrationError")
        q-avatar(size="80px" class="absolute-center shadow-10" icon="error" color="negative" v-if="registrationError")
      q-card-section
        div(class="text-center q-pt-md")
          div(class="col text-h6 ellipsis" v-if="!registrationError") Register
          div(class="col text-h6 ellipsis" v-if="registrationError") Registration Error
      q-card-section
        q-form(class="q-gutter-md" @submit="onSubmit")
          q-input(lazy-rules v-model="form.name" label="Name")
          q-input(lazy-rules v-model="form.email" label="Email")
          q-input(lazy-rules v-model="form.password" type="password" label="Password")
          q-card-actions(class="q-pa-none")
            q-btn(unelevated color="primary" size="lg" class="full-width" label="Register" type="submit")
</template>

  <script>
  import { reactive, ref } from 'vue'
  import { useRouter } from 'vue-router'
  import { authStore } from 'src/stores/auth'

  export default {
    setup() {
      const auth = authStore()
      const router = useRouter()
      const registrationError = ref(false)
      const form = reactive({ name: '', email: '', password: '' })

      async function onSubmit() {
        try {
          const response = await auth.register(form)
          if (response.status === 201) {
            router.push('/login')
          }
        } catch (error) {
          console.error(error)
          registrationError.value = true
        }
      }

      return { form, onSubmit, registrationError }
    }
  }
  </script>

  <style>
  .q-card {
    width: 360px;
  }
  </style>

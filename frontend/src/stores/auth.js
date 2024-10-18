import { defineStore } from 'pinia'
import { axiosInstance } from 'boot/axios'

export const authStore = defineStore('auth', {
  state: () => ({
    status: 'success',
    access_token: '',
    userProfile: null
  }),
  getters: {
    isLoggedIn: (state) => !!state.access_token,
  },
  actions: {
    async register(userData) {
      try {
        const response = await axiosInstance.post('/auth/register', userData)
        return response
      } catch (error) {
        throw error
      }
    },
    logout() {
      delete axiosInstance.defaults.headers.common['Authorization']
      localStorage.removeItem('access_token')
      this.$patch({ status: 'success', access_token: '' })
    },
    login(user) {
      return new Promise((resolve, reject) => {
        this.$patch({ status: 'loading' })
        axiosInstance({
          url: '/auth/login',
          data: user,
          method: 'POST'
        })
          .then(resp => {
            const access_token = resp.data.data.access_token
            // Armazena o token no localStorage e configura nos headers
            localStorage.setItem('access_token', access_token)
            axiosInstance.defaults.headers.common.Authorization = `Bearer ${access_token}`
            console.log('Token configurado:', axiosInstance.defaults.headers.common.Authorization)
            this.$patch({ status: 'success', access_token: access_token })
            resolve(resp)
          })
          .catch(err => {
            this.$patch({ status: 'error', access_token: '' })
            localStorage.removeItem('access_token')
            delete axiosInstance.defaults.headers.common['Authorization']
            console.error('Erro no login:', err)
            reject(err)
          })
      })
    },
    async fetchProfile() {
      try {
        const response = await axiosInstance.get('/auth/me')
        console.log('Profile data:', response.data.data)
        this.userProfile = response.data.data
        return response.data
      } catch (error) {
        console.error('Erro ao buscar o perfil:', error)
        throw error
      }
    }
  }
})

import { boot } from 'quasar/wrappers'
import axios from 'axios'

const api = axios.create({ baseURL: process.env.API_HOST })
const axiosInstance = axios.create({ baseURL: process.env.API_HOST })

axiosInstance.interceptors.request.use(async (config) => {
  const token = localStorage.getItem('access_token')
  console.log('Token carregado do localStorage:', token)
  if (token) {
    // Definindo o header Authorization com o formato correto
    config.headers.Authorization = `Bearer ${token}`
    console.log('Header de autorização configurado:', config.headers.Authorization)
  } else if (!window.location.href.endsWith('login')) {
    // Redireciona para a página de login se não houver token
    document.location.href = '/#/login'
    return Promise.reject()
  }
  return config
}, error => {
  return Promise.reject(error)
})

export default boot(({ app }) => {
  app.config.globalProperties.$axios = axios
  app.config.globalProperties.$api = axiosInstance
})

export { axios, axiosInstance }

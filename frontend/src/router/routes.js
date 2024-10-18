
const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '', meta: {auth: true} , component: () => import('pages/IndexPage.vue') },
      { path: '/login', component: () => import('pages/LoginPage.vue') },
      { path: '/register', component: () => import('pages/UserRegister.vue') },
      { path: '/profile', meta: { auth: true }, component: () => import('pages/UserProfile.vue') },
      { path: '/logout', component: () => import('pages/LogoutPage.vue') },
      { path: '/stock-query', meta: { auth: true }, component: () => import('pages/StockQuery.vue') },
      { path: '/stock-entry', meta: { auth: true }, component: () => import('pages/StockEntryForm.vue') },
      { path: '/product-form', meta: { auth: true }, component: () => import('pages/ProductForm.vue') },
      { path: '/dashboard', meta: { auth: true }, component: () => import('src/components/StockDashboard.vue') }

    ]
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue')
  }
]

export default routes

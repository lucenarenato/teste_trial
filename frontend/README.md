## Base template for vue + quasar project (with pinia and pug)

#### Include auth login page that accepts user credentials and sends a request to a server to authenticate the user, if user is OK, server return a token and stored in local storage. All other requests to the server will contain Authorization header with token.

`docker-compose -f ./docker-compose.dev.yml up --build --force-recreate --no-dep`

```
src/
├── components/
│   ├── ChartComponent.vue
│   ├── EntradaSaidaEstoqueUsuario.vue
│   ├── EntradaSaidaEstoqueProduto.vue
│   ├── TopProdutosMaisEstoque.vue
│   └── TopProdutosMenosEstoque.vue
```

- https://stackoverflow.com/questions/70034269/how-to-use-tailwind-css-with-quasar-framework

### Enjoy :)

# vue-project

This template should help get you started developing with Vue 3 in Vite.

## Customize configuration

See [Vite Configuration Reference](https://vitejs.dev/config/).

## Project Setup

```sh
npm install
```

### Compile and Hot-Reload for Development

```sh
npm run dev
```

### Type-Check, Compile and Minify for Production

```sh
npm run build
```

## Dockerrização
- https://v2.vuejs.org/v2/cookbook/dockerize-vuejs-app.html

```
docker build -t vuejs-app .
docker run -it -p 8080:8080 --rm --name vuejs-app vuejs-app
```
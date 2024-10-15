# vue-project
# Vue JS 3 + Typescript + Quasar 2 SSR mode + Docker

This template should help get you started developing with Vue 3 in Vite.



## Install the dependencies

```bash
yarn
# or
npm install
```
Config your Project at `my-app`/quasar.config.js


### Start the app in development mode (hot-code reloading, error reporting, etc.)

```bash
npm run dev or
yarn dev or
quasar dev
```
Starting webserver at port 8000
### Start the app in development SSR mode (hot-code reloading, error reporting, etc.)

```bash
npm run dev:ssr or
yarn dev:ssr or
quasar dev -m ssr


### Build the app for production

```bash
npm run build or
yarn build or
quasar build
```

### Build the SSR app for production

```bash
npm run build:ssr or
yarn build:ssr or
quasar build -m ssr
```

Docker run

```batch
docker-compose build
docker-compose up -d
```

### Customize the configuration

See [Configuring quasar.config.js](https://v2.quasar.dev/quasar-cli-vite/quasar-config-js)..gitignore

The frontend uses Vuejs and Quasar framework.

It has to be used with the backend.

# Installation for developpment environnment

*Source code can be modified live and application will automatically hot reload in browser.*

Build and run Docker container
```
docker-compose -f ./docker-compose.dev.yml up -d --build
```

Display container logs
```
docker-compose logs -f
```

Stop/Start container
```
docker-compose stop
docker-compose start
```

Application is accessible through https://localhost:8081

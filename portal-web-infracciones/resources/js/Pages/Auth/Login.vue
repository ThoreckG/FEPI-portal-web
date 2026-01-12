<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const logoError = ref(false);
// map.png is inside public/build/images — use that path and add a small cache-bust query
const logoSrc = '/build/images/map.png?v=2';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
  <Head title="Login" />

  <div class="min-h-screen bg-gray-900 flex items-center">
    <div class="w-full max-w-md mx-auto px-4">
      <div class="bg-transparent border border-gray-700 rounded-xl text-white p-8">

        <div class="text-center mb-6">
          <img v-if="!logoError" :src="logoSrc" @error="logoError = true" alt="logo" class="mx-auto mb-4 w-40 h-40 object-contain" />

          <svg v-else xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 w-12 h-12 text-red-500" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
            <path d="M8 0a5 5 0 0 0-5 5c0 3.25 5 11 5 11s5-7.75 5-11a5 5 0 0 0-5-5zM8 7.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5z" />
          </svg>

          <h1 class="text-2xl font-bold mt-2">Bienvenido</h1>
          <p class="text-gray-400">Inicia sesión para continuar</p>
        </div>

        <form @submit.prevent="submit" class="space-y-4">

          <div>
            <label for="email" class="sr-only">Usuario</label>
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 bg-gray-800 border border-gray-700 rounded-full flex items-center justify-center text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path d="M10 2a4 4 0 100 8 4 4 0 000-8zM2 18a8 8 0 1116 0H2z" />
                </svg>
              </div>
              <input
                id="email"
                v-model="form.email"
                type="email"
                class="flex-1 rounded-full bg-gray-800 border border-gray-700 text-white py-3 px-4 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500"
                placeholder="Usuario"
                required
                autofocus
                autocomplete="username"
              />
            </div>
            <div class="mt-1 text-red-500 text-sm" v-if="form.errors.email">{{ form.errors.email }}</div>
          </div>

          <div>
            <label for="password" class="sr-only">Contraseña</label>
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 bg-gray-800 border border-gray-700 rounded-full flex items-center justify-center text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M5 8a3 3 0 016 0v1h1a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4a2 2 0 012-2h1V8zm3-3a1 1 0 00-1 1v1h2V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
              </div>
              <input
                id="password"
                v-model="form.password"
                type="password"
                class="flex-1 rounded-full bg-gray-800 border border-gray-700 text-white py-3 px-4 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500"
                placeholder="Contraseña"
                required
                autocomplete="current-password"
              />
            </div>
            <div class="mt-1 text-red-500 text-sm" v-if="form.errors.password">{{ form.errors.password }}</div>
          </div>

          <div class="flex items-center">
            <input id="remember" type="checkbox" v-model="form.remember" class="h-4 w-4 text-red-600 bg-gray-800 border-gray-600 rounded focus:ring-red-500" />
            <label for="remember" class="ml-3 text-white">Recordarme</label>
          </div>

          <button type="submit" class="w-full py-3 rounded-full bg-red-600 hover:bg-red-700 font-medium text-white">Ingresar</button>

          <div class="text-center mt-4">
            <a :href="route('register')" class="text-white underline">Regístrate</a>
          </div>

          <div v-if="status" class="mt-3 rounded-md bg-green-900 border border-green-700 text-green-100 p-3 text-sm">{{ status }}</div>

          <div class="mt-5 text-center">
            <span class="inline-flex items-center gap-2 bg-gray-800 text-gray-300 px-3 py-1 rounded-full text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M13 7a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2 15s1-4 6-4 6 4 6 4H2z"/></svg>Conexión exitosa a Railway</span>
          </div>

        </form>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Small, scoped adjustments (most styling handled by Tailwind) */
</style>
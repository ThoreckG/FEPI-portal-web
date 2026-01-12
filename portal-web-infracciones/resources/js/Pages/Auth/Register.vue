<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const logoError = ref(false);
const logoSrc = '/build/images/map.png?v=2';

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  terms: false,
});

const submit = () => {
  form.post(route('register'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};
</script>

<template>
  <Head title="Crear cuenta" />

  <div class="min-h-screen bg-gray-900 flex items-center">
    <div class="w-full max-w-md mx-auto px-4">
      <div class="bg-transparent border border-gray-700 rounded-xl text-white p-8">

        <div class="text-center mb-6">
          <img v-if="!logoError" :src="logoSrc" @error="logoError = true" alt="logo" class="mx-auto mb-4 w-40 h-40 object-contain" />

          <svg v-else xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 w-12 h-12 text-red-500" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
            <path d="M8 0a5 5 0 0 0-5 5c0 3.25 5 11 5 11s5-7.75 5-11a5 5 0 0 0-5-5zM8 7.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5z" />
          </svg>

          <h1 class="text-2xl font-bold mt-2">Crear cuenta</h1>
          <p class="text-gray-400">Regístrate para poder consultar y entender tus multas.</p>
        </div>

        <form @submit.prevent="submit" class="space-y-4">

          <div>
            <label for="name" class="sr-only">Nombre</label>
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 bg-gray-800 border border-gray-700 rounded-full flex items-center justify-center text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M10 2a4 4 0 100 8 4 4 0 000-8zM2 18a8 8 0 1116 0H2z"/></svg>
              </div>
              <input id="name" v-model="form.name" type="text" class="flex-1 rounded-full bg-gray-800 border border-gray-700 text-white py-3 px-4 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Nombre completo" required autocomplete="name" />
            </div>
            <div class="mt-1 text-red-500 text-sm" v-if="form.errors.name">{{ form.errors.name }}</div>
          </div>

          <div>
            <label for="email" class="sr-only">Email</label>
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 bg-gray-800 border border-gray-700 rounded-full flex items-center justify-center text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M2.94 6.44a3 3 0 114.12-4.12L10 4.88l2.94-2.56a3 3 0 114.12 4.12L14.12 10l2.94 2.94a3 3 0 11-4.12 4.12L10 15.12l-2.94 2.94a3 3 0 11-4.12-4.12L5.88 10 2.94 6.44z"/></svg>
              </div>
              <input id="email" v-model="form.email" type="email" class="flex-1 rounded-full bg-gray-800 border border-gray-700 text-white py-3 px-4 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Correo electrónico" required autocomplete="username" />
            </div>
            <div class="mt-1 text-red-500 text-sm" v-if="form.errors.email">{{ form.errors.email }}</div>
          </div>

          <div>
            <label for="password" class="sr-only">Contraseña</label>
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 bg-gray-800 border border-gray-700 rounded-full flex items-center justify-center text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5 8a3 3 0 016 0v1h1a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4a2 2 0 012-2h1V8zm3-3a1 1 0 00-1 1v1h2V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
              </div>
              <input id="password" v-model="form.password" type="password" class="flex-1 rounded-full bg-gray-800 border border-gray-700 text-white py-3 px-4 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Contraseña" required autocomplete="new-password" />
            </div>
            <div class="mt-1 text-red-500 text-sm" v-if="form.errors.password">{{ form.errors.password }}</div>
          </div>

          <div>
            <label for="password_confirmation" class="sr-only">Confirmar contraseña</label>
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 bg-gray-800 border border-gray-700 rounded-full flex items-center justify-center text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M2 11a1 1 0 011-1h2v2H3v6h10v-4h2a1 1 0 001-1V6a1 1 0 00-1-1h-1.586A1 1 0 0014 4.586L12.414 3H8a1 1 0 00-1 1v2H3a1 1 0 00-1 1v5z"/></svg>
              </div>
              <input id="password_confirmation" v-model="form.password_confirmation" type="password" class="flex-1 rounded-full bg-gray-800 border border-gray-700 text-white py-3 px-4 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Confirmar contraseña" required autocomplete="new-password" />
            </div>
            <div class="mt-1 text-red-500 text-sm" v-if="form.errors.password_confirmation">{{ form.errors.password_confirmation }}</div>
          </div>

          <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="flex items-start gap-3">
            <input id="terms" type="checkbox" v-model="form.terms" class="h-4 w-4 text-red-600 bg-gray-800 border-gray-600 rounded focus:ring-red-500" />
            <label for="terms" class="text-sm text-white">Acepto los <a target="_blank" :href="route('terms.show')" class="underline">Términos</a> y la <a target="_blank" :href="route('policy.show')" class="underline">Política de privacidad</a>.</label>
          </div>

          <button type="submit" class="w-full py-3 rounded-full bg-red-600 hover:bg-red-700 font-medium text-white">Registrarse</button>

          <div class="text-center mt-4">
            <Link :href="route('login')" class="text-white underline">¿Ya tienes cuenta?</Link>
          </div>

        </form>
      </div>
    </div>
  </div>
</template>
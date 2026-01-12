<script setup>
// Importamos herramientas de Inertia para manejar formularios
import { useForm, Link } from '@inertiajs/vue3';

// Definimos el formulario reactivo
const form = useForm({
    placa: '', // Campo inicial vacío
});

// Función que se ejecuta al dar click en "Buscar"
const submit = () => {
    // CAMBIO AQUÍ: Usamos .get en lugar de .post
    form.get(route('infracciones.buscar'), {
        preserveState: true, // Mantiene el estado de la página
        onFinish: () => form.reset('placa'),
    });
};
</script>

<template>
  <div class="min-h-screen bg-gray-900 flex items-center">
    <div class="w-full max-w-md mx-auto px-4">
      <div class="bg-transparent border border-gray-700 rounded-xl text-white p-8">

        <div class="text-center mb-6">
          <h1 class="text-2xl font-bold">Consulta de Infracciones CDMX</h1>
          <p class="text-gray-400 text-sm mt-2">Ingresa la placa del vehículo para ver las infracciones registradas.</p>
        </div>

        <form @submit.prevent="submit" class="space-y-4">
          <div>
            <label for="placa" class="sr-only">Placa</label>
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 bg-gray-800 border border-gray-700 rounded-full flex items-center justify-center text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M3 6.5A2.5 2.5 0 015.5 4h13A2.5 2.5 0 0121 6.5v11A2.5 2.5 0 0118.5 20h-13A2.5 2.5 0 013 17.5v-11zM5.5 6A.5.5 0 005 6.5v11c0 .276.224.5.5.5h13c.276 0 .5-.224.5-.5v-11A.5.5 0 0018.5 6h-13z"/></svg>
              </div>

              <input
                id="placa"
                v-model="form.placa"
                type="text"
                class="flex-1 rounded-full bg-gray-800 border border-gray-700 text-white py-3 px-4 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500"
                placeholder="Ej: 123-ABC"
                required
                autofocus
              />
            </div>
            <div class="mt-1 text-red-500 text-sm" v-if="form.errors.placa">{{ form.errors.placa }}</div>
          </div>

          <button type="submit" :disabled="form.processing" class="w-full py-3 rounded-full bg-red-600 hover:bg-red-700 font-medium text-white">
            <span v-if="form.processing">Buscando...</span>
            <span v-else>Consultar</span>
          </button>

          <div class="text-center mt-4">
            <Link :href="route('dashboard')" class="text-gray-400 underline">Volver al panel</Link>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

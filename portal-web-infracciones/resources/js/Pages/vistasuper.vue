<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { reactive, computed } from 'vue';
import ThemeToggle from '../Components/ThemeToggle.vue';

// Form state for filters
const form = useForm({
  fecha_desde: '',
  fecha_hasta: '',
  agente: '',
  estatus: '',
});

// Results placeholder (will be populated by the controller/props after applying filters)
const results = reactive({ items: [] });

const totals = computed(() => ({
  total: results.items.length,
  validadas: results.items.filter(i => (i.estatus || '').toLowerCase() === 'validada').length,
  pendientes: results.items.filter(i => (i.estatus || '').toLowerCase() === 'pendiente').length,
}));

const limpiar = () => {
  form.reset();
  results.items = [];
};

const aplicarFiltros = () => {
  // Real implementation: lanzar una petición Inertia al backend que devuelva resultados.
  // Por ahora usamos Inertia.get a una ruta que podrás preparar en el backend: 'supervisor.index'.
  form.get(route('supervisor.index'), {
    preserveState: true,
    onSuccess: (page) => {
      // Si el backend retorna `props.infracciones`, Inertia las expone en la página
      // Intentamos leerlas para llenar la tabla sin recargar manualmente
      if (page.props && page.props.infracciones) {
        results.items = page.props.infracciones;
      }
    }
  });
};

const exportarReporte = () => {
  // Abrimos el endpoint de exportación en nueva ventana con los parámetros del filtro
  const q = new URLSearchParams({
    fecha_desde: form.fecha_desde || '',
    fecha_hasta: form.fecha_hasta || '',
    agente: form.agente || '',
    estatus: form.estatus || '',
  }).toString();

  window.open(`/supervisor/export?${q}`, '_blank');
};
</script>

<template>
  <Head title="Panel de Supervisor" />

  <div class="min-h-screen bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <div class="max-w-3xl mx-auto py-12 px-6">

      <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-center w-full">Panel de Supervisor</h1>
        <div class="ml-4">
          <ThemeToggle />
        </div>
      </div>

      <!-- Filtros -->
      <div class="bg-white dark:bg-gray-800 rounded-lg px-6 py-8 ring shadow-xl ring-gray-900/5 mb-8">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Filtros de búsqueda</h2>

        <div class="grid grid-cols-1 gap-4">
          <input v-model="form.fecha_desde" type="date" class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-700 rounded p-4 text-gray-900 dark:text-gray-100" placeholder="Fecha desde" />
          <input v-model="form.fecha_hasta" type="date" class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-700 rounded p-4 text-gray-900 dark:text-gray-100" placeholder="Fecha hasta" />
          <input v-model="form.agente" type="text" class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-700 rounded p-4 text-gray-900 dark:text-gray-100" placeholder="ID / nombre del agente" />

          <div>
            <label class="block text-sm text-gray-600 dark:text-gray-300 mb-2">Estatus de infracción:</label>
            <select v-model="form.estatus" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-700 rounded p-3 text-gray-900 dark:text-gray-100">
              <option value="">-- Todos --</option>
              <option value="pendiente">Pendiente</option>
              <option value="validada">Validada</option>
              <option value="pagada">Pagada</option>
              <option value="en_aclaracion">En aclaración</option>
            </select>
          </div>

          <div class="flex items-center gap-4 mt-2">
            <button @click.prevent="limpiar" class="px-6 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-700 rounded text-gray-900 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-600">Limpiar</button>
            <button @click.prevent="aplicarFiltros" :disabled="form.processing" class="ml-auto px-6 py-3 bg-red-600 hover:bg-red-700 rounded text-white">Aplicar filtros</button>
          </div>
        </div>
      </div>

      <!-- Resumen -->
      <div class="mb-8">
        <h3 class="text-lg font-semibold text-red-400 mb-3">Resumen</h3>
        <div class="grid grid-cols-3 gap-4 text-center text-sm">
          <div class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded p-6">
            <div class="text-xs text-gray-600 dark:text-gray-300">Total</div>
            <div class="text-xl font-bold mt-1 text-gray-900 dark:text-gray-100">{{ totals.total }}</div>
          </div>
          <div class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded p-6">
            <div class="text-xs text-gray-600 dark:text-gray-300">Validadas</div>
            <div class="text-xl font-bold mt-1 text-gray-900 dark:text-gray-100">{{ totals.validadas }}</div>
          </div>
          <div class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded p-6">
            <div class="text-xs text-gray-600 dark:text-gray-300">Pendientes</div>
            <div class="text-xl font-bold mt-1 text-gray-900 dark:text-gray-100">{{ totals.pendientes }}</div>
          </div>
        </div>
      </div>

      <!-- Resultados -->
      <div class="mb-8">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Infracciones encontradas</h3>

        <div v-if="results.items.length === 0" class="text-gray-500 italic p-8 bg-white dark:bg-gray-800 rounded">No se encontraron infracciones con los filtros actuales.</div>

        <div v-else class="space-y-4">
          <div v-for="item in results.items" :key="item.id" class="bg-white dark:bg-gray-800 rounded-lg px-6 py-8 ring ring-gray-900/5 border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-lg transition">

            <div class="flex justify-between items-start gap-4">
              <div>
                <div class="text-sm text-gray-500 dark:text-gray-300">Folio</div>
                <div class="font-medium text-gray-900 dark:text-gray-100">{{ item.folio || 'S/N' }}</div>
              </div>

              <div class="text-right">
                <div class="text-sm text-gray-500 dark:text-gray-300">Fecha</div>
                <div class="font-medium text-gray-900 dark:text-gray-100">{{ item.fecha_infraccion ? new Date(item.fecha_infraccion).toLocaleDateString() : '-' }}</div>
              </div>

              <div class="text-center">
                <div class="text-sm text-gray-500 dark:text-gray-300">Estatus</div>
                <div class="mt-1 inline-block px-3 py-1 rounded-full text-xs font-semibold" :class="{
                  'bg-red-600 text-white': (item.estatus || '').toLowerCase() === 'pendiente',
                  'bg-green-600 text-white': (item.estatus || '').toLowerCase() === 'pagada',
                  'bg-yellow-600 text-white': (item.estatus || '').toLowerCase() === 'validada'
                }">{{ item.estatus || 'Desconocido' }}</div>
              </div>
            </div>

            <div class="mt-3 text-sm text-gray-700 dark:text-gray-300">{{ item.ubicacion_infraccion || 'Ubicación no disponible' }}</div>
          </div>
        </div>

      </div>

      <div class="flex justify-end">
        <button @click.prevent="exportarReporte" class="bg-red-600 hover:bg-red-700 px-6 py-3 rounded-full">Exportar reporte</button>
      </div>

    </div>
  </div>
</template>

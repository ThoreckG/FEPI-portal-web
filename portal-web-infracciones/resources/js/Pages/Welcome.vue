<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ThemeToggle from '../Components/ThemeToggle.vue';

const tiposInfracciones = [
  { icon: '/build/images/velocidad.png', titulo: 'Exceso de velocidad', descripcion: 'Registro por exceso de velocidad en tramos controlados.' },
  { icon: '/build/images/Alto.png', titulo: 'No respetar alto o semáforo', descripcion: 'Intersecciones y señalización ignoradas.' },
  { icon: '/build/images/camara.png', titulo: 'Multas captadas por cámara', descripcion: 'Fotografías y registros automáticos por cámaras.' },
  { icon: '/build/images/grua.png', titulo: 'Remisión al corralón / arrastre', descripcion: 'Vehículos remolcados por infracciones de estacionamiento o abandono.' },
  { icon: '/build/images/seguridad.png', titulo: 'Falta de medidas de seguridad', descripcion: 'Cinturón, casco u otras medidas de seguridad no cumplidas.' },
  { icon: '/build/images/multa.png', titulo: 'Otras sanciones económicas', descripcion: 'Sanciones diversas registradas por autoridades.' },
];

const infoItems = [
  { icon: '/build/images/informacion.png', title: 'Datos claros de conductor y vehículo', desc: 'Nombre, placa y documentos relacionados.' },
  { icon: '/build/images/map.png', title: 'Lugar exacto en el mapa', desc: 'Coordenadas y referencia del lugar de la infracción.' },
  { icon: '/build/images/multa.png', title: 'Monto y conceptos de la multa', desc: 'Detalle del importe y cómo se desglosa.' },
  { icon: '/build/images/datos.png', title: 'Historial y estadísticas', desc: 'Reportes y tendencias de infracciones.' },
  { icon: '/build/images/seguridad.png', title: 'Estado de la multa', desc: 'Pagada, pendiente o en aclaración.' },
];

const scrollTo = (id) => {
  const el = document.getElementById(id);
  if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
};
</script>

<template>
  <Head title="Inicio - Infracciones MX" />

  <!-- Header / Navbar -->
  <header class="sticky top-0 bg-white dark:bg-gray-900 shadow-sm z-30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
      <div class="flex items-center justify-between h-16">
        <!-- Left: Logo -->
        <div class="flex-shrink-0">
          <a href="#inicio" class="text-xl font-bold text-gray-800 dark:text-white">Infracciones MX</a>
        </div>

        <!-- Center: Nav links -->
        <nav class="hidden md:flex space-x-8">
          <a href="#inicio" @click.prevent="scrollTo('inicio')" class="text-gray-700 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white">Inicio</a>
          <a href="#sobre" @click.prevent="scrollTo('sobre')" class="text-gray-700 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white">Sobre el sistema</a>
          <a href="#tipos" @click.prevent="scrollTo('tipos')" class="text-gray-700 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white">Tipos de infracciones</a>
          <a href="#beneficios" @click.prevent="scrollTo('beneficios')" class="text-gray-700 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white">Beneficios</a>
        </nav>

        <!-- Right: Public quick entry -->
        <div class="flex items-center space-x-4">
          <Link :href="route('infracciones.index')" class="text-gray-700 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white">Ingresar placa</Link>
          <Link :href="route('login')" class="inline-block bg-gray-900 text-white px-3 py-1 rounded-lg text-sm hover:bg-gray-800 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100">Iniciar sesión</Link>
          <ThemeToggle />
        </div>
      </div>
    </div>
  </header>

  <!-- Hero -->
  <section id="inicio" class="bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
    <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
        <!-- Left column -->
        <div>
          <h1 class="text-3xl sm:text-4xl font-extrabold leading-tight">Entiende y consulta tus multas de tránsito en un solo lugar</h1>
          <p class="mt-4 text-gray-700 dark:text-gray-300 max-w-xl">Nuestro sistema te permite ver el detalle de la multa, lugar exacto, evidencia visual, el monto y el estado para que puedas tomar decisiones con claridad.</p>

          <div class="mt-6 flex flex-wrap gap-3">
            <Link :href="route('infracciones.index')" class="inline-block bg-red-500 hover:bg-red-600 text-white rounded-full px-6 py-2 font-medium">Consultar infracciones</Link>
            <button @click.prevent="scrollTo('pagos')" class="bg-white dark:bg-gray-800 dark:text-gray-100 text-gray-900 rounded-full px-6 py-2 font-medium hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">Checar pagos</button>
            <button @click.prevent="scrollTo('aclaraciones')" class="bg-white dark:bg-gray-700 dark:text-gray-100 text-gray-900 rounded-full px-6 py-2 font-medium hover:bg-gray-100 dark:hover:bg-gray-800">Levantar aclaración</button>
          </div>
        </div>

        <!-- Right column: example card -->
        <div>
          <div class="bg-white dark:bg-gray-800 rounded-xl p-6 ring ring-gray-900/5 border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-lg transition">
            <div class="flex items-center gap-4">
              <img src="/build/images/multa.png" alt="Multa" class="w-12 h-12" />
              <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Ejemplo de multa</h3>
                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Monto: <span class="font-medium">$1,200.00</span></p>
                <p class="text-sm text-gray-600 dark:text-gray-300">Fecha: <span class="font-medium">10 Ene 2026</span></p>
                <p class="text-sm text-gray-600 dark:text-gray-300">Estado: <span class="inline-block bg-green-100 text-green-800 px-2 py-0.5 rounded-full text-xs ml-2">Pendiente</span></p>
              </div>
            </div>

            <div class="mt-4 text-sm text-gray-700 dark:text-gray-300">
              <p>Ubicación: Av. Ejemplo 123, Col. Centro</p>
              <p class="mt-1">Evidencia: Fotografía disponible en la ficha.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Sobre el sistema -->
  <section id="sobre" class="bg-white dark:bg-gray-900">
    <div class="max-w-3xl mx-auto py-16 px-4 text-gray-900 dark:text-gray-100">
      <h2 class="text-2xl font-semibold text-center">¿De qué trata este sistema?</h2>
      <div class="mt-6 space-y-4 text-center text-gray-700 dark:text-gray-300">
        <p>Es una plataforma para consultar y entender multas de tránsito de forma sencilla y transparente. Aquí encontrarás la información relevante asociada a cada infracción.</p>
        <p>Mostramos datos del conductor y vehículo, motivo de la infracción, la ubicación exacta y evidencia cuando aplica, para que siempre sepas de dónde viene la multa.</p>
        <p>La plataforma busca dar claridad y facilitar el proceso para que los ciudadanos puedan revisar su situación y tomar acciones si es necesario.</p>
      </div>

      <div class="mt-10 grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 text-center">
          <img src="/build/images/informacion.png" alt="Información" class="w-12 h-12 mx-auto" />
          <h4 class="mt-3 font-medium text-gray-900 dark:text-gray-100">Datos claros</h4>
          <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Información de conductor y vehículo.</p>
        </div>

        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 text-center">
          <img src="/build/images/map.png" alt="Mapa" class="w-12 h-12 mx-auto" />
          <h4 class="mt-3 font-medium text-gray-900 dark:text-gray-100">Ubicación precisa</h4>
          <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Señalamos el lugar exacto de la infracción.</p>
        </div>

        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 text-center">
          <img src="/build/images/camara.png" alt="Cámara" class="w-12 h-12 mx-auto" />
          <h4 class="mt-3 font-medium text-gray-900 dark:text-gray-100">Evidencia</h4>
          <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Fotografías y registros cuando aplican.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Tipos de infracciones -->
  <section id="tipos" class="bg-gray-100 dark:bg-gray-800">
    <div class="max-w-7xl mx-auto py-16 px-4">
      <h2 class="text-2xl font-semibold text-center text-gray-900 dark:text-gray-100">Tipos de infracciones que puedes consultar</h2>

      <div class="mt-8 grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-6">
        <div v-for="(tipo, idx) in tiposInfracciones" :key="idx" class="bg-white dark:bg-gray-800 rounded-xl shadow p-5 flex flex-col items-start gap-3">
          <img :src="tipo.icon" :alt="tipo.titulo" class="w-12 h-12" />
          <h3 class="font-semibold text-gray-900 dark:text-gray-100">{{ tipo.titulo }}</h3>
          <p class="text-sm text-gray-600 dark:text-gray-300">{{ tipo.descripcion }}</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Beneficios / Información que verás -->
  <section id="beneficios" class="bg-white dark:bg-gray-900">
    <div class="max-w-4xl mx-auto py-16 px-4">
      <h2 class="text-2xl font-semibold text-center text-gray-900 dark:text-gray-100">¿Qué información verás en cada multa?</h2>

      <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div v-for="(item, i) in infoItems" :key="i" class="flex items-start gap-4 bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
          <img :src="item.icon" :alt="item.title" class="w-10 h-10" />
          <div>
            <h4 class="font-medium text-gray-900 dark:text-gray-100">{{ item.title }}</h4>
            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">{{ item.desc }}</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Pagos -->
  <section id="pagos" class="bg-gray-50 dark:bg-gray-800">
    <div class="max-w-3xl mx-auto py-12 px-4 text-gray-900 dark:text-gray-100">
      <h2 class="text-2xl font-semibold text-center">Checar pagos</h2>
      <p class="mt-4 text-center text-gray-700 dark:text-gray-300">Consulta el estado de pagos asociados a tus infracciones. Para ver detalles y pagar, inicia sesión con tu cuenta.</p>
      <div class="mt-6 text-center">
        <Link :href="route('infracciones.index')" class="inline-block bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-full">Ingresar placa para ver pagos</Link>
      </div>
    </div>
  </section>

  <!-- Aclaraciones -->
  <section id="aclaraciones" class="bg-white dark:bg-gray-900">
    <div class="max-w-3xl mx-auto py-12 px-4 text-gray-900 dark:text-gray-100">
      <h2 class="text-2xl font-semibold text-center">Levantar aclaración</h2>
      <p class="mt-4 text-center text-gray-700 dark:text-gray-300">Si consideras que existe un error en la infracción, puedes levantar una aclaración. Nuestro equipo la revisará y te contactará con los siguientes pasos.</p>
      <div class="mt-6 text-center">
        <a href="mailto:soporte@infracciones.local" class="inline-block bg-gray-900 dark:bg-white dark:text-gray-900 text-white px-6 py-2 rounded-full">Contactar soporte</a>
      </div>
    </div>
  </section>

  <!-- CTA final -->
  <section class="bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
    <div class="max-w-4xl mx-auto py-12 px-4 text-center">
      <h3 class="text-xl font-semibold">¿Tienes una multa y no sabes qué significa?</h3>
      <p class="mt-2 text-gray-700 dark:text-gray-300">Usa nuestra plataforma para consultar con rapidez y claridad todos los detalles de la infracción.</p>
      <div class="mt-6">
        <Link :href="route('infracciones.index')" class="inline-block bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-full font-medium">Ingresar placa</Link>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-white text-gray-700">
    <div class="max-w-7xl mx-auto py-6 px-4 text-center text-sm">
      © 2025 Infracciones MX. Todos los derechos reservados.
    </div>
  </footer>
</template>
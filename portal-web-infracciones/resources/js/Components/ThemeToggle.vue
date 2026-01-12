<script setup>
import { ref, onMounted } from 'vue';

const theme = ref('light');

const apply = (t) => {
  try {
    if (t === 'dark') document.documentElement.classList.add('dark');
    else document.documentElement.classList.remove('dark');
    localStorage.setItem('theme', t);
    theme.value = t;
  } catch (e) {
    theme.value = t; // fallback
  }
};

onMounted(() => {
  try {
    const saved = localStorage.getItem('theme');
    const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    if (saved === 'dark' || (!saved && prefersDark)) apply('dark');
    else apply('light');
  } catch (e) {
    apply('light');
  }
});

const toggle = () => apply(theme.value === 'dark' ? 'light' : 'dark');
</script>

<template>
  <button @click="toggle" aria-label="Cambiar tema" class="inline-flex items-center gap-2 px-3 py-1 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
    <span v-if="theme==='dark'">
      <!-- Sun icon for light mode -->
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.36 6.36-1.42-1.42M7.05 6.05L5.63 4.63m12.02 0l-1.42 1.42M7.05 17.95l-1.42 1.42M12 7a5 5 0 100 10 5 5 0 000-10z"/></svg>
    </span>
    <span v-else>
      <!-- Moon icon for dark mode -->
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600 dark:text-gray-300" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>
    </span>
    <span class="text-xs text-gray-700 dark:text-gray-200">{{ theme==='dark' ? 'Claro' : 'Oscuro' }}</span>
  </button>
</template>
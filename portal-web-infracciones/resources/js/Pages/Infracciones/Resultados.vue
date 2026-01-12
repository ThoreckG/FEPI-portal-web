<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue'; // Importamos ref para manejar el estado del modal

const props = defineProps({
    placa_consultada: String,
    lista_infracciones: Array,
    error_sistema: { type: Boolean, default: false },
    error_message: { type: String, default: '' },
});

// --- ESTADO DEL MODAL (ZOOM) ---
const imagenSeleccionada = ref(null); // Aquí guardaremos la URL de la imagen a ver en grande

const abrirZoom = (url) => {
    if (url) {
        imagenSeleccionada.value = url;
        // Opcional: Bloquear el scroll del body cuando el modal está abierto
        document.body.style.overflow = 'hidden';
    }
};

const cerrarZoom = () => {
    imagenSeleccionada.value = null;
    document.body.style.overflow = 'auto';
};

// --- FUNCIONES AUXILIARES ---
const formatearFecha = (fechaIso) => {
    if (!fechaIso) return 'Sin fecha';
    return new Date(fechaIso).toLocaleDateString('es-MX', {
        year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit'
    });
};

const getImagenUrl = (urlParcial) => {
    if (!urlParcial) return null; // Retornamos null si no hay URL
    const baseUrl = 'http://127.0.0.1:1337';
    return urlParcial.startsWith('http') ? urlParcial : `${baseUrl}${urlParcial}`;
};
</script>

<template>
    <Head title="Resultados" />

    <div class="min-h-screen bg-gray-100 py-10 px-4">
        <div class="max-w-5xl mx-auto">

            <!-- Encabezado -->
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold text-gray-800">
                    Placa: <span class="text-blue-700">{{ placa_consultada }}</span>
                </h2>
                <Link :href="route('infracciones.index')" class="text-sm text-gray-600 hover:text-blue-600 underline">
                    &larr; Volver a buscar
                </Link>
            </div>

            <!-- Error de conexión -->
            <div v-if="error_sistema" class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-lg mb-4">
                <p class="font-semibold">No se pudo obtener los resultados</p>
                <p class="text-sm mt-1">{{ error_message || 'Ha ocurrido un problema de conexión con el servicio de datos.' }}</p>
            </div>

            <!-- Sin Resultados -->
            <div v-if="!lista_infracciones || lista_infracciones.length === 0" class="bg-white p-8 rounded-lg shadow text-center">
                <p class="text-gray-500 text-lg">No se encontraron infracciones para esta placa.</p>
            </div>

            <!-- Lista de Infracciones -->
            <div v-else class="grid gap-6 md:grid-cols-2">
                <div v-for="item in lista_infracciones" :key="item.id" class="bg-white rounded-lg shadow overflow-hidden border border-gray-200 flex flex-col">

                    <!-- Cabecera -->
                    <div class="bg-gray-50 px-4 py-3 border-b flex justify-between items-center">
                        <span class="font-bold text-gray-700">Folio: {{ item.folio || 'S/N' }}</span>
                        <span
                            class="text-xs font-bold px-2 py-1 rounded uppercase"
                            :class="{
                                'bg-red-100 text-red-800': item.estatus === 'pendiente',
                                'bg-green-100 text-green-800': item.estatus === 'pagado',
                                'bg-gray-100 text-gray-800': item.estatus !== 'pendiente' && item.estatus !== 'pagado'
                            }"
                        >
                            {{ item.estatus || 'Desconocido' }}
                        </span>
                    </div>

                    <!-- Cuerpo -->
                    <div class="p-4 space-y-4 flex-grow">

                        <!-- Datos Generales -->
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Fecha</p>
                                <p class="font-medium">{{ formatearFecha(item.fecha_infraccion) }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Ubicación</p>
                                <p class="font-medium truncate" :title="item.ubicacion_infraccion">{{ item.ubicacion_infraccion || 'No registrada' }}</p>
                            </div>
                        </div>

                        <!-- Artículo -->
                        <div v-if="item.articulo_id" class="bg-yellow-50 p-3 rounded border border-yellow-200">
                            <p class="text-xs text-yellow-800 uppercase font-bold mb-1">Fundamento Legal</p>
                            <p class="text-sm font-bold text-gray-900">
                                Art. {{ item.articulo_id.articulo }} - {{ item.articulo_id.ordenamiento }}
                            </p>
                            <p v-if="item.articulo_id.contenido" class="text-xs text-gray-600 mt-2 italic border-l-2 border-yellow-400 pl-2 leading-relaxed">
                                "{{ item.articulo_id.contenido }}"
                            </p>
                        </div>

                        <!-- EVIDENCIAS (Fotos) -->
                        <!-- Validamos que exista el array y tenga elementos -->
                        <div v-if="item.evidencia_infraccion && item.evidencia_infraccion.length > 0">
                            <p class="text-xs font-bold text-gray-500 mb-2">Evidencia Fotográfica (Click para ampliar):</p>
                            <div class="flex gap-2 overflow-x-auto pb-2">
                                <!-- Iteramos sobre las imágenes -->
                                <template v-for="img in item.evidencia_infraccion" :key="img.id">
                                    <!-- Solo mostramos si la URL es válida -->
                                    <img
                                        v-if="getImagenUrl(img.url)"
                                        :src="getImagenUrl(img.url)"
                                        class="h-20 w-20 object-cover rounded border cursor-zoom-in hover:opacity-80 transition shadow-sm"
                                        @click="abrirZoom(getImagenUrl(img.url))"
                                        alt="Evidencia"
                                    />
                                </template>
                            </div>
                        </div>
                        <div v-else class="text-xs text-gray-400 italic pt-2">
                            No hay evidencia fotográfica adjunta.
                        </div>

                        <!-- FIRMA -->
                        <div class="pt-2 border-t border-gray-100">
                            <p class="text-xs font-bold text-gray-500 mb-1">Firma:</p>

                            <!-- Validamos que exista el objeto firma y tenga URL -->
                            <div v-if="item.firma_infractor && item.firma_infractor.url"
                                 class="bg-gray-50 p-2 rounded border border-dashed border-gray-300 inline-block cursor-zoom-in hover:bg-gray-100 transition"
                                 @click="abrirZoom(getImagenUrl(item.firma_infractor.url))"
                            >
                                <img
                                    :src="getImagenUrl(item.firma_infractor.url)"
                                    class="h-12 w-auto object-contain mix-blend-multiply"
                                    alt="Firma"
                                />
                            </div>
                            <div v-else>
                                <p class="text-xs text-gray-400 italic">Sin firma registrada.</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL DE ZOOM (LIGHTBOX) -->
        <!-- Se muestra solo si imagenSeleccionada tiene valor -->
        <div v-if="imagenSeleccionada" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-90 backdrop-blur-sm transition-opacity" @click.self="cerrarZoom">

            <!-- Botón Cerrar -->
            <button @click="cerrarZoom" class="absolute top-4 right-4 text-white hover:text-gray-300 focus:outline-none">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <!-- Imagen Grande -->
            <div class="relative max-w-4xl max-h-screen p-4">
                <img
                    :src="imagenSeleccionada"
                    class="max-w-full max-h-[90vh] rounded shadow-2xl object-contain"
                    alt="Zoom Evidencia"
                />
            </div>
        </div>

    </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';

const logout = () => {
    // Usar axios global para cerrar sesión (Fortify espera POST /logout)
    window.axios.post(route('logout')).then(() => {
        window.location.href = route('login');
    });
};
</script>

<template>
    <Head title="Panel de Control - Agente" />

    <div class="min-vh-100 d-flex align-items-start justify-content-center bg-dark py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <h2 class="display-6 fw-bold text-white mb-2">Panel de Control - Agente:</h2>
                    <p class="text-white-50 mb-4">¿Qué acción desea realizar hoy?</p>

                    <div class="mb-4">
                        <Link :href="route('infracciones.index')" class="btn btn-danger btn-lg rounded-pill w-100 py-3 d-flex align-items-center">
                            <i class="bi bi-pencil-fill me-3 fs-4"></i>
                            <span class="flex-grow-1 text-start">Nueva Infracción</span>
                        </Link>
                    </div>

                    <div class="mb-4">
                        <button class="btn btn-danger btn-lg rounded-pill w-100 py-3 d-flex align-items-center" @click.prevent>
                            <i class="bi bi-gem me-3 fs-4"></i>
                            <span class="flex-grow-1 text-start">Generar Orden de Arrastre</span>
                        </button>
                    </div>

                    <div class="mb-4">
                        <Link :href="route('infracciones.index')" class="btn btn-outline-dark btn-lg rounded-pill w-100 py-3 d-flex align-items-center text-danger border-secondary">
                            <i class="bi bi-clock-history me-3 fs-4 text-danger"></i>
                            <span class="flex-grow-1 text-start text-danger">Ver Infracciones Registradas</span>
                        </Link>
                    </div>

                    <div class="text-center mt-5">
                        <button class="btn btn-link text-danger" @click.prevent="logout">
                            <i class="bi bi-power me-2"></i> CERRAR SESIÓN
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.bg-dark { background-color: #191b1e !important; }
.btn-danger { background-color: #d63b45; border-color: #d63b45; }
.btn-danger:hover { background-color: #c63540; }
.btn-outline-dark { background-color: transparent; border-color: rgba(255,255,255,0.08); }
.text-danger { color: #d63b45 !important; }
.display-6 { font-size: 1.75rem; }
</style>
<template>
    <AppLayout title="Dashboard">
        <template #header>
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-800 dark:text-white tracking-tight">
                        Panel de Control
                    </h2>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Gestiona tu catálogo culinario y métricas.</p>
                </div>
                <Link :href="route('recetas.create')" 
                    class="inline-flex items-center justify-center px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl transition-all shadow-lg shadow-orange-200 dark:shadow-none transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Nueva Receta
                </Link>
            </div>
        </template>

        <div class="py-10 bg-gray-50/50 dark:bg-gray-900 min-h-screen">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-10">
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden group">
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 bg-indigo-50 dark:bg-indigo-900/30 rounded-2xl text-indigo-600">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                </div>
                                <Link :href="route('recetas.index')" class="text-xs font-semibold text-indigo-600 hover:underline uppercase tracking-widest">Ver todas</Link>
                            </div>
                            <h3 class="text-5xl font-black text-gray-900 dark:text-white">{{ stats.totalRecetas }}</h3>
                            <p class="text-gray-500 dark:text-gray-400 font-medium mt-2">Recetas en tu colección</p>
                        </div>
                        <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                            <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden group">
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 bg-emerald-50 dark:bg-emerald-900/30 rounded-2xl text-emerald-600">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                </div>
                                <Link :href="route('categorias.index')" class="text-xs font-semibold text-emerald-600 hover:underline uppercase tracking-widest">Gestionar</Link>
                            </div>
                            <h3 class="text-5xl font-black text-gray-900 dark:text-white">{{ stats.totalCategorias }}</h3>
                            <p class="text-gray-500 dark:text-gray-400 font-medium mt-2">Categorías organizadas</p>
                        </div>
                        <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                            <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-gray-800 to-gray-900 dark:from-indigo-900 dark:to-slate-900 rounded-3xl p-8 shadow-xl text-white flex flex-col justify-between">
                        <div>
                            <h4 class="text-indigo-300 font-bold uppercase text-xs tracking-[0.2em] mb-2">Usuario Activo</h4>
                            <p class="text-xl font-semibold">{{ $page.props.auth.user.name }}</p>
                        </div>
                        <div class="mt-6 flex items-center gap-3">
                            <div class="h-12 w-12 rounded-full bg-white/10 flex items-center justify-center border border-white/20 text-2xl">
                                👋
                            </div>
                            <p class="text-sm text-gray-300 leading-relaxed">
                                ¡Listo para cocinar algo nuevo hoy!
                            </p>
                        </div>
                    </div>
                </div>

                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-6 flex items-center">
                    <span class="w-8 h-1 bg-orange-500 rounded-full mr-3"></span>
                    Acceso Rápido
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    <Link :href="route('recetas.create')" class="p-6 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl hover:border-orange-500 transition-all group shadow-sm">
                        <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/30 rounded-xl flex items-center justify-center text-orange-600 mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="block font-bold text-gray-800 dark:text-white">Crear Receta</span>
                        <span class="text-xs text-gray-500">Publicar nuevo plato</span>
                    </Link>

                    <Link :href="route('recetas.index')" class="p-6 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl hover:border-indigo-500 transition-all group shadow-sm">
                        <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl flex items-center justify-center text-indigo-600 mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                        </div>
                        <span class="block font-bold text-gray-800 dark:text-white">Ver Catálogo</span>
                        <span class="text-xs text-gray-500">Explorar biblioteca</span>
                    </Link>

                    <Link :href="route('categorias.index')" class="p-6 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl hover:border-emerald-500 transition-all group shadow-sm">
                        <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center text-emerald-600 mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        </div>
                        <span class="block font-bold text-gray-800 dark:text-white">Categorías</span>
                        <span class="text-xs text-gray-500">Organizar platos</span>
                    </Link>
                </div>

            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    stats: {
        type: Object,
        default: () => ({
            totalRecetas: 0,
            totalFavoritos: 0,
            totalCategorias: 0
        })
    }
});
</script>
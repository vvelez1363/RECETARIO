<template>
    <AppLayout title="Gestión de Categorías">
        <template #header>
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-3">
                    <span class="p-2 bg-orange-100 rounded-xl text-2xl">🗂️</span>
                    <h2 class="font-extrabold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                        Categorías
                    </h2>
                </div>
                <Link :href="route('categorias.create')" 
                    class="w-full md:w-auto inline-flex justify-center items-center px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-black rounded-2xl shadow-lg shadow-orange-200 dark:shadow-none transition-all transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                    Nueva Categoría
                </Link>
            </div>
        </template>

        <div class="py-12 bg-gray-50/50 dark:bg-gray-900 min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <div v-if="categorias.length === 0" class="text-center py-20 bg-white dark:bg-gray-800 rounded-[3rem] border border-dashed border-gray-200 dark:border-gray-700">
                    <div class="w-20 h-20 bg-gray-50 dark:bg-gray-900 rounded-full flex items-center justify-center mx-auto mb-4 text-4xl">📁</div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Aún no hay categorías</h3>
                    <p class="text-gray-500 mt-2">Comienza creando una para organizar tus recetas.</p>
                </div>

                <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div v-for="categoria in categorias" :key="categoria.id" 
                        class="group relative bg-white dark:bg-gray-800 rounded-[2.5rem] p-8 shadow-sm hover:shadow-2xl hover:shadow-orange-200/50 dark:hover:shadow-none border border-gray-100 dark:border-gray-700 transition-all duration-300">
                        
                        <div class="absolute top-6 right-6">
                            <span class="inline-flex items-center px-3 py-1 bg-orange-50 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 text-xs font-black uppercase tracking-widest rounded-full">
                                {{ categoria.recetas_count || 0 }} Recetas
                            </span>
                        </div>

                        <div class="mb-6 text-left">
                            <div class="w-12 h-12 bg-gray-50 dark:bg-gray-900 rounded-2xl flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform">
                                🍽️
                            </div>
                            <Link :href="route('categorias.show', categoria.id)" 
                                class="text-2xl font-black text-gray-800 dark:text-white hover:text-orange-500 transition-colors block mb-2 text-left">
                                {{ categoria.nombre }}
                            </Link>
                            <p class="text-gray-500 dark:text-gray-400 text-sm line-clamp-2 leading-relaxed text-left">
                                {{ categoria.descripcion || 'Sin descripción disponible.' }}
                            </p>
                        </div>

                        <div class="flex items-center gap-3 pt-6 border-t border-gray-50 dark:border-gray-700">
                            <Link :href="route('categorias.edit', categoria.id)" 
                                class="flex-1 inline-flex justify-center items-center py-2 bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 text-xs font-black uppercase tracking-tighter rounded-xl hover:bg-amber-500 hover:text-white transition-all">
                                Editar
                            </Link>
                            <button @click="confirmarEliminacion(categoria)" 
                                class="flex-1 inline-flex justify-center items-center py-2 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 text-xs font-black uppercase tracking-tighter rounded-xl hover:bg-red-500 hover:text-white transition-all text-left">
                                Borrar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Transition name="fade">
            <div v-if="categoriaAEliminar" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm flex items-center justify-center z-[100] p-4" @click="categoriaAEliminar = null">
                <div @click.stop class="bg-white dark:bg-gray-800 rounded-[2.5rem] p-8 max-w-sm w-full shadow-2xl text-center">
                    <div class="w-20 h-20 bg-red-100 text-red-500 rounded-3xl flex items-center justify-center mx-auto mb-6 text-3xl">⚠️</div>
                    <h3 class="text-2xl font-black text-gray-800 dark:text-white mb-2 text-center">¿Eliminar?</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mb-8 text-center px-4">
                        Borrarás <span class="font-bold text-red-500">"{{ categoriaAEliminar.nombre }}"</span>. Esta acción es definitiva.
                    </p>
                    <div class="flex flex-col gap-3">
                        <button @click="deleteCategoria" class="w-full py-4 bg-red-500 text-white font-black rounded-2xl hover:bg-red-600 transition-colors shadow-lg shadow-red-200">
                            Eliminar Categoría
                        </button>
                        <button @click="categoriaAEliminar = null" class="w-full py-4 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 font-bold rounded-2xl hover:bg-gray-200 transition-colors">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </Transition>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    categorias: Array
});

const categoriaAEliminar = ref(null);

const confirmarEliminacion = (categoria) => {
    categoriaAEliminar.value = categoria;
};

const deleteCategoria = () => {
    if (categoriaAEliminar.value) {
        router.delete(route('categorias.destroy', categoriaAEliminar.value.id), {
            onSuccess: () => categoriaAEliminar.value = null
        });
    }
};
</script>

<style scoped>
.fade-enter-active, .fade-leave-active { transition: opacity 0.3s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
</style>
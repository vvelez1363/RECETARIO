<template>
    <AppLayout title="Nueva Categoría">
        <template #header>
            <div class="flex items-center gap-3">
                <Link :href="route('categorias.index')" class="p-2 bg-gray-100 dark:bg-gray-800 rounded-xl text-gray-500 hover:text-orange-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </Link>
                <h2 class="font-extrabold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                    Nueva Categoría
                </h2>
            </div>
        </template>

        <div class="py-12 bg-gray-50/50 dark:bg-gray-900 min-h-screen">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm border border-gray-100 dark:border-gray-700 rounded-[2.5rem] p-8 md:p-10">
                    
                    <div class="mb-8 text-center">
                        <div class="w-16 h-16 bg-orange-100 dark:bg-orange-900/30 text-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl shadow-inner">
                            🏷️
                        </div>
                        <p class="text-gray-500 dark:text-gray-400 font-medium">Define una nueva etiqueta para organizar tus creaciones culinarias.</p>
                    </div>

                    <form @submit.prevent="submit" class="space-y-6">
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Nombre de la Categoría</label>
                            <input v-model="form.nombre" type="text" placeholder="Ej: Postres, Pastas, Vegano..." 
                                class="w-full rounded-2xl border-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all py-3 px-4">
                            <div v-if="form.errors.nombre" class="text-red-500 text-xs font-bold mt-2 ml-1 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"/></svg>
                                {{ form.errors.nombre }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Descripción (Opcional)</label>
                            <textarea v-model="form.descripcion" rows="4" placeholder="¿Qué tipo de recetas incluirá esta categoría?" 
                                class="w-full rounded-2xl border-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all py-3 px-4"></textarea>
                            <div v-if="form.errors.descripcion" class="text-red-500 text-xs font-bold mt-2 ml-1">{{ form.errors.descripcion }}</div>
                        </div>

                        <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4">
                            <Link :href="route('categorias.index')" 
                                class="inline-flex justify-center items-center px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 font-bold rounded-2xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                Cancelar
                            </Link>
                            <button type="submit" :disabled="form.processing" 
                                class="inline-flex justify-center items-center px-8 py-3 bg-orange-500 text-white font-black rounded-2xl shadow-lg shadow-orange-200 dark:shadow-none hover:bg-orange-600 transition-all transform hover:-translate-y-0.5 disabled:opacity-50">
                                <svg v-if="form.processing" class="animate-spin h-4 w-4 mr-2" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Crear Categoría
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    nombre: '',
    descripcion: ''
});

const submit = () => {
    form.post(route('categorias.store'));
};
</script>
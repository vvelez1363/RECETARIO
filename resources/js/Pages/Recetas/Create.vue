<template>
    <AppLayout title="Nueva Receta">
        <template #header>
            <div class="flex items-center gap-3">
                <span class="p-2 bg-orange-100 rounded-lg text-2xl">📝</span>
                <h2 class="font-extrabold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                    Crear Nueva Receta
                </h2>
            </div>
        </template>

        <div class="py-12 bg-gray-50/50 dark:bg-gray-900 min-h-screen">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm border border-gray-100 dark:border-gray-700 sm:rounded-3xl p-8">
                    
                    <form @submit.prevent="submit" enctype="multipart/form-data" class="space-y-8">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Nombre de la Receta</label>
                                    <input v-model="form.nombre" type="text" placeholder="Ej: Lasaña de la Abuela" 
                                        class="mt-1 block w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:border-orange-500 focus:ring-orange-500 shadow-sm transition-all">
                                    <div v-if="form.errors.nombre" class="text-red-500 text-xs mt-1 font-medium">{{ form.errors.nombre }}</div>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Categoría</label>
                                    <select v-model="form.categoria_id" 
                                        class="mt-1 block w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:border-orange-500 focus:ring-orange-500 shadow-sm transition-all">
                                        <option value="">Selecciona una categoría</option>
                                        <option v-for="categoria in categorias" :key="categoria.id" :value="categoria.id">
                                            {{ categoria.nombre }}
                                        </option>
                                    </select>
                                    <div v-if="form.errors.categoria_id" class="text-red-500 text-xs mt-1 font-medium">{{ form.errors.categoria_id }}</div>
                                </div>
                            </div>

                            <div class="relative group">
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Foto del Plato</label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-700 border-dashed rounded-3xl group-hover:border-orange-400 transition-colors">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-orange-500 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                            <label class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-bold text-orange-600 hover:text-orange-500">
                                                <span>Sube un archivo</span>
                                                <input type="file" @change="handleFileUpload" accept="image/*" class="sr-only">
                                            </label>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG hasta 10MB</p>
                                    </div>
                                </div>
                                <div v-if="form.errors.imagen" class="text-red-500 text-xs mt-1 font-medium">{{ form.errors.imagen }}</div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6 bg-gray-50 dark:bg-gray-800/50 rounded-3xl border border-gray-100 dark:border-gray-700">
                            <div>
                                <label class="block text-xs font-black uppercase tracking-wider text-gray-500 mb-1">⏱ Tiempo (min)</label>
                                <input v-model="form.tiempo_preparacion" type="number" 
                                    class="block w-full rounded-xl border-none dark:bg-gray-900 focus:ring-orange-500">
                            </div>
                            <div>
                                <label class="block text-xs font-black uppercase tracking-wider text-gray-500 mb-1">🍽 Porciones</label>
                                <input v-model="form.porciones" type="number" 
                                    class="block w-full rounded-xl border-none dark:bg-gray-900 focus:ring-orange-500">
                            </div>
                            <div>
                                <label class="block text-xs font-black uppercase tracking-wider text-gray-500 mb-1">📊 Dificultad</label>
                                <select v-model="form.dificultad" class="block w-full rounded-xl border-none dark:bg-gray-900 focus:ring-orange-500">
                                    <option value="">Selecciona</option>
                                    <option value="fácil">🟢 Fácil</option>
                                    <option value="media">🟡 Media</option>
                                    <option value="difícil">🔴 Difícil</option>
                                </select>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Breve Descripción</label>
                                <textarea v-model="form.descripcion" rows="2" placeholder="Cuéntanos un poco sobre este plato..."
                                    class="mt-1 block w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:border-orange-500 focus:ring-orange-500"></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Pasos de Preparación</label>
                                <textarea v-model="form.instrucciones" rows="5" placeholder="1. Picar la cebolla... 2. Sofreír..."
                                    class="mt-1 block w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:border-orange-500 focus:ring-orange-500"></textarea>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-100 dark:border-gray-700">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                                <span class="text-orange-500">🛒</span> Ingredientes Necesarios
                            </h3>
                            
                            <div class="space-y-3">
                                <div v-for="(ingrediente, index) in form.ingredientes" :key="index" 
                                    class="flex flex-wrap md:flex-nowrap gap-3 items-center bg-gray-50 dark:bg-gray-900 p-3 rounded-2xl border border-gray-100 dark:border-gray-800">
                                    
                                    <select v-model="ingrediente.id" class="flex-1 min-w-[200px] rounded-xl border-none focus:ring-orange-500 dark:bg-gray-800">
                                        <option value="">Selecciona ingrediente</option>
                                        <option v-for="ing in ingredientes" :key="ing.id" :value="ing.id">{{ ing.nombre }}</option>
                                    </select>
                                    
                                    <input v-model="ingrediente.cantidad" type="text" placeholder="Cant. (Ej: 200g)" 
                                        class="w-full md:w-40 rounded-xl border-none focus:ring-orange-500 dark:bg-gray-800">
                                    
                                    <button type="button" @click="removeIngrediente(index)" 
                                        class="p-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </div>

                            <button type="button" @click="addIngrediente" 
                                class="mt-4 inline-flex items-center px-4 py-2 bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400 font-bold rounded-xl hover:bg-orange-100 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Agregar otro ingrediente
                            </button>
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-8 border-t border-gray-100 dark:border-gray-700">
                            <Link :href="route('recetas.index')" class="text-sm font-bold text-gray-500 hover:text-gray-700 transition-colors">
                                Cancelar y volver
                            </Link>
                            <button type="submit" :disabled="form.processing" 
                                class="px-10 py-4 bg-orange-500 text-white rounded-2xl font-bold shadow-lg shadow-orange-200 dark:shadow-none hover:bg-orange-600 transform hover:-translate-y-0.5 transition-all disabled:opacity-50">
                                Guardar Receta
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

const props = defineProps({
    categorias: Array,
    ingredientes: Array
});

const form = useForm({
    nombre: '',
    categoria_id: '',
    descripcion: '',
    instrucciones: '',
    tiempo_preparacion: '',
    porciones: '',
    dificultad: '',
    ingredientes: [{ id: '', cantidad: '' }],
    imagen: null
});

const addIngrediente = () => {
    form.ingredientes.push({ id: '', cantidad: '' });
};

const removeIngrediente = (index) => {
    form.ingredientes.splice(index, 1);
};

const handleFileUpload = (event) => {
    form.imagen = event.target.files[0];
};

const submit = () => {
    form.post(route('recetas.store'));
};
</script>
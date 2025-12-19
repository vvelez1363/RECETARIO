<template>
    <AppLayout :title="'Editar ' + receta.nombre">
        <template #header>
            <div class="flex items-center gap-3">
                <span class="p-2 bg-amber-100 rounded-lg text-2xl">✍️</span>
                <h2 class="font-extrabold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                    Editar: <span class="text-orange-600">{{ receta.nombre }}</span>
                </h2>
            </div>
        </template>

        <div class="py-12 bg-gray-50/50 dark:bg-gray-900 min-h-screen">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm border border-gray-100 dark:border-gray-700 sm:rounded-3xl p-8">
                    
                    <form @submit.prevent="submit" enctype="multipart/form-data" class="space-y-8">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Nombre de la Receta</label>
                                    <input v-model="form.nombre" type="text" 
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
                                </div>
                            </div>

                            <div class="flex gap-4 items-start bg-orange-50/50 dark:bg-gray-900/50 p-4 rounded-3xl border border-orange-100 dark:border-gray-700">
                                <div v-if="receta.imagen" class="shrink-0">
                                    <p class="text-[10px] font-bold uppercase text-orange-600 mb-1 px-1">Actual</p>
                                    <img :src="`/storage/${receta.imagen}`" alt="Actual" class="w-24 h-24 object-cover rounded-2xl shadow-md border-2 border-white dark:border-gray-800">
                                </div>
                                <div class="flex-1">
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 px-1">Cambiar Imagen</label>
                                    <input type="file" @change="handleFileUpload" accept="image/*" 
                                        class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 transition-all cursor-pointer">
                                    <p class="text-[10px] text-gray-400 mt-2 px-1 italic">Deja vacío para mantener la imagen actual.</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6 bg-gray-50 dark:bg-gray-800/50 rounded-3xl border border-gray-100 dark:border-gray-700">
                            <div>
                                <label class="block text-xs font-black uppercase tracking-wider text-gray-500 mb-1">⏱ Tiempo (min)</label>
                                <input v-model="form.tiempo_preparacion" type="number" 
                                    class="block w-full rounded-xl border-none dark:bg-gray-900 focus:ring-orange-500 shadow-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-black uppercase tracking-wider text-gray-500 mb-1">🍽 Porciones</label>
                                <input v-model="form.porciones" type="number" 
                                    class="block w-full rounded-xl border-none dark:bg-gray-900 focus:ring-orange-500 shadow-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-black uppercase tracking-wider text-gray-500 mb-1">📊 Dificultad</label>
                                <select v-model="form.dificultad" class="block w-full rounded-xl border-none dark:bg-gray-900 focus:ring-orange-500 shadow-sm">
                                    <option value="fácil">🟢 Fácil</option>
                                    <option value="media">🟡 Media</option>
                                    <option value="difícil">🔴 Difícil</option>
                                </select>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1 px-1">Descripción Corta</label>
                                <textarea v-model="form.descripcion" rows="2" 
                                    class="mt-1 block w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:border-orange-500 focus:ring-orange-500 shadow-sm"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1 px-1">Proceso de Elaboración</label>
                                <textarea v-model="form.instrucciones" rows="6" 
                                    class="mt-1 block w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:border-orange-500 focus:ring-orange-500 shadow-sm"></textarea>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-100 dark:border-gray-700">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                                <span class="text-orange-500 text-xl">🛒</span> Ingredientes
                            </h3>
                            
                            <div class="space-y-3">
                                <TransitionGroup name="list">
                                    <div v-for="(ingrediente, index) in form.ingredientes" :key="index" 
                                        class="flex flex-wrap md:flex-nowrap gap-3 items-center bg-gray-50 dark:bg-gray-900 p-3 rounded-2xl border border-gray-100 dark:border-gray-800 transition-all hover:border-orange-200 shadow-sm">
                                        
                                        <select v-model="ingrediente.id" class="flex-1 min-w-[200px] rounded-xl border-none focus:ring-orange-500 dark:bg-gray-800">
                                            <option value="">Selecciona ingrediente</option>
                                            <option v-for="ing in ingredientes" :key="ing.id" :value="ing.id">{{ ing.nombre }}</option>
                                        </select>
                                        
                                        <input v-model="ingrediente.cantidad" type="text" placeholder="Cant. (Ej: 500g)" 
                                            class="w-full md:w-40 rounded-xl border-none focus:ring-orange-500 dark:bg-gray-800">
                                        
                                        <button type="button" @click="removeIngrediente(index)" 
                                            class="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-all">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </TransitionGroup>
                            </div>

                            <button type="button" @click="addIngrediente" 
                                class="mt-4 inline-flex items-center px-4 py-2 bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400 font-bold rounded-xl hover:bg-orange-100 transition-colors shadow-sm">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Añadir Ingrediente
                            </button>
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-8 border-t border-gray-100 dark:border-gray-700">
                            <Link :href="route('recetas.show', receta.id)" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition-colors">
                                Descartar cambios
                            </Link>
                            <button type="submit" :disabled="form.processing" 
                                class="px-10 py-4 bg-orange-500 text-white rounded-2xl font-bold shadow-lg shadow-orange-200 dark:shadow-none hover:bg-orange-600 transform hover:-translate-y-0.5 transition-all disabled:opacity-50">
                                Guardar Cambios
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
    receta: Object,
    categorias: Array,
    ingredientes: Array
});

const form = useForm({
    nombre: props.receta.nombre,
    categoria_id: props.receta.categoria_id,
    descripcion: props.receta.descripcion,
    instrucciones: props.receta.instrucciones,
    tiempo_preparacion: props.receta.tiempo_preparacion,
    porciones: props.receta.porciones,
    dificultad: props.receta.dificultad,
    ingredientes: props.receta.ingredientes.map(ing => ({
        id: ing.id,
        cantidad: ing.pivot.cantidad
    })),
    imagen: null,
    // Importante para Laravel cuando se envían archivos mediante PUT
    _method: 'PUT' 
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
    // Usamos POST con el campo _method: PUT para que Laravel e Inertia 
    // manejen correctamente el FormData con archivos.
    form.post(route('recetas.update', props.receta.id), {
        forceFormData: true,
        preserveScroll: true,
    });
};
</script>

<style scoped>
.list-enter-active, .list-leave-active {
  transition: all 0.3s ease;
}
.list-enter-from, .list-leave-to {
  opacity: 0;
  transform: translateX(30px);
}
</style>
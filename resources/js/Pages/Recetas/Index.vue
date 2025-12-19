<template>
    <AppLayout title="Explorar Recetas">
        <template #header>
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-3">
                    <span class="p-2 bg-orange-100 rounded-lg text-2xl">👨‍🍳</span>
                    <h2 class="font-extrabold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                        Explorar Recetas
                    </h2>
                </div>
                <Link :href="route('recetas.create')" 
                    class="w-full md:w-auto inline-flex justify-center items-center px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-2xl shadow-lg shadow-orange-200 dark:shadow-none transition-all transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                    Nueva Receta
                </Link>
            </div>
        </template>

        <div class="py-12 bg-gray-50/50 dark:bg-gray-900 min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 mb-8">
                    <form @submit.prevent="buscar" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                            <div class="lg:col-span-2 relative">
                                <label class="block text-xs font-black uppercase text-gray-400 mb-1 ml-1">Buscar por nombre</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                    </span>
                                    <input v-model="form.search" type="text" placeholder="Ej: Pasta Carbonara..." 
                                        class="pl-10 w-full rounded-2xl border-gray-100 dark:border-gray-700 dark:bg-gray-900 focus:ring-orange-500 focus:border-orange-500 transition-all shadow-sm">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-black uppercase text-gray-400 mb-1 ml-1">Categoría</label>
                                <select v-model="form.categoria" class="w-full rounded-2xl border-gray-100 dark:border-gray-700 dark:bg-gray-900 focus:ring-orange-500 shadow-sm">
                                    <option value="">Todas</option>
                                    <option v-for="cat in categorias" :key="cat.id" :value="cat.id">{{ cat.nombre }}</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-black uppercase text-gray-400 mb-1 ml-1">Dificultad</label>
                                <select v-model="form.dificultad" class="w-full rounded-2xl border-gray-100 dark:border-gray-700 dark:bg-gray-900 focus:ring-orange-500 shadow-sm">
                                    <option value="">Todas</option>
                                    <option value="fácil">🟢 Fácil</option>
                                    <option value="media">🟡 Media</option>
                                    <option value="difícil">🔴 Difícil</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-black uppercase text-gray-400 mb-1 ml-1">Ingrediente principal</label>
                                <select v-model="form.ingrediente" class="w-full rounded-2xl border-gray-100 dark:border-gray-700 dark:bg-gray-900 focus:ring-orange-500 shadow-sm">
                                    <option value="">Cualquiera</option>
                                    <option v-for="ing in ingredientes" :key="ing.id" :value="ing.id">{{ ing.nombre }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-2">
                            <div class="flex gap-2">
                                <button type="submit" class="bg-gray-900 dark:bg-orange-600 text-white px-6 py-2 rounded-xl font-bold hover:bg-gray-800 transition-colors shadow-md">
                                    Aplicar Filtros
                                </button>
                                <button type="button" @click="limpiarFiltros" class="text-gray-400 hover:text-orange-500 font-bold text-sm px-4">
                                    Limpiar
                                </button>
                            </div>
                            
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-gray-400 uppercase">Ordenar:</span>
                                <select v-model="form.orden" @change="buscar" class="border-none bg-transparent text-sm font-bold text-orange-600 focus:ring-0 cursor-pointer">
                                    <option value="reciente">Más recientes</option>
                                    <option value="antiguo">Más antiguas</option>
                                    <option value="nombre">A-Z</option>
                                    <option value="tiempo">Menor tiempo</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>

                <div v-if="recetas.data.length === 0" class="text-center py-20 bg-white dark:bg-gray-800 rounded-3xl border border-dashed border-gray-200 dark:border-gray-700">
                    <span class="text-6xl mb-4 block">🔍</span>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">No hay recetas que coincidan</h3>
                    <p class="text-gray-500">Intenta ajustar los filtros o añade una nueva receta.</p>
                </div>

                <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div v-for="receta in recetas.data" :key="receta.id" 
                        class="group bg-white dark:bg-gray-800 rounded-[2.5rem] shadow-sm hover:shadow-2xl hover:shadow-orange-200/50 dark:hover:shadow-none border border-gray-100 dark:border-gray-700 overflow-hidden transition-all duration-300 transform hover:-translate-y-2">
                        
                        <div class="relative overflow-hidden h-56">
                            <Link :href="route('recetas.show', receta.id)">
                                <img v-if="receta.imagen" :src="`/storage/${receta.imagen}`" :alt="receta.nombre" 
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                <div v-else class="w-full h-full bg-orange-50 dark:bg-gray-700 flex items-center justify-center text-orange-200 text-4xl">
                                    🍲
                                </div>
                            </Link>
                            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm dark:bg-gray-900/90 px-3 py-1 rounded-full shadow-sm">
                                <span class="text-xs font-black text-gray-800 dark:text-gray-200 flex items-center gap-1">
                                    <svg class="w-3 h-3 text-orange-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"/></svg>
                                    {{ receta.tiempo_preparacion }} min
                                </span>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="text-[10px] font-black uppercase tracking-widest px-2 py-0.5 bg-orange-100 text-orange-600 rounded-md">
                                    {{ receta.categoria.nombre }}
                                </span>
                                <span :class="{
                                    'text-green-600 bg-green-50': receta.dificultad === 'fácil',
                                    'text-amber-600 bg-amber-50': receta.dificultad === 'media',
                                    'text-red-600 bg-red-50': receta.dificultad === 'difícil'
                                }" class="text-[10px] font-black uppercase tracking-widest px-2 py-0.5 rounded-md">
                                    {{ receta.dificultad }}
                                </span>
                            </div>

                            <Link :href="route('recetas.show', receta.id)" class="block mb-2 text-xl font-extrabold text-gray-800 dark:text-white group-hover:text-orange-500 transition-colors leading-tight">
                                {{ receta.nombre }}
                            </Link>
                            
                            <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 mb-4">
                                {{ receta.descripcion }}
                            </p>

                            <div class="flex items-center justify-between pt-4 border-t border-gray-50 dark:border-gray-700">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-900 flex items-center justify-center text-xs font-bold text-gray-400">
                                        {{ receta.user.name.charAt(0) }}
                                    </div>
                                    <span class="text-xs font-bold text-gray-600 dark:text-gray-400">{{ receta.user.name }}</span>
                                </div>
                                <span class="text-xs font-bold text-gray-400 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    {{ receta.porciones }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="recetas.links.length > 3" class="mt-12 flex justify-center">
                    <nav class="inline-flex p-1 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <template v-for="(link, index) in recetas.links" :key="index">
                            <Link v-if="link.url" :href="link.url" v-html="link.label" 
                                :class="{
                                    'bg-orange-500 text-white shadow-md': link.active,
                                    'text-gray-500 hover:text-orange-500 hover:bg-orange-50 dark:hover:bg-gray-700': !link.active
                                }"
                                class="px-4 py-2 rounded-xl text-sm font-black transition-all mx-0.5"
                            />
                            <span v-else v-html="link.label" class="px-4 py-2 text-gray-300 text-sm cursor-not-allowed mx-0.5"/>
                        </template>
                    </nav>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { reactive } from 'vue';

const props = defineProps({
    recetas: Object,
    categorias: Array,
    ingredientes: Array,
    filtros: Object
});

const form = reactive({
    search: props.filtros.search || '',
    categoria: props.filtros.categoria || '',
    dificultad: props.filtros.dificultad || '',
    ingrediente: props.filtros.ingrediente || '',
    orden: props.filtros.orden || 'reciente'
});

const buscar = () => {
    router.get(route('recetas.index'), form, {
        preserveState: true,
        preserveScroll: true
    });
};

const limpiarFiltros = () => {
    form.search = '';
    form.categoria = '';
    form.dificultad = '';
    form.ingrediente = '';
    form.orden = 'reciente';
    buscar();
};
</script>
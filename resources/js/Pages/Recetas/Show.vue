<template>
    <AppLayout :title="receta.nombre">
        <template #header>
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="flex items-center gap-3 text-left">
                    <Link :href="route('recetas.index')" class="p-2 bg-gray-100 dark:bg-gray-800 rounded-xl text-gray-500 hover:text-orange-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </Link>
                    <h2 class="font-extrabold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ receta.nombre }}
                    </h2>
                </div>
                
                <div class="flex flex-wrap gap-2 w-full md:w-auto">
                    <button @click="compartir" class="flex-1 md:flex-none inline-flex items-center justify-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 font-bold rounded-xl hover:bg-gray-50 transition-all">
                        Compartir
                    </button>
                    <a :href="route('recetas.pdf', receta.id)" class="flex-1 md:flex-none inline-flex items-center justify-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 font-bold rounded-xl hover:bg-gray-50 transition-all">
                        PDF
                    </a>
                    <template v-if="$page.props.auth.user.id === receta.user_id">
                        <Link :href="route('recetas.edit', receta.id)" class="p-2 bg-amber-100 text-amber-700 rounded-xl hover:bg-amber-200 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </Link>
                        <button @click="confirmandoBorrado = true" class="p-2 bg-red-100 text-red-700 rounded-xl hover:bg-red-200 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </template>
                </div>
            </div>
        </template>

        <div class="py-12 bg-gray-50/50 dark:bg-gray-900 min-h-screen">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 rounded-[3rem] shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                    
                    <div class="relative h-[450px] w-full">
                        <img v-if="receta.imagen" :src="`/storage/${receta.imagen}`" :alt="receta.nombre" class="w-full h-full object-cover">
                        <div v-else class="w-full h-full bg-orange-50 flex items-center justify-center text-8xl">🥘</div>
                        <div class="absolute bottom-8 left-8 right-8 flex flex-wrap gap-4">
                            <span class="px-4 py-2 bg-white/90 backdrop-blur dark:bg-gray-900/90 rounded-2xl shadow-xl text-orange-600 font-black uppercase text-xs">
                                {{ receta.categoria.nombre }}
                            </span>
                            <span :class="{'bg-green-500': receta.dificultad === 'fácil', 'bg-amber-500': receta.dificultad === 'media', 'bg-red-500': receta.dificultad === 'difícil'}" 
                                class="px-4 py-2 text-white rounded-2xl shadow-xl font-black uppercase text-xs">
                                {{ receta.dificultad }}
                            </span>
                        </div>
                    </div>

                    <div class="p-8 md:p-12">
                        <div class="grid grid-cols-3 gap-4 mb-12 p-6 bg-gray-50 dark:bg-gray-900 rounded-[2rem] border border-gray-100 dark:border-gray-700">
                            <div class="text-center border-r border-gray-200 dark:border-gray-700 text-left">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Tiempo</p>
                                <p class="text-lg font-bold text-gray-800 dark:text-white">{{ receta.tiempo_preparacion }} min</p>
                            </div>
                            <div class="text-center border-r border-gray-200 dark:border-gray-700 text-left">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Porciones</p>
                                <p class="text-lg font-bold text-gray-800 dark:text-white">{{ receta.porciones }}</p>
                            </div>
                            <div class="text-center text-left">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Autor</p>
                                <p class="text-lg font-bold text-orange-500 truncate text-center">{{ receta.user.name }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 text-left">
                            <div class="lg:col-span-1">
                                <h3 class="text-xl font-black text-gray-800 dark:text-white mb-6">🛒 Ingredientes</h3>
                                <ul class="space-y-4">
                                    <li v-for="ingrediente in receta.ingredientes" :key="ingrediente.id" class="flex items-center p-3 rounded-2xl bg-orange-50/50 dark:bg-gray-700/50">
                                        <div class="mr-3">🧂</div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-800 dark:text-gray-200">{{ ingrediente.nombre }}</p>
                                            <p class="text-xs font-black text-orange-500 uppercase">{{ ingrediente.pivot.cantidad }}</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="lg:col-span-2 space-y-10">
                                <div>
                                    <h3 class="text-xl font-black text-gray-800 dark:text-white mb-4">Historia</h3>
                                    <p class="text-gray-600 dark:text-gray-400 italic border-l-4 border-orange-200 pl-4">{{ receta.descripcion }}</p>
                                </div>
                                <div>
                                    <h3 class="text-xl font-black text-gray-800 dark:text-white mb-6">👨‍🍳 Preparación</h3>
                                    <div class="text-gray-700 dark:text-gray-300 whitespace-pre-line leading-loose text-lg font-medium">
                                        {{ receta.instrucciones }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Transition name="fade">
            <div v-if="confirmandoBorrado" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm flex items-center justify-center z-[100] p-4" @click="confirmandoBorrado = false">
                <div @click.stop class="bg-white dark:bg-gray-800 rounded-[2.5rem] p-10 max-w-md w-full shadow-2xl text-center">
                    <div class="w-24 h-24 bg-red-100 text-red-500 rounded-[2rem] flex items-center justify-center mx-auto mb-6 text-4xl">🗑️</div>
                    <h3 class="text-2xl font-black text-gray-800 dark:text-white mb-3 text-center">¿Eliminar Receta?</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-8 px-4 text-center leading-relaxed">¿Seguro que quieres borrar <span class="text-gray-800 dark:text-white font-bold italic">"{{ receta.nombre }}"</span>? Esta acción es irreversible.</p>
                    <div class="grid grid-cols-2 gap-4">
                        <button @click="confirmandoBorrado = false" class="py-4 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 font-black rounded-2xl hover:bg-gray-200 transition-all">CANCELAR</button>
                        <button @click="deleteReceta" class="py-4 bg-red-500 text-white font-black rounded-2xl hover:bg-red-600 transition-all shadow-lg shadow-red-200">BORRAR</button>
                    </div>
                </div>
            </div>
        </Transition>

        <Transition name="fade">
            <div v-if="mostrarModalCompartir" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm flex items-center justify-center z-[100] p-4" @click="cerrarModal">
                <div @click.stop class="bg-white dark:bg-gray-800 rounded-[2.5rem] p-8 max-w-md w-full shadow-2xl">
                    <h3 class="text-2xl font-black text-gray-800 dark:text-white mb-6 text-center">Compartir</h3>
                    <div class="relative mb-6">
                        <input :value="urlCompartir" readonly class="w-full rounded-2xl border-gray-100 dark:border-gray-700 dark:bg-gray-900 p-4 text-sm font-bold text-gray-500">
                        <button @click="copiarUrl" class="absolute right-2 top-2 bottom-2 bg-orange-500 text-white px-4 rounded-xl text-xs font-black uppercase hover:bg-orange-600">
                            {{ copiado ? 'Copiado' : 'Copiar' }}
                        </button>
                    </div>
                    <button @click="cerrarModal" class="w-full py-4 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 font-bold rounded-2xl hover:bg-gray-200">Cerrar</button>
                </div>
            </div>
        </Transition>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({ receta: Object });

const confirmandoBorrado = ref(false);
const mostrarModalCompartir = ref(false);
const urlCompartir = ref('');
const copiado = ref(false);

const compartir = () => {
    urlCompartir.value = window.location.href;
    mostrarModalCompartir.value = true;
};

const cerrarModal = () => mostrarModalCompartir.value = false;

const copiarUrl = async () => {
    await navigator.clipboard.writeText(urlCompartir.value);
    copiado.value = true;
    setTimeout(() => copiado.value = false, 2000);
};

const deleteReceta = () => {
    router.delete(route('recetas.destroy', props.receta.id));
};
</script>

<style scoped>
.fade-enter-active, .fade-leave-active { transition: opacity 0.3s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
</style>
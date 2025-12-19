<template>
    <Head title="Bienvenidos" />

    <div class="relative min-h-screen bg-gray-50 dark:bg-gray-950 selection:bg-orange-500 selection:text-white">
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-[10%] -right-[10%] w-[50%] h-[50%] bg-orange-100 dark:bg-orange-900/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-[10%] -left-[10%] w-[40%] h-[40%] bg-indigo-100 dark:bg-indigo-900/20 rounded-full blur-3xl"></div>
        </div>

        <div class="relative min-h-screen flex flex-col items-center">
            <div class="w-full max-w-7xl px-6">
                <header class="flex justify-between items-center py-8">
                    <div class="flex items-center gap-2">
                        <span class="text-3xl">🍳</span>
                        <h1 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">FoodieBook</h1>
                    </div>

                    <nav v-if="canLogin" class="flex gap-4">
                        <Link v-if="$page.props.auth.user" :href="route('dashboard')" 
                            class="px-5 py-2.5 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-xl font-bold transition hover:scale-105">
                            Ir al Panel
                        </Link>

                        <template v-else>
                            <Link :href="route('login')" class="px-5 py-2.5 text-gray-600 dark:text-gray-300 font-semibold hover:text-orange-500 transition">
                                Iniciar Sesión
                            </Link>
                            <Link v-if="canRegister" :href="route('register')" 
                                class="px-5 py-2.5 bg-orange-500 text-white rounded-xl font-bold shadow-lg shadow-orange-200 dark:shadow-none transition hover:bg-orange-600 hover:scale-105">
                                Registrarse
                            </Link>
                        </template>
                    </nav>
                </header>

                <main class="mt-12 lg:mt-20 text-left">
                    <div class="grid lg:grid-cols-2 gap-16 items-center">
                        <div class="text-left">
                            <span class="inline-block px-4 py-1.5 mb-6 text-sm font-black tracking-widest text-orange-600 uppercase bg-orange-100 rounded-full">
                                🥘 Legado Gastronómico
                            </span>
                            <h2 class="text-5xl lg:text-7xl font-black text-gray-900 dark:text-white leading-[1.1] mb-6">
                                Organiza tus <span class="text-orange-500 text-left">Recetas</span>
                            </h2>
                            <p class="text-lg text-gray-600 dark:text-gray-400 mb-10 leading-relaxed max-w-lg">
                                Las mejores recetas de la familia Velez - Castrillon, reunidas en un solo lugar para compartir y disfrutar juntos por generaciones.
                            </p>
                            
                            <div class="flex flex-col sm:flex-row gap-4">
                                <Link :href="route('register')" class="px-8 py-4 bg-orange-500 text-white text-center rounded-2xl font-black text-lg shadow-xl shadow-orange-200 dark:shadow-none hover:bg-orange-600 transition-all transform hover:-translate-y-1">
                                    Empezar a cocinar
                                </Link>
                            </div>
                        </div>

                        <div class="relative group">
                            <div class="bg-gradient-to-tr from-orange-400 to-amber-300 rounded-[3rem] aspect-square rotate-3 absolute inset-0 shadow-2xl opacity-20 group-hover:rotate-6 transition-transform duration-500"></div>
                            
                            <div class="relative bg-white dark:bg-gray-900 rounded-[3rem] aspect-square overflow-hidden border border-gray-100 dark:border-gray-800 shadow-2xl flex items-center justify-center p-12 overflow-hidden">
                                <div class="absolute top-0 left-0 p-8 text-orange-200 dark:text-orange-900/40 text-8xl font-serif">“</div>
                                <div class="absolute bottom-0 right-0 p-8 text-orange-200 dark:text-orange-900/40 text-8xl font-serif rotate-180">“</div>

                                <div class="text-center relative z-10">
                                    <div class="w-20 h-20 bg-orange-50 dark:bg-orange-900/20 rounded-2xl flex items-center justify-center mx-auto mb-8 shadow-inner">
                                        <span class="text-4xl">✨</span>
                                    </div>
                                    <blockquote class="text-3xl md:text-4xl font-black text-gray-800 dark:text-white leading-tight italic mb-6">
                                        "La cocina es amor hecho visible."
                                    </blockquote>
                                    <div class="w-12 h-1 bg-orange-500 mx-auto mb-4 rounded-full"></div>
                                    <p class="text-orange-600 dark:text-orange-400 font-black uppercase tracking-[0.2em] text-sm">
                                        — Tradición Familiar —
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>

                <footer class="py-12 border-t border-gray-200 dark:border-gray-800 text-center">
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">
                        &copy; 2025 FoodieBook • Valentina Velez Castrillon
                    </p>
                    <p class="text-gray-500 text-[10px] mt-2 italic">Cultivando el sabor de nuestra historia.</p>
                </footer>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});
</script>
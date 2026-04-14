<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { home } from '@/routes';

const page = usePage();
const name = page.props.name;

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div class="relative grid min-h-dvh lg:grid-cols-2 lg:max-w-none">
        <!-- Panel izquierdo -->
        <div class="relative hidden min-h-dvh overflow-hidden lg:flex">
            <!-- Imagen de fondo -->
            <img
                src="/images/institucion.jpg"
                alt="Institución educativa"
                class="absolute inset-0 h-full w-full object-cover"
            />

            <!-- Capa oscura -->
            <div class="absolute inset-0 bg-purple-950/55" />

            <!-- Desenfoque suave -->
            <div class="absolute inset-0 backdrop-purple-[2px]" />

            <!-- Degradado decorativo -->
            <div class="absolute inset-0 bg-gradient-to-br from-purple-500/20 via-transparent to-purple-400/20" />

            <!-- Borde degradado -->
            <div class="absolute inset-0">
                <div class="absolute inset-y-0 right-0 w-px bg-gradient-to-b from-purple-300 via-purple-400 to-purple-500" />
                <div class="absolute inset-6 rounded-3xl border border-white/10 ring-1 ring-inset ring-white/10" />
            </div>

            <!-- Contenido -->
            <div class="relative z-20 flex h-full w-full flex-col justify-between p-10">
                <!-- Logo arriba -->
                <div>
                    <Link
                        :href="home()"
                        class="inline-flex items-center gap-4 rounded-2xl border border-white/15 bg-white/10 px-4 py-3 backdrop-blur-md"
                    >
                        <img
                            src="/images/logo.png"
                            alt="Logo institucional"
                            class="h-14 w-14 rounded-full border-2 border-white/30 bg-white object-cover shadow-lg"
                        />
                        <div>
                            <p class="text-xs uppercase tracking-[0.35em] text-white/70">
                                Sistema Académico
                            </p>
                            <h2 class="text-lg font-semibold text-white">
                                SGA Alessandro Volta
                            </h2>
                        </div>
                    </Link>
                </div>

                <!-- Texto institucional elegante -->
                <div class="max-w-xl rounded-3xl border border-white/10 bg-white/10 p-8 shadow-2xl backdrop-blur-md">
                    <p class="mb-3 text-xs uppercase tracking-[0.4em] text-purple-200/90">
                        Unidad Educativa
                    </p>

                    <h1 class="text-4xl font-semibold leading-tight text-white xl:text-5xl">
                        {{ name ?? 'Alessandro Volta' }}
                    </h1>

                    <p class="mt-4 text-sm leading-7 text-white/80">
                        Plataforma institucional para la gestión académica, el seguimiento estudiantil
                        y la administración eficiente de procesos escolares.
                    </p>

                    <div class="mt-6 h-px w-24 bg-gradient-to-r from-purple-300 via-purple-400 to-purple-500" />
                </div>
            </div>
        </div>

        <!-- Panel derecho -->
<div
    class="relative flex min-h-dvh items-center justify-center overflow-hidden bg-gradient-to-b from-[#4F079C] via-[#4F079C] to-[#4F079C] px-6 py-10 lg:px-8"
>
            <!-- Cuadrícula -->
            <div
                class="absolute inset-0 opacity-25
                       bg-[linear-gradient(to_right,rgba(255,255,255,0.22)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.22)_1px,transparent_1px)]
                       bg-[size:56px_56px]"
            />

            <!-- Resplandor superior derecho -->
            <div
                class="absolute -top-10 right-[-80px] h-[320px] w-[320px] rounded-full opacity-20 blur-3xl
                       bg-[radial-gradient(circle,rgba(54,40,128,0.30)_0%,rgba(54,40,128,0.10)_35%,transparent_70%)]"
            />

            <!-- Capa interior suave -->
            <div class="absolute inset-0 bg-gradient-to-b from-white/[0.06] via-transparent to-black/10" />

            <!-- Contenido -->
            <div class="relative z-10 w-full max-w-md">
                <div class="mb-6 flex flex-col space-y-2 text-center">
                    <h1 class="text-xl font-semibold tracking-tight text-white" v-if="title">
                        {{ title }}
                    </h1>
                    <p class="text-sm text-white/75" v-if="description">
                        {{ description }}
                    </p>
                </div>

                <slot />
            </div>
        </div>
    </div>
</template>
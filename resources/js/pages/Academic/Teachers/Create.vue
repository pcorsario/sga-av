<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import { dashboard } from '@/routes';
import teachersRoutes from '@/routes/teachers';
import type { Team } from '@/types';

const props = defineProps<{
    currentTeam?: Team | null;
}>();

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(teachersRoutes.store.url({ current_team: props.currentTeam?.slug ?? '' }), {
        preserveScroll: true,
    });
};

defineOptions({
    layout: (props: { currentTeam?: Team | null }) => ({
        breadcrumbs: [
            {
                title: 'Dashboard Académico',
                href: props.currentTeam ? dashboard(props.currentTeam.slug) : '/',
            },
            {
                title: 'Nómina',
                href: props.currentTeam ? teachersRoutes.index.url({ current_team: props.currentTeam.slug }) : '#',
            },
            {
                title: 'Alta de Profesor',
                href: '#',
            },
        ],
    }),
});
</script>

<template>
    <Head title="Añadir Profesor" />

    <div class="px-4 py-8 mx-auto max-w-4xl sm:px-6 lg:px-8">
        <div class="mb-8 flex items-center gap-4">
            <Link 
                :href="currentTeam ? teachersRoutes.index.url({ current_team: currentTeam.slug }) : '#'"
                class="p-2 border border-zinc-200 dark:border-zinc-800 rounded-full hover:bg-zinc-100 dark:hover:bg-zinc-800 transition text-zinc-500"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
            </Link>
            <div>
                <h1 class="text-3xl font-black text-zinc-900 dark:text-zinc-50">Registrar Docente</h1>
                <p class="text-zinc-500 font-medium">Asignar credenciales de acceso al nuevo maestro.</p>
            </div>
        </div>

        <form @submit.prevent="submit" class="bg-white dark:bg-zinc-900 shadow-xl shadow-zinc-100 dark:shadow-zinc-900/50 rounded-3xl border border-zinc-200 dark:border-zinc-800 p-8 space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Información Personal -->
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-bold text-zinc-900 dark:text-zinc-100 mb-2">Nombre Completo</label>
                        <input 
                            id="name"
                            v-model="form.name"
                            type="text"
                            required
                            placeholder="Ej. Ing. Juan Pérez"
                            class="w-full rounded-xl border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 shadow-sm transition px-4 py-3"
                            :class="{'border-red-500': form.errors.name}"
                        />
                        <p v-if="form.errors.name" class="text-red-500 text-xs font-bold mt-2">{{ form.errors.name }}</p>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-bold text-zinc-900 dark:text-zinc-100 mb-2">Correo Electrónico Institucional</label>
                        <input 
                            id="email"
                            v-model="form.email"
                            type="email"
                            required
                            placeholder="jperez@colegio.edu.ec"
                            class="w-full rounded-xl border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 shadow-sm transition px-4 py-3"
                            :class="{'border-red-500': form.errors.email}"
                        />
                        <p v-if="form.errors.email" class="text-red-500 text-xs font-bold mt-2">{{ form.errors.email }}</p>
                    </div>
                </div>

                <!-- Credenciales -->
                <div class="space-y-6">
                    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-2xl p-4 border border-blue-100 dark:border-blue-900/30">
                        <p class="text-xs text-blue-600 dark:text-blue-400 font-medium">
                            <span class="font-bold">Opcional:</span> Si dejas las contraseñas en blanco, el sistema autogenerará una segura y el maestro deberá usar "Olvidé mi contraseña" para definir una propia.
                        </p>
                    </div>
                    
                    <div>
                        <label for="password" class="block text-sm font-bold text-zinc-900 dark:text-zinc-100 mb-2">Contraseña Inicial (Opcional)</label>
                        <input 
                            id="password"
                            v-model="form.password"
                            type="password"
                            placeholder="••••••••"
                            class="w-full rounded-xl border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 shadow-sm transition px-4 py-3"
                            :class="{'border-red-500': form.errors.password}"
                        />
                        <p v-if="form.errors.password" class="text-red-500 text-xs font-bold mt-2">{{ form.errors.password }}</p>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-zinc-900 dark:text-zinc-100 mb-2">Confirmar Contraseña</label>
                        <input 
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            type="password"
                            placeholder="••••••••"
                            class="w-full rounded-xl border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 shadow-sm transition px-4 py-3"
                        />
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-zinc-200 dark:border-zinc-800 flex items-center justify-end gap-4">
                <Link 
                    :href="currentTeam ? teachersRoutes.index.url({ current_team: currentTeam.slug }) : '#'"
                    class="px-6 py-3 text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white font-bold transition"
                >
                    Cancelar
                </Link>
                <button 
                    type="submit" 
                    :disabled="form.processing"
                    class="px-8 py-3 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-black shadow-lg shadow-blue-500/30 transition-all disabled:opacity-50 flex items-center gap-2"
                >
                    <span v-if="form.processing" class="h-4 w-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                    {{ form.processing ? 'Registrando...' : 'Dar de Alta' }}
                </button>
            </div>
        </form>
    </div>
</template>

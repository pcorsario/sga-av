<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
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

const importForm = useForm({
    file: null as File | null,
});

const isImporting = ref(false);

const submit = () => {
    form.post(teachersRoutes.store.url({ current_team: props.currentTeam?.slug ?? '' }), {
        preserveScroll: true,
    });
};

const importExcel = () => {
    if (!importForm.file) return;
    
    isImporting.value = true;
    importForm.post(teachersRoutes.importExcel.url({ current_team: props.currentTeam?.slug ?? '' }), {
        onFinish: () => isImporting.value = false,
        onError: () => isImporting.value = false,
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
                    class="px-6 py-3 text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:white font-bold transition"
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

        <!-- Sección de Carga Masiva (Excel) -->
        <div class="mt-12 group">
            <div class="bg-zinc-50 dark:bg-zinc-900/50 border border-zinc-200 dark:border-zinc-800 rounded-3xl p-8 flex flex-col md:flex-row items-center justify-between gap-6 transition hover:shadow-xl hover:shadow-zinc-200/50 dark:hover:shadow-none">
                <div class="flex-1">
                    <h2 class="text-xl font-black text-zinc-900 dark:text-zinc-100 flex items-center gap-2">
                        Registro Masivo de Profesores (Excel)
                    </h2>
                    <p class="text-zinc-500 dark:text-zinc-400 font-medium mt-1">Carga la nómina completa de docentes de forma automatizada.</p>
                </div>
                
                <div class="flex items-center gap-3">
                    <a 
                        :href="teachersRoutes.exportTemplate.url({ current_team: props.currentTeam?.slug ?? '' })"
                        class="px-5 py-2.5 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 rounded-xl font-bold flex items-center gap-2 hover:bg-zinc-50 dark:hover:bg-zinc-700 transition shadow-sm"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Plantilla
                    </a>
                    
                    <label class="px-6 py-2.5 bg-zinc-900 dark:bg-zinc-50 text-white dark:text-zinc-900 rounded-xl font-black flex items-center gap-2 hover:opacity-90 transition cursor-pointer shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        Importar Profesores
                        <input 
                            type="file" 
                            class="hidden" 
                            accept=".xlsx, .xls, .csv"
                            @change="(e: any) => {
                                importForm.file = e.target.files[0];
                                importExcel();
                            }"
                        >
                    </label>
                </div>
            </div>
            
            <div v-if="importForm.errors.file" class="mt-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-900/30 rounded-2xl flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                <p class="text-sm font-bold text-red-600 dark:text-red-400">{{ importForm.errors.file }}</p>
            </div>
        </div>

        <!-- Overlay de Carga con Glassmorphism -->
        <div v-if="isImporting" class="fixed inset-0 z-[100] flex items-center justify-center bg-zinc-900/40 backdrop-blur-md transition-all duration-500">
            <div class="bg-white dark:bg-zinc-900 p-8 rounded-3xl shadow-2xl border border-white/20 flex flex-col items-center gap-6 animate-in zoom-in-95 duration-300">
                <div class="relative">
                    <div class="h-16 w-16 border-4 border-blue-500/20 border-t-blue-600 rounded-full animate-spin"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0l-4 4m4-4v12" />
                        </svg>
                    </div>
                </div>
                <div class="text-center">
                    <h3 class="text-xl font-black text-zinc-900 dark:text-zinc-100">Procesando Nómina...</h3>
                    <p class="text-zinc-500 dark:text-zinc-400 font-medium">Estamos registrando a tus profesores en la institución.</p>
                </div>
            </div>
        </div>
    </div>
</template>

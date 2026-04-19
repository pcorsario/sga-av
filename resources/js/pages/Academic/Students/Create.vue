<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { dashboard } from '@/routes';
import studentsRoutes from '@/routes/students';
import type { Team } from '@/types';

const props = defineProps<{
    currentTeam?: Team | null;
    courses: { id: number, name: string, level: string }[];
}>();

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    course_id: '',
});

const fileInput = ref<HTMLInputElement | null>(null);

const importForm = useForm({
    file: null as File | null,
});

const submit = () => {
    form.post(studentsRoutes.store.url({ current_team: props.currentTeam?.slug ?? '' }), {
        preserveScroll: true,
    });
};

const triggerFileSelect = () => {
    fileInput.value?.click();
};

const handleFileUpload = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files.length > 0) {
        importForm.file = target.files[0];
        importForm.post(studentsRoutes.importExcel.url({ current_team: props.currentTeam?.slug ?? '' }), {
            onSuccess: () => {
                importForm.reset();
            },
        });
    }
};

defineOptions({
    layout: (props: { currentTeam?: Team | null }) => ({
        breadcrumbs: [
            {
                title: 'Dashboard Académico',
                href: props.currentTeam ? dashboard(props.currentTeam.slug) : '/',
            },
            {
                title: 'Estudiantes',
                href: props.currentTeam ? studentsRoutes.index.url({ current_team: props.currentTeam.slug }) : '#',
            },
            {
                title: 'Matricular',
                href: '#',
            },
        ],
    }),
});
</script>

<template>
    <Head title="Matricular Estudiante" />

    <div class="px-4 py-8 mx-auto max-w-4xl sm:px-6 lg:px-8">
        <div class="mb-8 flex items-center gap-4">
            <Link 
                :href="currentTeam ? studentsRoutes.index.url({ current_team: currentTeam.slug }) : '#'"
                class="p-2 border border-zinc-200 dark:border-zinc-800 rounded-full hover:bg-zinc-100 dark:hover:bg-zinc-800 transition text-zinc-500"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
            </Link>
            <div>
                <h1 class="text-3xl font-black text-zinc-900 dark:text-zinc-50">Matricular Alumno</h1>
                <p class="text-zinc-500 font-medium">Registra un nuevo estudiante y asígnalo a un curso vigente.</p>
            </div>
        </div>

        <div class="space-y-8">
            <!-- Manual Enrollment Card -->
            <form @submit.prevent="submit" class="bg-white dark:bg-zinc-900 shadow-xl shadow-zinc-100 dark:shadow-zinc-900/50 rounded-3xl border border-zinc-200 dark:border-zinc-800 p-8 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Información Personal -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-black border-b pb-2 dark:border-zinc-800 text-zinc-800 dark:text-zinc-200">Datos Personales</h3>
                        <div>
                            <label for="name" class="block text-sm font-bold text-zinc-900 dark:text-zinc-100 mb-2">Nombres y Apellidos</label>
                            <input 
                                id="name"
                                v-model="form.name"
                                type="text"
                                required
                                class="w-full rounded-xl border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 shadow-sm transition px-4 py-3"
                                :class="{'border-red-500': form.errors.name}"
                            />
                            <p v-if="form.errors.name" class="text-red-500 text-xs font-bold mt-2">{{ form.errors.name }}</p>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-bold text-zinc-900 dark:text-zinc-100 mb-2">Correo Estudiantil / Usuario</label>
                            <input 
                                id="email"
                                v-model="form.email"
                                type="email"
                                required
                                class="w-full rounded-xl border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 shadow-sm transition px-4 py-3"
                                :class="{'border-red-500': form.errors.email}"
                            />
                            <p v-if="form.errors.email" class="text-red-500 text-xs font-bold mt-2">{{ form.errors.email }}</p>
                        </div>
                        
                        <div>
                            <label for="course_id" class="block text-sm font-bold text-zinc-900 dark:text-zinc-100 mb-2">Matricular en Paralelo</label>
                            <select 
                                id="course_id"
                                v-model="form.course_id"
                                required
                                class="w-full rounded-xl border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 shadow-sm transition px-4 py-3"
                                :class="{'border-red-500': form.errors.course_id}"
                            >
                                <option value="" disabled>Seleccione un curso...</option>
                                <option v-for="course in courses" :key="course.id" :value="course.id">
                                    {{ course.name }} ({{ course.level }})
                                </option>
                            </select>
                            <p v-if="form.errors.course_id" class="text-red-500 text-xs font-bold mt-2">{{ form.errors.course_id }}</p>
                        </div>
                    </div>

                    <!-- Credenciales -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-black border-b pb-2 dark:border-zinc-800 text-zinc-800 dark:text-zinc-200">Seguridad</h3>
                        <div>
                            <label for="password" class="block text-sm font-bold text-zinc-900 dark:text-zinc-100 mb-2">Contraseña Temporal</label>
                            <input 
                                id="password"
                                v-model="form.password"
                                type="password"
                                required
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
                                required
                                class="w-full rounded-xl border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 shadow-sm transition px-4 py-3"
                            />
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-zinc-200 dark:border-zinc-800 flex items-center justify-end gap-4">
                    <Link 
                        :href="currentTeam ? studentsRoutes.index.url({ current_team: currentTeam.slug }) : '#'"
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
                        {{ form.processing ? 'Procesando Matrícula...' : 'Registrar Estudiante' }}
                    </button>
                </div>
            </form>

            <!-- Bulk Enrollment Card -->
            <div class="bg-zinc-50 dark:bg-zinc-900/50 border border-zinc-200 dark:border-zinc-800 rounded-3xl p-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <h2 class="text-xl font-bold text-zinc-900 dark:text-zinc-50">Matriculación Masiva (Excel)</h2>
                        <p class="text-zinc-500 text-sm mt-1">Sube una lista de estudiantes para matricularlos de forma automática.</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <input 
                            type="file" 
                            ref="fileInput" 
                            class="hidden" 
                            accept=".xlsx,.xls,.csv"
                            @change="handleFileUpload"
                        >

                        <a 
                            :href="studentsRoutes.exportTemplate.url({ current_team: currentTeam?.slug ?? '' })"
                            class="px-4 py-2 border border-zinc-200 dark:border-zinc-700 text-zinc-600 dark:text-zinc-400 hover:bg-white dark:hover:bg-zinc-800 rounded-xl font-bold transition flex items-center gap-2 text-sm"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
                            </svg>
                            Plantilla
                        </a>

                        <button 
                            @click="triggerFileSelect"
                            :disabled="importForm.processing"
                            class="px-5 py-2 bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 hover:bg-zinc-800 dark:hover:bg-zinc-200 rounded-xl font-bold transition flex items-center gap-2 text-sm disabled:opacity-50"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>
                            </svg>
                            Importar Excel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Premium Loading Overlay -->
    <div v-if="importForm.processing" class="fixed inset-0 z-[100] flex items-center justify-center bg-white/60 dark:bg-zinc-950/60 backdrop-blur-md transition-all">
        <div class="flex flex-col items-center gap-4 p-8 bg-white dark:bg-zinc-900 rounded-3xl shadow-2xl border border-zinc-200 dark:border-zinc-800 animate-in zoom-in duration-300">
            <div class="relative w-20 h-20">
                <div class="absolute inset-0 border-4 border-blue-100 dark:border-blue-900/30 rounded-full"></div>
                <div class="absolute inset-0 border-4 border-blue-600 rounded-full border-t-transparent animate-spin"></div>
            </div>
            <div class="text-center">
                <h3 class="text-xl font-bold text-zinc-900 dark:text-zinc-50">Matriculando por Lote...</h3>
                <p class="text-zinc-500 font-medium">Estamos procesando la lista de estudiantes.</p>
            </div>
        </div>
    </div>
</template>


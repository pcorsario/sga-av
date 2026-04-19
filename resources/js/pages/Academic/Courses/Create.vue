<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { dashboard } from '@/routes';
import coursesRoutes from '@/routes/courses';
import type { Team } from '@/types';

const props = defineProps<{
    currentTeam?: Team | null;
}>();

const form = useForm({
    name: '',
    level: 'Básica Superior',
});

const fileInput = ref<HTMLInputElement | null>(null);

const importForm = useForm({
    file: null as File | null,
});

const submit = () => {
    form.post(coursesRoutes.store.url({ current_team: props.currentTeam?.slug ?? '' }), {
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
        importForm.post(coursesRoutes.importExcel.url({ current_team: props.currentTeam?.slug ?? '' }), {
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
                title: 'Malla Curricular',
                href: props.currentTeam ? coursesRoutes.index.url({ current_team: props.currentTeam.slug }) : '#',
            },
            {
                title: 'Nuevo Curso',
                href: '#',
            },
        ],
    }),
});
</script>

<template>
    <Head title="Nuevo Curso" />

    <div class="px-4 py-8 mx-auto max-w-3xl sm:px-6 lg:px-8">
        <div class="mb-8 flex items-center gap-4">
            <Link 
                :href="currentTeam ? coursesRoutes.index.url({ current_team: currentTeam.slug }) : '#'"
                class="p-2 border border-zinc-200 dark:border-zinc-800 rounded-full hover:bg-zinc-100 dark:hover:bg-zinc-800 transition text-zinc-500"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
            </Link>
            <div>
                <h1 class="text-3xl font-black text-zinc-900 dark:text-zinc-50">Nuevo Curso / Paralelo</h1>
                <p class="text-zinc-500 font-medium">Agrega un nivel educativo a la malla curricular institucional.</p>
            </div>
        </div>

        <div class="space-y-8">
            <!-- Manual Form Card -->
            <form @submit.prevent="submit" class="bg-white dark:bg-zinc-900 shadow-xl shadow-zinc-100 dark:shadow-zinc-900/50 rounded-3xl border border-zinc-200 dark:border-zinc-800 p-8 space-y-8">
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-bold text-zinc-900 dark:text-zinc-100 mb-2">Nombre del Curso (ej. 8vo EGB "A")</label>
                        <input 
                            id="name"
                            v-model="form.name"
                            type="text"
                            required
                            class="w-full rounded-xl border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 shadow-sm transition px-4 py-3 text-zinc-900 dark:text-white"
                            :class="{'border-red-500': form.errors.name}"
                            placeholder="Escribe el nombre identificador del paralelo..."
                        />
                        <p v-if="form.errors.name" class="text-red-500 text-xs font-bold mt-2">{{ form.errors.name }}</p>
                    </div>

                    <div>
                        <label for="level" class="block text-sm font-bold text-zinc-900 dark:text-zinc-100 mb-2">Nivel de Educación</label>
                        <select 
                            id="level"
                            v-model="form.level"
                            required
                            class="w-full rounded-xl border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 shadow-sm transition px-4 py-3 text-zinc-900 dark:text-white"
                            :class="{'border-red-500': form.errors.level}"
                        >
                            <option value="Básica Elemental">Básica Elemental</option>
                            <option value="Básica Media">Básica Media</option>
                            <option value="Básica Superior">Básica Superior</option>
                            <option value="Bachillerato">Bachillerato</option>
                        </select>
                        <p v-if="form.errors.level" class="text-red-500 text-xs font-bold mt-2">{{ form.errors.level }}</p>
                    </div>
                </div>

                <div class="pt-6 border-t border-zinc-200 dark:border-zinc-800 flex items-center justify-end gap-4">
                    <Link 
                        :href="currentTeam ? coursesRoutes.index.url({ current_team: currentTeam.slug }) : '#'"
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
                        {{ form.processing ? 'Guardando...' : 'Crear Curso' }}
                    </button>
                </div>
            </form>

            <!-- Bulk Import Card -->
            <div class="bg-zinc-50 dark:bg-zinc-900/50 border border-zinc-200 dark:border-zinc-800 rounded-3xl p-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <h2 class="text-xl font-bold text-zinc-900 dark:text-zinc-50">Carga Masiva (Excel)</h2>
                        <p class="text-zinc-500 text-sm mt-1">¿Tienes muchos cursos? Impórtalos todos a la vez con un archivo Excel.</p>
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
                            :href="coursesRoutes.exportTemplate.url({ current_team: currentTeam?.slug ?? '' })"
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
                <h3 class="text-xl font-bold text-zinc-900 dark:text-zinc-50">Procesando Importación...</h3>
                <p class="text-zinc-500 font-medium">Estamos configurando tu malla curricular.</p>
            </div>
        </div>
    </div>
</template>


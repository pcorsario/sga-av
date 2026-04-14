<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
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

const submit = () => {
    form.post(coursesRoutes.store.url({ current_team: props.currentTeam?.slug ?? '' }), {
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
    </div>
</template>

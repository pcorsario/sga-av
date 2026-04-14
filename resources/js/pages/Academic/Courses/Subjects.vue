<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import { dashboard } from '@/routes';
import coursesRoutes from '@/routes/courses';
import type { Team } from '@/types';

const props = defineProps<{
    currentTeam?: Team | null;
    course: {
        id: number;
        name: string;
        level: string;
    };
    allSubjects: { id: number, name: string }[];
    assignedIds: number[];
}>();

const form = useForm({
    subjects: props.assignedIds || [],
});

const submit = () => {
    form.post(coursesRoutes.subjects.update.url({ 
        current_team: props.currentTeam?.slug ?? '', 
        course: props.course.id 
    }), {
        preserveScroll: true,
    });
};

defineOptions({
    layout: (props: { currentTeam?: Team | null, course: any }) => ({
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
                title: 'Materias Básicas',
                href: '#',
            },
        ],
    }),
});
</script>

<template>
    <Head title="Materias del Curso" />

    <div class="px-4 py-8 mx-auto max-w-4xl sm:px-6 lg:px-8">
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
                <h1 class="text-3xl font-black text-zinc-900 dark:text-zinc-50">Gestionar Materias</h1>
                <p class="text-zinc-500 font-medium">Asigna el currículo base para <strong class="text-blue-600 dark:text-blue-400">{{ course.name }}</strong> ({{ course.level }}).</p>
            </div>
        </div>

        <form @submit.prevent="submit" class="bg-white dark:bg-zinc-900 shadow-xl shadow-zinc-100 dark:shadow-zinc-900/50 rounded-3xl border border-zinc-200 dark:border-zinc-800 p-8 space-y-8">
            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-2xl p-4 border border-blue-100 dark:border-blue-900/30 flex gap-4">
                 <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 mt-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">
                    Marca abajo todas las asignaturas elementales que conformaran la malla curricular para los estudiantes de este paralelo. 
                    Si desmarcas una materia que ya tenía un profesor o notas, esas asignaciones se eliminarán y se perderá dicho registro. 
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <label 
                    v-for="subject in allSubjects" 
                    :key="subject.id" 
                    class="flex items-center gap-4 p-4 rounded-xl border border-zinc-200 dark:border-zinc-800 cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition duration-200 relative group"
                    :class="{'ring-2 ring-blue-500 border-transparent bg-blue-50 dark:bg-blue-900/10': form.subjects.includes(subject.id)}"
                >
                    <div class="flex items-center h-5">
                        <input 
                            type="checkbox" 
                            :value="subject.id" 
                            v-model="form.subjects"
                            class="w-5 h-5 text-blue-600 border-zinc-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-zinc-800 dark:bg-zinc-700 dark:border-zinc-600 cursor-pointer"
                        />
                    </div>
                    <div class="flex flex-col">
                        <span class="font-bold text-lg text-zinc-900 dark:text-zinc-100 group-hover:text-blue-600 transition">{{ subject.name }}</span>
                    </div>
                </label>
            </div>
            
            <div v-if="allSubjects.length === 0" class="p-8 text-center bg-zinc-50 dark:bg-zinc-800/20 text-zinc-500 dark:text-zinc-400 border border-dashed border-zinc-200 dark:border-zinc-800 rounded-2xl italic font-medium">
                No existen materias globales registradas en el sistema todavía.
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
                    :disabled="form.processing || allSubjects.length === 0"
                    class="px-8 py-3 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-black shadow-lg shadow-blue-500/30 transition-all disabled:opacity-50 flex items-center gap-2"
                >
                    <span v-if="form.processing" class="h-4 w-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                    {{ form.processing ? 'Guardando...' : 'Actualizar Malla del Curso' }}
                </button>
            </div>
        </form>
    </div>
</template>

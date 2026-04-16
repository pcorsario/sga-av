<script setup lang="ts">
import { Head, useForm, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { dashboard } from '@/routes';
import coursesRoutes from '@/routes/courses';
import subjectsRoutes from '@/routes/subjects';
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

const showModal = ref(false);

const newSubjectForm = useForm({
    name: '',
});

const submitNewSubject = () => {
    newSubjectForm.post(subjectsRoutes.store.url({
        current_team: props.currentTeam?.slug ?? ''
    }), {
        preserveScroll: true,
        onSuccess: () => {
            showModal.value = false;
            newSubjectForm.reset();
        },
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
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <Link 
                    :href="currentTeam ? coursesRoutes.index.url({ current_team: currentTeam.slug }) : '#'"
                    class="p-2 border border-zinc-200 dark:border-zinc-800 rounded-full hover:bg-zinc-100 dark:hover:bg-zinc-800 transition text-zinc-500 flex-shrink-0"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                </Link>
                <div>
                    <h1 class="text-3xl font-black text-zinc-900 dark:text-zinc-50">Gestionar Materias</h1>
                    <p class="text-zinc-500 font-medium tracking-tight">Asigna el currículo base para <strong class="text-blue-600 dark:text-blue-400">{{ course.name }}</strong> ({{ course.level }}).</p>
                </div>
            </div>
            <button 
                @click="showModal = true"
                type="button" 
                class="px-4 py-2 bg-zinc-900 hover:bg-zinc-800 dark:bg-white dark:hover:bg-zinc-200 dark:text-zinc-900 text-white rounded-xl font-bold transition flex items-center justify-center gap-2 text-sm shadow-md"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Crear Materia Global
            </button>
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

    <!-- Modal para Nueva Materia Global -->
    <Transition
        enter-active-class="transition duration-300 ease-out"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition duration-200 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-zinc-900/40 dark:bg-zinc-900/80 backdrop-blur-sm p-4">
            <div class="bg-white dark:bg-zinc-900 w-full max-w-md rounded-3xl shadow-2xl overflow-hidden border border-zinc-200 dark:border-zinc-800">
                <div class="p-6 border-b border-zinc-200 dark:border-zinc-800 flex justify-between items-center">
                    <h3 class="text-xl font-black text-zinc-900 dark:text-zinc-50">Nueva Materia Global</h3>
                    <button @click="showModal = false" type="button" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <form @submit.prevent="submitNewSubject" class="p-6 space-y-6">
                    <div>
                        <label for="new_subject_name" class="block text-sm font-bold text-zinc-900 dark:text-zinc-100 mb-2">Nombre de la Materia</label>
                        <input 
                            id="new_subject_name"
                            v-model="newSubjectForm.name"
                            type="text"
                            required
                            placeholder="Ej. Computación Avanzada"
                            class="w-full rounded-xl border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 shadow-sm transition px-4 py-3"
                            :class="{'border-red-500': newSubjectForm.errors.name}"
                        />
                        <p v-if="newSubjectForm.errors.name" class="text-red-500 text-xs font-bold mt-2">{{ newSubjectForm.errors.name }}</p>
                    </div>
                    
                    <div class="flex justify-end gap-3 pt-2">
                        <button 
                            type="button" 
                            @click="showModal = false"
                            class="px-5 py-2.5 text-sm font-bold text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-xl transition"
                        >
                            Cancelar
                        </button>
                        <button 
                            type="submit" 
                            :disabled="newSubjectForm.processing"
                            class="px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-bold shadow-lg shadow-blue-500/30 transition flex items-center gap-2 text-sm disabled:opacity-50"
                        >
                            <span v-if="newSubjectForm.processing" class="h-4 w-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                            Añadir al Sistema
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </Transition>
</template>

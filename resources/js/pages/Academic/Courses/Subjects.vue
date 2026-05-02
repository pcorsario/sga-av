<script setup lang="ts">
import { Head, useForm, Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
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
    allSubjects: { id: number; name: string }[];
    assignedIds: number[];
    otherCourses: { id: number; name: string; level: string; subject_ids: number[] }[];
}>();

const form = useForm({
    subjects: props.assignedIds || [],
});

const search = ref('');
const selectedCourseToCopy = ref<number | null>(null);

const copyFromCourse = () => {
    if (!selectedCourseToCopy.value) return;
    const course = props.otherCourses.find(c => c.id === selectedCourseToCopy.value);
    if (course) {
        form.subjects = [...course.subject_ids];
    }
};

const filteredSubjects = computed(() => {
    if (!search.value) {
        return props.allSubjects;
    }
    const query = search.value.toLowerCase();
    return props.allSubjects.filter(subject => 
        subject.name.toLowerCase().includes(query)
    );
});

const submit = () => {
    form.post(
        coursesRoutes.subjects.update.url({
            current_team: props.currentTeam?.slug ?? '',
            course: props.course.id,
        }),
        {
            preserveScroll: true,
        },
    );
};

const showModal = ref(false);

const newSubjectForm = useForm({
    name: '',
});

const submitNewSubject = () => {
    newSubjectForm.post(
        subjectsRoutes.store.url({
            current_team: props.currentTeam?.slug ?? '',
        }),
        {
            preserveScroll: true,
            onSuccess: () => {
                showModal.value = false;
                newSubjectForm.reset();
            },
        },
    );
};

defineOptions({
    layout: (props: { currentTeam?: Team | null; course: any }) => ({
        breadcrumbs: [
            {
                title: 'Dashboard Académico',
                href: props.currentTeam
                    ? dashboard(props.currentTeam.slug)
                    : '/',
            },
            {
                title: 'Malla Curricular',
                href: props.currentTeam
                    ? coursesRoutes.index.url({
                          current_team: props.currentTeam.slug,
                      })
                    : '#',
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

    <div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
        <div
            class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-center"
        >
            <div class="flex items-center gap-4">
                <Link
                    :href="
                        currentTeam
                            ? coursesRoutes.index.url({
                                  current_team: currentTeam.slug,
                               })
                            : '#'
                    "
                    class="flex-shrink-0 rounded-full border border-zinc-200 p-2 text-zinc-500 transition hover:bg-zinc-100 dark:border-zinc-800 dark:hover:bg-zinc-800"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </Link>
                <div>
                    <h1
                        class="text-3xl font-black text-zinc-900 dark:text-zinc-50"
                    >
                        Gestionar Materias
                    </h1>
                    <p class="font-medium tracking-tight text-zinc-500">
                        Asigna el currículo base para
                        <strong class="text-blue-600 dark:text-blue-400">{{
                            course.name
                        }}</strong>
                        ({{ course.level }}).
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <div class="relative w-full sm:w-auto flex items-center gap-2">
                    <!-- Selector de Curso para Copiar -->
                    <select
                        v-model="selectedCourseToCopy"
                        class="rounded-xl border-zinc-200 bg-white py-2 pl-3 pr-8 text-xs font-bold text-zinc-600 shadow-sm transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-400"
                    >
                        <option :value="null" disabled>Copiar de...</option>
                        <option v-for="c in otherCourses" :key="c.id" :value="c.id">
                            {{ c.name }} ({{ c.level }})
                        </option>
                    </select>
                    <button
                        type="button"
                        @click="copyFromCourse"
                        :disabled="!selectedCourseToCopy"
                        class="flex h-9 items-center justify-center rounded-xl bg-blue-100 px-3 text-xs font-black text-blue-700 transition hover:bg-blue-200 disabled:opacity-50 dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-900/50"
                        title="Copiar materias de este curso"
                    >
                        Copiar
                    </button>
                    
                    <div class="h-6 w-px bg-zinc-200 dark:bg-zinc-800 mx-1"></div>

                    <div class="relative flex-1 sm:w-48">
                        <input
                            v-model="search"
                            type="text"
                            placeholder="Buscar..."
                            class="w-full rounded-full border-zinc-200 bg-white py-2 pr-10 pl-4 text-xs font-medium shadow-sm transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-100"
                        />
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 text-zinc-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <button
                    @click="showModal = true"
                    type="button"
                    class="flex items-center justify-center gap-2 rounded-xl bg-zinc-900 px-4 py-2 text-sm font-bold text-white shadow-md transition hover:bg-zinc-800 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-200"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                            clip-rule="evenodd"
                        />
                    </svg>
                    Crear Materia Global
                </button>
            </div>
        </div>

        <form
            @submit.prevent="submit"
            class="space-y-8 rounded-3xl border border-zinc-200 bg-white p-8 shadow-xl shadow-zinc-100 dark:border-zinc-800 dark:bg-zinc-900 dark:shadow-zinc-900/50"
        >
            <div
                class="flex gap-4 rounded-2xl border border-blue-100 bg-blue-50 p-4 dark:border-blue-900/30 dark:bg-blue-900/20"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="mt-1 h-6 w-6 flex-shrink-0 text-blue-500"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                    />
                </svg>
                <p class="text-sm font-medium text-blue-600 dark:text-blue-400">
                    Marca abajo todas las asignaturas elementales que
                    conformaran la malla curricular para los estudiantes de este
                    paralelo. Si desmarcas una materia que ya tenía un profesor
                    o notas, esas asignaciones se eliminarán y se perderá dicho
                    registro.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <label
                    v-for="subject in filteredSubjects"
                    :key="subject.id"
                    class="group relative flex cursor-pointer items-center gap-4 rounded-xl border border-zinc-200 p-4 transition duration-200 hover:bg-zinc-50 dark:border-zinc-800 dark:hover:bg-zinc-800/50"
                    :class="{
                        'border-transparent bg-blue-50 ring-2 ring-blue-500 dark:bg-blue-900/10':
                            form.subjects.includes(subject.id),
                    }"
                >
                    <div class="flex h-5 items-center">
                        <input
                            type="checkbox"
                            :value="subject.id"
                            v-model="form.subjects"
                            class="h-5 w-5 cursor-pointer rounded border-zinc-300 text-blue-600 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:ring-offset-zinc-800 dark:focus:ring-blue-600"
                        />
                    </div>
                    <div class="flex flex-col">
                        <span
                            class="text-lg font-bold text-zinc-900 transition group-hover:text-blue-600 dark:text-zinc-100"
                            >{{ subject.name }}</span
                        >
                    </div>
                </label>
            </div>

            <div
                v-if="filteredSubjects.length === 0 && search"
                class="rounded-2xl border border-dashed border-zinc-200 bg-zinc-50 p-8 text-center font-medium text-zinc-500 italic dark:border-zinc-800 dark:bg-zinc-800/20 dark:text-zinc-400"
            >
                No se encontraron materias que coincidan con "{{ search }}".
            </div>

            <div
                v-if="allSubjects.length === 0"
                class="rounded-2xl border border-dashed border-zinc-200 bg-zinc-50 p-8 text-center font-medium text-zinc-500 italic dark:border-zinc-800 dark:bg-zinc-800/20 dark:text-zinc-400"
            >
                No existen materias globales registradas en el sistema todavía.
            </div>

            <div
                class="flex items-center justify-end gap-4 border-t border-zinc-200 pt-6 dark:border-zinc-800"
            >
                <Link
                    :href="
                        currentTeam
                            ? coursesRoutes.index.url({
                                  current_team: currentTeam.slug,
                               })
                            : '#'
                    "
                    class="px-6 py-3 font-bold text-zinc-500 transition hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white"
                >
                    Cancelar
                </Link>
                <button
                    type="submit"
                    :disabled="form.processing || allSubjects.length === 0"
                    class="flex items-center gap-2 rounded-xl bg-blue-600 px-8 py-3 font-black text-white shadow-lg shadow-blue-500/30 transition-all hover:bg-blue-500 disabled:opacity-50"
                >
                    <span
                        v-if="form.processing"
                        class="h-4 w-4 animate-spin rounded-full border-2 border-white/30 border-t-white"
                    ></span>
                    {{
                        form.processing
                            ? 'Guardando...'
                            : 'Actualizar Malla del Curso'
                    }}
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
        <div
            v-if="showModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-zinc-900/40 p-4 backdrop-blur-sm dark:bg-zinc-900/80"
        >
            <div
                class="w-full max-w-md overflow-hidden rounded-3xl border border-zinc-200 bg-white shadow-2xl dark:border-zinc-800 dark:bg-zinc-900"
            >
                <div
                    class="flex items-center justify-between border-b border-zinc-200 p-6 dark:border-zinc-800"
                >
                    <h3
                        class="text-xl font-black text-zinc-900 dark:text-zinc-50"
                    >
                        Nueva Materia Global
                    </h3>
                    <button
                        @click="showModal = false"
                        type="button"
                        class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>

                <form @submit.prevent="submitNewSubject" class="space-y-6 p-6">
                    <div>
                        <label
                            for="new_subject_name"
                            class="mb-2 block text-sm font-bold text-zinc-900 dark:text-zinc-100"
                            >Nombre de la Materia</label
                        >
                        <input
                            id="new_subject_name"
                            v-model="newSubjectForm.name"
                            type="text"
                            required
                            placeholder="Ej. Computación Avanzada"
                            class="w-full rounded-xl border-zinc-300 bg-zinc-50 px-4 py-3 shadow-sm transition focus:ring-2 focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-800"
                            :class="{
                                'border-red-500': newSubjectForm.errors.name,
                            }"
                        />
                        <p
                            v-if="newSubjectForm.errors.name"
                            class="mt-2 text-xs font-bold text-red-500"
                        >
                            {{ newSubjectForm.errors.name }}
                        </p>
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <button
                            type="button"
                            @click="showModal = false"
                            class="rounded-xl px-5 py-2.5 text-sm font-bold text-zinc-600 transition hover:bg-zinc-100 dark:text-zinc-400 dark:hover:bg-zinc-800"
                        >
                            Cancelar
                        </button>
                        <button
                            type="submit"
                            :disabled="newSubjectForm.processing"
                            class="flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-blue-500/30 transition hover:bg-blue-500 disabled:opacity-50"
                        >
                            <span
                                v-if="newSubjectForm.processing"
                                class="h-4 w-4 animate-spin rounded-full border-2 border-white/30 border-t-white"
                            ></span>
                            Añadir al Sistema
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </Transition>
</template>

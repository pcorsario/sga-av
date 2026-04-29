<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { dashboard } from '@/routes';
import courses from '@/routes/courses';
import grades from '@/routes/grades';
import parentsRoute from '@/routes/parents';
import students from '@/routes/students';
import teachers from '@/routes/teachers';
import type { Team } from '@/types';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps<{
    currentTeam?: Team | null;
    academic: any;
}>();

const isBoardSettingsModalOpen = ref(false);
const isBoardSettingsSaving = ref(false);
const activeBoardCourse = ref<any>(null);
const activeBoardTrimestre = ref<string>('');
const boardOptionsCatalog = ref<any>({});

const boardSettingsForm = useForm({
    nee_students: '',
    dece_options: [] as number[],
    behavior_options: [] as number[],
    resolution_options: [] as number[],
});

const openBoardSettingsModal = async (course: any, trimestre: string) => {
    activeBoardCourse.value = course;
    activeBoardTrimestre.value = trimestre;
    isBoardSettingsModalOpen.value = true;
    boardOptionsCatalog.value = {};

    try {
        const response = await fetch(`/teachers/courses/${course.id}/board-settings/${trimestre}`);
        const data = await response.json();
        
        boardOptionsCatalog.value = data.options;
        boardSettingsForm.nee_students = data.setting.nee_students || '';
        boardSettingsForm.dece_options = data.setting.dece_options || [];
        boardSettingsForm.behavior_options = data.setting.behavior_options || [];
        boardSettingsForm.resolution_options = data.setting.resolution_options || [];
    } catch (error) {
        console.error('Error fetching board settings', error);
    }
};

const saveBoardSettings = async () => {
    if (!activeBoardCourse.value) return;
    
    isBoardSettingsSaving.value = true;
    try {
        await fetch(`/teachers/courses/${activeBoardCourse.value.id}/board-settings/${activeBoardTrimestre.value}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify(boardSettingsForm.data())
        });
        
        window.open(`/teachers/courses/${activeBoardCourse.value.id}/board-pdf/${activeBoardTrimestre.value}`, '_blank');
        isBoardSettingsModalOpen.value = false;
    } catch (error) {
        console.error('Error saving board settings', error);
    } finally {
        isBoardSettingsSaving.value = false;
    }
};

defineOptions({
    layout: (props: { currentTeam?: Team | null; academic: any }) => ({
        breadcrumbs: [
            {
                title: 'Dashboard Académico',
                href:
                    props.academic?.role === 'profesor'
                        ? teachers.dashboard.url()
                        : props.currentTeam
                          ? dashboard(props.currentTeam.slug)
                          : '/',
            },
        ],
    }),
});
</script>

<template>
    <Head title="Dashboard Académico" />

    <div class="flex h-full flex-1 flex-col gap-6 p-6">
        <!-- Dashboard para Autoridad -->
        <div
            v-if="academic.role === 'autoridad'"
            class="grid gap-6 md:grid-cols-2 lg:grid-cols-4"
        >
            <Link
                :href="
                    students.index.url({
                        current_team: currentTeam?.slug ?? '',
                    })
                "
                class="block rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm transition hover:border-blue-500/50 hover:shadow-md dark:border-zinc-800 dark:bg-zinc-900"
            >
                <h3
                    class="text-sm font-medium tracking-wider text-zinc-500 uppercase dark:text-zinc-400"
                >
                    Estudiantes
                </h3>
                <p
                    class="mt-2 text-4xl font-extrabold text-zinc-900 dark:text-zinc-50"
                >
                    {{ academic.stats.students_count }}
                </p>
                <div
                    class="mt-4 flex items-center gap-1 text-xs font-medium text-blue-600"
                >
                    Gestionar alumnos
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-3 w-3"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </div>
            </Link>
            <Link
                :href="
                    teachers.index.url({
                        current_team: currentTeam?.slug ?? '',
                    })
                "
                class="block rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm transition hover:border-blue-500/50 hover:shadow-md dark:border-zinc-800 dark:bg-zinc-900"
            >
                <h3
                    class="text-sm font-medium tracking-wider text-zinc-500 uppercase dark:text-zinc-400"
                >
                    Profesores
                </h3>
                <p
                    class="mt-2 text-4xl font-extrabold text-zinc-900 dark:text-zinc-50"
                >
                    {{ academic.stats.teachers_count }}
                </p>
                <div
                    class="mt-4 flex items-center gap-1 text-xs font-medium text-blue-600"
                >
                    Gestionar nómina
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-3 w-3"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </div>
            </Link>
            <Link
                :href="
                    courses.index.url({ current_team: currentTeam?.slug ?? '' })
                "
                class="block rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm transition hover:border-blue-500/50 hover:shadow-md dark:border-zinc-800 dark:bg-zinc-900"
            >
                <h3
                    class="text-sm font-medium tracking-wider text-zinc-500 uppercase dark:text-zinc-400"
                >
                    Cursos
                </h3>
                <p
                    class="mt-2 text-4xl font-extrabold text-zinc-900 dark:text-zinc-50"
                >
                    {{ academic.stats.courses_count }}
                </p>
                <div
                    class="mt-4 flex items-center gap-1 text-xs font-medium text-blue-600"
                >
                    Ver malla curricular
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-3 w-3"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </div>
            </Link>
            <Link
                :href="
                    parentsRoute.index.url({
                        current_team: currentTeam?.slug ?? '',
                    })
                "
                class="block rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm transition hover:border-blue-500/50 hover:shadow-md dark:border-zinc-800 dark:bg-zinc-900"
            >
                <h3
                    class="text-sm font-medium tracking-wider text-zinc-500 uppercase dark:text-zinc-400"
                >
                    Padres Familia
                </h3>
                <p
                    class="mt-2 text-4xl font-extrabold text-zinc-900 dark:text-zinc-50"
                >
                    {{ academic.stats.parents_count }}
                </p>
                <div
                    class="mt-4 flex items-center gap-1 text-xs font-medium text-blue-600"
                >
                    Representantes
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-3 w-3"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </div>
            </Link>
        </div>

        <!-- Dashboard para Profesor -->
        <div v-if="academic.role === 'profesor'" class="space-y-12">
            <!-- Cursos Tutorizados -->
            <div v-if="academic.tutored_courses && academic.tutored_courses.length > 0" class="space-y-6">
                <div class="flex items-center justify-between border-b border-zinc-200 pb-4 dark:border-zinc-800">
                    <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-50 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Cursos a mi cargo (Tutor)
                    </h2>
                    <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-600 uppercase dark:bg-amber-900/30 dark:text-amber-400">
                        Tutor
                    </span>
                </div>
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <div v-for="course in academic.tutored_courses" :key="'tutor-'+course.id" class="group relative overflow-hidden rounded-2xl border border-zinc-200 bg-gradient-to-br from-white to-zinc-50 p-6 shadow-sm transition hover:border-amber-500/50 dark:border-zinc-800 dark:bg-gradient-to-br dark:from-zinc-900 dark:to-zinc-800">
                        <div class="absolute top-0 right-0 -mt-8 -mr-8 h-32 w-32 rounded-full bg-amber-500/5 transition group-hover:bg-amber-500/10"></div>
                        <h3 class="text-xl font-black text-zinc-900 dark:text-zinc-100">{{ course.name }}</h3>
                        <p class="mt-1 text-xs tracking-tighter text-amber-600 font-bold uppercase">{{ course.level }}</p>
                        
                        <div class="mt-6 space-y-2 relative z-10">
                            <p class="text-xs font-bold text-zinc-500 dark:text-zinc-400 mb-3 uppercase tracking-wider">Actas Junta de Curso</p>
                            <button @click="openBoardSettingsModal(course, 't1')" class="w-full flex justify-between items-center px-4 py-2 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg text-sm font-medium hover:border-amber-500 hover:text-amber-600 transition-colors">
                                <span>1er Trimestre</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            </button>
                            <button @click="openBoardSettingsModal(course, 't2')" class="w-full flex justify-between items-center px-4 py-2 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg text-sm font-medium hover:border-amber-500 hover:text-amber-600 transition-colors">
                                <span>2do Trimestre</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            </button>
                            <button @click="openBoardSettingsModal(course, 't3')" class="w-full flex justify-between items-center px-4 py-2 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg text-sm font-medium hover:border-amber-500 hover:text-amber-600 transition-colors">
                                <span>3er Trimestre</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Materias Asignadas -->
            <div class="space-y-6">
                <div class="flex items-center justify-between border-b border-zinc-200 pb-4 dark:border-zinc-800">
                    <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-50">
                        Mis Materias Asignadas
                    </h2>
                    <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-600 uppercase dark:bg-blue-900/30 dark:text-blue-400">
                        Docente
                    </span>
                </div>
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <div
                        v-for="asig in academic.assigned_subjects"
                        :key="asig.id"
                        class="group relative overflow-hidden rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm transition hover:border-blue-500/50 dark:border-zinc-800 dark:bg-zinc-900"
                    >
                        <div class="absolute top-0 right-0 -mt-8 -mr-8 h-32 w-32 rounded-full bg-blue-500/5 transition group-hover:bg-blue-500/10"></div>
                        <h3 class="text-xl font-bold text-zinc-900 dark:text-zinc-100">{{ asig.subject.name }}</h3>
                        <p class="mt-1 text-zinc-500">{{ asig.course.name }}</p>
                        <p class="mt-2 text-xs tracking-tighter text-zinc-400 uppercase">{{ asig.course.level }}</p>
                        <Link
                            :href="teachers.grades.edit.url({ courseSubject: asig.id })"
                            class="mt-6 inline-block w-full rounded-xl bg-zinc-900 py-2.5 text-center text-sm font-semibold text-white transition hover:opacity-90 dark:bg-zinc-100 dark:text-zinc-900"
                        >
                            Subir Calificaciones
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dashboard para Estudiante -->
        <div v-if="academic.role === 'estudiante'" class="space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-50">
                    Mi Perfil Académico
                </h2>
                <span
                    class="rounded-full bg-green-100 px-3 py-1 text-xs font-bold text-green-600 uppercase dark:bg-green-900/30 dark:text-green-400"
                    >Estudiante</span
                >
            </div>

            <div
                class="rounded-2xl border bg-gradient-to-r from-blue-600 to-indigo-700 p-6 text-white shadow-lg"
            >
                <p
                    class="text-sm font-medium tracking-widest text-blue-100 uppercase"
                >
                    Matriculado actualmente en:
                </p>
                <p
                    v-if="academic.enrollments.length"
                    class="mt-1 text-3xl font-black"
                >
                    {{ academic.enrollments[0].course.name }}
                </p>
                <p v-else class="mt-1 text-xl font-bold italic opacity-80">
                    No tienes matrículas activas.
                </p>
            </div>

            <div class="space-y-4">
                <h3
                    class="flex items-center gap-2 text-lg font-bold text-zinc-900 dark:text-zinc-50"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 text-blue-500"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                        <path
                            fill-rule="evenodd"
                            d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3z"
                            clip-rule="evenodd"
                        />
                    </svg>
                    Mis Calificaciones
                </h3>
                <div
                    class="overflow-hidden rounded-2xl border border-zinc-200 shadow-sm dark:border-zinc-800"
                >
                    <table class="w-full text-left text-sm">
                        <thead
                            class="bg-zinc-50 text-zinc-500 dark:bg-zinc-800/50 dark:text-zinc-400"
                        >
                            <tr>
                                <th
                                    class="px-6 py-4 text-[10px] font-bold tracking-wider uppercase"
                                >
                                    Materia
                                </th>
                                <th
                                    class="px-3 py-4 text-center text-[10px] font-bold tracking-wider uppercase"
                                >
                                    1T
                                </th>
                                <th
                                    class="px-3 py-4 text-center text-[10px] font-bold tracking-wider uppercase"
                                >
                                    2T
                                </th>
                                <th
                                    class="px-3 py-4 text-center text-[10px] font-bold tracking-wider uppercase"
                                >
                                    3T
                                </th>
                                <th
                                    class="px-4 py-4 text-center text-[10px] font-bold tracking-wider text-blue-500 uppercase"
                                >
                                    Prom.
                                </th>
                                <th
                                    class="px-6 py-4 text-[10px] font-bold tracking-wider uppercase"
                                >
                                    Estado
                                </th>
                            </tr>
                        </thead>
                        <tbody
                            class="divide-y divide-zinc-200 bg-white dark:divide-zinc-800 dark:bg-zinc-900"
                        >
                            <tr
                                v-for="grade in academic.grades"
                                :key="grade.id"
                                class="transition hover:bg-zinc-50 dark:hover:bg-zinc-800/30"
                            >
                                <td
                                    class="px-6 py-4 font-semibold text-zinc-900 dark:text-zinc-100"
                                >
                                    {{ grade.course_subject.subject.name }}
                                </td>
                                <td class="px-3 py-4 text-center font-medium">
                                    {{ grade.t1 ?? '-' }}
                                </td>
                                <td class="px-3 py-4 text-center font-medium">
                                    {{ grade.t2 ?? '-' }}
                                </td>
                                <td class="px-3 py-4 text-center font-medium">
                                    {{ grade.t3 ?? '-' }}
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span
                                        class="text-lg font-black"
                                        :class="
                                            ((parseFloat(grade.t1 || 0) +
                                                parseFloat(grade.t2 || 0) +
                                                parseFloat(grade.t3 || 0)) /
                                                ((grade.t1 !== null ? 1 : 0) +
                                                    (grade.t2 !== null
                                                        ? 1
                                                        : 0) +
                                                    (grade.t3 !== null
                                                        ? 1
                                                        : 0)) || 0) < 7
                                                ? 'text-red-500'
                                                : 'text-blue-600 dark:text-blue-400'
                                        "
                                    >
                                        {{
                                            grade.t1 !== null ||
                                            grade.t2 !== null ||
                                            grade.t3 !== null
                                                ? (
                                                      (parseFloat(
                                                          grade.t1 || 0,
                                                      ) +
                                                          parseFloat(
                                                              grade.t2 || 0,
                                                          ) +
                                                          parseFloat(
                                                              grade.t3 || 0,
                                                          )) /
                                                      ((grade.t1 !== null
                                                          ? 1
                                                          : 0) +
                                                          (grade.t2 !== null
                                                              ? 1
                                                              : 0) +
                                                          (grade.t3 !== null
                                                              ? 1
                                                              : 0))
                                                  ).toFixed(2)
                                                : '-'
                                        }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        v-if="
                                            ((parseFloat(grade.t1 || 0) +
                                                parseFloat(grade.t2 || 0) +
                                                parseFloat(grade.t3 || 0)) /
                                                ((grade.t1 !== null ? 1 : 0) +
                                                    (grade.t2 !== null
                                                        ? 1
                                                        : 0) +
                                                    (grade.t3 !== null
                                                        ? 1
                                                        : 0)) || 0) >= 7
                                        "
                                        class="rounded-full bg-green-100 px-2 py-0.5 text-[10px] font-bold text-green-600 uppercase dark:bg-green-900/30 dark:text-green-400"
                                        >Aprobando</span
                                    >
                                    <span
                                        v-else
                                        class="rounded-full bg-red-100 px-2 py-0.5 text-[10px] font-bold text-red-600 uppercase dark:bg-red-900/30 dark:text-red-400"
                                        >Alerta</span
                                    >
                                </td>
                            </tr>
                            <tr v-if="!academic.grades.length">
                                <td
                                    colspan="6"
                                    class="bg-zinc-50/50 px-6 py-12 text-center text-zinc-500 italic dark:bg-zinc-800/20 dark:text-zinc-400"
                                >
                                    Aún no se han registrado calificaciones en
                                    el sistema.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Dashboard para Padre -->
        <div v-if="academic.role === 'padre'" class="space-y-8">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-50">
                    Gestión de Representados
                </h2>
                <span
                    class="rounded-full bg-purple-100 px-3 py-1 text-xs font-bold text-purple-600 uppercase dark:bg-purple-900/30 dark:text-purple-400"
                    >Representante</span
                >
            </div>

            <div class="grid gap-8">
                <div
                    v-for="child in academic.children"
                    :key="child.id"
                    class="group overflow-hidden rounded-3xl border border-zinc-200 bg-white shadow-sm transition-all duration-300 hover:shadow-xl dark:border-zinc-800 dark:bg-zinc-900"
                >
                    <div class="p-8">
                        <div class="flex items-center gap-6">
                            <div
                                class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-purple-500 to-indigo-600 text-2xl font-black text-white shadow-lg shadow-indigo-500/20"
                            >
                                {{ child.name.charAt(0) }}
                            </div>
                            <div>
                                <h3
                                    class="text-2xl font-black text-zinc-900 dark:text-zinc-50"
                                >
                                    {{ child.name }}
                                </h3>
                                <p
                                    class="mt-0.5 font-medium text-zinc-500 dark:text-zinc-400"
                                    v-if="child.enrollments.length"
                                >
                                    {{ child.enrollments[0].course.name }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-8 grid gap-4 lg:grid-cols-2">
                            <div class="space-y-3">
                                <h4
                                    class="mb-4 text-[10px] font-black tracking-[0.2em] text-zinc-400 uppercase"
                                >
                                    Reporte de Calificaciones
                                </h4>
                                <div
                                    v-for="grade in child.grades"
                                    :key="grade.id"
                                    class="flex items-center justify-between rounded-2xl bg-zinc-50 p-4 transition group-hover:bg-zinc-100 dark:bg-zinc-800/50 dark:group-hover:bg-zinc-800"
                                >
                                    <span
                                        class="font-bold text-zinc-700 dark:text-zinc-300"
                                        >{{
                                            grade.course_subject.subject.name
                                        }}</span
                                    >
                                    <div
                                        class="flex items-center gap-4 text-sm font-medium text-zinc-500"
                                    >
                                        <div
                                            class="flex items-center gap-1"
                                            title="1er Trimestre"
                                        >
                                            <span class="text-[10px] uppercase"
                                                >1T:</span
                                            >
                                            <span
                                                class="text-zinc-800 dark:text-zinc-200"
                                                >{{ grade.t1 ?? '-' }}</span
                                            >
                                        </div>
                                        <div
                                            class="flex items-center gap-1"
                                            title="2do Trimestre"
                                        >
                                            <span class="text-[10px] uppercase"
                                                >2T:</span
                                            >
                                            <span
                                                class="text-zinc-800 dark:text-zinc-200"
                                                >{{ grade.t2 ?? '-' }}</span
                                            >
                                        </div>
                                        <div
                                            class="flex items-center gap-1"
                                            title="3er Trimestre"
                                        >
                                            <span class="text-[10px] uppercase"
                                                >3T:</span
                                            >
                                            <span
                                                class="text-zinc-800 dark:text-zinc-200"
                                                >{{ grade.t3 ?? '-' }}</span
                                            >
                                        </div>
                                        <div
                                            class="mx-2 h-4 w-px bg-zinc-200 dark:bg-zinc-700"
                                        ></div>
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="text-[10px] font-bold tracking-wider text-blue-500 uppercase"
                                                >Promedio:</span
                                            >
                                            <span
                                                class="text-lg font-black"
                                                :class="
                                                    ((parseFloat(
                                                        grade.t1 || 0,
                                                    ) +
                                                        parseFloat(
                                                            grade.t2 || 0,
                                                        ) +
                                                        parseFloat(
                                                            grade.t3 || 0,
                                                        )) /
                                                        ((grade.t1 !== null
                                                            ? 1
                                                            : 0) +
                                                            (grade.t2 !== null
                                                                ? 1
                                                                : 0) +
                                                            (grade.t3 !== null
                                                                ? 1
                                                                : 0)) || 0) < 7
                                                        ? 'text-red-500'
                                                        : 'text-indigo-600 dark:text-indigo-400'
                                                "
                                            >
                                                {{
                                                    grade.t1 !== null ||
                                                    grade.t2 !== null ||
                                                    grade.t3 !== null
                                                        ? (
                                                              (parseFloat(
                                                                  grade.t1 || 0,
                                                              ) +
                                                                  parseFloat(
                                                                      grade.t2 ||
                                                                          0,
                                                                  ) +
                                                                  parseFloat(
                                                                      grade.t3 ||
                                                                          0,
                                                                  )) /
                                                              ((grade.t1 !==
                                                              null
                                                                  ? 1
                                                                  : 0) +
                                                                  (grade.t2 !==
                                                                  null
                                                                      ? 1
                                                                      : 0) +
                                                                  (grade.t3 !==
                                                                  null
                                                                      ? 1
                                                                      : 0))
                                                          ).toFixed(2)
                                                        : '-'
                                                }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <p
                                    v-if="!child.grades.length"
                                    class="rounded-2xl bg-zinc-50 p-4 text-sm text-zinc-500 italic dark:bg-zinc-800/30"
                                >
                                    No hay notas registradas para este periodo.
                                </p>
                            </div>

                            <div
                                class="flex flex-col items-center justify-center space-y-4 rounded-2xl border border-dashed border-zinc-200 bg-zinc-50 p-6 text-center dark:border-zinc-700 dark:bg-zinc-800/30"
                            >
                                <div class="text-sm text-zinc-400 italic">
                                    Próximamente:
                                </div>
                                <p
                                    class="font-bold text-zinc-600 dark:text-zinc-300"
                                >
                                    Registro de Asistencia & Observaciones
                                </p>
                                <button
                                    class="cursor-not-allowed rounded-full bg-zinc-200 px-6 py-2 text-xs font-bold text-zinc-500 uppercase dark:bg-zinc-700"
                                >
                                    Ver Informe Completo
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal para Acta de Junta de Curso -->
        <div v-if="isBoardSettingsModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-xl w-full max-w-4xl max-h-[90vh] flex flex-col">
                <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800 flex justify-between items-center bg-zinc-50 dark:bg-zinc-800/50 rounded-t-2xl">
                    <div>
                        <h3 class="text-lg font-bold text-zinc-800 dark:text-zinc-200">Ajustes Acta Junta de Curso</h3>
                        <p class="text-xs text-zinc-500 uppercase font-bold tracking-wider">{{ activeBoardCourse?.name }} - Trimestre {{ activeBoardTrimestre.replace('t','') }}</p>
                    </div>
                    <button @click="isBoardSettingsModalOpen = false" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <div class="p-6 overflow-y-auto flex-1 custom-scrollbar space-y-8">
                    <!-- NEE -->
                    <div>
                        <h4 class="text-sm font-black text-indigo-600 uppercase tracking-wider mb-4 border-b border-indigo-100 pb-2">Análisis de estudiantes con NEE</h4>
                        <textarea v-model="boardSettingsForm.nee_students" rows="3" placeholder="Detalle el análisis de estudiantes con Necesidades Educativas Específicas..." class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm"></textarea>
                    </div>

                    <!-- DECE -->
                    <div>
                        <h4 class="text-sm font-black text-sky-600 uppercase tracking-wider mb-4 border-b border-sky-100 pb-2">Informe del DECE</h4>
                        <div class="grid grid-cols-1 gap-3">
                            <div v-for="(options, category) in boardOptionsCatalog.dece" :key="category" class="space-y-2">
                                <label v-for="option in options" :key="option.id" class="flex items-start gap-2 text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-200 cursor-pointer">
                                    <input type="checkbox" :value="option.id" v-model="boardSettingsForm.dece_options" class="mt-1 rounded border-zinc-300 text-sky-600 focus:ring-sky-500">
                                    <span class="leading-snug">{{ option.description }}</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Comportamiento -->
                    <div>
                        <h4 class="text-sm font-black text-emerald-600 uppercase tracking-wider mb-4 border-b border-emerald-100 pb-2">Análisis del Comportamiento Estudiantil</h4>
                        <div class="grid grid-cols-1 gap-3">
                            <div v-for="(options, category) in boardOptionsCatalog.comportamiento" :key="category" class="space-y-2">
                                <label v-for="option in options" :key="option.id" class="flex items-start gap-2 text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-200 cursor-pointer">
                                    <input type="checkbox" :value="option.id" v-model="boardSettingsForm.behavior_options" class="mt-1 rounded border-zinc-300 text-emerald-600 focus:ring-emerald-500">
                                    <span class="leading-snug">{{ option.description }}</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Resoluciones -->
                    <div>
                        <h4 class="text-sm font-black text-rose-600 uppercase tracking-wider mb-4 border-b border-rose-100 pb-2">Resoluciones</h4>
                        <div class="grid grid-cols-1 gap-3">
                            <div v-for="(options, category) in boardOptionsCatalog.resolucion" :key="category" class="space-y-2">
                                <label v-for="option in options" :key="option.id" class="flex items-start gap-2 text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-200 cursor-pointer">
                                    <input type="checkbox" :value="option.id" v-model="boardSettingsForm.resolution_options" class="mt-1 rounded border-zinc-300 text-rose-600 focus:ring-rose-500">
                                    <span class="leading-snug">{{ option.description }}</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-800 flex justify-end gap-3 bg-zinc-50 dark:bg-zinc-800/50 rounded-b-2xl">
                    <button @click="isBoardSettingsModalOpen = false" type="button" class="px-4 py-2 text-sm font-bold text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100">
                        Cancelar
                    </button>
                    <button @click="saveBoardSettings" :disabled="isBoardSettingsSaving" type="button" class="px-6 py-2 bg-amber-600 hover:bg-amber-700 text-white text-sm font-bold rounded-xl shadow-md transition-all flex items-center gap-2">
                        <svg v-if="isBoardSettingsSaving" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Guardar y Generar PDF
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { dashboard } from '@/routes';
import courses from '@/routes/courses';
import grades from '@/routes/grades';
import parentsRoute from '@/routes/parents';
import students from '@/routes/students';
import teachers from '@/routes/teachers';
import type { Team } from '@/types';

const props = defineProps<{
    currentTeam?: Team | null;
    academic: any;
}>();

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
        <div v-if="academic.role === 'profesor'" class="space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-50">
                    Mis Materias Asignadas
                </h2>
                <span
                    class="rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-600 uppercase dark:bg-blue-900/30 dark:text-blue-400"
                    >Docente</span
                >
            </div>
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                <div
                    v-for="asig in academic.assigned_subjects"
                    :key="asig.id"
                    class="group relative overflow-hidden rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm transition hover:border-blue-500/50 dark:border-zinc-800 dark:bg-zinc-900"
                >
                    <div
                        class="absolute top-0 right-0 -mt-8 -mr-8 h-32 w-32 rounded-full bg-blue-500/5 transition group-hover:bg-blue-500/10"
                    ></div>
                    <h3
                        class="text-xl font-bold text-zinc-900 dark:text-zinc-100"
                    >
                        {{ asig.subject.name }}
                    </h3>
                    <p class="mt-1 text-zinc-500">{{ asig.course.name }}</p>
                    <p
                        class="mt-2 text-xs tracking-tighter text-zinc-400 uppercase"
                    >
                        {{ asig.course.level }}
                    </p>
                    <Link
                        :href="
                            teachers.grades.edit.url({ courseSubject: asig.id })
                        "
                        class="mt-6 inline-block w-full rounded-xl bg-zinc-900 py-2.5 text-center text-sm font-semibold text-white transition hover:opacity-90 dark:bg-zinc-100 dark:text-zinc-900"
                    >
                        Subir Calificaciones
                    </Link>
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
    </div>
</template>

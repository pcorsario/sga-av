<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import { dashboard } from '@/routes';
import coursesRoutes from '@/routes/courses';
import type { Team } from '@/types';

const props = defineProps<{
    currentTeam?: Team | null;
    courses: any[];
}>();

// Group courses by level
const groupedCourses = computed(() => {
    const groups: Record<string, any[]> = {};
    props.courses.forEach((course) => {
        const levelName = course.level || 'General';

        if (!groups[levelName]) {
            groups[levelName] = [];
        }

        groups[levelName].push(course);
    });

    return groups;
});

defineOptions({
    layout: (props: { currentTeam?: Team | null }) => ({
        breadcrumbs: [
            {
                title: 'Dashboard Académico',
                href: props.currentTeam
                    ? dashboard(props.currentTeam.slug)
                    : '/',
            },
            {
                title: 'Malla Curricular',
                href: '#',
            },
        ],
    }),
});
</script>

<template>
    <Head title="Malla Curricular" />

    <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
        <div
            class="mb-8 flex flex-col justify-between gap-4 md:flex-row md:items-center"
        >
            <div>
                <h1 class="text-3xl font-black text-zinc-900 dark:text-zinc-50">
                    Malla Curricular d
                </h1>
                <p class="font-medium text-zinc-500">
                    Gestión de cursos, paralelos y sus respectivas materias
                    base.
                </p>
            </div>

            <Link
                :href="
                    coursesRoutes.create.url({
                        current_team: currentTeam?.slug ?? '',
                    })
                "
                class="flex items-center gap-2 rounded-xl bg-blue-600 px-6 py-3 font-bold text-white shadow-lg shadow-blue-500/30 transition hover:bg-blue-500"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                >
                    <path
                        fill-rule="evenodd"
                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                        clip-rule="evenodd"
                    />
                </svg>
                Nuevo Curso
            </Link>
        </div>

        <div class="space-y-12">
            <div
                v-for="(coursesList, levelName) in groupedCourses"
                :key="levelName"
                class="space-y-6"
            >
                <!-- Nivel Educativo Encabezado -->
                <div class="flex items-center gap-4">
                    <h2
                        class="text-2xl font-black text-zinc-900 dark:text-zinc-100"
                    >
                        {{ levelName }}
                    </h2>
                    <div class="h-px flex-1 bg-zinc-200 dark:bg-zinc-800"></div>
                </div>

                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    <!-- Tarjeta de Curso -->
                    <div
                        v-for="course in coursesList"
                        :key="course.id"
                        class="group flex flex-col overflow-hidden rounded-3xl border border-zinc-200 bg-white shadow-sm transition-all duration-300 hover:shadow-xl dark:border-zinc-800 dark:bg-zinc-900"
                    >
                        <!-- Header del Curso -->
                        <div
                            class="flex items-start justify-between border-b border-zinc-200 bg-zinc-50 p-6 dark:border-zinc-800 dark:bg-zinc-800/30"
                        >
                            <div>
                                <h3
                                    class="text-xl font-black text-zinc-900 transition group-hover:text-blue-600 dark:text-zinc-50 dark:group-hover:text-blue-400"
                                >
                                    {{ course.name }}
                                </h3>
                                <p
                                    class="mt-1 text-xs font-semibold tracking-wider text-zinc-400 uppercase"
                                >
                                    {{ course.subjects.length }} Materias Base
                                </p>
                            </div>
                            <div
                                class="rounded-xl bg-blue-100 p-2 text-sm font-bold text-blue-600 dark:bg-blue-900/30 dark:text-blue-400"
                            >
                                ID: {{ course.id }}
                            </div>
                        </div>

                        <!-- Lista de Materias -->
                        <div class="flex-1 p-6">
                            <ul
                                v-if="course.subjects.length > 0"
                                class="space-y-3"
                            >
                                <li
                                    v-for="subject in course.subjects"
                                    :key="subject.id"
                                    class="flex items-center gap-3"
                                >
                                    <div
                                        class="h-1.5 w-1.5 rounded-full bg-blue-500"
                                    ></div>
                                    <span
                                        class="font-medium text-zinc-700 dark:text-zinc-300"
                                        >{{ subject.name }}</span
                                    >
                                </li>
                            </ul>
                            <div
                                v-else
                                class="flex h-full items-center justify-center py-6 text-sm text-zinc-500 italic"
                            >
                                Este curso carece de materias asociadas.
                            </div>
                        </div>

                        <!-- Acciones -->
                        <div
                            class="flex justify-end gap-2 border-t border-zinc-100 bg-white p-4 dark:border-zinc-800/50 dark:bg-zinc-900"
                        >
                            <Link
                                :href="
                                    coursesRoutes.subjects.url({
                                        current_team: currentTeam?.slug ?? '',
                                        course: course.id,
                                    })
                                "
                                class="px-4 py-2 text-sm font-semibold text-blue-600 transition hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300"
                            >
                                Gestionar Materias
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty State Global -->
            <div
                v-if="Object.keys(groupedCourses).length === 0"
                class="rounded-3xl border border-dashed border-zinc-300 bg-zinc-50 p-12 text-center dark:border-zinc-700 dark:bg-zinc-800/30"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="mx-auto mb-4 h-12 w-12 text-zinc-400"
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
                <h3 class="text-xl font-bold text-zinc-900 dark:text-zinc-50">
                    Base Académica Vacía
                </h3>
                <p class="mt-2 text-zinc-500">
                    No se han registrado cursos en la malla curricular todavía.
                </p>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { dashboard } from '@/routes';
import studentsRoutes from '@/routes/students';
import type { Team } from '@/types';
import { debounce } from 'lodash';

const props = defineProps<{
    currentTeam?: Team | null;
    students: any;
    filters?: { search?: string };
}>();

const search = ref(props.filters?.search || '');

watch(
    search,
    debounce((value) => {
        router.get(
            studentsRoutes.index.url({
                current_team: props.currentTeam?.slug ?? '',
            }),
            { search: value },
            { preserveState: true, replace: true },
        );
    }, 500),
);

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
                title: 'Estudiantes',
                href: '#',
            },
        ],
    }),
});
</script>

<template>
    <Head title="Directorio Estudiantil" />

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div
            class="mb-8 flex flex-col justify-between gap-4 md:flex-row md:items-center"
        >
            <div>
                <h1 class="text-3xl font-black text-zinc-900 dark:text-zinc-50">
                    Directorio Estudiantil
                </h1>
                <p class="font-medium text-zinc-500">
                    Gestión de alumnos, matrículas a cursos y perfiles
                    escolares.
                </p>
            </div>

            <Link
                :href="
                    studentsRoutes.create.url({
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
                Matricular Alumno
            </Link>
        </div>

        <div class="space-y-4">
            <!-- Barra de Herramientas / Búsqueda -->
            <div class="flex items-center justify-between gap-4">
                <div class="relative max-w-md flex-1">
                    <div
                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4"
                    >
                        <svg
                            class="h-5 w-5 text-zinc-400"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </div>
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Buscar por nombre o correo electrónico..."
                        class="block w-full rounded-2xl border border-zinc-200 bg-white py-3 pr-4 pl-11 text-sm shadow-sm transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-100"
                    />
                </div>
            </div>

            <div
                class="relative overflow-hidden rounded-3xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900"
            >
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs whitespace-nowrap">
                        <thead
                            class="border-b border-zinc-200 bg-zinc-50 text-[10px] tracking-wider text-zinc-500 uppercase dark:border-zinc-800 dark:bg-zinc-800/50 dark:text-zinc-400"
                        >
                            <tr>
                                <th
                                    class="flex items-center gap-2 px-6 py-4 font-bold"
                                >
                                    Estudiante
                                </th>
                                <th class="px-6 py-4 font-bold">
                                    Matriculado En
                                </th>
                                <th class="px-6 py-4 text-center font-bold">
                                    Registro
                                </th>
                                <th class="px-6 py-4 text-right font-bold">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody
                            class="divide-y divide-zinc-200 dark:divide-zinc-800"
                        >
                            <tr
                                v-for="student in students.data"
                                :key="student.id"
                                class="transition hover:bg-zinc-50 dark:hover:bg-zinc-800/30"
                            >
                                <td class="px-6 py-2.5">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 font-bold text-white shadow-md"
                                        >
                                            {{ student.name.charAt(0) }}
                                        </div>
                                        <div>
                                            <div
                                                class="text-sm font-bold text-zinc-900 dark:text-zinc-100"
                                            >
                                                {{ student.name }}
                                            </div>
                                            <div
                                                class="mt-0.5 text-xs text-zinc-500 dark:text-zinc-400"
                                            >
                                                {{ student.email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-2.5">
                                    <span
                                        v-if="
                                            student.enrollments &&
                                            student.enrollments.length > 0
                                        "
                                        class="inline-flex items-center rounded-full bg-indigo-100 px-2.5 py-1 text-xs font-bold text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400"
                                    >
                                        {{ student.enrollments[0].course.name }}
                                    </span>
                                    <span
                                        v-else
                                        class="text-xs font-semibold text-zinc-400 italic"
                                    >
                                        Sin matrícula
                                    </span>
                                </td>
                                <td
                                    class="px-6 py-2.5 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400"
                                >
                                    {{
                                        new Date(
                                            student.created_at,
                                        ).toLocaleDateString('es-ES')
                                    }}
                                </td>
                                <td
                                    class="flex justify-end gap-3 px-6 py-2.5 text-right"
                                >
                                    <Link
                                        :href="
                                            studentsRoutes.edit.url({
                                                current_team:
                                                    currentTeam?.slug ?? '',
                                                student: student.id,
                                            })
                                        "
                                        class="rounded-lg px-3 py-1.5 text-sm font-medium text-blue-600 transition hover:bg-blue-50 hover:text-blue-900 dark:text-blue-400 dark:hover:bg-blue-900/20 dark:hover:text-blue-300"
                                    >
                                        Editar / Mover
                                    </Link>
                                    <button
                                        class="rounded-lg px-3 py-1.5 text-sm font-medium text-red-500 transition hover:bg-red-50 hover:text-red-700 dark:text-red-400 dark:hover:bg-red-900/20 dark:hover:text-red-300"
                                        title="Desmatricular alumno (Pronto)"
                                    >
                                        Baja
                                    </button>
                                </td>
                            </tr>
                            <tr
                                v-if="
                                    (!students.data && !students.length) ||
                                    (students.data &&
                                        students.data.length === 0)
                                "
                            >
                                <td
                                    colspan="4"
                                    class="px-6 py-12 text-center text-zinc-500 italic dark:text-zinc-400"
                                >
                                    <div
                                        class="flex flex-col items-center justify-center"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="mb-4 h-10 w-10 opacity-20"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                                            />
                                        </svg>
                                        No se encontraron estudiantes
                                        matriculados en la institución.
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Paginación Simple -->
                <div
                    v-if="students.links && students.links.length > 3"
                    class="flex justify-center gap-2 border-t border-zinc-200 bg-zinc-50 px-6 py-4 dark:border-zinc-800 dark:bg-zinc-800/30"
                >
                    <template v-for="(link, p) in students.links" :key="p">
                        <div
                            v-if="link.url === null"
                            class="cursor-not-allowed rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm text-zinc-400 dark:border-zinc-800 dark:bg-zinc-900"
                            v-html="link.label"
                        ></div>
                        <Link
                            v-else
                            :href="link.url"
                            class="rounded-lg border px-4 py-2 text-sm transition"
                            :class="
                                link.active
                                    ? 'border-blue-600 bg-blue-600 font-bold text-white'
                                    : 'border-zinc-200 bg-white text-zinc-700 hover:bg-zinc-50 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-300 dark:hover:bg-zinc-800'
                            "
                            v-html="link.label"
                        />
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

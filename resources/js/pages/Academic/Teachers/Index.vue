<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { dashboard } from '@/routes';
import teachersRoutes from '@/routes/teachers';
import type { Team } from '@/types';

const props = defineProps<{
    currentTeam?: Team | null;
    teachers: any; // Paginator object
    filters: { search: string };
}>();

const search = ref(props.filters.search || '');

watch(search, (value) => {
    router.get(
        teachersRoutes.index.url({
            current_team: props.currentTeam?.slug ?? '',
        }),
        { search: value },
        {
            preserveState: true,
            replace: true,
            preserveScroll: true,
        },
    );
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
                title: 'Nómina de Profesores',
                href: '#',
            },
        ],
    }),
});
</script>

<template>
    <Head title="Nómina de Profesores" />

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div
            class="mb-8 flex flex-col justify-between gap-4 md:flex-row md:items-center"
        >
            <div>
                <h1 class="text-3xl font-black text-zinc-900 dark:text-zinc-50">
                    Cuerpo Docente
                </h1>
                <p class="font-medium text-zinc-500">
                    Gestión administrativa de profesores y asignaciones
                </p>
            </div>

            <div class="flex flex-col items-center gap-4 sm:flex-row">
                <div class="group relative w-full sm:w-80">
                    <div
                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-zinc-400 transition-colors group-focus-within:text-blue-500"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
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
                        placeholder="Buscar por nombre o correo..."
                        class="block w-full rounded-2xl border border-zinc-200 bg-white py-3 pr-4 pl-11 leading-5 placeholder-zinc-400 shadow-sm transition-all focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none sm:text-sm dark:border-zinc-700 dark:bg-zinc-800"
                    />
                </div>

                <Link
                    :href="
                        teachersRoutes.create.url({
                            current_team: currentTeam?.slug ?? '',
                        })
                    "
                    class="flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 py-3 font-bold text-white shadow-lg shadow-blue-500/30 transition-all hover:bg-blue-500 sm:w-auto"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                            clip-rule="evenodd"
                        />
                    </svg>
                    Añadir Profesor
                </Link>
            </div>
        </div>

        <div
            class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900"
        >
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead
                        class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-800 dark:bg-zinc-800/50"
                    >
                        <tr>
                            <th
                                class="px-6 py-4 text-xs font-black tracking-widest text-zinc-500 uppercase dark:text-zinc-400"
                            >
                                Profesor
                            </th>
                            <th
                                class="px-6 py-4 text-center text-xs font-black tracking-widest text-zinc-500 uppercase dark:text-zinc-400"
                            >
                                Materias Asignadas
                            </th>
                            <th
                                class="px-6 py-4 text-center text-xs font-black tracking-widest text-zinc-500 uppercase dark:text-zinc-400"
                            >
                                Ingreso al Sistema
                            </th>
                            <th
                                class="px-6 py-4 text-right text-xs font-black tracking-widest text-zinc-500 uppercase dark:text-zinc-400"
                            >
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody
                        class="divide-y divide-zinc-200 dark:divide-zinc-800"
                    >
                        <tr
                            v-for="teacher in teachers.data || teachers"
                            :key="teacher.id"
                            class="transition hover:bg-zinc-50 dark:hover:bg-zinc-800/20"
                        >
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 text-sm font-black text-white shadow"
                                    >
                                        {{ teacher.name.charAt(0) }}
                                    </div>
                                    <div>
                                        <div
                                            class="font-bold text-zinc-900 dark:text-zinc-100"
                                        >
                                            {{ teacher.name }}
                                        </div>
                                        <div class="text-sm text-zinc-500">
                                            {{ teacher.email }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-600 dark:bg-blue-900/30 dark:text-blue-400"
                                >
                                    {{ teacher.assigned_subjects_count || 0 }}
                                    Materias
                                </span>
                            </td>
                            <td
                                class="px-6 py-4 text-center text-sm font-medium text-zinc-500 dark:text-zinc-400"
                            >
                                {{
                                    new Date(
                                        teacher.created_at,
                                    ).toLocaleDateString('es-ES')
                                }}
                            </td>
                            <td
                                class="flex justify-end gap-4 px-6 py-4 text-right"
                            >
                                <Link
                                    :href="
                                        teachersRoutes.subjects.url({
                                            current_team:
                                                currentTeam?.slug ?? '',
                                            teacher: teacher.id,
                                        })
                                    "
                                    class="text-sm font-medium text-emerald-600 transition hover:text-emerald-900 dark:text-emerald-400 dark:hover:text-emerald-300"
                                >
                                    Carga Horaria
                                </Link>
                                <Link
                                    :href="
                                        teachersRoutes.edit.url({
                                            current_team:
                                                currentTeam?.slug ?? '',
                                            teacher: teacher.id,
                                        })
                                    "
                                    class="text-sm font-medium text-blue-600 transition hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300"
                                >
                                    Editar
                                </Link>
                            </td>
                        </tr>
                        <tr
                            v-if="
                                (!teachers.data && !teachers.length) ||
                                (teachers.data && teachers.data.length === 0)
                            "
                        >
                            <td
                                colspan="4"
                                class="px-6 py-12 text-center text-zinc-500 italic"
                            >
                                No hay profesores registrados en la nómina.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div
                class="flex flex-col items-center justify-between gap-4 border-t border-zinc-200 bg-zinc-50 px-6 py-4 sm:flex-row dark:border-zinc-800 dark:bg-zinc-900/50"
            >
                <span class="text-sm font-medium text-zinc-500">
                    Mostrando {{ teachers.from || 0 }} a
                    {{ teachers.to || 0 }} de {{ teachers.total }} profesores
                </span>

                <div class="flex gap-2">
                    <Link
                        v-if="teachers.prev_page_url"
                        :href="teachers.prev_page_url"
                        class="rounded-lg border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-800"
                    >
                        Anterior
                    </Link>
                    <Link
                        v-if="teachers.next_page_url"
                        :href="teachers.next_page_url"
                        class="rounded-lg border border-blue-600 bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700"
                    >
                        Siguiente
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>

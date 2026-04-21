<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { dashboard } from '@/routes';
import parentsRoutes from '@/routes/parents';
import type { Team } from '@/types';

const props = defineProps<{
    currentTeam?: Team | null;
    parents: any;
}>();

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
                title: 'Padres de Familia',
                href: '#',
            },
        ],
    }),
});
</script>

<template>
    <Head title="Representantes" />

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div
            class="mb-8 flex flex-col justify-between gap-4 md:flex-row md:items-center"
        >
            <div>
                <h1 class="text-3xl font-black text-zinc-900 dark:text-zinc-50">
                    Directorio de Representantes
                </h1>
                <p class="font-medium text-zinc-500">
                    Gestión de padres de familia y vinculación con estudiantes.
                </p>
            </div>

            <Link
                :href="
                    parentsRoutes.create.url({
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
                Registrar Representante
            </Link>
        </div>

        <div
            class="relative overflow-hidden rounded-3xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900"
        >
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead
                        class="border-b border-zinc-200 bg-zinc-50 text-xs tracking-wider text-zinc-500 uppercase dark:border-zinc-800 dark:bg-zinc-800/50 dark:text-zinc-400"
                    >
                        <tr>
                            <th class="px-6 py-4 font-bold">
                                Representante Legal
                            </th>
                            <th class="px-6 py-4 font-bold">
                                Representados (Hijos)
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
                            v-for="parent in parents.data"
                            :key="parent.id"
                            class="transition hover:bg-zinc-50 dark:hover:bg-zinc-800/30"
                        >
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 font-bold text-white shadow-md"
                                    >
                                        {{ parent.name.charAt(0) }}
                                    </div>
                                    <div>
                                        <div
                                            class="font-bold text-zinc-900 dark:text-zinc-100"
                                        >
                                            {{ parent.name }}
                                        </div>
                                        <div
                                            class="mt-0.5 text-xs text-zinc-500 dark:text-zinc-400"
                                        >
                                            {{ parent.email }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div
                                    v-if="
                                        parent.children &&
                                        parent.children.length > 0
                                    "
                                    class="flex flex-col gap-1"
                                >
                                    <div
                                        v-for="child in parent.children"
                                        :key="child.id"
                                        class="flex items-center gap-2"
                                    >
                                        <span
                                            class="inline-flex items-center rounded bg-blue-100 px-2 py-0.5 text-xs font-semibold text-blue-700 dark:bg-blue-900/30 dark:text-blue-400"
                                        >
                                            {{ child.name }}
                                        </span>
                                        <span class="text-xs text-zinc-400">
                                            ({{
                                                child.enrollments?.[0]?.course
                                                    ?.name ?? 'Sin curso'
                                            }})
                                        </span>
                                    </div>
                                </div>
                                <span
                                    v-else
                                    class="text-xs font-semibold text-zinc-400 italic"
                                >
                                    Ningún alumno asignado
                                </span>
                            </td>
                            <td
                                class="flex justify-end gap-3 px-6 py-4 text-right"
                            >
                                <Link
                                    :href="
                                        parentsRoutes.edit.url({
                                            current_team:
                                                currentTeam?.slug ?? '',
                                            parent: parent.id,
                                        })
                                    "
                                    class="rounded-lg px-3 py-1.5 text-sm font-medium text-blue-600 transition hover:bg-blue-50 hover:text-blue-900 dark:text-blue-400 dark:hover:bg-blue-900/20 dark:hover:text-blue-300"
                                >
                                    Editar Perfil
                                </Link>
                                <button
                                    class="rounded-lg px-3 py-1.5 text-sm font-medium text-red-500 transition hover:bg-red-50 hover:text-red-700 dark:text-red-400 dark:hover:bg-red-900/20 dark:hover:text-red-300"
                                >
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                        <tr
                            v-if="
                                (!parents.data && !parents.length) ||
                                (parents.data && parents.data.length === 0)
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
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                                        />
                                    </svg>
                                    No se encontraron representantes registrados
                                    en la institución.
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Paginación Simple -->
            <div
                v-if="parents.links && parents.links.length > 3"
                class="flex justify-center gap-2 border-t border-zinc-200 bg-zinc-50 px-6 py-4 dark:border-zinc-800 dark:bg-zinc-800/30"
            >
                <template v-for="(link, p) in parents.links" :key="p">
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
</template>

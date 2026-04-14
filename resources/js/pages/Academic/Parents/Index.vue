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
                href: props.currentTeam ? dashboard(props.currentTeam.slug) : '/',
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

    <div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black text-zinc-900 dark:text-zinc-50">Directorio de Representantes</h1>
                <p class="text-zinc-500 font-medium">Gestión de padres de familia y vinculación con estudiantes.</p>
            </div>
            
            <Link 
                :href="parentsRoutes.create.url({ current_team: currentTeam?.slug ?? '' })"
                class="px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-bold transition shadow-lg shadow-blue-500/30 flex items-center gap-2" 
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Registrar Representante
            </Link>
        </div>

        <div class="bg-white dark:bg-zinc-900 rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden relative">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-zinc-50 dark:bg-zinc-800/50 text-zinc-500 dark:text-zinc-400 border-b border-zinc-200 dark:border-zinc-800 uppercase tracking-wider text-xs">
                        <tr>
                            <th class="px-6 py-4 font-bold">Representante Legal</th>
                            <th class="px-6 py-4 font-bold">Representados (Hijos)</th>
                            <th class="px-6 py-4 font-bold text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        <tr v-for="parent in parents.data" :key="parent.id" class="hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white font-bold shadow-md">
                                        {{ parent.name.charAt(0) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-zinc-900 dark:text-zinc-100">{{ parent.name }}</div>
                                        <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">{{ parent.email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div v-if="parent.children && parent.children.length > 0" class="flex flex-col gap-1">
                                    <div v-for="child in parent.children" :key="child.id" class="flex items-center gap-2">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400">
                                            {{ child.name }}
                                        </span>
                                        <span class="text-xs text-zinc-400">
                                            ({{ child.enrollments?.[0]?.course?.name ?? 'Sin curso' }})
                                        </span>
                                    </div>
                                </div>
                                <span v-else class="text-xs font-semibold text-zinc-400 italic">
                                    Ningún alumno asignado
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right flex justify-end gap-3">
                                <Link 
                                    :href="parentsRoutes.edit.url({ current_team: currentTeam?.slug ?? '', parent: parent.id })"
                                    class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 font-medium text-sm transition px-3 py-1.5 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/20"
                                >
                                    Editar Perfil
                                </Link>
                                <button
                                    class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 font-medium text-sm transition px-3 py-1.5 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20"
                                >
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                        <tr v-if="(!parents.data && !parents.length) || (parents.data && parents.data.length === 0)">
                            <td colspan="4" class="px-6 py-12 text-center text-zinc-500 italic dark:text-zinc-400">
                                <div class="flex flex-col items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mb-4 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    No se encontraron representantes registrados en la institución.
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Paginación Simple -->
            <div v-if="parents.links && parents.links.length > 3" class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-800/30 flex justify-center gap-2">
                 <template v-for="(link, p) in parents.links" :key="p">
                    <div 
                        v-if="link.url === null" 
                        class="px-4 py-2 text-sm text-zinc-400 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-lg cursor-not-allowed" 
                        v-html="link.label">
                    </div>
                    <Link 
                        v-else
                        :href="link.url"
                        class="px-4 py-2 text-sm border rounded-lg transition"
                        :class="link.active ? 'bg-blue-600 text-white border-blue-600 font-bold' : 'bg-white dark:bg-zinc-900 text-zinc-700 dark:text-zinc-300 border-zinc-200 dark:border-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-800'"
                        v-html="link.label"
                    />
                 </template>
            </div>
        </div>
    </div>
</template>

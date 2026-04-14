<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { dashboard } from '@/routes';
import teachersRoutes from '@/routes/teachers';
import type { Team } from '@/types';

const props = defineProps<{
    currentTeam?: Team | null;
    teachers: any; // Paginator object
}>();

defineOptions({
    layout: (props: { currentTeam?: Team | null }) => ({
        breadcrumbs: [
            {
                title: 'Dashboard Académico',
                href: props.currentTeam ? dashboard(props.currentTeam.slug) : '/',
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

    <div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-black text-zinc-900 dark:text-zinc-50">Cuerpo Docente</h1>
                <p class="text-zinc-500 font-medium">Gestión administrativa de profesores y asignaciones</p>
            </div>
            <div>
                <Link 
                    :href="teachersRoutes.create.url({ current_team: currentTeam?.slug ?? '' })"
                    class="px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-bold transition-all shadow-lg shadow-blue-500/30 flex items-center gap-2"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Añadir Profesor
                </Link>
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-900 shadow-sm rounded-2xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-zinc-50 dark:bg-zinc-800/50 border-b border-zinc-200 dark:border-zinc-800">
                        <tr>
                            <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-zinc-500 dark:text-zinc-400">Profesor</th>
                            <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-zinc-500 dark:text-zinc-400 text-center">Materias Asignadas</th>
                            <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-zinc-500 dark:text-zinc-400 text-center">Ingreso al Sistema</th>
                            <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-zinc-500 dark:text-zinc-400 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        <tr v-for="teacher in (teachers.data || teachers)" :key="teacher.id" class="hover:bg-zinc-50 dark:hover:bg-zinc-800/20 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-black text-sm shadow">
                                        {{ teacher.name.charAt(0) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-zinc-900 dark:text-zinc-100">{{ teacher.name }}</div>
                                        <div class="text-sm text-zinc-500">{{ teacher.email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-xs font-bold rounded-full">
                                    {{ teacher.assigned_subjects_count || 0 }} Materias
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center text-sm text-zinc-500 dark:text-zinc-400 font-medium">
                                {{ new Date(teacher.created_at).toLocaleDateString('es-ES') }}
                            </td>
                            <td class="px-6 py-4 text-right flex justify-end gap-4">
                                <Link 
                                    :href="teachersRoutes.subjects.url({ current_team: currentTeam?.slug ?? '', teacher: teacher.id })"
                                    class="text-emerald-600 hover:text-emerald-900 dark:text-emerald-400 dark:hover:text-emerald-300 font-medium text-sm transition"
                                >
                                    Carga Horaria
                                </Link>
                                <Link 
                                    :href="teachersRoutes.edit.url({ current_team: currentTeam?.slug ?? '', teacher: teacher.id })"
                                    class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 font-medium text-sm transition"
                                >
                                    Editar
                                </Link>
                            </td>
                        </tr>
                        <tr v-if="(!teachers.data && !teachers.length) || (teachers.data && teachers.data.length === 0)">
                            <td colspan="4" class="px-6 py-12 text-center text-zinc-500 italic">No hay profesores registrados en la nómina.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900/50 flex flex-col sm:flex-row items-center justify-between gap-4">
                <span class="text-sm text-zinc-500 font-medium">
                    Mostrando {{ teachers.from || 0 }} a {{ teachers.to || 0 }} de {{ teachers.total }} profesores
                </span>
                
                <div class="flex gap-2">
                    <Link
                        v-if="teachers.prev_page_url"
                        :href="teachers.prev_page_url"
                        class="px-4 py-2 border border-zinc-300 dark:border-zinc-700 rounded-lg text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition"
                    >
                        Anterior
                    </Link>
                    <Link
                        v-if="teachers.next_page_url"
                        :href="teachers.next_page_url"
                        class="px-4 py-2 border border-blue-600 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition"
                    >
                        Siguiente
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>

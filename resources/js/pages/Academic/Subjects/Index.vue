<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { dashboard } from '@/routes';
import subjectsRoutes from '@/routes/subjects';
import type { Team } from '@/types';

const props = defineProps<{
    currentTeam?: Team | null;
    subjects: {
        data: any[];
        links: any[];
        current_page: number;
        last_page: number;
    };
    filters: { search?: string };
}>();

const search = ref(props.filters?.search || '');
const fileInput = ref<HTMLInputElement | null>(null);

// Debounce manual
let timeoutId: any;
watch(search, (value) => {
    clearTimeout(timeoutId);
    timeoutId = setTimeout(() => {
        router.get(
            subjectsRoutes.index.url({ current_team: props.currentTeam?.slug ?? '' }),
            { search: value },
            { preserveState: true, replace: true }
        );
    }, 300);
});

const triggerFileSelect = () => {
    fileInput.value?.click();
};

const handleFileUpload = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files.length > 0) {
        const formData = new FormData();
        formData.append('file', target.files[0]);
        
        router.post(
            subjectsRoutes.importExcel.url({ current_team: props.currentTeam?.slug ?? '' }),
            formData
        );
    }
};

const deleteSubject = (id: number) => {
    if (confirm('¿Estás seguro de que deseas eliminar esta materia? Esta acción no se puede deshacer.')) {
        router.delete(subjectsRoutes.destroy.url({ 
            current_team: props.currentTeam?.slug ?? '',
            subject: id 
        }));
    }
};

defineOptions({
    layout: (props: { currentTeam?: Team | null }) => ({
        breadcrumbs: [
            {
                title: 'Dashboard Académico',
                href: props.currentTeam ? dashboard(props.currentTeam.slug) : '/',
            },
            {
                title: 'Gestión de Materias',
                href: '#',
            },
        ],
    }),
});
</script>

<template>
    <Head title="Gestión de Materias" />

    <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-col justify-between gap-6 md:flex-row md:items-center">
            <div>
                <h1 class="text-3xl font-black text-zinc-900 dark:text-zinc-50">
                    Gestión de Materias
                </h1>
                <p class="font-medium text-zinc-500">
                    Administra el catálogo global de asignaturas de la institución.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <Link
                    :href="subjectsRoutes.create.url({ current_team: currentTeam?.slug ?? '' })"
                    class="flex items-center gap-2 rounded-xl bg-blue-600 px-6 py-3 font-bold text-white shadow-lg shadow-blue-500/30 transition hover:bg-blue-500"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Nueva Materia
                </Link>
            </div>
        </div>

        <div class="mb-8 flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
            <!-- Search Bar -->
            <div class="relative w-full md:max-w-md">
                <input
                    v-model="search"
                    type="text"
                    placeholder="Buscar materia por nombre..."
                    class="w-full rounded-full border-zinc-200 bg-white py-3 pr-12 pl-6 text-sm shadow-sm transition-all focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-100"
                />
                <div class="absolute right-2 top-1/2 -translate-y-1/2 rounded-full bg-blue-600 p-2 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <!-- Excel Actions -->
            <div class="flex items-center gap-3">
                <input type="file" ref="fileInput" class="hidden" accept=".xlsx,.xls,.csv" @change="handleFileUpload" />
                
                <a
                    :href="subjectsRoutes.exportTemplate.url({ current_team: currentTeam?.slug ?? '' })"
                    class="flex items-center gap-2 rounded-xl border border-zinc-200 bg-white px-4 py-2 text-sm font-bold text-zinc-600 transition hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400 dark:hover:bg-zinc-700"
                >
                    Plantilla
                </a>

                <button
                    @click="triggerFileSelect"
                    class="flex items-center gap-2 rounded-xl bg-zinc-900 px-5 py-2 text-sm font-bold text-white transition hover:bg-zinc-800 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-200"
                >
                    Importar Excel
                </button>

                <a
                    :href="subjectsRoutes.exportExcel.url({ current_team: currentTeam?.slug ?? '' })"
                    class="flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-2 text-sm font-bold text-white transition hover:bg-emerald-500"
                >
                    Exportar
                </a>
            </div>
        </div>

        <!-- Subjects Table -->
        <div class="overflow-hidden rounded-3xl border border-zinc-200 bg-white shadow-xl shadow-zinc-100 dark:border-zinc-800 dark:bg-zinc-900 dark:shadow-none">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-zinc-100 bg-zinc-50 dark:border-zinc-800 dark:bg-zinc-800/50">
                        <th class="px-6 py-4 text-xs font-bold text-zinc-500 uppercase tracking-wider">Nombre de la Materia</th>
                        <th class="px-6 py-4 text-xs font-bold text-zinc-500 uppercase tracking-wider">Creado el</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-zinc-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    <tr v-for="subject in subjects.data" :key="subject.id" class="group transition hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                        <td class="px-6 py-4">
                            <span class="font-bold text-zinc-900 dark:text-zinc-100">{{ subject.name }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-zinc-500">{{ new Date(subject.created_at).toLocaleDateString() }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <Link
                                    :href="subjectsRoutes.edit.url({ current_team: currentTeam?.slug ?? '', subject: subject.id })"
                                    class="rounded-lg border border-zinc-200 p-2 text-zinc-500 transition hover:border-blue-500 hover:text-blue-600 dark:border-zinc-700 dark:text-zinc-400"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </Link>
                                <button
                                    @click="deleteSubject(subject.id)"
                                    class="rounded-lg border border-zinc-200 p-2 text-zinc-500 transition hover:border-red-500 hover:text-red-600 dark:border-zinc-700 dark:text-zinc-400"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Empty State -->
            <div v-if="subjects.data.length === 0" class="py-12 text-center">
                <p class="text-zinc-500">No se encontraron materias.</p>
            </div>
        </div>

        <!-- Pagination -->
        <div v-if="subjects.last_page > 1" class="mt-6 flex items-center justify-center gap-2">
            <Link
                v-for="(link, i) in subjects.links"
                :key="i"
                :href="link.url || '#'"
                v-html="link.label"
                class="rounded-lg px-4 py-2 text-sm font-bold transition"
                :class="{
                    'bg-blue-600 text-white': link.active,
                    'bg-white text-zinc-600 hover:bg-zinc-100 dark:bg-zinc-900 dark:text-zinc-400': !link.active,
                    'opacity-50 pointer-events-none': !link.url
                }"
            />
        </div>
    </div>
</template>

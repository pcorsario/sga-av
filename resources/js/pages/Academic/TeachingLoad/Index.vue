<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { dashboard } from '@/routes';
import type { Team } from '@/types';

const props = defineProps<{
    currentTeam?: Team | null;
    courses: any[];
    teachers: { id: number; name: string }[];
}>();

const search = ref('');

const form = useForm({
    assignments: props.courses.flatMap(course => 
        course.course_subjects.map((cs: any) => ({
            course_subject_id: cs.id,
            teacher_id: cs.teacher_id,
            course_name: course.name,
            subject_name: cs.subject.name,
            level: course.level
        }))
    )
});

const filteredAssignments = computed(() => {
    const query = search.value.toLowerCase().trim();
    if (!query) return form.assignments;

    return form.assignments.filter(a => 
        a.course_name.toLowerCase().includes(query) ||
        a.subject_name.toLowerCase().includes(query)
    );
});

const submit = () => {
    form.post(route('teaching-load.update', { current_team: props.currentTeam?.slug ?? '' }), {
        preserveScroll: true,
        onSuccess: () => {
            // Optional: Show notification
        }
    });
};

const importForm = useForm({
    file: null as File | null,
});

const importExcel = () => {
    if (!importForm.file) return;
    importForm.post(route('teaching-load.import-excel', { current_team: props.currentTeam?.slug ?? '' }), {
        onSuccess: () => {
            importForm.reset();
            window.location.reload();
        }
    });
};

defineOptions({
    layout: (props: { currentTeam?: Team | null }) => ({
        breadcrumbs: [
            {
                title: 'Dashboard Académico',
                href: props.currentTeam ? dashboard(props.currentTeam.slug) : '/',
            },
            {
                title: 'Carga Horaria Masiva',
                href: '#',
            },
        ],
    }),
});
</script>

<template>
    <Head title="Asignación Masiva de Carga Horaria" />

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-col justify-between gap-6 md:flex-row md:items-center">
            <div>
                <h1 class="text-3xl font-black text-zinc-900 dark:text-zinc-50">
                    Asignación Masiva
                </h1>
                <p class="font-medium text-zinc-500">
                    Gestiona toda la carga horaria institucional desde una sola vista
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-4">
                <!-- Importar Excel -->
                <div class="flex items-center gap-2 rounded-2xl border border-zinc-200 bg-white p-2 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    <a 
                        :href="route('teaching-load.export-template')"
                        class="rounded-xl px-3 py-2 text-xs font-bold text-zinc-600 transition hover:bg-zinc-100 dark:text-zinc-400 dark:hover:bg-zinc-800"
                    >
                        Descargar Plantilla
                    </a>
                    <div class="h-4 w-px bg-zinc-200 dark:bg-zinc-800"></div>
                    <label class="flex cursor-pointer items-center gap-2 px-3 py-2 text-xs font-bold text-blue-600 transition hover:text-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        Importar Carga
                        <input type="file" class="hidden" @change="(e: any) => { importForm.file = e.target.files[0]; importExcel(); }" />
                    </label>
                </div>
            </div>
        </div>

        <!-- Buscador -->
        <div class="mb-6 flex items-center gap-4">
            <div class="relative flex-1">
                <input
                    v-model="search"
                    type="text"
                    placeholder="Filtrar por curso o materia..."
                    class="w-full rounded-2xl border-zinc-200 bg-white py-3 pr-12 pl-6 text-sm font-medium shadow-sm transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-100"
                />
                <div class="absolute right-4 top-1/2 -translate-y-1/2 text-zinc-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
            
            <button
                @click="submit"
                :disabled="form.processing"
                class="flex items-center gap-2 rounded-2xl bg-zinc-900 px-8 py-3 font-black text-white shadow-xl transition-all hover:bg-zinc-800 disabled:opacity-50 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-200"
            >
                <span v-if="form.processing" class="h-4 w-4 animate-spin rounded-full border-2 border-white/30 border-t-white"></span>
                Guardar Cambios Masivos
            </button>
        </div>

        <div class="overflow-hidden rounded-3xl border border-zinc-200 bg-white shadow-xl shadow-zinc-100 dark:border-zinc-800 dark:bg-zinc-900 dark:shadow-zinc-900/50">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-800 dark:bg-zinc-800/50">
                        <tr>
                            <th class="px-6 py-4 text-xs font-black tracking-widest text-zinc-500 uppercase dark:text-zinc-400">Curso / Nivel</th>
                            <th class="px-6 py-4 text-xs font-black tracking-widest text-zinc-500 uppercase dark:text-zinc-400">Materia</th>
                            <th class="px-6 py-4 text-xs font-black tracking-widest text-zinc-500 uppercase dark:text-zinc-400">Profesor Asignado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        <tr 
                            v-for="(assignment, index) in filteredAssignments" 
                            :key="assignment.course_subject_id"
                            class="transition hover:bg-zinc-50 dark:hover:bg-zinc-800/20"
                        >
                            <td class="px-6 py-4">
                                <div class="font-bold text-zinc-900 dark:text-zinc-100">{{ assignment.course_name }}</div>
                                <div class="text-xs font-medium text-zinc-500">{{ assignment.level }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-blue-600 dark:text-blue-400">
                                {{ assignment.subject_name }}
                            </td>
                            <td class="px-6 py-4">
                                <select
                                    v-model="assignment.teacher_id"
                                    class="w-full rounded-xl border-zinc-200 bg-zinc-50 px-4 py-2 text-sm font-bold text-zinc-700 transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-zinc-800 dark:bg-zinc-800 dark:text-zinc-300"
                                >
                                    <option :value="null">-- Sin asignar --</option>
                                    <option v-for="teacher in teachers" :key="teacher.id" :value="teacher.id">
                                        {{ teacher.name }}
                                    </option>
                                </select>
                            </td>
                        </tr>
                        <tr v-if="filteredAssignments.length === 0">
                            <td colspan="3" class="px-6 py-12 text-center text-zinc-500 italic">
                                No se encontraron registros que coincidan con la búsqueda.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

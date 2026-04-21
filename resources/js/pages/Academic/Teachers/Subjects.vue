<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import { dashboard } from '@/routes';
import teachersRoutes from '@/routes/teachers';
import type { Team } from '@/types';

const props = defineProps<{
    currentTeam?: Team | null;
    teacher: {
        id: number;
        name: string;
        email: string;
    };
    courseSubjects: any[];
    assignedIds: number[];
}>();

const form = useForm({
    course_subjects: props.assignedIds || [],
});

const submit = () => {
    form.post(
        teachersRoutes.subjects.update.url({
            current_team: props.currentTeam?.slug ?? '',
            teacher: props.teacher.id,
        }),
        {
            preserveScroll: true,
        },
    );
};

// Group courseSubjects by course name
const groupedSubjects = computed(() => {
    const groups: Record<string, any[]> = {};
    props.courseSubjects.forEach((cs) => {
        const courseName = cs.course.name;

        if (!groups[courseName]) {
            groups[courseName] = [];
        }

        groups[courseName].push(cs);
    });

    return groups;
});

defineOptions({
    layout: (props: { currentTeam?: Team | null; teacher: any }) => ({
        breadcrumbs: [
            {
                title: 'Dashboard Académico',
                href: props.currentTeam
                    ? dashboard(props.currentTeam.slug)
                    : '/',
            },
            {
                title: 'Nómina',
                href: props.currentTeam
                    ? teachersRoutes.index.url({
                          current_team: props.currentTeam.slug,
                      })
                    : '#',
            },
            {
                title: 'Carga Horaria',
                href: '#',
            },
        ],
    }),
});
</script>

<template>
    <Head title="Carga Horaria" />

    <div class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="mb-8 flex items-center gap-4">
            <Link
                :href="
                    currentTeam
                        ? teachersRoutes.index.url({
                              current_team: currentTeam.slug,
                          })
                        : '#'
                "
                class="rounded-full border border-zinc-200 p-2 text-zinc-500 transition hover:bg-zinc-100 dark:border-zinc-800 dark:hover:bg-zinc-800"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                >
                    <path
                        fill-rule="evenodd"
                        d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                        clip-rule="evenodd"
                    />
                </svg>
            </Link>
            <div>
                <h1 class="text-3xl font-black text-zinc-900 dark:text-zinc-50">
                    Carga Horaria
                </h1>
                <p class="font-medium text-zinc-500">
                    Asignación de materias y paralelos para
                    <strong class="text-blue-600 dark:text-blue-400">{{
                        teacher.name
                    }}</strong>
                </p>
            </div>
        </div>

        <form
            @submit.prevent="submit"
            class="space-y-8 rounded-3xl border border-zinc-200 bg-white p-8 shadow-xl shadow-zinc-100 dark:border-zinc-800 dark:bg-zinc-900 dark:shadow-zinc-900/50"
        >
            <div
                class="flex gap-4 rounded-2xl border border-blue-100 bg-blue-50 p-4 dark:border-blue-900/30 dark:bg-blue-900/20"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 text-blue-500"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                </svg>
                <p class="text-sm text-blue-600 dark:text-blue-400">
                    Selecciona las materias que este maestro va a impartir. Si
                    marcas una que ya es impartida por otro profesor, este
                    perderá esa asignación y pasará en su lugar a
                    {{ teacher.name }}.
                </p>
            </div>

            <div class="space-y-8">
                <div
                    v-for="(subjectsList, courseName) in groupedSubjects"
                    :key="courseName"
                    class="overflow-hidden rounded-2xl border border-zinc-200 dark:border-zinc-800"
                >
                    <div
                        class="border-b border-zinc-200 bg-zinc-50 px-6 py-4 dark:border-zinc-800 dark:bg-zinc-800/50"
                    >
                        <h3
                            class="text-lg font-black text-zinc-900 dark:text-white"
                        >
                            {{ courseName }}
                        </h3>
                    </div>
                    <div
                        class="grid grid-cols-1 gap-6 p-6 md:grid-cols-2 lg:grid-cols-3"
                    >
                        <label
                            v-for="cs in subjectsList"
                            :key="cs.id"
                            class="group relative flex cursor-pointer items-start gap-4 rounded-xl border border-zinc-200 p-4 transition hover:bg-zinc-50 dark:border-zinc-800 dark:hover:bg-zinc-800/50"
                            :class="{
                                'border-transparent bg-blue-50 ring-2 ring-blue-500 dark:bg-blue-900/10':
                                    form.course_subjects.includes(cs.id),
                            }"
                        >
                            <div class="flex h-5 items-center">
                                <input
                                    type="checkbox"
                                    :value="cs.id"
                                    v-model="form.course_subjects"
                                    class="h-5 w-5 cursor-pointer rounded border-zinc-300 text-blue-600 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:ring-offset-zinc-800 dark:focus:ring-blue-600"
                                />
                            </div>
                            <div class="flex flex-col">
                                <span
                                    class="font-bold text-zinc-900 transition group-hover:text-blue-600 dark:text-zinc-100"
                                    >{{ cs.subject.name }}</span
                                >
                                <span
                                    v-if="
                                        cs.teacher_id &&
                                        cs.teacher_id !== teacher.id
                                    "
                                    class="mt-1 flex items-center gap-1 text-xs font-semibold text-amber-600 dark:text-amber-500"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-3 w-3"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                    Enseña: {{ cs.teacher.name }}
                                </span>
                                <span
                                    v-else-if="cs.teacher_id === teacher.id"
                                    class="mt-1 text-xs font-semibold text-emerald-600 dark:text-emerald-500"
                                    >✔ Asignada</span
                                >
                                <span
                                    v-else
                                    class="mt-1 text-xs font-medium text-zinc-500 dark:text-zinc-400"
                                    >Sin profesor asignado</span
                                >
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <div
                class="flex items-center justify-end gap-4 border-t border-zinc-200 pt-6 dark:border-zinc-800"
            >
                <Link
                    :href="
                        currentTeam
                            ? teachersRoutes.index.url({
                                  current_team: currentTeam.slug,
                              })
                            : '#'
                    "
                    class="px-6 py-3 font-bold text-zinc-500 transition hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white"
                >
                    Cancelar
                </Link>
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="flex items-center gap-2 rounded-xl bg-blue-600 px-8 py-3 font-black text-white shadow-lg shadow-blue-500/30 transition-all hover:bg-blue-500 disabled:opacity-50"
                >
                    <span
                        v-if="form.processing"
                        class="h-4 w-4 animate-spin rounded-full border-2 border-white/30 border-t-white"
                    ></span>
                    {{
                        form.processing
                            ? 'Guardando...'
                            : 'Guardar Carga Horaria'
                    }}
                </button>
            </div>
        </form>
    </div>
</template>

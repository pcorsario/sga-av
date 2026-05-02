<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import { dashboard } from '@/routes';
import coursesRoutes from '@/routes/courses';
import type { Team } from '@/types';

const props = defineProps<{
    currentTeam?: Team | null;
    course: {
        id: number;
        name: string;
        level: string;
        tutor_id: number | null;
    };
    teachers: Array<{ id: number; name: string }>;
}>();

const form = useForm({
    name: props.course.name,
    level: props.course.level,
    tutor_id: props.course.tutor_id,
});

const submit = () => {
    form.put(
        coursesRoutes.update.url({
            current_team: props.currentTeam?.slug ?? '',
            course: props.course.id,
        }),
        {
            preserveScroll: true,
        },
    );
};

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
                href: props.currentTeam
                    ? coursesRoutes.index.url({
                          current_team: props.currentTeam.slug,
                      })
                    : '#',
            },
            {
                title: 'Editar Curso',
                href: '#',
            },
        ],
    }),
});
</script>

<template>
    <Head title="Editar Curso" />

    <div class="mx-auto max-w-3xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="mb-8 flex items-center gap-4">
            <Link
                :href="
                    currentTeam
                        ? coursesRoutes.index.url({
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
                    Editar Curso
                </h1>
                <p class="font-medium text-zinc-500">
                    Actualiza la información del curso y su tutor asignado.
                </p>
            </div>
        </div>

        <form
            @submit.prevent="submit"
            class="space-y-8 rounded-3xl border border-zinc-200 bg-white p-8 shadow-xl shadow-zinc-100 dark:border-zinc-800 dark:bg-zinc-900 dark:shadow-zinc-900/50"
        >
            <div class="space-y-6">
                <div>
                    <label
                        for="name"
                        class="mb-2 block text-sm font-bold text-zinc-900 dark:text-zinc-100"
                        >Nombre del Curso</label
                    >
                    <input
                        id="name"
                        v-model="form.name"
                        type="text"
                        required
                        class="w-full rounded-xl border-zinc-300 bg-white px-4 py-3 text-zinc-900 shadow-sm transition focus:ring-2 focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                        :class="{ 'border-red-500': form.errors.name }"
                    />
                    <p
                        v-if="form.errors.name"
                        class="mt-2 text-xs font-bold text-red-500"
                    >
                        {{ form.errors.name }}
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label
                            for="level"
                            class="mb-2 block text-sm font-bold text-zinc-900 dark:text-zinc-100"
                            >Nivel de Educación</label
                        >
                        <select
                            id="level"
                            v-model="form.level"
                            required
                            class="w-full rounded-xl border-zinc-300 bg-white px-4 py-3 text-zinc-900 shadow-sm transition focus:ring-2 focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                            :class="{ 'border-red-500': form.errors.level }"
                        >
                            <option value="Inicial 1">Inicial 1</option>
                            <option value="Inicial 2">Inicial 2</option>
                            <option value="Preparatoria">Preparatoria</option>
                            <option value="Elemental">Elemental</option>
                            <option value="Basica Media">Basica Media</option>
                            <option value="Basica Superior">Basica Superior</option>
                            <option value="Bachillerato">Bachillerato</option>
                        </select>
                        <p
                            v-if="form.errors.level"
                            class="mt-2 text-xs font-bold text-red-500"
                        >
                            {{ form.errors.level }}
                        </p>
                    </div>

                    <div>
                        <label
                            for="tutor_id"
                            class="mb-2 block text-sm font-bold text-zinc-900 dark:text-zinc-100"
                            >Tutor del Curso</label
                        >
                        <select
                            id="tutor_id"
                            v-model="form.tutor_id"
                            class="w-full rounded-xl border-zinc-300 bg-white px-4 py-3 text-zinc-900 shadow-sm transition focus:ring-2 focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                            :class="{ 'border-red-500': form.errors.tutor_id }"
                        >
                            <option :value="null">Ninguno / Sin asignar</option>
                            <option v-for="teacher in teachers" :key="teacher.id" :value="teacher.id">
                                {{ teacher.name }}
                            </option>
                        </select>
                        <p
                            v-if="form.errors.tutor_id"
                            class="mt-2 text-xs font-bold text-red-500"
                        >
                            {{ form.errors.tutor_id }}
                        </p>
                    </div>
                </div>
            </div>

            <div
                class="flex items-center justify-end gap-4 border-t border-zinc-200 pt-6 dark:border-zinc-800"
            >
                <Link
                    :href="
                        currentTeam
                            ? coursesRoutes.index.url({
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
                    {{ form.processing ? 'Actualizando...' : 'Guardar Cambios' }}
                </button>
            </div>
        </form>
    </div>
</template>

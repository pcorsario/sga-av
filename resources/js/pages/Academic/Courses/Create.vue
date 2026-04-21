<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { dashboard } from '@/routes';
import coursesRoutes from '@/routes/courses';
import type { Team } from '@/types';

const props = defineProps<{
    currentTeam?: Team | null;
}>();

const form = useForm({
    name: '',
    level: 'Básica Superior',
});

const fileInput = ref<HTMLInputElement | null>(null);

const importForm = useForm({
    file: null as File | null,
});

const submit = () => {
    form.post(
        coursesRoutes.store.url({
            current_team: props.currentTeam?.slug ?? '',
        }),
        {
            preserveScroll: true,
        },
    );
};

const triggerFileSelect = () => {
    fileInput.value?.click();
};

const handleFileUpload = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files.length > 0) {
        importForm.file = target.files[0];
        importForm.post(
            coursesRoutes.importExcel.url({
                current_team: props.currentTeam?.slug ?? '',
            }),
            {
                onSuccess: () => {
                    importForm.reset();
                },
            },
        );
    }
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
                title: 'Nuevo Curso',
                href: '#',
            },
        ],
    }),
});
</script>

<template>
    <Head title="Nuevo Curso" />

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
                    Nuevo Curso / Paralelo
                </h1>
                <p class="font-medium text-zinc-500">
                    Agrega un nivel educativo a la malla curricular
                    institucional.
                </p>
            </div>
        </div>

        <div class="space-y-8">
            <!-- Manual Form Card -->
            <form
                @submit.prevent="submit"
                class="space-y-8 rounded-3xl border border-zinc-200 bg-white p-8 shadow-xl shadow-zinc-100 dark:border-zinc-800 dark:bg-zinc-900 dark:shadow-zinc-900/50"
            >
                <div class="space-y-6">
                    <div>
                        <label
                            for="name"
                            class="mb-2 block text-sm font-bold text-zinc-900 dark:text-zinc-100"
                            >Nombre del Curso (ej. 8vo EGB "A")</label
                        >
                        <input
                            id="name"
                            v-model="form.name"
                            type="text"
                            required
                            class="w-full rounded-xl border-zinc-300 bg-white px-4 py-3 text-zinc-900 shadow-sm transition focus:ring-2 focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                            :class="{ 'border-red-500': form.errors.name }"
                            placeholder="Escribe el nombre identificador del paralelo..."
                        />
                        <p
                            v-if="form.errors.name"
                            class="mt-2 text-xs font-bold text-red-500"
                        >
                            {{ form.errors.name }}
                        </p>
                    </div>

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
                            <option value="Básica Elemental">
                                Básica Elemental
                            </option>
                            <option value="Básica Media">Básica Media</option>
                            <option value="Básica Superior">
                                Básica Superior
                            </option>
                            <option value="Bachillerato">Bachillerato</option>
                        </select>
                        <p
                            v-if="form.errors.level"
                            class="mt-2 text-xs font-bold text-red-500"
                        >
                            {{ form.errors.level }}
                        </p>
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
                        {{ form.processing ? 'Guardando...' : 'Crear Curso' }}
                    </button>
                </div>
            </form>

            <!-- Bulk Import Card -->
            <div
                class="rounded-3xl border border-zinc-200 bg-zinc-50 p-8 dark:border-zinc-800 dark:bg-zinc-900/50"
            >
                <div
                    class="flex flex-col justify-between gap-6 md:flex-row md:items-center"
                >
                    <div>
                        <h2
                            class="text-xl font-bold text-zinc-900 dark:text-zinc-50"
                        >
                            Carga Masiva (Excel)
                        </h2>
                        <p class="mt-1 text-sm text-zinc-500">
                            ¿Tienes muchos cursos? Impórtalos todos a la vez con
                            un archivo Excel.
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <input
                            type="file"
                            ref="fileInput"
                            class="hidden"
                            accept=".xlsx,.xls,.csv"
                            @change="handleFileUpload"
                        />

                        <a
                            :href="
                                coursesRoutes.exportTemplate.url({
                                    current_team: currentTeam?.slug ?? '',
                                })
                            "
                            class="flex items-center gap-2 rounded-xl border border-zinc-200 px-4 py-2 text-sm font-bold text-zinc-600 transition hover:bg-white dark:border-zinc-700 dark:text-zinc-400 dark:hover:bg-zinc-800"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path
                                    d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"
                                />
                                <polyline points="7 10 12 15 17 10" />
                                <line x1="12" y1="15" x2="12" y2="3" />
                            </svg>
                            Plantilla
                        </a>

                        <button
                            @click="triggerFileSelect"
                            :disabled="importForm.processing"
                            class="flex items-center gap-2 rounded-xl bg-zinc-900 px-5 py-2 text-sm font-bold text-white transition hover:bg-zinc-800 disabled:opacity-50 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-200"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path
                                    d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"
                                />
                                <polyline points="17 8 12 3 7 8" />
                                <line x1="12" y1="3" x2="12" y2="15" />
                            </svg>
                            Importar Excel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Premium Loading Overlay -->
    <div
        v-if="importForm.processing"
        class="fixed inset-0 z-[100] flex items-center justify-center bg-white/60 backdrop-blur-md transition-all dark:bg-zinc-950/60"
    >
        <div
            class="flex animate-in flex-col items-center gap-4 rounded-3xl border border-zinc-200 bg-white p-8 shadow-2xl duration-300 zoom-in dark:border-zinc-800 dark:bg-zinc-900"
        >
            <div class="relative h-20 w-20">
                <div
                    class="absolute inset-0 rounded-full border-4 border-blue-100 dark:border-blue-900/30"
                ></div>
                <div
                    class="absolute inset-0 animate-spin rounded-full border-4 border-blue-600 border-t-transparent"
                ></div>
            </div>
            <div class="text-center">
                <h3 class="text-xl font-bold text-zinc-900 dark:text-zinc-50">
                    Procesando Importación...
                </h3>
                <p class="font-medium text-zinc-500">
                    Estamos configurando tu malla curricular.
                </p>
            </div>
        </div>
    </div>
</template>

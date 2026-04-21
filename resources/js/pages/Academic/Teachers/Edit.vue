<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
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
}>();

const form = useForm({
    name: props.teacher.name,
    email: props.teacher.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.put(
        teachersRoutes.update.url({
            current_team: props.currentTeam?.slug ?? '',
            teacher: props.teacher.id,
        }),
        {
            preserveScroll: true,
        },
    );
};

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
                title: 'Editar Profesor',
                href: '#',
            },
        ],
    }),
});
</script>

<template>
    <Head title="Editar Profesor" />

    <div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
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
                    Editar Profesor
                </h1>
                <p class="font-medium text-zinc-500">
                    Actualizar información y credenciales del docente.
                </p>
            </div>
        </div>

        <form
            @submit.prevent="submit"
            class="space-y-8 rounded-3xl border border-zinc-200 bg-white p-8 shadow-xl shadow-zinc-100 dark:border-zinc-800 dark:bg-zinc-900 dark:shadow-zinc-900/50"
        >
            <Transition
                enter-active-class="transition duration-300 ease-out"
                enter-from-class="transform scale-95 opacity-0"
                enter-to-class="transform scale-100 opacity-100"
                leave-active-class="transition duration-200 ease-in"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div
                    v-if="form.recentlySuccessful"
                    class="flex items-center justify-center gap-2 rounded-3xl border border-emerald-500/20 bg-emerald-500/10 p-4 font-black text-emerald-600 dark:text-emerald-400"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"
                        />
                    </svg>
                    Información actualizada exitosamente.
                </div>
            </Transition>
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                <!-- Información Personal -->
                <div class="space-y-6">
                    <div>
                        <label
                            for="name"
                            class="mb-2 block text-sm font-bold text-zinc-900 dark:text-zinc-100"
                            >Nombre Completo</label
                        >
                        <input
                            id="name"
                            v-model="form.name"
                            type="text"
                            required
                            class="w-full rounded-xl border-zinc-300 bg-white px-4 py-3 shadow-sm transition focus:ring-2 focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-800"
                            :class="{ 'border-red-500': form.errors.name }"
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
                            for="email"
                            class="mb-2 block text-sm font-bold text-zinc-900 dark:text-zinc-100"
                            >Correo Electrónico Institucional</label
                        >
                        <input
                            id="email"
                            v-model="form.email"
                            type="email"
                            required
                            class="w-full rounded-xl border-zinc-300 bg-white px-4 py-3 shadow-sm transition focus:ring-2 focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-800"
                            :class="{ 'border-red-500': form.errors.email }"
                        />
                        <p
                            v-if="form.errors.email"
                            class="mt-2 text-xs font-bold text-red-500"
                        >
                            {{ form.errors.email }}
                        </p>
                    </div>
                </div>

                <!-- Credenciales -->
                <div class="space-y-6">
                    <div
                        class="rounded-2xl border border-blue-100 bg-blue-50 p-4 dark:border-blue-900/30 dark:bg-blue-900/20"
                    >
                        <p
                            class="text-xs font-medium text-blue-600 dark:text-blue-400"
                        >
                            <span class="font-bold">Aviso:</span> Deja estos
                            campos en blanco si no deseas cambiar la contraseña
                            del maestro. Si la cambias, tendrá efecto inmediato.
                        </p>
                    </div>

                    <div>
                        <label
                            for="password"
                            class="mb-2 block text-sm font-bold text-zinc-900 dark:text-zinc-100"
                            >Nueva Contraseña</label
                        >
                        <input
                            id="password"
                            v-model="form.password"
                            type="password"
                            placeholder="••••••••"
                            class="w-full rounded-xl border-zinc-300 bg-white px-4 py-3 shadow-sm transition focus:ring-2 focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-800"
                            :class="{ 'border-red-500': form.errors.password }"
                        />
                        <p
                            v-if="form.errors.password"
                            class="mt-2 text-xs font-bold text-red-500"
                        >
                            {{ form.errors.password }}
                        </p>
                    </div>

                    <div>
                        <label
                            for="password_confirmation"
                            class="mb-2 block text-sm font-bold text-zinc-900 dark:text-zinc-100"
                            >Confirmar Contraseña</label
                        >
                        <input
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            type="password"
                            placeholder="••••••••"
                            class="w-full rounded-xl border-zinc-300 bg-white px-4 py-3 shadow-sm transition focus:ring-2 focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-800"
                        />
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
                    Volver a la Nómina
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
                    {{ form.processing ? 'Guardando...' : 'Guardar Cambios' }}
                </button>
            </div>
        </form>
    </div>
</template>

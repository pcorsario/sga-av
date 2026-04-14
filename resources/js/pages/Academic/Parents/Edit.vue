<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import { dashboard } from '@/routes';
import parentsRoutes from '@/routes/parents';
import type { Team } from '@/types';

const props = defineProps<{
    currentTeam?: Team | null;
    parent: any;
    students: { id: number, name: string, course: string, level: string }[];
}>();

const form = useForm({
    name: props.parent.name,
    email: props.parent.email,
    password: '',
    password_confirmation: '',
    children_ids: props.parent.children?.map((c: any) => c.id) || [] as number[],
});

const submit = () => {
    form.put(parentsRoutes.update.url({ 
        current_team: props.currentTeam?.slug ?? '', 
        parent: props.parent.id 
    }), {
        preserveScroll: true,
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
                title: 'Representantes',
                href: props.currentTeam ? parentsRoutes.index.url({ current_team: props.currentTeam.slug }) : '#',
            },
            {
                title: 'Editar Perfil',
                href: '#',
            },
        ],
    }),
});
</script>

<template>
    <Head title="Editar Representante" />

    <div class="px-4 py-8 mx-auto max-w-4xl sm:px-6 lg:px-8">
        <div class="mb-8 flex items-center gap-4">
            <Link 
                :href="currentTeam ? parentsRoutes.index.url({ current_team: currentTeam.slug }) : '#'"
                class="p-2 border border-zinc-200 dark:border-zinc-800 rounded-full hover:bg-zinc-100 dark:hover:bg-zinc-800 transition text-zinc-500"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
            </Link>
            <div>
                <h1 class="text-3xl font-black text-zinc-900 dark:text-zinc-50">Gestionar Representante</h1>
                <p class="text-zinc-500 font-medium">Actualiza datos y vínculos con estudiantes del sistema.</p>
            </div>
        </div>

        <form @submit.prevent="submit" class="bg-white dark:bg-zinc-900 shadow-xl shadow-zinc-100 dark:shadow-zinc-900/50 rounded-3xl border border-zinc-200 dark:border-zinc-800 p-8 space-y-8">
            <Transition
                enter-active-class="transition duration-300 ease-out"
                enter-from-class="transform scale-95 opacity-0"
                enter-to-class="transform scale-100 opacity-100"
                leave-active-class="transition duration-200 ease-in"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div v-if="form.recentlySuccessful" class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 p-4 rounded-3xl font-black flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    Información actualizada exitosamente.
                </div>
            </Transition>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Información Personal -->
                <div class="space-y-6">
                    <h3 class="text-lg font-black border-b pb-2 dark:border-zinc-800 text-zinc-800 dark:text-zinc-200">Datos Personales</h3>
                    <div>
                        <label for="name" class="block text-sm font-bold text-zinc-900 dark:text-zinc-100 mb-2">Nombres y Apellidos</label>
                        <input 
                            id="name"
                            v-model="form.name"
                            type="text"
                            required
                            class="w-full rounded-xl border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 shadow-sm transition px-4 py-3"
                            :class="{'border-red-500': form.errors.name}"
                        />
                        <p v-if="form.errors.name" class="text-red-500 text-xs font-bold mt-2">{{ form.errors.name }}</p>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-bold text-zinc-900 dark:text-zinc-100 mb-2">Correo Electrónico (Usuario habilitado)</label>
                        <input 
                            id="email"
                            v-model="form.email"
                            type="email"
                            required
                            class="w-full rounded-xl border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 shadow-sm transition px-4 py-3"
                            :class="{'border-red-500': form.errors.email}"
                        />
                        <p v-if="form.errors.email" class="text-red-500 text-xs font-bold mt-2">{{ form.errors.email }}</p>
                    </div>

                    <div>
                        <label for="children" class="block text-sm font-bold text-zinc-900 dark:text-zinc-100 mb-2">Estudiantes Asignados (Hijos)</label>
                        <select 
                            id="children"
                            v-model="form.children_ids"
                            multiple
                            class="w-full rounded-xl border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 shadow-sm transition px-4 py-3 h-40"
                            :class="{'border-red-500': form.errors.children_ids}"
                        >
                            <option v-for="student in students" :key="student.id" :value="student.id">
                                {{ student.name }} ({{ student.course }})
                            </option>
                        </select>
                        <p class="text-xs text-zinc-500 mt-2">Mantén presionado CTRL (o CMD) para seleccionar/desmarcar alumnos.</p>
                        <p v-if="form.errors.children_ids" class="text-red-500 text-xs font-bold mt-2">{{ form.errors.children_ids }}</p>
                    </div>
                </div>

                <!-- Credenciales -->
                <div class="space-y-6">
                    <h3 class="text-lg font-black border-b pb-2 dark:border-zinc-800 text-zinc-800 dark:text-zinc-200">Seguridad de Acceso</h3>
                    
                    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-2xl p-4 border border-blue-100 dark:border-blue-900/30">
                        <p class="text-xs text-blue-600 dark:text-blue-400 font-medium tracking-tight">
                            <span class="font-bold">Aviso:</span> Si no deseas cambiar la contraseña de este representante, deja estos campos vacíos.
                        </p>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-bold text-zinc-900 dark:text-zinc-100 mb-2">Nueva Contraseña</label>
                        <input 
                            id="password"
                            v-model="form.password"
                            type="password"
                            placeholder="••••••••"
                            class="w-full rounded-xl border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 shadow-sm transition px-4 py-3"
                            :class="{'border-red-500': form.errors.password}"
                        />
                        <p v-if="form.errors.password" class="text-red-500 text-xs font-bold mt-2">{{ form.errors.password }}</p>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-zinc-900 dark:text-zinc-100 mb-2">Confirmar Contraseña</label>
                        <input 
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            type="password"
                            placeholder="••••••••"
                            class="w-full rounded-xl border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 shadow-sm transition px-4 py-3"
                        />
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-zinc-200 dark:border-zinc-800 flex items-center justify-end gap-4">
                <Link 
                    :href="currentTeam ? parentsRoutes.index.url({ current_team: currentTeam.slug }) : '#'"
                    class="px-6 py-3 text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white font-bold transition"
                >
                    Regresar al Directorio
                </Link>
                <button 
                    type="submit" 
                    :disabled="form.processing"
                    class="px-8 py-3 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-black shadow-lg shadow-blue-500/30 transition-all disabled:opacity-50 flex items-center gap-2"
                >
                    <span v-if="form.processing" class="h-4 w-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                    {{ form.processing ? 'Guardando...' : 'Aplicar Cambios' }}
                </button>
            </div>
        </form>
    </div>
</template>

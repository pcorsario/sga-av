<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import { dashboard } from '@/routes';
import studentsRoutes from '@/routes/students';
import type { Team } from '@/types';

const props = defineProps<{
    currentTeam?: Team | null;
    student: any;
    courses: { id: number, name: string, level: string }[];
}>();

const form = useForm({
    name: props.student.name,
    email: props.student.email,
    password: '',
    password_confirmation: '',
    course_id: props.student.enrollments?.[0]?.course_id ?? '',
});

const submit = () => {
    form.put(studentsRoutes.update.url({ 
        current_team: props.currentTeam?.slug ?? '', 
        student: props.student.id 
    }), {
        preserveScroll: true,
    });
};

defineOptions({
    layout: (props: { currentTeam?: Team | null, student: any }) => ({
        breadcrumbs: [
            {
                title: 'Dashboard Académico',
                href: props.currentTeam ? dashboard(props.currentTeam.slug) : '/',
            },
            {
                title: 'Estudiantes',
                href: props.currentTeam ? studentsRoutes.index.url({ current_team: props.currentTeam.slug }) : '#',
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
    <Head title="Editar Estudiante" />

    <div class="px-4 py-8 mx-auto max-w-4xl sm:px-6 lg:px-8">
        <div class="mb-8 flex items-center gap-4">
            <Link 
                :href="currentTeam ? studentsRoutes.index.url({ current_team: currentTeam.slug }) : '#'"
                class="p-2 border border-zinc-200 dark:border-zinc-800 rounded-full hover:bg-zinc-100 dark:hover:bg-zinc-800 transition text-zinc-500"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
            </Link>
            <div>
                <h1 class="text-3xl font-black text-zinc-900 dark:text-zinc-50">Modificar Estudiante</h1>
                <p class="text-zinc-500 font-medium">Actualiza datos y transfiere de paralelo al alumno.</p>
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
                    Ficha académica actualizada exitosamente.
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
                        <label for="email" class="block text-sm font-bold text-zinc-900 dark:text-zinc-100 mb-2">Correo Estudiantil / Usuario</label>
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
                        <label for="course_id" class="block text-sm font-bold text-zinc-900 dark:text-zinc-100 mb-2">Transferir de Paralelo</label>
                        <select 
                            id="course_id"
                            v-model="form.course_id"
                            required
                            class="w-full rounded-xl border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 shadow-sm transition px-4 py-3"
                            :class="{'border-red-500': form.errors.course_id}"
                        >
                            <option value="" disabled>Seleccione un curso...</option>
                            <option v-for="course in courses" :key="course.id" :value="course.id">
                                {{ course.name }} ({{ course.level }})
                            </option>
                        </select>
                        <p v-if="form.errors.course_id" class="text-red-500 text-xs font-bold mt-2">{{ form.errors.course_id }}</p>
                    </div>
                </div>

                <!-- Credenciales -->
                <div class="space-y-6">
                    <h3 class="text-lg font-black border-b pb-2 dark:border-zinc-800 text-zinc-800 dark:text-zinc-200">Seguridad</h3>
                    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-2xl p-4 border border-blue-100 dark:border-blue-900/30">
                        <p class="text-xs text-blue-600 dark:text-blue-400 font-medium tracking-tight">
                            <span class="font-bold">Aviso:</span> Déjalos en blanco a menos que el alumno haya olvidado su contraseña y requiera ser reseteada.
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
                    :href="currentTeam ? studentsRoutes.index.url({ current_team: currentTeam.slug }) : '#'"
                    class="px-6 py-3 text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white font-bold transition"
                >
                    Volver al Directorio
                </Link>
                <button 
                    type="submit" 
                    :disabled="form.processing"
                    class="px-8 py-3 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-black shadow-lg shadow-blue-500/30 transition-all disabled:opacity-50 flex items-center gap-2"
                >
                    <span v-if="form.processing" class="h-4 w-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                    {{ form.processing ? 'Guardando cambios...' : 'Guardar Ficha' }}
                </button>
            </div>
        </form>
    </div>
</template>

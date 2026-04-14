<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import grades from '@/routes/grades';
import { dashboard } from '@/routes';
import type { Team } from '@/types';

const props = defineProps<{
    currentTeam?: Team | null;
    courseSubject: any;
    students: any[];
}>();

const form = useForm({
    grades: props.students.map(s => ({
        id: s.id,
        name: s.name,
        t1: s.t1,
        t2: s.t2,
        t3: s.t3,
        observations: s.observations
    }))
});

const submit = () => {
    form.post(grades.update.url({ 
        current_team: props.currentTeam?.slug ?? '', 
        courseSubject: props.courseSubject.id 
    }), {
        preserveScroll: true,
    });
};

defineOptions({
    layout: (props: { currentTeam?: Team | null, courseSubject: any }) => ({
        breadcrumbs: [
            {
                title: 'Dashboard Académico',
                href: props.currentTeam ? dashboard(props.currentTeam.slug) : '/',
            },
            {
                title: `Notas: ${props.courseSubject.subject.name}`,
                href: '#',
            },
        ],
    }),
});
</script>

<template>
    <Head :title="`Registrar Notas - ${courseSubject.subject.name}`" />

    <div class="p-6 max-w-5xl mx-auto">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-black text-zinc-900 dark:text-zinc-50">{{ courseSubject.subject.name }}</h1>
                <p class="text-zinc-500 font-medium">{{ courseSubject.course.name }} | {{ courseSubject.course.level }}</p>
            </div>
            <div class="hidden md:block">
                 <span class="px-4 py-2 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-xs font-black rounded-2xl uppercase tracking-tighter">Periodo Lectivo 2026</span>
            </div>
        </div>

        <form @submit.prevent="submit" class="space-y-6">
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-xl rounded-3xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-zinc-50 dark:bg-zinc-800/50 border-b border-zinc-200 dark:border-zinc-800">
                            <tr>
                                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-zinc-400">Estudiante</th>
                                <th class="px-3 py-4 text-[10px] font-black uppercase tracking-widest text-zinc-400 w-24 text-center">1T</th>
                                <th class="px-3 py-4 text-[10px] font-black uppercase tracking-widest text-zinc-400 w-24 text-center">2T</th>
                                <th class="px-3 py-4 text-[10px] font-black uppercase tracking-widest text-zinc-400 w-24 text-center">3T</th>
                                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-zinc-400">Observaciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                            <tr v-for="(student, index) in form.grades" :key="student.id" class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/20 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-8 w-8 rounded-lg bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-xs font-bold text-zinc-500">
                                            {{ index + 1 }}
                                        </div>
                                        <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ student.name }}</span>
                                    </div>
                                </td>
                                <td class="px-3 py-4">
                                    <input 
                                        v-model="student.t1" 
                                        type="number" 
                                        step="0.01" 
                                        min="0" 
                                        max="10"
                                        class="w-full rounded-xl border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 font-black text-center transition shadow-inner px-2"
                                    />
                                </td>
                                <td class="px-3 py-4">
                                    <input 
                                        v-model="student.t2" 
                                        type="number" 
                                        step="0.01" 
                                        min="0" 
                                        max="10"
                                        class="w-full rounded-xl border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 font-black text-center transition shadow-inner px-2"
                                    />
                                </td>
                                <td class="px-3 py-4">
                                    <input 
                                        v-model="student.t3" 
                                        type="number" 
                                        step="0.01" 
                                        min="0" 
                                        max="10"
                                        class="w-full rounded-xl border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 font-black text-center transition shadow-inner px-2"
                                    />
                                </td>
                                <td class="px-6 py-4">
                                    <input 
                                        v-model="student.observations" 
                                        type="text" 
                                        placeholder="Nota de conducta, atraso, etc..."
                                        class="w-full rounded-xl border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 text-sm transition"
                                    />
                                </td>
                            </tr>
                            <tr v-if="form.grades.length === 0">
                                <td colspan="5" class="px-6 py-12 text-center text-zinc-500 italic">No hay estudiantes matriculados en este curso.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex flex-col md:flex-row items-center justify-between gap-4 bg-zinc-900 dark:bg-zinc-50 p-8 rounded-[2.5rem] shadow-2xl relative overflow-hidden">
                <!-- Decorative background elements -->
                <div class="absolute top-0 right-0 w-64 h-64 -mr-32 -mt-32 bg-blue-500/10 rounded-full blur-3xl"></div>
                
                <div class="text-white dark:text-zinc-900 z-10">
                    <p class="text-[10px] font-black uppercase tracking-[0.3em] opacity-50">Confirmación de Carga</p>
                    <p class="text-3xl font-black mt-1">{{ form.grades.length }} Calificaciones listas</p>
                </div>
                
                <div class="flex items-center gap-4 z-10 w-full md:w-auto">
                    <button 
                        type="submit" 
                        :disabled="form.processing"
                        class="flex-1 md:flex-none px-10 py-4 bg-blue-600 hover:bg-blue-500 text-white rounded-2xl font-black transition-all shadow-xl shadow-blue-500/30 active:scale-95 disabled:opacity-50 flex items-center justify-center gap-2"
                    >
                        <span v-if="form.processing" class="h-4 w-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                        {{ form.processing ? 'Sincronizando...' : 'Publicar Notas' }}
                    </button>
                    <button 
                        type="button"
                        @click="form.reset()"
                        class="px-6 py-4 bg-zinc-800 dark:bg-zinc-200 text-zinc-400 dark:text-zinc-500 hover:text-white dark:hover:text-zinc-900 rounded-2xl font-bold transition-colors"
                    >
                        Deshacer
                    </button>
                </div>
            </div>
            
            <Transition
                enter-active-class="transition duration-300 ease-out"
                enter-from-class="transform scale-95 opacity-0"
                enter-to-class="transform scale-100 opacity-100"
                leave-active-class="transition duration-200 ease-in"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div v-if="form.recentlySuccessful" class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 p-4 rounded-3xl text-center font-black flex items-center justify-center gap-2">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    ¡Calificaciones publicadas exitosamente!
                </div>
            </Transition>
        </form>
    </div>
</template>

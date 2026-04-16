<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { dashboard } from '@/routes';
import courses from '@/routes/courses';
import grades from '@/routes/grades';
import parentsRoute from '@/routes/parents';
import students from '@/routes/students';
import teachers from '@/routes/teachers';
import type { Team } from '@/types';

const props = defineProps<{
    currentTeam?: Team | null;
    academic: any;
}>();

defineOptions({
    layout: (props: { currentTeam?: Team | null }) => ({
        breadcrumbs: [
            {
                title: 'Dashboard Académico',
                href: props.currentTeam
                    ? dashboard(props.currentTeam.slug)
                    : '/',
            },
        ],
    }),
});
</script>

<template>
    <Head title="Dashboard Académico" />

    <div class="flex h-full flex-1 flex-col gap-6 p-6">

        
        <!-- Dashboard para Autoridad -->
        <div v-if="academic.role === 'autoridad'" class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
            <Link :href="students.index.url({ current_team: currentTeam?.slug ?? '' })" class="block rounded-2xl border p-6 bg-white dark:bg-zinc-900 border-zinc-200 dark:border-zinc-800 shadow-sm hover:shadow-md hover:border-blue-500/50 transition">
                <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Estudiantes</h3>
                <p class="text-4xl font-extrabold mt-2 text-zinc-900 dark:text-zinc-50">{{ academic.stats.students_count }}</p>
                <div class="mt-4 text-xs text-blue-600 font-medium flex items-center gap-1">
                    Gestionar alumnos 
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </div>
            </Link>
            <Link :href="teachers.index.url({ current_team: currentTeam?.slug ?? '' })" class="block rounded-2xl border p-6 bg-white dark:bg-zinc-900 border-zinc-200 dark:border-zinc-800 shadow-sm hover:shadow-md hover:border-blue-500/50 transition">
                <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Profesores</h3>
                <p class="text-4xl font-extrabold mt-2 text-zinc-900 dark:text-zinc-50">{{ academic.stats.teachers_count }}</p>
                <div class="mt-4 text-xs text-blue-600 font-medium flex items-center gap-1">
                    Gestionar nómina 
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </div>
            </Link>
            <Link :href="courses.index.url({ current_team: currentTeam?.slug ?? '' })" class="block rounded-2xl border p-6 bg-white dark:bg-zinc-900 border-zinc-200 dark:border-zinc-800 shadow-sm hover:shadow-md hover:border-blue-500/50 transition">
                <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Cursos</h3>
                <p class="text-4xl font-extrabold mt-2 text-zinc-900 dark:text-zinc-50">{{ academic.stats.courses_count }}</p>
                <div class="mt-4 text-xs text-blue-600 font-medium flex items-center gap-1">
                    Ver malla curricular
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </div>
            </Link>
            <Link :href="parentsRoute.index.url({ current_team: currentTeam?.slug ?? '' })" class="block rounded-2xl border p-6 bg-white dark:bg-zinc-900 border-zinc-200 dark:border-zinc-800 shadow-sm hover:shadow-md hover:border-blue-500/50 transition">
                <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Padres Familia</h3>
                <p class="text-4xl font-extrabold mt-2 text-zinc-900 dark:text-zinc-50">{{ academic.stats.parents_count }}</p>
                <div class="mt-4 text-xs text-blue-600 font-medium flex items-center gap-1">
                    Representantes
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </div>
            </Link>
        </div>

        <!-- Dashboard para Profesor -->
        <div v-if="academic.role === 'profesor'" class="space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-50">Mis Materias Asignadas</h2>
                <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-xs font-bold rounded-full uppercase">Docente</span>
            </div>
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                <div v-for="asig in academic.assigned_subjects" :key="asig.id" class="group rounded-2xl border p-6 bg-white dark:bg-zinc-900 border-zinc-200 dark:border-zinc-800 shadow-sm hover:border-blue-500/50 transition relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 -mr-8 -mt-8 bg-blue-500/5 rounded-full group-hover:bg-blue-500/10 transition"></div>
                    <h3 class="font-bold text-xl text-zinc-900 dark:text-zinc-100">{{ asig.subject.name }}</h3>
                    <p class="text-zinc-500 mt-1">{{ asig.course.name }}</p>
                    <p class="text-xs text-zinc-400 uppercase mt-2 tracking-tighter">{{ asig.course.level }}</p>
                    <Link 
                        :href="grades.edit.url({ current_team: currentTeam?.slug ?? '', courseSubject: asig.id })"
                        class="mt-6 w-full py-2.5 bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 rounded-xl text-sm font-semibold hover:opacity-90 transition text-center inline-block"
                    >
                        Subir Calificaciones
                    </Link>
                </div>
            </div>
        </div>

        <!-- Dashboard para Estudiante -->
        <div v-if="academic.role === 'estudiante'" class="space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-50">Mi Perfil Académico</h2>
                <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 text-xs font-bold rounded-full uppercase">Estudiante</span>
            </div>

            <div class="rounded-2xl border p-6 bg-gradient-to-r from-blue-600 to-indigo-700 text-white shadow-lg">
                <p class="text-blue-100 text-sm font-medium uppercase tracking-widest">Matriculado actualmente en:</p>
                <p v-if="academic.enrollments.length" class="text-3xl font-black mt-1">
                    {{ academic.enrollments[0].course.name }}
                </p>
                <p v-else class="text-xl font-bold mt-1 opacity-80 italic">No tienes matrículas activas.</p>
            </div>
            
            <div class="space-y-4">
                <h3 class="text-lg font-bold text-zinc-900 dark:text-zinc-50 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                    </svg>
                    Mis Calificaciones
                </h3>
                <div class="overflow-hidden rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-zinc-50 dark:bg-zinc-800/50 text-zinc-500 dark:text-zinc-400">
                            <tr>
                                <th class="px-6 py-4 font-bold uppercase tracking-wider text-[10px]">Materia</th>
                                <th class="px-3 py-4 font-bold uppercase tracking-wider text-[10px] text-center">1T</th>
                                <th class="px-3 py-4 font-bold uppercase tracking-wider text-[10px] text-center">2T</th>
                                <th class="px-3 py-4 font-bold uppercase tracking-wider text-[10px] text-center">3T</th>
                                <th class="px-4 py-4 font-bold uppercase tracking-wider text-[10px] text-center text-blue-500">Prom.</th>
                                <th class="px-6 py-4 font-bold uppercase tracking-wider text-[10px]">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800 bg-white dark:bg-zinc-900">
                            <tr v-for="grade in academic.grades" :key="grade.id" class="hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition">
                                <td class="px-6 py-4 font-semibold text-zinc-900 dark:text-zinc-100">{{ grade.course_subject.subject.name }}</td>
                                <td class="px-3 py-4 text-center font-medium">{{ grade.t1 ?? '-' }}</td>
                                <td class="px-3 py-4 text-center font-medium">{{ grade.t2 ?? '-' }}</td>
                                <td class="px-3 py-4 text-center font-medium">{{ grade.t3 ?? '-' }}</td>
                                <td class="px-4 py-4 text-center">
                                    <span class="text-lg font-black" :class="(((parseFloat(grade.t1||0) + parseFloat(grade.t2||0) + parseFloat(grade.t3||0)) / ((grade.t1!==null?1:0) + (grade.t2!==null?1:0) + (grade.t3!==null?1:0)) || 0) < 7) ? 'text-red-500' : 'text-blue-600 dark:text-blue-400'">
                                        {{ ((grade.t1!==null || grade.t2!==null || grade.t3!==null) ? ((parseFloat(grade.t1||0) + parseFloat(grade.t2||0) + parseFloat(grade.t3||0)) / ((grade.t1!==null?1:0) + (grade.t2!==null?1:0) + (grade.t3!==null?1:0))).toFixed(2) : '-') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span v-if="((parseFloat(grade.t1||0) + parseFloat(grade.t2||0) + parseFloat(grade.t3||0)) / ((grade.t1!==null?1:0) + (grade.t2!==null?1:0) + (grade.t3!==null?1:0)) || 0) >= 7" class="px-2 py-0.5 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 text-[10px] font-bold rounded-full uppercase">Aprobando</span>
                                    <span v-else class="px-2 py-0.5 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 text-[10px] font-bold rounded-full uppercase">Alerta</span>
                                </td>
                            </tr>
                            <tr v-if="!academic.grades.length">
                                <td colspan="6" class="px-6 py-12 text-center text-zinc-500 italic dark:text-zinc-400 bg-zinc-50/50 dark:bg-zinc-800/20">
                                    Aún no se han registrado calificaciones en el sistema.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Dashboard para Padre -->
        <div v-if="academic.role === 'padre'" class="space-y-8">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-50">Gestión de Representados</h2>
                <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 text-xs font-bold rounded-full uppercase">Representante</span>
            </div>

            <div class="grid gap-8">
                <div v-for="child in academic.children" :key="child.id" class="group rounded-3xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden">
                    <div class="p-8">
                        <div class="flex items-center gap-6">
                            <div class="h-16 w-16 rounded-2xl bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center text-white font-black text-2xl shadow-lg shadow-indigo-500/20">
                                {{ child.name.charAt(0) }}
                            </div>
                            <div>
                                <h3 class="font-black text-2xl text-zinc-900 dark:text-zinc-50">{{ child.name }}</h3>
                                <p class="text-zinc-500 dark:text-zinc-400 font-medium mt-0.5" v-if="child.enrollments.length">
                                    {{ child.enrollments[0].course.name }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-8 grid gap-4 lg:grid-cols-2">
                            <div class="space-y-3">
                                <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-zinc-400 mb-4">Reporte de Calificaciones</h4>
                                <div v-for="grade in child.grades" :key="grade.id" class="flex items-center justify-between p-4 rounded-2xl bg-zinc-50 dark:bg-zinc-800/50 group-hover:bg-zinc-100 dark:group-hover:bg-zinc-800 transition">
                                    <span class="font-bold text-zinc-700 dark:text-zinc-300">{{ grade.course_subject.subject.name }}</span>
                                    <div class="flex items-center gap-4 text-sm font-medium text-zinc-500">
                                        <div class="flex items-center gap-1" title="1er Trimestre"><span class="text-[10px] uppercase">1T:</span> <span class="text-zinc-800 dark:text-zinc-200">{{ grade.t1 ?? '-' }}</span></div>
                                        <div class="flex items-center gap-1" title="2do Trimestre"><span class="text-[10px] uppercase">2T:</span> <span class="text-zinc-800 dark:text-zinc-200">{{ grade.t2 ?? '-' }}</span></div>
                                        <div class="flex items-center gap-1" title="3er Trimestre"><span class="text-[10px] uppercase">3T:</span> <span class="text-zinc-800 dark:text-zinc-200">{{ grade.t3 ?? '-' }}</span></div>
                                        <div class="w-px h-4 bg-zinc-200 dark:bg-zinc-700 mx-2"></div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-[10px] uppercase tracking-wider text-blue-500 font-bold">Promedio:</span>
                                            <span class="font-black text-lg" :class="(((parseFloat(grade.t1||0) + parseFloat(grade.t2||0) + parseFloat(grade.t3||0)) / ((grade.t1!==null?1:0) + (grade.t2!==null?1:0) + (grade.t3!==null?1:0)) || 0) < 7) ? 'text-red-500' : 'text-indigo-600 dark:text-indigo-400'">
                                                {{ ((grade.t1!==null || grade.t2!==null || grade.t3!==null) ? ((parseFloat(grade.t1||0) + parseFloat(grade.t2||0) + parseFloat(grade.t3||0)) / ((grade.t1!==null?1:0) + (grade.t2!==null?1:0) + (grade.t3!==null?1:0))).toFixed(2) : '-') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <p v-if="!child.grades.length" class="text-zinc-500 italic p-4 text-sm bg-zinc-50 dark:bg-zinc-800/30 rounded-2xl">
                                    No hay notas registradas para este periodo.
                                </p>
                            </div>
                            
                            <div class="bg-zinc-50 dark:bg-zinc-800/30 rounded-2xl p-6 flex flex-col justify-center items-center text-center space-y-4 border border-dashed border-zinc-200 dark:border-zinc-700">
                                <div class="text-zinc-400 italic text-sm">Próximamente:</div>
                                <p class="text-zinc-600 dark:text-zinc-300 font-bold">Registro de Asistencia & Observaciones</p>
                                <button class="px-6 py-2 bg-zinc-200 dark:bg-zinc-700 text-zinc-500 text-xs font-bold rounded-full cursor-not-allowed uppercase">Ver Informe Completo</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

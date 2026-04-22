<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';
import { useDebounceFn } from '@vueuse/core';
import { dashboard } from '@/routes';
import grades from '@/routes/grades';
import teachers from '@/routes/teachers';
import type { Team } from '@/types';

const props = defineProps<{
    currentTeam?: Team | null;
    academic?: { role: string };
    courseSubject: any;
    students: any[];
    dcds: any[];
    studentDcds: any;
    insumoNames: any;
}>();

const activeTab = ref<'diag' | 't1' | 't2' | 't3'>('diag');
const activeSubTab = ref<'ind' | 'grp' | 'trimestral'>('ind');
const isSaving = ref(false);
const lastSaved = ref<Date | null>(null);

const buildGradeData = (s: any) => ({
    id: s.id,
    name: s.name,
    observations: s.observations,
    t1_ind_1: s.t1.ind_1,
    t1_ind_2: s.t1.ind_2,
    t1_ind_3: s.t1.ind_3,
    t1_ind_4: s.t1.ind_4,
    t1_ind_5: s.t1.ind_5,
    t1_ind_6: s.t1.ind_6,
    t1_grp_1: s.t1.grp_1,
    t1_grp_2: s.t1.grp_2,
    t1_grp_3: s.t1.grp_3,
    t1_grp_4: s.t1.grp_4,
    t1_grp_5: s.t1.grp_5,
    t1_grp_6: s.t1.grp_6,
    t1_ref_1: s.t1.ref_1,
    t1_ref_2: s.t1.ref_2,
    t1_proj: s.t1.proj,
    t1_eval: s.t1.eval,
    t2_ind_1: s.t2.ind_1,
    t2_ind_2: s.t2.ind_2,
    t2_ind_3: s.t2.ind_3,
    t2_ind_4: s.t2.ind_4,
    t2_ind_5: s.t2.ind_5,
    t2_ind_6: s.t2.ind_6,
    t2_grp_1: s.t2.grp_1,
    t2_grp_2: s.t2.grp_2,
    t2_grp_3: s.t2.grp_3,
    t2_grp_4: s.t2.grp_4,
    t2_grp_5: s.t2.grp_5,
    t2_grp_6: s.t2.grp_6,
    t2_ref_1: s.t2.ref_1,
    t2_ref_2: s.t2.ref_2,
    t2_proj: s.t2.proj,
    t2_eval: s.t2.eval,
    t3_ind_1: s.t3.ind_1,
    t3_ind_2: s.t3.ind_2,
    t3_ind_3: s.t3.ind_3,
    t3_ind_4: s.t3.ind_4,
    t3_ind_5: s.t3.ind_5,
    t3_ind_6: s.t3.ind_6,
    t3_grp_1: s.t3.grp_1,
    t3_grp_2: s.t3.grp_2,
    t3_grp_3: s.t3.grp_3,
    t3_grp_4: s.t3.grp_4,
    t3_grp_5: s.t3.grp_5,
    t3_grp_6: s.t3.grp_6,
    t3_ref_1: s.t3.ref_1,
    t3_ref_2: s.t3.ref_2,
    t3_proj: s.t3.proj,
    t3_eval: s.t3.eval,
});

const form = useForm({
    grades: props.students.map(buildGradeData),
    dcds: props.dcds.map((d: any) => ({ id: d.id, name: d.name })),
    student_dcds: Object.fromEntries(
        props.students.map((s: any) => [
            s.id,
            props.studentDcds[s.id]?.selections || {},
        ]),
    ),
    insumo_names: {
        t1: { ...props.insumoNames.t1 },
        t2: { ...props.insumoNames.t2 },
        t3: { ...props.insumoNames.t3 },
    },
    auto_save: false,
});

const getUpdateUrl = () => {
    return props.academic?.role === 'profesor'
        ? teachers.grades.update.url({ courseSubject: props.courseSubject.id })
        : grades.update.url({
              current_team: props.currentTeam?.slug ?? '',
              courseSubject: props.courseSubject.id,
          });
};

const submit = () => {
    form.auto_save = false;
    form.post(getUpdateUrl(), {
        preserveScroll: true,
        onSuccess: () => {
            lastSaved.value = new Date();
        },
    });
};

const autoSave = useDebounceFn(() => {
    isSaving.value = true;
    form.auto_save = true;

    form.post(getUpdateUrl(), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            isSaving.value = false;
            lastSaved.value = new Date();
        },
        onError: () => {
            isSaving.value = false;
        },
        onFinish: () => {
            isSaving.value = false;
        },
    });
}, 1000);

// Observar todos los cambios para auto-guardado integral
watch(
    () => [form.student_dcds, form.dcds, form.grades, form.insumo_names],
    () => {
        autoSave();
    },
    { deep: true },
);

defineOptions({
    layout: (props: {
        currentTeam?: Team | null;
        courseSubject: any;
        academic: any;
    }) => ({
        breadcrumbs: [
            {
                title: 'Dashboard Académico',
                href:
                    props.academic?.role === 'profesor'
                        ? teachers.dashboard.url()
                        : props.currentTeam
                          ? dashboard(props.currentTeam.slug)
                          : '/',
            },
            {
                title: `Notas: ${props.courseSubject.subject.name}`,
                href: '#',
            },
        ],
    }),
});

const inputClass =
    'w-full rounded-none border border-zinc-400 dark:border-zinc-500 bg-white dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 font-black text-center transition px-1 py-1 text-xs min-w-[2.2rem]';
const nameInputClass =
    'w-full text-[9px] font-bold text-zinc-600 dark:text-zinc-300 bg-transparent border-0 p-0 text-center focus:ring-1 focus:ring-blue-500 rounded transition truncate uppercase [writing-mode:vertical-rl] rotate-180';

const parseGrade = (val: any) => {
    if (val === null || val === undefined || val === '') return null;
    const num = Number(val);
    return isNaN(num) ? null : num;
};

const calcPromedioBase = (student: any, term: string, type: 'ind' | 'grp') => {
    let sum = 0;
    let count = 0;
    for (let i = 1; i <= 6; i++) {
        const val = parseGrade(student[`${term}_${type}_${i}`]);
        if (val !== null) {
            sum += val;
            count++;
        }
    }
    return count > 0 ? sum / count : null;
};

const calcPromedioInsumos = (student: any, term: string) => {
    const pInd = calcPromedioBase(student, term, 'ind');
    const pGrp = calcPromedioBase(student, term, 'grp');
    if (pInd === null && pGrp === null) return null;
    if (pInd === null) return pGrp;
    if (pGrp === null) return pInd;
    return (pInd + pGrp) / 2;
};

const calcNuevoPromedio = (student: any, term: string, type: 'ind' | 'grp') => {
    const pBase = calcPromedioBase(student, term, type);
    const pIns = calcPromedioInsumos(student, term);
    const ref = parseGrade(student[`${term}_ref_${type === 'ind' ? 1 : 2}`]);

    if (pBase === null) return null;
    if (pIns === null || pIns >= 7) return pBase;

    if (ref !== null && ref > pBase && pBase < 7) {
        return Math.trunc(((pBase + ref) / 2) * 100) / 100;
    }
    return pBase;
};

const calcPromedioParcial = (student: any, term: string) => {
    const pInd = calcNuevoPromedio(student, term, 'ind');
    const pGrp = calcNuevoPromedio(student, term, 'grp');

    if (pInd === null && pGrp === null) return null;
    if (pInd === null) return pGrp;
    if (pGrp === null) return pInd;
    return (pInd + pGrp) / 2;
};

const calcPromedioFinal = (student: any, term: string) => {
    const pParcial = calcPromedioParcial(student, term);
    const proj = parseGrade(student[`${term}_proj`]);
    const evalGrade = parseGrade(student[`${term}_eval`]);

    if (pParcial === null || proj === null || evalGrade === null) return null;

    return (
        Math.trunc((pParcial * 0.7 + proj * 0.1 + evalGrade * 0.2) * 100) / 100
    );
};

const getStatus = (selections: Record<number, boolean>) => {
    const count = Object.values(selections).filter(Boolean).length;
    if (count === 0) return { text: '', class: '' };
    const percentage = count / 10;
    if (percentage > 0.69) {
        return {
            text: 'LOGRADO',
            class: 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
        };
    }
    if (percentage >= 0.39) {
        return {
            text: 'EN PROCESO',
            class: 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
        };
    }
    return {
        text: 'INICIADO',
        class: 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
    };
};

const getPercentage = (selections: Record<number, boolean>) => {
    const count = Object.values(selections).filter(Boolean).length;
    return Math.round((count / 10) * 100);
};

const columnTotals = computed(() => {
    const totals: Record<number, number> = {};
    for (let i = 1; i <= 10; i++) {
        totals[i] = 0;
    }
    for (const studentId in form.student_dcds) {
        const selections = form.student_dcds[studentId];
        for (let i = 1; i <= 10; i++) {
            if (selections && selections[i]) {
                totals[i]++;
            }
        }
    }
    return totals;
});

const totalSelected = computed(() => {
    let total = 0;
    for (const studentId in form.student_dcds) {
        const selections = form.student_dcds[studentId];
        if (selections) {
            total += Object.values(selections).filter(Boolean).length;
        }
    }
    return total;
});

const maxPossibleSelections = computed(() => {
    return props.students.length * 10;
});

const overallPercentage = computed(() => {
    if (maxPossibleSelections.value === 0) return 0;
    return Math.round(
        (totalSelected.value / maxPossibleSelections.value) * 100,
    );
});

const overallStatus = computed(() => {
    const percentage = overallPercentage.value / 100;
    if (percentage > 0.69) {
        return {
            text: 'LOGRADO',
            class: 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
        };
    }
    if (percentage >= 0.39) {
        return {
            text: 'EN PROCESO',
            class: 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
        };
    }
    return {
        text: 'INICIADO',
        class: 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
    };
});
</script>

<template>
    <Head :title="`Registrar Notas - ${courseSubject.subject.name}`" />

    <div class="mx-auto max-w-[1800px] p-6">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-black text-zinc-900 dark:text-zinc-50">
                    {{ courseSubject.subject.name }}
                </h1>
                <p class="font-medium text-zinc-500">
                    {{ courseSubject.course.name }} |
                    {{ courseSubject.course.level }}
                </p>
            </div>
            <div class="hidden items-center gap-4 md:flex">
                <!-- Indicador de Auto-guardado -->
                <div
                    v-if="isSaving || lastSaved"
                    class="flex items-center gap-2 rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-2 transition-all duration-500 dark:border-zinc-800 dark:bg-zinc-800/50"
                >
                    <template v-if="isSaving">
                        <div
                            class="h-2 w-2 animate-pulse rounded-full bg-blue-500"
                        ></div>
                        <span
                            class="text-[10px] leading-none font-black tracking-widest text-zinc-500 uppercase"
                            >Sincronizando...</span
                        >
                    </template>
                    <template v-else-if="lastSaved">
                        <div class="flex items-center gap-1.5 text-emerald-500">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-3.5 w-3.5"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <span
                                class="text-[10px] leading-none font-black tracking-widest text-zinc-400 uppercase"
                                >Cambios Guardados</span
                            >
                        </div>
                    </template>
                </div>

                <!-- Botón de Reporte PDF -->
                <a
                    v-if="activeTab === 'diag'"
                    :href="
                        academic?.role === 'profesor'
                            ? teachers.grades.pdf.url({
                                  courseSubject: props.courseSubject.id,
                              })
                            : grades.pdf.url({
                                  current_team: props.currentTeam?.slug ?? '',
                                  courseSubject: props.courseSubject.id,
                              })
                    "
                    target="_blank"
                    class="flex items-center gap-2 rounded-2xl border border-zinc-200 bg-white px-4 py-2 text-xs font-bold text-zinc-700 shadow-sm transition hover:bg-zinc-50 dark:border-zinc-800 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 text-red-500"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                            clip-rule="evenodd"
                        />
                    </svg>
                    Reporte PDF
                </a>

                <span
                    class="rounded-2xl bg-blue-100 px-4 py-2 text-xs font-black tracking-tighter text-blue-600 uppercase dark:bg-blue-900/30 dark:text-blue-400"
                    >Periodo Lectivo 2026</span
                >
            </div>
        </div>

        <form @submit.prevent="submit" class="space-y-6">
            <div
                class="overflow-hidden rounded-3xl border border-zinc-200 bg-white shadow-xl dark:border-zinc-800 dark:bg-zinc-900"
            >
                <div class="border-b border-zinc-200 dark:border-zinc-800">
                    <nav class="flex">
                        <button
                            type="button"
                            @click="activeTab = 'diag'"
                            :class="[
                                'px-6 py-4 text-sm font-black transition-colors',
                                activeTab === 'diag'
                                    ? 'bg-amber-500 text-white'
                                    : 'text-zinc-500 hover:bg-zinc-50 dark:hover:bg-zinc-800',
                            ]"
                        >
                            Diagnóstico
                        </button>
                        <button
                            type="button"
                            @click="activeTab = 't1'"
                            :class="[
                                'px-6 py-4 text-sm font-black transition-colors',
                                activeTab === 't1'
                                    ? 'bg-blue-600 text-white'
                                    : 'text-zinc-500 hover:bg-zinc-50 dark:hover:bg-zinc-800',
                            ]"
                        >
                            1er Trimestre
                        </button>
                        <button
                            type="button"
                            @click="activeTab = 't2'"
                            :class="[
                                'px-6 py-4 text-sm font-black transition-colors',
                                activeTab === 't2'
                                    ? 'bg-blue-600 text-white'
                                    : 'text-zinc-500 hover:bg-zinc-50 dark:hover:bg-zinc-800',
                            ]"
                        >
                            2do Trimestre
                        </button>
                        <button
                            type="button"
                            @click="activeTab = 't3'"
                            :class="[
                                'px-6 py-4 text-sm font-black transition-colors',
                                activeTab === 't3'
                                    ? 'bg-blue-600 text-white'
                                    : 'text-zinc-500 hover:bg-zinc-50 dark:hover:bg-zinc-800',
                            ]"
                        >
                            3er Trimestre
                        </button>
                    </nav>
                </div>

                <div v-if="activeTab === 'diag'" class="p-6">
                    <div class="custom-scrollbar relative overflow-x-auto pb-4">
                        <table class="w-full min-w-[1000px] text-left">
                            <thead>
                                <tr
                                    class="border-b-2 border-zinc-300 dark:border-zinc-600"
                                >
                                    <th
                                        class="sticky left-0 z-30 w-64 border-r border-zinc-200 bg-zinc-50 py-1 pr-4 text-sm font-black text-zinc-600 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300"
                                    >
                                        Estudiante
                                    </th>
                                    <th
                                        v-for="i in 10"
                                        :key="'th-' + i"
                                        class="min-w-[3rem] px-2 py-1 text-center text-xs font-black text-zinc-600 dark:text-zinc-300"
                                    >
                                        <input
                                            v-model="form.dcds[i - 1].name"
                                            class="w-full rounded border-0 bg-transparent px-1 text-center text-xs font-bold focus:ring-1 focus:ring-amber-500"
                                            :placeholder="`DCD ${i}`"
                                        />
                                    </th>
                                    <th
                                        class="px-4 py-1 text-center text-xs font-black text-zinc-600 dark:text-zinc-300"
                                    >
                                        Total
                                    </th>
                                    <th
                                        class="px-4 py-1 text-center text-xs font-black text-zinc-600 dark:text-zinc-300"
                                    >
                                        %
                                    </th>
                                    <th
                                        class="px-4 py-1 text-center text-xs font-black text-zinc-600 dark:text-zinc-300"
                                    >
                                        Estado
                                    </th>
                                </tr>
                            </thead>
                            <tbody
                                class="divide-y divide-zinc-100 dark:divide-zinc-800"
                            >
                                <tr
                                    v-for="(student, index) in students"
                                    :key="student.id"
                                    class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/20"
                                >
                                    <td
                                        class="sticky left-0 z-20 border-r border-zinc-100 bg-white py-2 pr-4 dark:border-zinc-800 dark:bg-zinc-900"
                                    >
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="flex h-8 w-8 items-center justify-center rounded-lg bg-zinc-100 text-xs font-bold text-zinc-500 dark:bg-zinc-800"
                                            >
                                                {{ index + 1 }}
                                            </div>
                                            <span
                                                class="text-xs font-bold text-zinc-800 dark:text-zinc-200"
                                                >{{ student.name }}</span
                                            >
                                        </div>
                                    </td>
                                    <td
                                        v-for="i in 10"
                                        :key="'cb-' + i"
                                        class="px-2 py-2 text-center"
                                    >
                                        <input
                                            type="checkbox"
                                            :checked="
                                                form.student_dcds[student.id]?.[
                                                    i
                                                ]
                                            "
                                            @change="
                                                form.student_dcds[student.id][
                                                    i
                                                ] = (
                                                    $event.target as HTMLInputElement
                                                ).checked
                                            "
                                            class="h-6 w-6 cursor-pointer rounded border-zinc-300 text-amber-500 focus:ring-amber-500"
                                        />
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <span
                                            class="font-black text-zinc-700 dark:text-zinc-300"
                                        >
                                            {{
                                                Object.values(
                                                    form.student_dcds[
                                                        student.id
                                                    ] || {},
                                                ).filter(Boolean).length
                                            }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <span
                                            class="font-black text-zinc-700 dark:text-zinc-300"
                                        >
                                            {{
                                                getPercentage(
                                                    form.student_dcds[
                                                        student.id
                                                    ] || {},
                                                )
                                            }}%
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <span
                                            :class="[
                                                'inline-block rounded-full px-3 py-1 text-xs font-black',
                                                getStatus(
                                                    form.student_dcds[
                                                        student.id
                                                    ] || {},
                                                ).class,
                                            ]"
                                        >
                                            {{
                                                getStatus(
                                                    form.student_dcds[
                                                        student.id
                                                    ] || {},
                                                ).text
                                            }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr
                                    class="border-t-2 border-zinc-300 bg-zinc-100 dark:border-zinc-600 dark:bg-zinc-800/50"
                                >
                                    <td class="py-1 pr-4">
                                        <span
                                            class="font-black text-zinc-700 dark:text-zinc-300"
                                            >TOTAL</span
                                        >
                                    </td>
                                    <td
                                        v-for="i in 10"
                                        :key="'total-' + i"
                                        class="px-2 py-1 text-center"
                                    >
                                        <span
                                            class="font-black text-zinc-700 dark:text-zinc-300"
                                            >{{ columnTotals[i] }}</span
                                        >
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <span
                                            class="font-black text-zinc-700 dark:text-zinc-300"
                                            >{{ totalSelected }}</span
                                        >
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <span
                                            class="font-black text-zinc-700 dark:text-zinc-300"
                                            >{{ overallPercentage }}%</span
                                        >
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <span
                                            :class="[
                                                'inline-block rounded-full px-3 py-1 text-xs font-black',
                                                overallStatus.class,
                                            ]"
                                        >
                                            {{ overallStatus.text }}
                                        </span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <div
                            class="rounded-2xl bg-emerald-100 p-4 dark:bg-emerald-900/30"
                        >
                            <p
                                class="text-xs font-black text-emerald-600 uppercase dark:text-emerald-400"
                            >
                                Logrado
                            </p>
                            <p
                                class="text-2xl font-black text-emerald-700 dark:text-emerald-300"
                            >
                                >69%
                            </p>
                            <p
                                class="text-xs text-emerald-600 dark:text-emerald-400"
                            >
                                Dominio suficiente
                            </p>
                        </div>
                        <div
                            class="rounded-2xl bg-amber-100 p-4 dark:bg-amber-900/30"
                        >
                            <p
                                class="text-xs font-black text-amber-600 uppercase dark:text-amber-400"
                            >
                                En Proceso
                            </p>
                            <p
                                class="text-2xl font-black text-amber-700 dark:text-amber-300"
                            >
                                39-69%
                            </p>
                            <p
                                class="text-xs text-amber-600 dark:text-amber-400"
                            >
                                Requiere refuerzo
                            </p>
                        </div>
                        <div
                            class="rounded-2xl bg-red-100 p-4 dark:bg-red-900/30"
                        >
                            <p
                                class="text-xs font-black text-red-600 uppercase dark:text-red-400"
                            >
                                Iniciado
                            </p>
                            <p
                                class="text-2xl font-black text-red-700 dark:text-red-300"
                            >
                                <39%
                            </p>
                            <p class="text-xs text-red-600 dark:text-red-400">
                                Necesita apoyo
                            </p>
                        </div>
                    </div>
                </div>

                <div v-else>
                    <div class="border-b border-zinc-200 bg-zinc-50/50 p-3 dark:border-zinc-800 dark:bg-zinc-800/20">
                        <div class="flex flex-wrap gap-2">
                            <button
                                type="button"
                                @click="activeSubTab = 'ind'"
                                :class="[
                                    'rounded-xl px-4 py-2 text-xs font-black transition-all duration-300',
                                    activeSubTab === 'ind'
                                        ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20 ring-1 ring-blue-500'
                                        : 'bg-white text-zinc-500 hover:bg-zinc-50 border border-zinc-200 dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-400 dark:hover:bg-zinc-700',
                                ]"
                            >
                                Insumos Individuales
                            </button>
                            <button
                                type="button"
                                @click="activeSubTab = 'grp'"
                                :class="[
                                    'rounded-xl px-4 py-2 text-xs font-black transition-all duration-300',
                                    activeSubTab === 'grp'
                                        ? 'bg-purple-600 text-white shadow-md shadow-purple-500/20 ring-1 ring-purple-500'
                                        : 'bg-white text-zinc-500 hover:bg-zinc-50 border border-zinc-200 dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-400 dark:hover:bg-zinc-700',
                                ]"
                            >
                                Insumos Grupales
                            </button>
                            <button
                                type="button"
                                @click="activeSubTab = 'trimestral'"
                                :class="[
                                    'rounded-xl px-4 py-2 text-xs font-black transition-all duration-300',
                                    activeSubTab === 'trimestral'
                                        ? 'bg-amber-500 text-white shadow-md shadow-amber-500/20 ring-1 ring-amber-500'
                                        : 'bg-white text-zinc-500 hover:bg-zinc-50 border border-zinc-200 dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-400 dark:hover:bg-zinc-700',
                                ]"
                            >
                                Resumen Trimestral
                            </button>
                        </div>
                    </div>

                    <div class="custom-scrollbar relative w-full overflow-x-auto pb-4">
                        <table
                            class="w-full border-collapse text-left"
                            :class="{ 'min-w-[800px]': activeSubTab !== 'trimestral', 'min-w-[600px]': activeSubTab === 'trimestral' }"
                        >
                            <thead
                                class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-800 dark:bg-zinc-800/50"
                            >
                                <!-- Encabezados Generales -->
                                <tr>
                                    <th
                                        class="sticky left-0 z-30 bg-zinc-50 px-6 py-4 text-[10px] font-black tracking-widest whitespace-nowrap text-zinc-400 uppercase dark:bg-zinc-800"
                                    >
                                        Estudiante
                                    </th>

                                    <template v-if="activeSubTab === 'ind'">
                                        <th
                                            class="border-l border-zinc-200 bg-blue-50/50 px-3 py-4 text-center text-[10px] font-black tracking-widest text-blue-400 uppercase dark:border-zinc-800 dark:bg-blue-900/10"
                                            colspan="6"
                                        >
                                            Insumos Individuales
                                        </th>
                                        <th
                                            class="border-l border-zinc-200 bg-blue-100/50 px-3 py-4 text-center text-[10px] font-black tracking-widest text-blue-500 uppercase dark:border-zinc-800 dark:bg-blue-900/30"
                                        >
                                            Prom. Indiv.
                                        </th>
                                        <th
                                            class="border-l border-zinc-200 bg-amber-50/50 px-3 py-4 text-center text-[10px] font-black tracking-widest text-amber-500 uppercase dark:border-zinc-800 dark:bg-amber-900/10"
                                        >
                                            Ref. Indiv.
                                        </th>
                                        <th
                                            class="border-l border-zinc-200 bg-emerald-50/50 px-3 py-4 text-center text-[10px] font-black tracking-widest text-emerald-500 uppercase dark:border-zinc-800 dark:bg-emerald-900/10"
                                        >
                                            Nuevo P. Indiv.
                                        </th>
                                    </template>

                                    <template v-if="activeSubTab === 'grp'">
                                        <th
                                            class="border-l border-zinc-200 bg-purple-50/50 px-3 py-4 text-center text-[10px] font-black tracking-widest text-purple-400 uppercase dark:border-zinc-800 dark:bg-purple-900/10"
                                            colspan="6"
                                        >
                                            Insumos Grupales
                                        </th>
                                        <th
                                            class="border-l border-zinc-200 bg-purple-100/50 px-3 py-4 text-center text-[10px] font-black tracking-widest text-purple-500 uppercase dark:border-zinc-800 dark:bg-purple-900/30"
                                        >
                                            Prom. Grup.
                                        </th>
                                        <th
                                            class="border-l border-zinc-200 bg-amber-50/50 px-3 py-4 text-center text-[10px] font-black tracking-widest text-amber-500 uppercase dark:border-zinc-800 dark:bg-amber-900/10"
                                        >
                                            Ref. Grup.
                                        </th>
                                        <th
                                            class="border-l border-zinc-200 bg-emerald-50/50 px-3 py-4 text-center text-[10px] font-black tracking-widest text-emerald-500 uppercase dark:border-zinc-800 dark:bg-emerald-900/10"
                                        >
                                            Nuevo P. Grup.
                                        </th>
                                    </template>

                                    <template v-if="activeSubTab === 'trimestral'">
                                        <th
                                            class="border-l border-zinc-200 bg-blue-50/50 px-3 py-4 text-center text-[10px] font-black tracking-widest text-blue-500 uppercase dark:border-zinc-800 dark:bg-blue-900/10"
                                        >
                                            P. Indiv.
                                        </th>
                                        <th
                                            class="border-l border-zinc-200 bg-purple-50/50 px-3 py-4 text-center text-[10px] font-black tracking-widest text-purple-500 uppercase dark:border-zinc-800 dark:bg-purple-900/10"
                                        >
                                            P. Grup.
                                        </th>
                                        <th
                                            class="border-l border-zinc-200 bg-amber-100/50 px-3 py-4 text-center text-[10px] font-black tracking-widest text-amber-600 uppercase dark:border-zinc-800 dark:bg-amber-900/30"
                                        >
                                            Prom. Parcial (70%)
                                        </th>
                                        <th
                                            class="border-l border-zinc-200 bg-indigo-50/50 px-3 py-4 text-center text-[10px] font-black tracking-widest text-indigo-500 uppercase dark:border-zinc-800 dark:bg-indigo-900/10"
                                        >
                                            Proyecto (10%)
                                        </th>
                                        <th
                                            class="border-l border-zinc-200 bg-rose-50/50 px-3 py-4 text-center text-[10px] font-black tracking-widest text-rose-500 uppercase dark:border-zinc-800 dark:bg-rose-900/10"
                                        >
                                            Evaluación (20%)
                                        </th>
                                        <th
                                            class="border-l border-zinc-200 bg-emerald-100/50 px-3 py-4 text-center text-[10px] font-black tracking-widest text-emerald-600 uppercase dark:border-zinc-800 dark:bg-emerald-900/30"
                                        >
                                            Prom. Final
                                        </th>
                                    </template>

                                    <th
                                        class="border-l border-zinc-200 px-6 py-4 text-[10px] font-black tracking-widest text-zinc-400 uppercase dark:border-zinc-800"
                                    >
                                        Obs.
                                    </th>
                                </tr>

                                <!-- Sub-encabezados (Inputs de Nombres) -->
                                <tr class="h-24 bg-zinc-50/50 dark:bg-zinc-800/30">
                                    <th
                                        class="sticky left-0 z-30 bg-zinc-50 px-6 py-2 dark:bg-zinc-800"
                                    ></th>

                                    <template v-if="activeSubTab === 'ind'">
                                        <th
                                            v-for="i in 6"
                                            :key="'ind-' + i"
                                            class="min-w-[4rem] px-1 py-2 text-center"
                                        >
                                            <input
                                                v-model="form.insumo_names[activeTab === 't2' ? 't2' : activeTab === 't3' ? 't3' : 't1'][`ind_${i}`]"
                                                :class="nameInputClass"
                                                :placeholder="`Insumo ${i}`"
                                            />
                                        </th>
                                        <th class="min-w-[4rem] border-l border-zinc-200 px-2 py-2 text-center dark:border-zinc-800"></th>
                                        <th class="min-w-[4rem] border-l border-zinc-200 px-1 py-2 text-center dark:border-zinc-800">
                                            <input
                                                v-model="form.insumo_names[activeTab === 't2' ? 't2' : activeTab === 't3' ? 't3' : 't1'].ref_1"
                                                :class="nameInputClass"
                                                placeholder="Ref. Indiv."
                                            />
                                        </th>
                                        <th class="min-w-[4rem] border-l border-zinc-200 px-2 py-2 text-center dark:border-zinc-800"></th>
                                    </template>

                                    <template v-if="activeSubTab === 'grp'">
                                        <th
                                            v-for="i in 6"
                                            :key="'grp-' + i"
                                            class="min-w-[4rem] px-1 py-2 text-center"
                                        >
                                            <input
                                                v-model="form.insumo_names[activeTab === 't2' ? 't2' : activeTab === 't3' ? 't3' : 't1'][`grp_${i}`]"
                                                :class="nameInputClass"
                                                :placeholder="`Grupo ${i}`"
                                            />
                                        </th>
                                        <th class="min-w-[4rem] border-l border-zinc-200 px-2 py-2 text-center dark:border-zinc-800"></th>
                                        <th class="min-w-[4rem] border-l border-zinc-200 px-1 py-2 text-center dark:border-zinc-800">
                                            <input
                                                v-model="form.insumo_names[activeTab === 't2' ? 't2' : activeTab === 't3' ? 't3' : 't1'].ref_2"
                                                :class="nameInputClass"
                                                placeholder="Ref. Grup."
                                            />
                                        </th>
                                        <th class="min-w-[4rem] border-l border-zinc-200 px-2 py-2 text-center dark:border-zinc-800"></th>
                                    </template>

                                    <template v-if="activeSubTab === 'trimestral'">
                                        <th class="min-w-[4rem] border-l border-zinc-200 px-2 py-2 text-center dark:border-zinc-800"></th>
                                        <th class="min-w-[4rem] border-l border-zinc-200 px-2 py-2 text-center dark:border-zinc-800"></th>
                                        <th class="min-w-[4rem] border-l border-zinc-200 px-2 py-2 text-center dark:border-zinc-800"></th>
                                        <th class="min-w-[4rem] border-l border-zinc-200 px-1 py-2 text-center dark:border-zinc-800">
                                            <input
                                                v-model="form.insumo_names[activeTab === 't2' ? 't2' : activeTab === 't3' ? 't3' : 't1'].proj"
                                                :class="nameInputClass"
                                                placeholder="Proyecto"
                                            />
                                        </th>
                                        <th class="min-w-[4rem] border-l border-zinc-200 px-1 py-2 text-center dark:border-zinc-800">
                                            <input
                                                v-model="form.insumo_names[activeTab === 't2' ? 't2' : activeTab === 't3' ? 't3' : 't1'].eval"
                                                :class="nameInputClass"
                                                placeholder="Evaluación"
                                            />
                                        </th>
                                        <th class="min-w-[4rem] border-l border-zinc-200 px-2 py-2 text-center dark:border-zinc-800"></th>
                                    </template>

                                    <th class="border-l border-zinc-200 px-4 py-2 dark:border-zinc-800"></th>
                                </tr>
                            </thead>
                            <tbody
                                class="divide-y divide-zinc-100 dark:divide-zinc-800"
                            >
                                <tr
                                    v-for="(student, index) in form.grades"
                                    :key="student.id"
                                    class="transition hover:bg-zinc-50/50 dark:hover:bg-zinc-800/20"
                                >
                                    <td
                                        class="sticky left-0 z-20 border-r border-zinc-100 bg-white px-6 py-1 dark:border-zinc-800 dark:bg-zinc-900"
                                    >
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="flex h-7 w-7 items-center justify-center rounded-lg bg-zinc-100 text-xs font-bold text-zinc-500 dark:bg-zinc-800"
                                            >
                                                {{ index + 1 }}
                                            </div>
                                            <span
                                                class="font-bold whitespace-nowrap text-zinc-800 dark:text-zinc-200"
                                                >{{ student.name }}</span
                                            >
                                        </div>
                                    </td>

                                    <template v-if="activeSubTab === 'ind'">
                                        <td v-for="i in 6" :key="'ind-' + i" class="px-1 py-1">
                                            <input
                                                v-model="(student as any)[activeTab + '_ind_' + i]"
                                                type="number"
                                                step="0.01"
                                                min="1"
                                                max="10"
                                                :class="inputClass"
                                            />
                                        </td>
                                        <td class="border-l border-zinc-200 px-2 py-1 text-center text-xs font-bold text-blue-600 dark:border-zinc-800 dark:text-blue-400 bg-blue-50/20 dark:bg-blue-900/5">
                                            {{ calcPromedioBase(student, activeTab, 'ind')?.toFixed(2) || '-' }}
                                        </td>
                                        <td class="border-l border-zinc-200 px-1 py-1 dark:border-zinc-800">
                                            <input
                                                v-model="(student as any)[activeTab + '_ref_1']"
                                                type="number"
                                                step="0.01"
                                                min="1"
                                                max="10"
                                                :class="inputClass"
                                            />
                                        </td>
                                        <td class="border-l border-zinc-200 px-2 py-1 text-center text-sm font-black text-emerald-600 dark:border-zinc-800 dark:text-emerald-400 bg-emerald-50/40 dark:bg-emerald-900/10">
                                            {{ calcNuevoPromedio(student, activeTab, 'ind')?.toFixed(2) || '-' }}
                                        </td>
                                    </template>

                                    <template v-if="activeSubTab === 'grp'">
                                        <td v-for="i in 6" :key="'grp-' + i" class="px-1 py-1">
                                            <input
                                                v-model="(student as any)[activeTab + '_grp_' + i]"
                                                type="number"
                                                step="0.01"
                                                min="1"
                                                max="10"
                                                :class="inputClass"
                                            />
                                        </td>
                                        <td class="border-l border-zinc-200 px-2 py-1 text-center text-xs font-bold text-purple-600 dark:border-zinc-800 dark:text-purple-400 bg-purple-50/20 dark:bg-purple-900/5">
                                            {{ calcPromedioBase(student, activeTab, 'grp')?.toFixed(2) || '-' }}
                                        </td>
                                        <td class="border-l border-zinc-200 px-1 py-1 dark:border-zinc-800">
                                            <input
                                                v-model="(student as any)[activeTab + '_ref_2']"
                                                type="number"
                                                step="0.01"
                                                min="1"
                                                max="10"
                                                :class="inputClass"
                                            />
                                        </td>
                                        <td class="border-l border-zinc-200 px-2 py-1 text-center text-sm font-black text-emerald-600 dark:border-zinc-800 dark:text-emerald-400 bg-emerald-50/40 dark:bg-emerald-900/10">
                                            {{ calcNuevoPromedio(student, activeTab, 'grp')?.toFixed(2) || '-' }}
                                        </td>
                                    </template>

                                    <template v-if="activeSubTab === 'trimestral'">
                                        <td class="border-l border-zinc-200 px-2 py-1 text-center text-xs font-bold text-blue-600 dark:border-zinc-800 dark:text-blue-400">
                                            {{ calcNuevoPromedio(student, activeTab, 'ind')?.toFixed(2) || '-' }}
                                        </td>
                                        <td class="border-l border-zinc-200 px-2 py-1 text-center text-xs font-bold text-purple-600 dark:border-zinc-800 dark:text-purple-400">
                                            {{ calcNuevoPromedio(student, activeTab, 'grp')?.toFixed(2) || '-' }}
                                        </td>
                                        <td class="border-l border-zinc-200 px-2 py-1 text-center text-sm font-black text-amber-600 dark:border-zinc-800 dark:text-amber-400 bg-amber-50/30 dark:bg-amber-900/10">
                                            {{ calcPromedioParcial(student, activeTab)?.toFixed(2) || '-' }}
                                        </td>
                                        <td class="border-l border-zinc-200 px-1 py-1 dark:border-zinc-800">
                                            <input
                                                v-model="(student as any)[activeTab + '_proj']"
                                                type="number"
                                                step="0.01"
                                                min="1"
                                                max="10"
                                                :class="inputClass"
                                            />
                                        </td>
                                        <td class="border-l border-zinc-200 px-1 py-1 dark:border-zinc-800">
                                            <input
                                                v-model="(student as any)[activeTab + '_eval']"
                                                type="number"
                                                step="0.01"
                                                min="1"
                                                max="10"
                                                :class="inputClass"
                                            />
                                        </td>
                                        <td class="border-l border-zinc-200 px-2 py-1 text-center text-sm font-black text-emerald-600 dark:border-zinc-800 dark:text-emerald-400 bg-emerald-100/30 dark:bg-emerald-900/30">
                                            {{ calcPromedioFinal(student, activeTab)?.toFixed(2) || '-' }}
                                        </td>
                                    </template>

                                    <td
                                        class="border-l border-zinc-200 px-4 py-1 dark:border-zinc-800"
                                    >
                                        <input
                                            v-model="student.observations"
                                            type="text"
                                            placeholder="..."
                                            class="w-full rounded-xl border-zinc-200 bg-zinc-50 text-sm transition focus:ring-2 focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-800"
                                        />
                                    </td>
                                </tr>
                                <tr v-if="form.grades.length === 0">
                                    <td
                                        colspan="10"
                                        class="px-6 py-12 text-center text-zinc-500 italic"
                                    >
                                        No hay estudiantes matriculados en este
                                        curso.
                                    </td>
                                </tr>
                            </tbody>
                    </table>
                </div>
                </div>
            </div>

            <div
                class="relative flex flex-col items-center justify-between gap-4 overflow-hidden rounded-[2.5rem] bg-zinc-900 p-8 shadow-2xl md:flex-row dark:bg-zinc-50"
            >
                <div
                    class="absolute top-0 right-0 -mt-32 -mr-32 h-64 w-64 rounded-full bg-blue-500/10 blur-3xl"
                ></div>
                <div class="z-10 text-white dark:text-zinc-900">
                    <p
                        class="text-[10px] font-black tracking-[0.3em] uppercase opacity-50"
                    >
                        Confirmación de Carga
                    </p>
                    <p class="mt-1 text-3xl font-black">
                        {{ form.grades.length }} Calificaciones
                    </p>
                </div>
                <div class="z-10 flex w-full items-center gap-4 md:w-auto">
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="flex flex-1 items-center justify-center gap-2 rounded-2xl bg-blue-600 px-10 py-4 font-black text-white shadow-xl shadow-blue-500/30 transition-all hover:bg-blue-500 active:scale-95 disabled:opacity-50 md:flex-none"
                    >
                        <span
                            v-if="form.processing"
                            class="h-4 w-4 animate-spin rounded-full border-2 border-white/30 border-t-white"
                        ></span>
                        {{
                            form.processing
                                ? 'Sincronizando...'
                                : 'Publicar Notas'
                        }}
                    </button>
                    <button
                        type="button"
                        @click="form.reset()"
                        class="rounded-2xl bg-zinc-800 px-6 py-4 font-bold text-zinc-400 transition-colors hover:text-white dark:bg-zinc-200 dark:text-zinc-500 dark:hover:text-zinc-900"
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
                <div
                    v-if="form.recentlySuccessful"
                    class="flex items-center justify-center gap-2 rounded-3xl border border-emerald-500/20 bg-emerald-500/10 p-4 text-center font-black text-emerald-600 dark:text-emerald-400"
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
                    ¡Calificaciones publicadas exitosamente!
                </div>
            </Transition>
        </form>
    </div>
</template>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
    height: 10px;
    display: block !important;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 5px;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #bbb;
    border-radius: 5px;
    border: 2px solid #f1f1f1;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #999;
}

/* Forzar visibilidad en otros navegadores */
.custom-scrollbar {
    scrollbar-width: auto;
    scrollbar-color: #bbb #f1f1f1;
}
</style>

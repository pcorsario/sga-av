<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref, onMounted, computed, watch } from 'vue';
import { ClipboardList, X } from 'lucide-vue-next';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Button } from '@/components/ui/button';

const props = defineProps<{
    course: any;
    courseSubject: any;
    domains: any[];
    selectedDomain: any;
    students: any[];
    students: any[];
    existingGrades: any;
    quarter: string;
    selectedItemIds: number[];
}>();

const form = useForm({
    quarter: props.quarter,
    grades: {} as Record<number, Record<number, number | string>>,
});

const configForm = useForm({
    quarter: props.quarter,
    itemIds: [...props.selectedItemIds] as number[],
});

const isModalOpen = ref(false);
const isConfigModalOpen = ref(false);
const selectedStudent = ref<any>(null);

const openEvaluationModal = (student: any) => {
    selectedStudent.value = student;
    isModalOpen.value = true;
};

const openConfigModal = () => {
    isConfigModalOpen.value = true;
};

const saveConfig = () => {
    configForm.post(`/teachers/grades/${props.courseSubject.id}/selected-items`, {
        preserveScroll: true,
        onSuccess: () => {
            isConfigModalOpen.value = false;
        },
    });
};

// Guardado automático con debounce
let timeout: any = null;
watch(() => form.grades, () => {
    if (timeout) clearTimeout(timeout);
    timeout = setTimeout(() => {
        form.transform((data) => ({
            ...data,
            auto_save: true
        })).post(`/teachers/grades/${props.courseSubject.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                console.log('Autosaved');
            },
        });
    }, 2000); // 2 segundos de retraso
}, { deep: true });

// Filtrar las destrezas que se mostrarán en la tabla
// Si no hay ninguna seleccionada, no mostramos ninguna para obligar a configurar
const visibleItems = computed(() => {
    if (props.selectedItemIds.length === 0) {
        return [];
    }
    return props.selectedDomain?.evaluation_items.filter((item: any) => 
        props.selectedItemIds.includes(item.id)
    ) || [];
});

// Calcula el promedio y la letra
const getStudentAverage = (studentId: number) => {
    const grades = form.grades[studentId];
    const totalItems = props.selectedDomain?.evaluation_items?.length || 0;
    
    if (!grades || totalItems === 0) return { avg: '-', letter: 'NE', percentage: 0 };

    let sum = 0;
    let count = 0;

    for (const itemId in grades) {
        const val = parseFloat(grades[itemId] as string);
        if (!isNaN(val)) {
            if (form.quarter === 'diagnostic') {
                sum += val > 0 ? 1 : 0;
            } else if (val >= 0 && val <= 10) {
                sum += val;
            }
            count++;
        }
    }

    if (count === 0) return { avg: '-', letter: 'NE', percentage: 0 };

    if (form.quarter === 'diagnostic') {
        const percentage = (sum / totalItems) * 100;
        let status = 'INICIADO';
        if (percentage > 69) status = 'LOGRADO';
        else if (percentage >= 39) status = 'EN PROCESO';

        return {
            avg: sum.toString(),
            letter: status,
            percentage: Math.round(percentage)
        };
    }

    const avg = sum / count;
    const roundedAvg = Math.round(avg);
    let letter = 'NE';

    if (roundedAvg >= 8 && roundedAvg <= 10) {
        letter = 'A (Alcanzada)';
    } else if (roundedAvg >= 5 && roundedAvg < 8) {
        letter = 'EP (En Proceso)';
    } else if (roundedAvg >= 1 && roundedAvg < 5) {
        letter = 'I (Iniciada)';
    }

    return { 
        avg: avg.toFixed(2), 
        letter,
        percentage: 0
    };
};

// Inicializar el formulario con las notas existentes o vacío
onMounted(() => {
    props.students.forEach(student => {
        form.grades[student.id] = {};
        if (props.selectedDomain) {
            props.selectedDomain.evaluation_items.forEach((item: any) => {
                const key = `${student.id}-${item.id}`;
                const gradeObj = props.existingGrades[key];
                form.grades[student.id][item.id] = gradeObj ? gradeObj[`${props.quarter}_grade`] : '';
            });
        }
    });
});

const submit = () => {
    form.post(`/teachers/grades/${props.courseSubject.id}`, {
        preserveScroll: true,
    });
};

const changeQuarter = () => {
    // Navegar a la misma página pero con el nuevo trimestre
    window.location.href = `?quarter=${form.quarter}`;
};
</script>

<template>
    <Head title="Calificaciones Cualitativas" />

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-col justify-between gap-4 md:flex-row md:items-center">
            <div>
                <h1 class="text-3xl font-black text-zinc-900 dark:text-zinc-50">
                    Evaluación Cualitativa
                </h1>
                <p class="font-medium text-zinc-500">
                    Curso: {{ course.name }} - Materia: {{ courseSubject.subject.name }}
                </p>
                <div v-if="selectedDomain" class="mt-2 flex items-center gap-2">
                    <button 
                        type="button"
                        @click="openConfigModal"
                        class="bg-indigo-600 hover:bg-indigo-500 text-white text-[10px] font-black px-3 py-1 rounded-full shadow-sm uppercase tracking-wider transition-all flex items-center gap-1"
                    >
                        <ClipboardList class="h-3 w-3" />
                        {{ props.selectedItemIds.length }} Destrezas Seleccionadas
                    </button>
                    <span v-if="props.selectedItemIds.length === 0" class="text-[10px] font-bold text-red-500 animate-pulse">
                        ⚠️ Configura las destrezas del trimestre
                    </span>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <a 
                    v-if="form.quarter === 'diagnostic'"
                    :href="`/teachers/grades/${courseSubject.id}/qualitative-pdf`"
                    target="_blank"
                    class="flex items-center gap-2 rounded-xl border border-zinc-200 bg-white px-4 py-2 text-sm font-bold text-zinc-700 shadow-sm transition-all hover:bg-zinc-50 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-300 dark:hover:bg-zinc-800"
                >
                    <ClipboardList class="h-4 w-4 text-indigo-600" />
                    Reporte Diagnóstico
                </a>
                <a 
                    v-else
                    :href="`/teachers/grades/${courseSubject.id}/qualitative-pdf/${form.quarter}`"
                    target="_blank"
                    class="flex items-center gap-2 rounded-xl border border-zinc-200 bg-white px-4 py-2 text-sm font-bold text-zinc-700 shadow-sm transition-all hover:bg-zinc-50 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-300 dark:hover:bg-zinc-800"
                >
                    <ClipboardList class="h-4 w-4 text-indigo-600" />
                    Reporte Trimestral
                </a>

                <select 
                    v-model="form.quarter" 
                    @change="changeQuarter"
                    class="rounded-xl border-zinc-300 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-800 font-bold"
                >
                    <option value="diagnostic">Diagnóstico</option>
                    <option value="q1">1er Trimestre</option>
                    <option value="q2">2do Trimestre</option>
                    <option value="q3">3er Trimestre</option>
                </select>
            </div>
        </div>

        <form @submit.prevent="submit" class="rounded-3xl border border-zinc-200 bg-white shadow-xl dark:border-zinc-800 dark:bg-zinc-900">
            <div class="overflow-x-auto p-4">
                <table v-if="selectedDomain" class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-zinc-200 dark:border-zinc-800">
                            <th class="sticky left-0 bg-white p-4 font-bold text-zinc-900 dark:bg-zinc-900 dark:text-zinc-100 min-w-[250px] z-10 shadow-[1px_0_0_0_#e5e7eb] dark:shadow-[1px_0_0_0_#27272a]">
                                Estudiantes
                            </th>
                            <th 
                                v-for="(item, index) in visibleItems" 
                                :key="item.id"
                                class="p-4 font-bold text-zinc-500 dark:text-zinc-400 min-w-[120px] text-center align-top"
                                :title="item.description"
                            >
                                <div class="text-xs font-normal mb-1 line-clamp-3 leading-tight">{{ item.description }}</div>
                                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-0.5 rounded-full dark:bg-blue-900/30 dark:text-blue-300">
                                    D.{{ index + 1 }}
                                </span>
                            </th>
                            <th class="p-4 font-bold text-yellow-900 bg-yellow-400 min-w-[120px] text-center shadow-[1px_0_0_0_#e5e7eb] dark:shadow-[1px_0_0_0_#27272a] dark:bg-yellow-600 dark:text-yellow-50">
                                {{ form.quarter === 'diagnostic' ? 'LOGRO' : 'PROMEDIO' }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="visibleItems.length === 0">
                            <td 
                                colspan="100" 
                                class="p-12 text-center"
                            >
                                <div class="flex flex-col items-center gap-3">
                                    <div class="bg-indigo-50 dark:bg-indigo-900/20 p-4 rounded-full">
                                        <ClipboardList class="h-8 w-8 text-indigo-600 dark:text-indigo-400" />
                                    </div>
                                    <div>
                                        <p class="text-lg font-black text-zinc-900 dark:text-zinc-100">Sin destrezas configuradas</p>
                                        <p class="text-sm text-zinc-500 max-w-xs mx-auto">
                                            Haz clic en el botón de configuración arriba para seleccionar las destrezas que evaluarás en este periodo.
                                        </p>
                                    </div>
                                    <button 
                                        type="button"
                                        @click="openConfigModal"
                                        class="mt-2 bg-indigo-600 hover:bg-indigo-500 text-white font-bold px-6 py-2 rounded-xl shadow-md transition-all active:scale-95"
                                    >
                                        Configurar Ahora
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr 
                            v-else
                            v-for="student in students" 
                            :key="student.id"
                            class="border-b border-zinc-100 hover:bg-zinc-50 dark:border-zinc-800/50 dark:hover:bg-zinc-800/50"
                        >
                            <td class="sticky left-0 bg-white p-4 font-medium text-zinc-900 dark:bg-zinc-900 dark:text-zinc-100 z-10 shadow-[1px_0_0_0_#e5e7eb] group-hover:bg-zinc-50 dark:shadow-[1px_0_0_0_#27272a]">
                                <div class="flex items-center justify-between gap-2">
                                    <span>{{ student.name }}</span>
                                    <button 
                                        v-if="form.quarter === 'diagnostic'"
                                        type="button"
                                        @click="openEvaluationModal(student)"
                                        :disabled="props.selectedItemIds.length === 0"
                                        class="p-1 text-blue-600 hover:bg-blue-50 rounded-md transition-colors dark:hover:bg-blue-900/20 disabled:opacity-30 disabled:cursor-not-allowed"
                                        title="Evaluar destrezas"
                                    >
                                        <ClipboardList class="h-4 w-4" />
                                    </button>
                                </div>
                            </td>
                            <td 
                                v-for="item in visibleItems" 
                                :key="item.id"
                                class="p-2 text-center min-w-[100px]"
                            >
                                <template v-if="form.grades[student.id]">
                                    <input 
                                        v-if="form.quarter === 'diagnostic'"
                                        type="checkbox"
                                        :true-value="1"
                                        :false-value="0"
                                        v-model="form.grades[student.id][item.id]"
                                        class="h-5 w-5 rounded border-zinc-300 text-blue-600 transition focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-800"
                                    >
                                    <input 
                                        v-else
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        max="10"
                                        v-model="form.grades[student.id][item.id]"
                                        class="w-full rounded-lg border-zinc-300 py-1.5 text-center text-sm shadow-sm transition focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-100 placeholder:text-zinc-300"
                                        placeholder="-"
                                    >
                                </template>
                            </td>
                            <td class="p-2 text-center font-bold bg-yellow-50 dark:bg-yellow-900/20 text-yellow-900 dark:text-yellow-100 shadow-[1px_0_0_0_#e5e7eb] dark:shadow-[1px_0_0_0_#27272a]">
                                <div class="flex flex-col items-center justify-center">
                                    <template v-if="form.quarter === 'diagnostic'">
                                        <span class="text-sm">{{ getStudentAverage(student.id).percentage }}%</span>
                                        <span 
                                            class="mt-1 px-2 py-0.5 rounded-full text-[10px] uppercase"
                                            :class="{
                                                'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300': getStudentAverage(student.id).letter === 'LOGRADO',
                                                'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300': getStudentAverage(student.id).letter === 'EN PROCESO',
                                                'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300': getStudentAverage(student.id).letter === 'INICIADO'
                                            }"
                                        >
                                            {{ getStudentAverage(student.id).letter }}
                                        </span>
                                    </template>
                                    <template v-else>
                                        <span class="text-sm">{{ getStudentAverage(student.id).avg }}</span>
                                        <span class="text-[10px] text-yellow-700 dark:text-yellow-300">{{ getStudentAverage(student.id).letter }}</span>
                                    </template>
                                </div>
                            </td>
                            <td 
                                :colspan="visibleItems.length + 2" 
                                v-if="visibleItems.length === 0"
                                class="p-12 text-center"
                            >
                                <div class="flex flex-col items-center gap-3">
                                    <div class="bg-indigo-50 dark:bg-indigo-900/20 p-4 rounded-full">
                                        <ClipboardList class="h-8 w-8 text-indigo-600 dark:text-indigo-400" />
                                    </div>
                                    <div>
                                        <p class="text-lg font-black text-zinc-900 dark:text-zinc-100">Sin destrezas configuradas</p>
                                        <p class="text-sm text-zinc-500 max-w-xs mx-auto">
                                            Haz clic en el botón de configuración arriba para seleccionar las destrezas que evaluarás en este periodo.
                                        </p>
                                    </div>
                                    <button 
                                        type="button"
                                        @click="openConfigModal"
                                        class="mt-2 bg-indigo-600 hover:bg-indigo-500 text-white font-bold px-6 py-2 rounded-xl shadow-md transition-all active:scale-95"
                                    >
                                        Configurar Ahora
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div v-else class="p-12 text-center text-zinc-500">
                    No se ha seleccionado ningún ámbito o no hay ámbitos disponibles.
                </div>
            </div>

            <!-- Botón oculto ya que usamos auto_save -->
            <div class="flex justify-end p-6 bg-zinc-50/50 dark:bg-zinc-900/50 border-t border-zinc-100 dark:border-zinc-800 rounded-b-3xl">
                <div v-if="form.processing" class="flex items-center gap-2 text-blue-600 font-bold text-sm">
                    <div class="animate-spin rounded-full h-4 w-4 border-2 border-blue-600 border-t-transparent"></div>
                    Guardando cambios...
                </div>
                <div v-else class="text-zinc-400 font-bold text-sm">
                    ✓ Cambios guardados automáticamente
                </div>
            </div>
        </form>

        <!-- Modal de Evaluación Diagnóstica -->
        <Dialog :open="isModalOpen" @update:open="isModalOpen = $event">
            <DialogContent class="sm:max-w-[600px] max-h-[80vh] overflow-hidden flex flex-col p-0 rounded-3xl border-0 shadow-2xl">
                <div v-if="selectedStudent" class="flex flex-col h-full">
                    <DialogHeader class="p-6 bg-blue-600 text-white rounded-t-3xl">
                        <div class="flex justify-between items-start">
                            <div>
                                <DialogTitle class="text-2xl font-black">Evaluar Destrezas</DialogTitle>
                                <DialogDescription class="text-blue-100 mt-1 font-medium">
                                    {{ selectedStudent.name }}
                                </DialogDescription>
                            </div>
                        </div>
                    </DialogHeader>

                    <div class="flex-1 overflow-y-auto p-6 space-y-4">
                        <div 
                            v-for="(item, index) in visibleItems" 
                            :key="item.id"
                            class="flex items-start gap-4 p-4 rounded-2xl border border-zinc-100 hover:border-blue-200 hover:bg-blue-50/30 transition-all dark:border-zinc-800 dark:hover:border-blue-900/50 dark:hover:bg-blue-900/10"
                        >
                            <div class="pt-1">
                                <input 
                                    type="checkbox"
                                    :true-value="1"
                                    :false-value="0"
                                    v-model="form.grades[selectedStudent.id][item.id]"
                                    class="h-6 w-6 rounded-lg border-zinc-300 text-blue-600 transition focus:ring-blue-500 cursor-pointer dark:border-zinc-700 dark:bg-zinc-800"
                                >
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-zinc-900 dark:text-zinc-100 leading-tight">
                                    {{ item.description }}
                                </p>
                                <span class="inline-block mt-2 text-[10px] font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400">
                                    Destreza {{ index + 1 }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border-t border-zinc-100 dark:border-zinc-800 flex justify-between items-center bg-zinc-50 dark:bg-zinc-900/50 rounded-b-3xl">
                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-zinc-400 uppercase tracking-widest">Progreso Actual</span>
                            <div class="flex items-center gap-2">
                                <span class="text-2xl font-black text-zinc-900 dark:text-zinc-100">
                                    {{ getStudentAverage(selectedStudent.id).percentage }}%
                                </span>
                                <span 
                                    class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase"
                                    :class="{
                                        'bg-green-100 text-green-700': getStudentAverage(selectedStudent.id).letter === 'LOGRADO',
                                        'bg-yellow-100 text-yellow-700': getStudentAverage(selectedStudent.id).letter === 'EN PROCESO',
                                        'bg-red-100 text-red-700': getStudentAverage(selectedStudent.id).letter === 'INICIADO'
                                    }"
                                >
                                    {{ getStudentAverage(selectedStudent.id).letter }}
                                </span>
                            </div>
                        </div>
                        <Button @click="isModalOpen = false" class="bg-blue-600 hover:bg-blue-500 text-white font-black px-8 py-2 rounded-xl shadow-lg">
                            Listo
                        </Button>
                    </div>
                </div>
            </DialogContent>
        </Dialog>

        <!-- Modal de Configuración de Destrezas (Global por Trimestre) -->
        <Dialog :open="isConfigModalOpen" @update:open="isConfigModalOpen = $event">
            <DialogContent class="sm:max-w-[600px] h-[80vh] overflow-hidden flex flex-col p-0 rounded-3xl border-0 shadow-2xl">
                <div v-if="selectedDomain" class="flex flex-col h-full overflow-hidden">
                    <DialogHeader class="p-6 bg-indigo-600 text-white rounded-t-3xl shrink-0">
                        <DialogTitle class="text-2xl font-black">Configurar Trimestre</DialogTitle>
                        <DialogDescription class="text-indigo-100 mt-1 font-medium">
                            Selecciona las destrezas que evaluarás en el <b>{{ form.quarter === 'diagnostic' ? 'Diagnóstico' : form.quarter.toUpperCase() }}</b>
                        </DialogDescription>
                    </DialogHeader>

                    <div class="flex-1 overflow-y-auto p-6 space-y-4 min-h-0">
                        <div 
                            v-for="(item, index) in selectedDomain.evaluation_items" 
                            :key="item.id"
                            class="flex items-start gap-4 p-4 rounded-2xl border transition-all cursor-pointer"
                            :class="configForm.itemIds.includes(item.id) 
                                ? 'border-indigo-200 bg-indigo-50/50 dark:border-indigo-900/50 dark:bg-indigo-900/10' 
                                : 'border-zinc-100 dark:border-zinc-800'"
                            @click="() => {
                                if (configForm.itemIds.includes(item.id)) {
                                    configForm.itemIds = configForm.itemIds.filter(id => id !== item.id);
                                } else {
                                    configForm.itemIds.push(item.id);
                                }
                            }"
                        >
                            <div class="pt-1">
                                <input 
                                    type="checkbox"
                                    :value="item.id"
                                    v-model="configForm.itemIds"
                                    class="h-6 w-6 rounded-lg border-zinc-300 text-indigo-600 transition focus:ring-indigo-500 cursor-pointer"
                                    @click.stop
                                >
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold leading-tight" :class="configForm.itemIds.includes(item.id) ? 'text-indigo-900 dark:text-indigo-100' : 'text-zinc-600 dark:text-zinc-400'">
                                    {{ item.description }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border-t border-zinc-100 dark:border-zinc-800 flex justify-end items-center bg-zinc-50 dark:bg-zinc-900/50 rounded-b-3xl shrink-0">
                        <div class="flex items-center gap-4">
                            <Button variant="outline" @click="isConfigModalOpen = false" class="rounded-xl font-bold">
                                Cancelar
                            </Button>
                            <Button 
                                @click="saveConfig" 
                                :disabled="configForm.processing"
                                class="bg-indigo-600 hover:bg-indigo-500 text-white font-black px-8 py-2 rounded-xl shadow-lg disabled:opacity-50"
                            >
                                {{ configForm.processing ? 'Guardando...' : 'Aplicar a este Trimestre' }}
                            </Button>
                        </div>
                    </div>
                </div>
            </DialogContent>
        </Dialog>
    </div>
</template>

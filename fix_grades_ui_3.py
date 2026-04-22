import re

with open('resources/js/pages/Academic/Grades/Edit.vue', 'r') as f:
    content = f.read()

new_tbody = """                            <tr v-for="(student, index) in form.grades" :key="student.id" class="transition hover:bg-zinc-50/50 dark:hover:bg-zinc-800/20">
                                <td class="sticky left-0 z-20 border-r border-zinc-100 bg-white px-6 py-1 dark:border-zinc-800 dark:bg-zinc-900">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-zinc-100 text-xs font-bold text-zinc-500 dark:bg-zinc-800">{{ index + 1 }}</div>
                                        <span class="font-bold whitespace-nowrap text-zinc-800 dark:text-zinc-200">{{ student.name }}</span>
                                    </div>
                                </td>

                                <!-- INSUMOS INDIVIDUALES -->
                                <template v-if="activeTab === 't1'">
                                    <td v-for="i in 6" :key="'t1-ind-' + i" class="px-1 py-1"><input v-model="student[`t1_ind_${i}`]" type="number" step="0.01" min="1" max="10" :class="inputClass" /></td>
                                    <td class="px-1 py-1 bg-blue-50/30 dark:bg-blue-900/10"><div class="font-black text-center text-xs text-blue-700 dark:text-blue-400">{{ calcPromedioBase(student, 't1', 'ind')?.toFixed(2) || '-' }}</div></td>
                                </template>
                                <template v-else-if="activeTab === 't2'">
                                    <td v-for="i in 6" :key="'t2-ind-' + i" class="px-1 py-1"><input v-model="student[`t2_ind_${i}`]" type="number" step="0.01" min="1" max="10" :class="inputClass" /></td>
                                    <td class="px-1 py-1 bg-blue-50/30 dark:bg-blue-900/10"><div class="font-black text-center text-xs text-blue-700 dark:text-blue-400">{{ calcPromedioBase(student, 't2', 'ind')?.toFixed(2) || '-' }}</div></td>
                                </template>
                                <template v-else>
                                    <td v-for="i in 6" :key="'t3-ind-' + i" class="px-1 py-1"><input v-model="student[`t3_ind_${i}`]" type="number" step="0.01" min="1" max="10" :class="inputClass" /></td>
                                    <td class="px-1 py-1 bg-blue-50/30 dark:bg-blue-900/10"><div class="font-black text-center text-xs text-blue-700 dark:text-blue-400">{{ calcPromedioBase(student, 't3', 'ind')?.toFixed(2) || '-' }}</div></td>
                                </template>

                                <!-- INSUMOS GRUPALES -->
                                <template v-if="activeTab === 't1'">
                                    <td v-for="i in 6" :key="'t1-grp-' + i" class="border-l border-zinc-200 px-1 py-1 dark:border-zinc-800"><input v-model="student[`t1_grp_${i}`]" type="number" step="0.01" min="1" max="10" :class="inputClass" /></td>
                                    <td class="px-1 py-1 bg-purple-50/30 dark:bg-purple-900/10"><div class="font-black text-center text-xs text-purple-700 dark:text-purple-400">{{ calcPromedioBase(student, 't1', 'grp')?.toFixed(2) || '-' }}</div></td>
                                </template>
                                <template v-else-if="activeTab === 't2'">
                                    <td v-for="i in 6" :key="'t2-grp-' + i" class="border-l border-zinc-200 px-1 py-1 dark:border-zinc-800"><input v-model="student[`t2_grp_${i}`]" type="number" step="0.01" min="1" max="10" :class="inputClass" /></td>
                                    <td class="px-1 py-1 bg-purple-50/30 dark:bg-purple-900/10"><div class="font-black text-center text-xs text-purple-700 dark:text-purple-400">{{ calcPromedioBase(student, 't2', 'grp')?.toFixed(2) || '-' }}</div></td>
                                </template>
                                <template v-else>
                                    <td v-for="i in 6" :key="'t3-grp-' + i" class="border-l border-zinc-200 px-1 py-1 dark:border-zinc-800"><input v-model="student[`t3_grp_${i}`]" type="number" step="0.01" min="1" max="10" :class="inputClass" /></td>
                                    <td class="px-1 py-1 bg-purple-50/30 dark:bg-purple-900/10"><div class="font-black text-center text-xs text-purple-700 dark:text-purple-400">{{ calcPromedioBase(student, 't3', 'grp')?.toFixed(2) || '-' }}</div></td>
                                </template>

                                <!-- PROMEDIOS Y PONDERACIÓN -->
                                <template v-if="activeTab === 't1'">
                                    <td class="px-1 py-1 bg-amber-50/30 dark:bg-amber-900/10"><div class="font-black text-center text-xs text-amber-700 dark:text-amber-400">{{ calcPromedioInsumos(student, 't1')?.toFixed(2) || '-' }}</div></td>
                                    <td class="border-l border-zinc-200 px-1 py-1 dark:border-zinc-800"><input v-model="student.t1_ref_1" type="number" step="0.01" min="1" max="10" :class="inputClass" /></td>
                                    <td class="border-l border-zinc-200 px-1 py-1 dark:border-zinc-800"><input v-model="student.t1_ref_2" type="number" step="0.01" min="1" max="10" :class="inputClass" /></td>
                                    <td class="px-1 py-1"><div class="font-black text-center text-xs text-blue-600">{{ calcNuevoPromedio(student, 't1', 'ind')?.toFixed(2) || '-' }}</div></td>
                                    <td class="px-1 py-1"><div class="font-black text-center text-xs text-purple-600">{{ calcNuevoPromedio(student, 't1', 'grp')?.toFixed(2) || '-' }}</div></td>
                                    <td class="px-1 py-1 bg-rose-50/30 dark:bg-rose-900/10"><div class="font-black text-center text-xs text-rose-600 dark:text-rose-400">{{ calcPromedioParcial(student, 't1')?.toFixed(2) || '-' }}</div></td>
                                    <td class="border-l border-zinc-200 px-1 py-1 dark:border-zinc-800"><input v-model="student.t1_proj" type="number" step="0.01" min="1" max="10" :class="inputClass" /></td>
                                    <td class="border-l border-zinc-200 px-1 py-1 dark:border-zinc-800"><input v-model="student.t1_eval" type="number" step="0.01" min="1" max="10" :class="inputClass" /></td>
                                    <td class="px-1 py-1 bg-emerald-50/30 dark:bg-emerald-900/10"><div class="font-black text-center text-xs text-emerald-700 dark:text-emerald-400">{{ calcPromedioFinal(student, 't1')?.toFixed(2) || '-' }}</div></td>
                                </template>
                                <template v-else-if="activeTab === 't2'">
                                    <td class="px-1 py-1 bg-amber-50/30 dark:bg-amber-900/10"><div class="font-black text-center text-xs text-amber-700 dark:text-amber-400">{{ calcPromedioInsumos(student, 't2')?.toFixed(2) || '-' }}</div></td>
                                    <td class="border-l border-zinc-200 px-1 py-1 dark:border-zinc-800"><input v-model="student.t2_ref_1" type="number" step="0.01" min="1" max="10" :class="inputClass" /></td>
                                    <td class="border-l border-zinc-200 px-1 py-1 dark:border-zinc-800"><input v-model="student.t2_ref_2" type="number" step="0.01" min="1" max="10" :class="inputClass" /></td>
                                    <td class="px-1 py-1"><div class="font-black text-center text-xs text-blue-600">{{ calcNuevoPromedio(student, 't2', 'ind')?.toFixed(2) || '-' }}</div></td>
                                    <td class="px-1 py-1"><div class="font-black text-center text-xs text-purple-600">{{ calcNuevoPromedio(student, 't2', 'grp')?.toFixed(2) || '-' }}</div></td>
                                    <td class="px-1 py-1 bg-rose-50/30 dark:bg-rose-900/10"><div class="font-black text-center text-xs text-rose-600 dark:text-rose-400">{{ calcPromedioParcial(student, 't2')?.toFixed(2) || '-' }}</div></td>
                                    <td class="border-l border-zinc-200 px-1 py-1 dark:border-zinc-800"><input v-model="student.t2_proj" type="number" step="0.01" min="1" max="10" :class="inputClass" /></td>
                                    <td class="border-l border-zinc-200 px-1 py-1 dark:border-zinc-800"><input v-model="student.t2_eval" type="number" step="0.01" min="1" max="10" :class="inputClass" /></td>
                                    <td class="px-1 py-1 bg-emerald-50/30 dark:bg-emerald-900/10"><div class="font-black text-center text-xs text-emerald-700 dark:text-emerald-400">{{ calcPromedioFinal(student, 't2')?.toFixed(2) || '-' }}</div></td>
                                </template>
                                <template v-else>
                                    <td class="px-1 py-1 bg-amber-50/30 dark:bg-amber-900/10"><div class="font-black text-center text-xs text-amber-700 dark:text-amber-400">{{ calcPromedioInsumos(student, 't3')?.toFixed(2) || '-' }}</div></td>
                                    <td class="border-l border-zinc-200 px-1 py-1 dark:border-zinc-800"><input v-model="student.t3_ref_1" type="number" step="0.01" min="1" max="10" :class="inputClass" /></td>
                                    <td class="border-l border-zinc-200 px-1 py-1 dark:border-zinc-800"><input v-model="student.t3_ref_2" type="number" step="0.01" min="1" max="10" :class="inputClass" /></td>
                                    <td class="px-1 py-1"><div class="font-black text-center text-xs text-blue-600">{{ calcNuevoPromedio(student, 't3', 'ind')?.toFixed(2) || '-' }}</div></td>
                                    <td class="px-1 py-1"><div class="font-black text-center text-xs text-purple-600">{{ calcNuevoPromedio(student, 't3', 'grp')?.toFixed(2) || '-' }}</div></td>
                                    <td class="px-1 py-1 bg-rose-50/30 dark:bg-rose-900/10"><div class="font-black text-center text-xs text-rose-600 dark:text-rose-400">{{ calcPromedioParcial(student, 't3')?.toFixed(2) || '-' }}</div></td>
                                    <td class="border-l border-zinc-200 px-1 py-1 dark:border-zinc-800"><input v-model="student.t3_proj" type="number" step="0.01" min="1" max="10" :class="inputClass" /></td>
                                    <td class="border-l border-zinc-200 px-1 py-1 dark:border-zinc-800"><input v-model="student.t3_eval" type="number" step="0.01" min="1" max="10" :class="inputClass" /></td>
                                    <td class="px-1 py-1 bg-emerald-50/30 dark:bg-emerald-900/10"><div class="font-black text-center text-xs text-emerald-700 dark:text-emerald-400">{{ calcPromedioFinal(student, 't3')?.toFixed(2) || '-' }}</div></td>
                                </template>

                                <td class="border-l border-zinc-200 px-4 py-2 dark:border-zinc-800">
                                    <input v-model="student.observations" class="w-full rounded-none border-0 bg-transparent px-2 py-1 text-xs text-zinc-900 focus:ring-1 focus:ring-blue-500 dark:text-zinc-100" placeholder="Añadir..." />
                                </td>
                            </tr>"""

# Find the loop body
pattern = re.compile(r'                            <tr\s*v-for="\(student, index\) in form\.grades".*?</template>\s*<td\s*class="border-l border-zinc-200 px-4 py-2 dark:border-zinc-800"\s*>\s*<input[^>]+/>\s*</td>\s*</tr>', re.DOTALL)

content = pattern.sub(new_tbody, content)

with open('resources/js/pages/Academic/Grades/Edit.vue', 'w') as f:
    f.write(content)

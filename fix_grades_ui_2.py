import re

with open('resources/js/pages/Academic/Grades/Edit.vue', 'r') as f:
    content = f.read()

# Define the new second row headers
new_tr2 = """                            <tr class="h-24 bg-zinc-50/50 dark:bg-zinc-800/30">
                                <th class="sticky left-0 z-30 bg-zinc-50 px-6 py-2 dark:bg-zinc-800"></th>
                                <!-- INSUMOS INDIVIDUALES -->
                                <template v-if="activeTab === 't1'">
                                    <th v-for="i in 6" :key="'t1-ind-' + i" class="min-w-[5rem] px-1 py-2 text-center">
                                        <input v-model="form.insumo_names.t1[`ind_${i}`]" :class="nameInputClass" :placeholder="`Insumo ${i}`" />
                                    </th>
                                </template>
                                <template v-else-if="activeTab === 't2'">
                                    <th v-for="i in 6" :key="'t2-ind-' + i" class="min-w-[5rem] px-1 py-2 text-center">
                                        <input v-model="form.insumo_names.t2[`ind_${i}`]" :class="nameInputClass" :placeholder="`Insumo ${i}`" />
                                    </th>
                                </template>
                                <template v-else>
                                    <th v-for="i in 6" :key="'t3-ind-' + i" class="min-w-[5rem] px-1 py-2 text-center">
                                        <input v-model="form.insumo_names.t3[`ind_${i}`]" :class="nameInputClass" :placeholder="`Insumo ${i}`" />
                                    </th>
                                </template>
                                <th class="min-w-[3rem] px-2 py-2 text-center font-black text-blue-700 dark:text-blue-400 border-l border-blue-200 dark:border-blue-900/50 bg-blue-50/50 dark:bg-blue-900/10"><div class="rotate-180 [writing-mode:vertical-rl] text-[9px] mx-auto uppercase">Prom. Indiv.</div></th>
                                
                                <!-- INSUMOS GRUPALES -->
                                <template v-if="activeTab === 't1'">
                                    <th v-for="i in 6" :key="'t1-grp-' + i" class="min-w-[5rem] border-l border-zinc-200 px-1 py-2 text-center dark:border-zinc-800">
                                        <input v-model="form.insumo_names.t1[`grp_${i}`]" :class="nameInputClass" :placeholder="`Grupo ${i}`" />
                                    </th>
                                </template>
                                <template v-else-if="activeTab === 't2'">
                                    <th v-for="i in 6" :key="'t2-grp-' + i" class="min-w-[5rem] border-l border-zinc-200 px-1 py-2 text-center dark:border-zinc-800">
                                        <input v-model="form.insumo_names.t2[`grp_${i}`]" :class="nameInputClass" :placeholder="`Grupo ${i}`" />
                                    </th>
                                </template>
                                <template v-else>
                                    <th v-for="i in 6" :key="'t3-grp-' + i" class="min-w-[5rem] border-l border-zinc-200 px-1 py-2 text-center dark:border-zinc-800">
                                        <input v-model="form.insumo_names.t3[`grp_${i}`]" :class="nameInputClass" :placeholder="`Grupo ${i}`" />
                                    </th>
                                </template>
                                <th class="min-w-[3rem] px-2 py-2 text-center font-black text-purple-700 dark:text-purple-400 border-l border-purple-200 dark:border-purple-900/50 bg-purple-50/50 dark:bg-purple-900/10"><div class="rotate-180 [writing-mode:vertical-rl] text-[9px] mx-auto uppercase">Prom. Grup.</div></th>
                                
                                <!-- PROMEDIOS Y PONDERACIÓN -->
                                <th class="min-w-[3rem] px-2 py-2 text-center font-black text-amber-700 dark:text-amber-400 border-l border-amber-200 dark:border-amber-900/50 bg-amber-50/50 dark:bg-amber-900/10"><div class="rotate-180 [writing-mode:vertical-rl] text-[9px] mx-auto uppercase">Prom. Insumos</div></th>
                                
                                <template v-if="activeTab === 't1'">
                                    <th class="min-w-[4rem] border-l border-zinc-200 px-1 py-2 text-center dark:border-zinc-800"><input v-model="form.insumo_names.t1.ref_1" :class="nameInputClass" placeholder="Ref. Indiv." /></th>
                                    <th class="min-w-[4rem] border-l border-zinc-200 px-1 py-2 text-center dark:border-zinc-800"><input v-model="form.insumo_names.t1.ref_2" :class="nameInputClass" placeholder="Ref. Grup." /></th>
                                </template>
                                <template v-else-if="activeTab === 't2'">
                                    <th class="min-w-[4rem] border-l border-zinc-200 px-1 py-2 text-center dark:border-zinc-800"><input v-model="form.insumo_names.t2.ref_1" :class="nameInputClass" placeholder="Ref. Indiv." /></th>
                                    <th class="min-w-[4rem] border-l border-zinc-200 px-1 py-2 text-center dark:border-zinc-800"><input v-model="form.insumo_names.t2.ref_2" :class="nameInputClass" placeholder="Ref. Grup." /></th>
                                </template>
                                <template v-else>
                                    <th class="min-w-[4rem] border-l border-zinc-200 px-1 py-2 text-center dark:border-zinc-800"><input v-model="form.insumo_names.t3.ref_1" :class="nameInputClass" placeholder="Ref. Indiv." /></th>
                                    <th class="min-w-[4rem] border-l border-zinc-200 px-1 py-2 text-center dark:border-zinc-800"><input v-model="form.insumo_names.t3.ref_2" :class="nameInputClass" placeholder="Ref. Grup." /></th>
                                </template>
                                
                                <th class="min-w-[3rem] px-2 py-2 text-center font-black text-blue-700 dark:text-blue-400 border-l border-zinc-200 dark:border-zinc-800"><div class="rotate-180 [writing-mode:vertical-rl] text-[9px] mx-auto uppercase">Nuevo P. Indiv.</div></th>
                                <th class="min-w-[3rem] px-2 py-2 text-center font-black text-purple-700 dark:text-purple-400 border-l border-zinc-200 dark:border-zinc-800"><div class="rotate-180 [writing-mode:vertical-rl] text-[9px] mx-auto uppercase">Nuevo P. Grup.</div></th>
                                <th class="min-w-[3rem] px-2 py-2 text-center font-black text-rose-600 dark:text-rose-400 border-l border-zinc-200 dark:border-zinc-800"><div class="rotate-180 [writing-mode:vertical-rl] text-[9px] mx-auto uppercase">Prom. Parcial</div></th>
                                
                                <template v-if="activeTab === 't1'">
                                    <th class="min-w-[4rem] border-l border-zinc-200 px-1 py-2 text-center dark:border-zinc-800"><input v-model="form.insumo_names.t1.proj" :class="nameInputClass" placeholder="Proyecto" /></th>
                                    <th class="min-w-[4rem] border-l border-zinc-200 px-1 py-2 text-center dark:border-zinc-800"><input v-model="form.insumo_names.t1.eval" :class="nameInputClass" placeholder="Evaluación" /></th>
                                </template>
                                <template v-else-if="activeTab === 't2'">
                                    <th class="min-w-[4rem] border-l border-zinc-200 px-1 py-2 text-center dark:border-zinc-800"><input v-model="form.insumo_names.t2.proj" :class="nameInputClass" placeholder="Proyecto" /></th>
                                    <th class="min-w-[4rem] border-l border-zinc-200 px-1 py-2 text-center dark:border-zinc-800"><input v-model="form.insumo_names.t2.eval" :class="nameInputClass" placeholder="Evaluación" /></th>
                                </template>
                                <template v-else>
                                    <th class="min-w-[4rem] border-l border-zinc-200 px-1 py-2 text-center dark:border-zinc-800"><input v-model="form.insumo_names.t3.proj" :class="nameInputClass" placeholder="Proyecto" /></th>
                                    <th class="min-w-[4rem] border-l border-zinc-200 px-1 py-2 text-center dark:border-zinc-800"><input v-model="form.insumo_names.t3.eval" :class="nameInputClass" placeholder="Evaluación" /></th>
                                </template>
                                
                                <th class="min-w-[4rem] px-2 py-2 text-center font-black text-emerald-700 dark:text-emerald-400 border-l border-zinc-200 dark:border-zinc-800"><div class="rotate-180 [writing-mode:vertical-rl] text-[9px] mx-auto uppercase">Prom. Final</div></th>
                                <th class="border-l border-zinc-200 px-4 py-2 dark:border-zinc-800"></th>
                            </tr>"""

# Regex to find the <tr class="h-24 bg-zinc-50/50 dark:bg-zinc-800/30"> block down to the end of the </thead>
pattern = re.compile(r'                            <tr class="h-24 bg-zinc-50/50 dark:bg-zinc-800/30">.*?</template>\s*<th\s*class="border-l border-zinc-200 px-4 py-2 dark:border-zinc-800"\s*></th>\s*</tr>', re.DOTALL)

content = pattern.sub(new_tr2, content)

with open('resources/js/pages/Academic/Grades/Edit.vue', 'w') as f:
    f.write(content)

import re

with open('resources/js/pages/Academic/Grades/Edit.vue', 'r') as f:
    content = f.read()

# 1. Replace the first header row (around line 716-755)
old_tr1 = """                            <tr>
                                <th
                                    class="sticky left-0 z-30 bg-zinc-50 px-6 py-4 text-[10px] font-black tracking-widest whitespace-nowrap text-zinc-400 uppercase dark:bg-zinc-800"
                                >
                                    Estudiante
                                </th>
                                <th
                                    class="border-l border-zinc-200 px-3 py-4 text-center text-[10px] font-black tracking-widest text-zinc-400 uppercase dark:border-zinc-800"
                                    colspan="6"
                                >
                                    Indiv.
                                </th>
                                <th
                                    class="border-l border-zinc-200 px-3 py-4 text-center text-[10px] font-black tracking-widest text-zinc-400 uppercase dark:border-zinc-800"
                                    colspan="6"
                                >
                                    Grup.
                                </th>
                                <th
                                    class="border-l border-zinc-200 px-3 py-4 text-center text-[10px] font-black tracking-widest text-zinc-400 uppercase dark:border-zinc-800"
                                    colspan="2"
                                >
                                    Ref.
                                </th>
                                <th
                                    class="border-l border-zinc-200 px-3 py-4 text-center text-[10px] font-black tracking-widest text-zinc-400 uppercase dark:border-zinc-800"
                                >
                                    Proj.
                                </th>
                                <th
                                    class="border-l border-zinc-200 px-3 py-4 text-center text-[10px] font-black tracking-widest text-zinc-400 uppercase dark:border-zinc-800"
                                >
                                    Eval.
                                </th>
                                <th
                                    class="border-l border-zinc-200 px-6 py-4 text-[10px] font-black tracking-widest text-zinc-400 uppercase dark:border-zinc-800"
                                >
                                    Obs.
                                </th>
                            </tr>"""

new_tr1 = """                            <tr>
                                <th class="sticky left-0 z-30 bg-zinc-50 px-6 py-4 text-[10px] font-black tracking-widest whitespace-nowrap text-zinc-400 uppercase dark:bg-zinc-800">
                                    Estudiante
                                </th>
                                <th class="border-l border-zinc-200 px-3 py-4 text-center text-[10px] font-black tracking-widest text-zinc-400 uppercase dark:border-zinc-800 bg-blue-50/50 dark:bg-blue-900/10" colspan="7">
                                    Insumos Individuales
                                </th>
                                <th class="border-l border-zinc-200 px-3 py-4 text-center text-[10px] font-black tracking-widest text-zinc-400 uppercase dark:border-zinc-800 bg-purple-50/50 dark:bg-purple-900/10" colspan="7">
                                    Insumos Grupales
                                </th>
                                <th class="border-l border-zinc-200 px-3 py-4 text-center text-[10px] font-black tracking-widest text-zinc-400 uppercase dark:border-zinc-800 bg-amber-50/50 dark:bg-amber-900/10" colspan="8">
                                    Promedios y Ponderación
                                </th>
                                <th class="border-l border-zinc-200 px-6 py-4 text-[10px] font-black tracking-widest text-zinc-400 uppercase dark:border-zinc-800">
                                    Obs.
                                </th>
                            </tr>"""

content = content.replace(old_tr1, new_tr1)

# Write back
with open('resources/js/pages/Academic/Grades/Edit.vue', 'w') as f:
    f.write(content)

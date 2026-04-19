import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../wayfinder'
/**
* @see \App\Http\Controllers\StudentController::exportTemplate
* @see app/Http/Controllers/StudentController.php:23
* @route '/{current_team}/students/export-template'
*/
export const exportTemplate = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: exportTemplate.url(args, options),
    method: 'get',
})

exportTemplate.definition = {
    methods: ["get","head"],
    url: '/{current_team}/students/export-template',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StudentController::exportTemplate
* @see app/Http/Controllers/StudentController.php:23
* @route '/{current_team}/students/export-template'
*/
exportTemplate.url = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { current_team: args }
    }

    if (Array.isArray(args)) {
        args = {
            current_team: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        current_team: args.current_team,
    }

    return exportTemplate.definition.url
            .replace('{current_team}', parsedArgs.current_team.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentController::exportTemplate
* @see app/Http/Controllers/StudentController.php:23
* @route '/{current_team}/students/export-template'
*/
exportTemplate.get = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: exportTemplate.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\StudentController::exportTemplate
* @see app/Http/Controllers/StudentController.php:23
* @route '/{current_team}/students/export-template'
*/
exportTemplate.head = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: exportTemplate.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StudentController::exportTemplate
* @see app/Http/Controllers/StudentController.php:23
* @route '/{current_team}/students/export-template'
*/
const exportTemplateForm = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: exportTemplate.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\StudentController::exportTemplate
* @see app/Http/Controllers/StudentController.php:23
* @route '/{current_team}/students/export-template'
*/
exportTemplateForm.get = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: exportTemplate.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\StudentController::exportTemplate
* @see app/Http/Controllers/StudentController.php:23
* @route '/{current_team}/students/export-template'
*/
exportTemplateForm.head = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: exportTemplate.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

exportTemplate.form = exportTemplateForm

/**
* @see \App\Http\Controllers\StudentController::importExcel
* @see app/Http/Controllers/StudentController.php:31
* @route '/{current_team}/students/import'
*/
export const importExcel = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: importExcel.url(args, options),
    method: 'post',
})

importExcel.definition = {
    methods: ["post"],
    url: '/{current_team}/students/import',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\StudentController::importExcel
* @see app/Http/Controllers/StudentController.php:31
* @route '/{current_team}/students/import'
*/
importExcel.url = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { current_team: args }
    }

    if (Array.isArray(args)) {
        args = {
            current_team: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        current_team: args.current_team,
    }

    return importExcel.definition.url
            .replace('{current_team}', parsedArgs.current_team.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentController::importExcel
* @see app/Http/Controllers/StudentController.php:31
* @route '/{current_team}/students/import'
*/
importExcel.post = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: importExcel.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\StudentController::importExcel
* @see app/Http/Controllers/StudentController.php:31
* @route '/{current_team}/students/import'
*/
const importExcelForm = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: importExcel.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\StudentController::importExcel
* @see app/Http/Controllers/StudentController.php:31
* @route '/{current_team}/students/import'
*/
importExcelForm.post = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: importExcel.url(args, options),
    method: 'post',
})

importExcel.form = importExcelForm

/**
* @see \App\Http\Controllers\StudentController::index
* @see app/Http/Controllers/StudentController.php:55
* @route '/{current_team}/students'
*/
export const index = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(args, options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/{current_team}/students',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StudentController::index
* @see app/Http/Controllers/StudentController.php:55
* @route '/{current_team}/students'
*/
index.url = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { current_team: args }
    }

    if (Array.isArray(args)) {
        args = {
            current_team: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        current_team: args.current_team,
    }

    return index.definition.url
            .replace('{current_team}', parsedArgs.current_team.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentController::index
* @see app/Http/Controllers/StudentController.php:55
* @route '/{current_team}/students'
*/
index.get = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\StudentController::index
* @see app/Http/Controllers/StudentController.php:55
* @route '/{current_team}/students'
*/
index.head = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StudentController::index
* @see app/Http/Controllers/StudentController.php:55
* @route '/{current_team}/students'
*/
const indexForm = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\StudentController::index
* @see app/Http/Controllers/StudentController.php:55
* @route '/{current_team}/students'
*/
indexForm.get = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\StudentController::index
* @see app/Http/Controllers/StudentController.php:55
* @route '/{current_team}/students'
*/
indexForm.head = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

index.form = indexForm

/**
* @see \App\Http\Controllers\StudentController::create
* @see app/Http/Controllers/StudentController.php:84
* @route '/{current_team}/students/create'
*/
export const create = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(args, options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/{current_team}/students/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StudentController::create
* @see app/Http/Controllers/StudentController.php:84
* @route '/{current_team}/students/create'
*/
create.url = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { current_team: args }
    }

    if (Array.isArray(args)) {
        args = {
            current_team: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        current_team: args.current_team,
    }

    return create.definition.url
            .replace('{current_team}', parsedArgs.current_team.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentController::create
* @see app/Http/Controllers/StudentController.php:84
* @route '/{current_team}/students/create'
*/
create.get = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\StudentController::create
* @see app/Http/Controllers/StudentController.php:84
* @route '/{current_team}/students/create'
*/
create.head = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StudentController::create
* @see app/Http/Controllers/StudentController.php:84
* @route '/{current_team}/students/create'
*/
const createForm = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\StudentController::create
* @see app/Http/Controllers/StudentController.php:84
* @route '/{current_team}/students/create'
*/
createForm.get = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\StudentController::create
* @see app/Http/Controllers/StudentController.php:84
* @route '/{current_team}/students/create'
*/
createForm.head = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

create.form = createForm

/**
* @see \App\Http\Controllers\StudentController::store
* @see app/Http/Controllers/StudentController.php:100
* @route '/{current_team}/students'
*/
export const store = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/{current_team}/students',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\StudentController::store
* @see app/Http/Controllers/StudentController.php:100
* @route '/{current_team}/students'
*/
store.url = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { current_team: args }
    }

    if (Array.isArray(args)) {
        args = {
            current_team: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        current_team: args.current_team,
    }

    return store.definition.url
            .replace('{current_team}', parsedArgs.current_team.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentController::store
* @see app/Http/Controllers/StudentController.php:100
* @route '/{current_team}/students'
*/
store.post = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\StudentController::store
* @see app/Http/Controllers/StudentController.php:100
* @route '/{current_team}/students'
*/
const storeForm = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\StudentController::store
* @see app/Http/Controllers/StudentController.php:100
* @route '/{current_team}/students'
*/
storeForm.post = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(args, options),
    method: 'post',
})

store.form = storeForm

/**
* @see \App\Http\Controllers\StudentController::edit
* @see app/Http/Controllers/StudentController.php:139
* @route '/{current_team}/students/{student}/edit'
*/
export const edit = (args: { current_team: string | number, student: number | { id: number } } | [current_team: string | number, student: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/{current_team}/students/{student}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StudentController::edit
* @see app/Http/Controllers/StudentController.php:139
* @route '/{current_team}/students/{student}/edit'
*/
edit.url = (args: { current_team: string | number, student: number | { id: number } } | [current_team: string | number, student: number | { id: number } ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            current_team: args[0],
            student: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        current_team: args.current_team,
        student: typeof args.student === 'object'
        ? args.student.id
        : args.student,
    }

    return edit.definition.url
            .replace('{current_team}', parsedArgs.current_team.toString())
            .replace('{student}', parsedArgs.student.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentController::edit
* @see app/Http/Controllers/StudentController.php:139
* @route '/{current_team}/students/{student}/edit'
*/
edit.get = (args: { current_team: string | number, student: number | { id: number } } | [current_team: string | number, student: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\StudentController::edit
* @see app/Http/Controllers/StudentController.php:139
* @route '/{current_team}/students/{student}/edit'
*/
edit.head = (args: { current_team: string | number, student: number | { id: number } } | [current_team: string | number, student: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StudentController::edit
* @see app/Http/Controllers/StudentController.php:139
* @route '/{current_team}/students/{student}/edit'
*/
const editForm = (args: { current_team: string | number, student: number | { id: number } } | [current_team: string | number, student: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\StudentController::edit
* @see app/Http/Controllers/StudentController.php:139
* @route '/{current_team}/students/{student}/edit'
*/
editForm.get = (args: { current_team: string | number, student: number | { id: number } } | [current_team: string | number, student: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\StudentController::edit
* @see app/Http/Controllers/StudentController.php:139
* @route '/{current_team}/students/{student}/edit'
*/
editForm.head = (args: { current_team: string | number, student: number | { id: number } } | [current_team: string | number, student: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

edit.form = editForm

/**
* @see \App\Http\Controllers\StudentController::update
* @see app/Http/Controllers/StudentController.php:157
* @route '/{current_team}/students/{student}'
*/
export const update = (args: { current_team: string | number, student: number | { id: number } } | [current_team: string | number, student: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put","patch"],
    url: '/{current_team}/students/{student}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \App\Http\Controllers\StudentController::update
* @see app/Http/Controllers/StudentController.php:157
* @route '/{current_team}/students/{student}'
*/
update.url = (args: { current_team: string | number, student: number | { id: number } } | [current_team: string | number, student: number | { id: number } ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            current_team: args[0],
            student: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        current_team: args.current_team,
        student: typeof args.student === 'object'
        ? args.student.id
        : args.student,
    }

    return update.definition.url
            .replace('{current_team}', parsedArgs.current_team.toString())
            .replace('{student}', parsedArgs.student.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentController::update
* @see app/Http/Controllers/StudentController.php:157
* @route '/{current_team}/students/{student}'
*/
update.put = (args: { current_team: string | number, student: number | { id: number } } | [current_team: string | number, student: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\StudentController::update
* @see app/Http/Controllers/StudentController.php:157
* @route '/{current_team}/students/{student}'
*/
update.patch = (args: { current_team: string | number, student: number | { id: number } } | [current_team: string | number, student: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\StudentController::update
* @see app/Http/Controllers/StudentController.php:157
* @route '/{current_team}/students/{student}'
*/
const updateForm = (args: { current_team: string | number, student: number | { id: number } } | [current_team: string | number, student: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\StudentController::update
* @see app/Http/Controllers/StudentController.php:157
* @route '/{current_team}/students/{student}'
*/
updateForm.put = (args: { current_team: string | number, student: number | { id: number } } | [current_team: string | number, student: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\StudentController::update
* @see app/Http/Controllers/StudentController.php:157
* @route '/{current_team}/students/{student}'
*/
updateForm.patch = (args: { current_team: string | number, student: number | { id: number } } | [current_team: string | number, student: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

update.form = updateForm

/**
* @see \App\Http\Controllers\StudentController::destroy
* @see app/Http/Controllers/StudentController.php:193
* @route '/{current_team}/students/{student}'
*/
export const destroy = (args: { current_team: string | number, student: number | { id: number } } | [current_team: string | number, student: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/{current_team}/students/{student}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\StudentController::destroy
* @see app/Http/Controllers/StudentController.php:193
* @route '/{current_team}/students/{student}'
*/
destroy.url = (args: { current_team: string | number, student: number | { id: number } } | [current_team: string | number, student: number | { id: number } ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            current_team: args[0],
            student: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        current_team: args.current_team,
        student: typeof args.student === 'object'
        ? args.student.id
        : args.student,
    }

    return destroy.definition.url
            .replace('{current_team}', parsedArgs.current_team.toString())
            .replace('{student}', parsedArgs.student.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentController::destroy
* @see app/Http/Controllers/StudentController.php:193
* @route '/{current_team}/students/{student}'
*/
destroy.delete = (args: { current_team: string | number, student: number | { id: number } } | [current_team: string | number, student: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\StudentController::destroy
* @see app/Http/Controllers/StudentController.php:193
* @route '/{current_team}/students/{student}'
*/
const destroyForm = (args: { current_team: string | number, student: number | { id: number } } | [current_team: string | number, student: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\StudentController::destroy
* @see app/Http/Controllers/StudentController.php:193
* @route '/{current_team}/students/{student}'
*/
destroyForm.delete = (args: { current_team: string | number, student: number | { id: number } } | [current_team: string | number, student: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

destroy.form = destroyForm

const students = {
    exportTemplate: Object.assign(exportTemplate, exportTemplate),
    importExcel: Object.assign(importExcel, importExcel),
    index: Object.assign(index, index),
    create: Object.assign(create, create),
    store: Object.assign(store, store),
    edit: Object.assign(edit, edit),
    update: Object.assign(update, update),
    destroy: Object.assign(destroy, destroy),
}

export default students
import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\TeacherController::subjects
* @see app/Http/Controllers/TeacherController.php:107
* @route '/{current_team}/teachers/{teacher}/subjects'
*/
export const subjects = (args: { current_team: string | number, teacher: number | { id: number } } | [current_team: string | number, teacher: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: subjects.url(args, options),
    method: 'get',
})

subjects.definition = {
    methods: ["get","head"],
    url: '/{current_team}/teachers/{teacher}/subjects',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\TeacherController::subjects
* @see app/Http/Controllers/TeacherController.php:107
* @route '/{current_team}/teachers/{teacher}/subjects'
*/
subjects.url = (args: { current_team: string | number, teacher: number | { id: number } } | [current_team: string | number, teacher: number | { id: number } ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            current_team: args[0],
            teacher: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        current_team: args.current_team,
        teacher: typeof args.teacher === 'object'
        ? args.teacher.id
        : args.teacher,
    }

    return subjects.definition.url
            .replace('{current_team}', parsedArgs.current_team.toString())
            .replace('{teacher}', parsedArgs.teacher.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\TeacherController::subjects
* @see app/Http/Controllers/TeacherController.php:107
* @route '/{current_team}/teachers/{teacher}/subjects'
*/
subjects.get = (args: { current_team: string | number, teacher: number | { id: number } } | [current_team: string | number, teacher: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: subjects.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\TeacherController::subjects
* @see app/Http/Controllers/TeacherController.php:107
* @route '/{current_team}/teachers/{teacher}/subjects'
*/
subjects.head = (args: { current_team: string | number, teacher: number | { id: number } } | [current_team: string | number, teacher: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: subjects.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\TeacherController::subjects
* @see app/Http/Controllers/TeacherController.php:107
* @route '/{current_team}/teachers/{teacher}/subjects'
*/
const subjectsForm = (args: { current_team: string | number, teacher: number | { id: number } } | [current_team: string | number, teacher: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: subjects.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\TeacherController::subjects
* @see app/Http/Controllers/TeacherController.php:107
* @route '/{current_team}/teachers/{teacher}/subjects'
*/
subjectsForm.get = (args: { current_team: string | number, teacher: number | { id: number } } | [current_team: string | number, teacher: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: subjects.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\TeacherController::subjects
* @see app/Http/Controllers/TeacherController.php:107
* @route '/{current_team}/teachers/{teacher}/subjects'
*/
subjectsForm.head = (args: { current_team: string | number, teacher: number | { id: number } } | [current_team: string | number, teacher: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: subjects.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

subjects.form = subjectsForm

/**
* @see \App\Http\Controllers\TeacherController::updateSubjects
* @see app/Http/Controllers/TeacherController.php:125
* @route '/{current_team}/teachers/{teacher}/subjects'
*/
export const updateSubjects = (args: { current_team: string | number, teacher: number | { id: number } } | [current_team: string | number, teacher: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: updateSubjects.url(args, options),
    method: 'post',
})

updateSubjects.definition = {
    methods: ["post"],
    url: '/{current_team}/teachers/{teacher}/subjects',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\TeacherController::updateSubjects
* @see app/Http/Controllers/TeacherController.php:125
* @route '/{current_team}/teachers/{teacher}/subjects'
*/
updateSubjects.url = (args: { current_team: string | number, teacher: number | { id: number } } | [current_team: string | number, teacher: number | { id: number } ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            current_team: args[0],
            teacher: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        current_team: args.current_team,
        teacher: typeof args.teacher === 'object'
        ? args.teacher.id
        : args.teacher,
    }

    return updateSubjects.definition.url
            .replace('{current_team}', parsedArgs.current_team.toString())
            .replace('{teacher}', parsedArgs.teacher.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\TeacherController::updateSubjects
* @see app/Http/Controllers/TeacherController.php:125
* @route '/{current_team}/teachers/{teacher}/subjects'
*/
updateSubjects.post = (args: { current_team: string | number, teacher: number | { id: number } } | [current_team: string | number, teacher: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: updateSubjects.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\TeacherController::updateSubjects
* @see app/Http/Controllers/TeacherController.php:125
* @route '/{current_team}/teachers/{teacher}/subjects'
*/
const updateSubjectsForm = (args: { current_team: string | number, teacher: number | { id: number } } | [current_team: string | number, teacher: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updateSubjects.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\TeacherController::updateSubjects
* @see app/Http/Controllers/TeacherController.php:125
* @route '/{current_team}/teachers/{teacher}/subjects'
*/
updateSubjectsForm.post = (args: { current_team: string | number, teacher: number | { id: number } } | [current_team: string | number, teacher: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updateSubjects.url(args, options),
    method: 'post',
})

updateSubjects.form = updateSubjectsForm

/**
* @see \App\Http\Controllers\TeacherController::index
* @see app/Http/Controllers/TeacherController.php:17
* @route '/{current_team}/teachers'
*/
export const index = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(args, options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/{current_team}/teachers',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\TeacherController::index
* @see app/Http/Controllers/TeacherController.php:17
* @route '/{current_team}/teachers'
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
* @see \App\Http\Controllers\TeacherController::index
* @see app/Http/Controllers/TeacherController.php:17
* @route '/{current_team}/teachers'
*/
index.get = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\TeacherController::index
* @see app/Http/Controllers/TeacherController.php:17
* @route '/{current_team}/teachers'
*/
index.head = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\TeacherController::index
* @see app/Http/Controllers/TeacherController.php:17
* @route '/{current_team}/teachers'
*/
const indexForm = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\TeacherController::index
* @see app/Http/Controllers/TeacherController.php:17
* @route '/{current_team}/teachers'
*/
indexForm.get = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\TeacherController::index
* @see app/Http/Controllers/TeacherController.php:17
* @route '/{current_team}/teachers'
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
* @see \App\Http\Controllers\TeacherController::create
* @see app/Http/Controllers/TeacherController.php:31
* @route '/{current_team}/teachers/create'
*/
export const create = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(args, options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/{current_team}/teachers/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\TeacherController::create
* @see app/Http/Controllers/TeacherController.php:31
* @route '/{current_team}/teachers/create'
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
* @see \App\Http\Controllers\TeacherController::create
* @see app/Http/Controllers/TeacherController.php:31
* @route '/{current_team}/teachers/create'
*/
create.get = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\TeacherController::create
* @see app/Http/Controllers/TeacherController.php:31
* @route '/{current_team}/teachers/create'
*/
create.head = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\TeacherController::create
* @see app/Http/Controllers/TeacherController.php:31
* @route '/{current_team}/teachers/create'
*/
const createForm = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\TeacherController::create
* @see app/Http/Controllers/TeacherController.php:31
* @route '/{current_team}/teachers/create'
*/
createForm.get = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\TeacherController::create
* @see app/Http/Controllers/TeacherController.php:31
* @route '/{current_team}/teachers/create'
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
* @see \App\Http\Controllers\TeacherController::store
* @see app/Http/Controllers/TeacherController.php:38
* @route '/{current_team}/teachers'
*/
export const store = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/{current_team}/teachers',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\TeacherController::store
* @see app/Http/Controllers/TeacherController.php:38
* @route '/{current_team}/teachers'
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
* @see \App\Http\Controllers\TeacherController::store
* @see app/Http/Controllers/TeacherController.php:38
* @route '/{current_team}/teachers'
*/
store.post = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\TeacherController::store
* @see app/Http/Controllers/TeacherController.php:38
* @route '/{current_team}/teachers'
*/
const storeForm = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\TeacherController::store
* @see app/Http/Controllers/TeacherController.php:38
* @route '/{current_team}/teachers'
*/
storeForm.post = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(args, options),
    method: 'post',
})

store.form = storeForm

/**
* @see \App\Http\Controllers\TeacherController::edit
* @see app/Http/Controllers/TeacherController.php:71
* @route '/{current_team}/teachers/{teacher}/edit'
*/
export const edit = (args: { current_team: string | number, teacher: number | { id: number } } | [current_team: string | number, teacher: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/{current_team}/teachers/{teacher}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\TeacherController::edit
* @see app/Http/Controllers/TeacherController.php:71
* @route '/{current_team}/teachers/{teacher}/edit'
*/
edit.url = (args: { current_team: string | number, teacher: number | { id: number } } | [current_team: string | number, teacher: number | { id: number } ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            current_team: args[0],
            teacher: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        current_team: args.current_team,
        teacher: typeof args.teacher === 'object'
        ? args.teacher.id
        : args.teacher,
    }

    return edit.definition.url
            .replace('{current_team}', parsedArgs.current_team.toString())
            .replace('{teacher}', parsedArgs.teacher.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\TeacherController::edit
* @see app/Http/Controllers/TeacherController.php:71
* @route '/{current_team}/teachers/{teacher}/edit'
*/
edit.get = (args: { current_team: string | number, teacher: number | { id: number } } | [current_team: string | number, teacher: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\TeacherController::edit
* @see app/Http/Controllers/TeacherController.php:71
* @route '/{current_team}/teachers/{teacher}/edit'
*/
edit.head = (args: { current_team: string | number, teacher: number | { id: number } } | [current_team: string | number, teacher: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\TeacherController::edit
* @see app/Http/Controllers/TeacherController.php:71
* @route '/{current_team}/teachers/{teacher}/edit'
*/
const editForm = (args: { current_team: string | number, teacher: number | { id: number } } | [current_team: string | number, teacher: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\TeacherController::edit
* @see app/Http/Controllers/TeacherController.php:71
* @route '/{current_team}/teachers/{teacher}/edit'
*/
editForm.get = (args: { current_team: string | number, teacher: number | { id: number } } | [current_team: string | number, teacher: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\TeacherController::edit
* @see app/Http/Controllers/TeacherController.php:71
* @route '/{current_team}/teachers/{teacher}/edit'
*/
editForm.head = (args: { current_team: string | number, teacher: number | { id: number } } | [current_team: string | number, teacher: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
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
* @see \App\Http\Controllers\TeacherController::update
* @see app/Http/Controllers/TeacherController.php:84
* @route '/{current_team}/teachers/{teacher}'
*/
export const update = (args: { current_team: string | number, teacher: number | { id: number } } | [current_team: string | number, teacher: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put","patch"],
    url: '/{current_team}/teachers/{teacher}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \App\Http\Controllers\TeacherController::update
* @see app/Http/Controllers/TeacherController.php:84
* @route '/{current_team}/teachers/{teacher}'
*/
update.url = (args: { current_team: string | number, teacher: number | { id: number } } | [current_team: string | number, teacher: number | { id: number } ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            current_team: args[0],
            teacher: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        current_team: args.current_team,
        teacher: typeof args.teacher === 'object'
        ? args.teacher.id
        : args.teacher,
    }

    return update.definition.url
            .replace('{current_team}', parsedArgs.current_team.toString())
            .replace('{teacher}', parsedArgs.teacher.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\TeacherController::update
* @see app/Http/Controllers/TeacherController.php:84
* @route '/{current_team}/teachers/{teacher}'
*/
update.put = (args: { current_team: string | number, teacher: number | { id: number } } | [current_team: string | number, teacher: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\TeacherController::update
* @see app/Http/Controllers/TeacherController.php:84
* @route '/{current_team}/teachers/{teacher}'
*/
update.patch = (args: { current_team: string | number, teacher: number | { id: number } } | [current_team: string | number, teacher: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\TeacherController::update
* @see app/Http/Controllers/TeacherController.php:84
* @route '/{current_team}/teachers/{teacher}'
*/
const updateForm = (args: { current_team: string | number, teacher: number | { id: number } } | [current_team: string | number, teacher: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\TeacherController::update
* @see app/Http/Controllers/TeacherController.php:84
* @route '/{current_team}/teachers/{teacher}'
*/
updateForm.put = (args: { current_team: string | number, teacher: number | { id: number } } | [current_team: string | number, teacher: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\TeacherController::update
* @see app/Http/Controllers/TeacherController.php:84
* @route '/{current_team}/teachers/{teacher}'
*/
updateForm.patch = (args: { current_team: string | number, teacher: number | { id: number } } | [current_team: string | number, teacher: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
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
* @see \App\Http\Controllers\TeacherController::destroy
* @see app/Http/Controllers/TeacherController.php:0
* @route '/{current_team}/teachers/{teacher}'
*/
export const destroy = (args: { current_team: string | number, teacher: string | number } | [current_team: string | number, teacher: string | number ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/{current_team}/teachers/{teacher}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\TeacherController::destroy
* @see app/Http/Controllers/TeacherController.php:0
* @route '/{current_team}/teachers/{teacher}'
*/
destroy.url = (args: { current_team: string | number, teacher: string | number } | [current_team: string | number, teacher: string | number ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            current_team: args[0],
            teacher: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        current_team: args.current_team,
        teacher: args.teacher,
    }

    return destroy.definition.url
            .replace('{current_team}', parsedArgs.current_team.toString())
            .replace('{teacher}', parsedArgs.teacher.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\TeacherController::destroy
* @see app/Http/Controllers/TeacherController.php:0
* @route '/{current_team}/teachers/{teacher}'
*/
destroy.delete = (args: { current_team: string | number, teacher: string | number } | [current_team: string | number, teacher: string | number ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\TeacherController::destroy
* @see app/Http/Controllers/TeacherController.php:0
* @route '/{current_team}/teachers/{teacher}'
*/
const destroyForm = (args: { current_team: string | number, teacher: string | number } | [current_team: string | number, teacher: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\TeacherController::destroy
* @see app/Http/Controllers/TeacherController.php:0
* @route '/{current_team}/teachers/{teacher}'
*/
destroyForm.delete = (args: { current_team: string | number, teacher: string | number } | [current_team: string | number, teacher: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

destroy.form = destroyForm

const TeacherController = { subjects, updateSubjects, index, create, store, edit, update, destroy }

export default TeacherController
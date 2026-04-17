import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\CourseController::subjects
* @see app/Http/Controllers/CourseController.php:81
* @route '/{current_team}/courses/{course}/subjects'
*/
export const subjects = (args: { current_team: string | number, course: number | { id: number } } | [current_team: string | number, course: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: subjects.url(args, options),
    method: 'get',
})

subjects.definition = {
    methods: ["get","head"],
    url: '/{current_team}/courses/{course}/subjects',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\CourseController::subjects
* @see app/Http/Controllers/CourseController.php:81
* @route '/{current_team}/courses/{course}/subjects'
*/
subjects.url = (args: { current_team: string | number, course: number | { id: number } } | [current_team: string | number, course: number | { id: number } ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            current_team: args[0],
            course: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        current_team: args.current_team,
        course: typeof args.course === 'object'
        ? args.course.id
        : args.course,
    }

    return subjects.definition.url
            .replace('{current_team}', parsedArgs.current_team.toString())
            .replace('{course}', parsedArgs.course.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\CourseController::subjects
* @see app/Http/Controllers/CourseController.php:81
* @route '/{current_team}/courses/{course}/subjects'
*/
subjects.get = (args: { current_team: string | number, course: number | { id: number } } | [current_team: string | number, course: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: subjects.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CourseController::subjects
* @see app/Http/Controllers/CourseController.php:81
* @route '/{current_team}/courses/{course}/subjects'
*/
subjects.head = (args: { current_team: string | number, course: number | { id: number } } | [current_team: string | number, course: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: subjects.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\CourseController::subjects
* @see app/Http/Controllers/CourseController.php:81
* @route '/{current_team}/courses/{course}/subjects'
*/
const subjectsForm = (args: { current_team: string | number, course: number | { id: number } } | [current_team: string | number, course: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: subjects.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CourseController::subjects
* @see app/Http/Controllers/CourseController.php:81
* @route '/{current_team}/courses/{course}/subjects'
*/
subjectsForm.get = (args: { current_team: string | number, course: number | { id: number } } | [current_team: string | number, course: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: subjects.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CourseController::subjects
* @see app/Http/Controllers/CourseController.php:81
* @route '/{current_team}/courses/{course}/subjects'
*/
subjectsForm.head = (args: { current_team: string | number, course: number | { id: number } } | [current_team: string | number, course: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
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
* @see \App\Http\Controllers\CourseController::updateSubjects
* @see app/Http/Controllers/CourseController.php:99
* @route '/{current_team}/courses/{course}/subjects'
*/
export const updateSubjects = (args: { current_team: string | number, course: number | { id: number } } | [current_team: string | number, course: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: updateSubjects.url(args, options),
    method: 'post',
})

updateSubjects.definition = {
    methods: ["post"],
    url: '/{current_team}/courses/{course}/subjects',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\CourseController::updateSubjects
* @see app/Http/Controllers/CourseController.php:99
* @route '/{current_team}/courses/{course}/subjects'
*/
updateSubjects.url = (args: { current_team: string | number, course: number | { id: number } } | [current_team: string | number, course: number | { id: number } ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            current_team: args[0],
            course: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        current_team: args.current_team,
        course: typeof args.course === 'object'
        ? args.course.id
        : args.course,
    }

    return updateSubjects.definition.url
            .replace('{current_team}', parsedArgs.current_team.toString())
            .replace('{course}', parsedArgs.course.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\CourseController::updateSubjects
* @see app/Http/Controllers/CourseController.php:99
* @route '/{current_team}/courses/{course}/subjects'
*/
updateSubjects.post = (args: { current_team: string | number, course: number | { id: number } } | [current_team: string | number, course: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: updateSubjects.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\CourseController::updateSubjects
* @see app/Http/Controllers/CourseController.php:99
* @route '/{current_team}/courses/{course}/subjects'
*/
const updateSubjectsForm = (args: { current_team: string | number, course: number | { id: number } } | [current_team: string | number, course: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updateSubjects.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\CourseController::updateSubjects
* @see app/Http/Controllers/CourseController.php:99
* @route '/{current_team}/courses/{course}/subjects'
*/
updateSubjectsForm.post = (args: { current_team: string | number, course: number | { id: number } } | [current_team: string | number, course: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updateSubjects.url(args, options),
    method: 'post',
})

updateSubjects.form = updateSubjectsForm

/**
* @see \App\Http\Controllers\CourseController::index
* @see app/Http/Controllers/CourseController.php:17
* @route '/{current_team}/courses'
*/
export const index = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(args, options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/{current_team}/courses',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\CourseController::index
* @see app/Http/Controllers/CourseController.php:17
* @route '/{current_team}/courses'
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
* @see \App\Http\Controllers\CourseController::index
* @see app/Http/Controllers/CourseController.php:17
* @route '/{current_team}/courses'
*/
index.get = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CourseController::index
* @see app/Http/Controllers/CourseController.php:17
* @route '/{current_team}/courses'
*/
index.head = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\CourseController::index
* @see app/Http/Controllers/CourseController.php:17
* @route '/{current_team}/courses'
*/
const indexForm = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CourseController::index
* @see app/Http/Controllers/CourseController.php:17
* @route '/{current_team}/courses'
*/
indexForm.get = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CourseController::index
* @see app/Http/Controllers/CourseController.php:17
* @route '/{current_team}/courses'
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
* @see \App\Http\Controllers\CourseController::create
* @see app/Http/Controllers/CourseController.php:33
* @route '/{current_team}/courses/create'
*/
export const create = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(args, options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/{current_team}/courses/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\CourseController::create
* @see app/Http/Controllers/CourseController.php:33
* @route '/{current_team}/courses/create'
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
* @see \App\Http\Controllers\CourseController::create
* @see app/Http/Controllers/CourseController.php:33
* @route '/{current_team}/courses/create'
*/
create.get = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CourseController::create
* @see app/Http/Controllers/CourseController.php:33
* @route '/{current_team}/courses/create'
*/
create.head = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\CourseController::create
* @see app/Http/Controllers/CourseController.php:33
* @route '/{current_team}/courses/create'
*/
const createForm = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CourseController::create
* @see app/Http/Controllers/CourseController.php:33
* @route '/{current_team}/courses/create'
*/
createForm.get = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CourseController::create
* @see app/Http/Controllers/CourseController.php:33
* @route '/{current_team}/courses/create'
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
* @see \App\Http\Controllers\CourseController::store
* @see app/Http/Controllers/CourseController.php:45
* @route '/{current_team}/courses'
*/
export const store = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/{current_team}/courses',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\CourseController::store
* @see app/Http/Controllers/CourseController.php:45
* @route '/{current_team}/courses'
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
* @see \App\Http\Controllers\CourseController::store
* @see app/Http/Controllers/CourseController.php:45
* @route '/{current_team}/courses'
*/
store.post = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\CourseController::store
* @see app/Http/Controllers/CourseController.php:45
* @route '/{current_team}/courses'
*/
const storeForm = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\CourseController::store
* @see app/Http/Controllers/CourseController.php:45
* @route '/{current_team}/courses'
*/
storeForm.post = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(args, options),
    method: 'post',
})

store.form = storeForm

/**
* @see \App\Http\Controllers\CourseController::show
* @see app/Http/Controllers/CourseController.php:65
* @route '/{current_team}/courses/{course}'
*/
export const show = (args: { current_team: string | number, course: string | number } | [current_team: string | number, course: string | number ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/{current_team}/courses/{course}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\CourseController::show
* @see app/Http/Controllers/CourseController.php:65
* @route '/{current_team}/courses/{course}'
*/
show.url = (args: { current_team: string | number, course: string | number } | [current_team: string | number, course: string | number ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            current_team: args[0],
            course: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        current_team: args.current_team,
        course: args.course,
    }

    return show.definition.url
            .replace('{current_team}', parsedArgs.current_team.toString())
            .replace('{course}', parsedArgs.course.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\CourseController::show
* @see app/Http/Controllers/CourseController.php:65
* @route '/{current_team}/courses/{course}'
*/
show.get = (args: { current_team: string | number, course: string | number } | [current_team: string | number, course: string | number ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CourseController::show
* @see app/Http/Controllers/CourseController.php:65
* @route '/{current_team}/courses/{course}'
*/
show.head = (args: { current_team: string | number, course: string | number } | [current_team: string | number, course: string | number ], options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\CourseController::show
* @see app/Http/Controllers/CourseController.php:65
* @route '/{current_team}/courses/{course}'
*/
const showForm = (args: { current_team: string | number, course: string | number } | [current_team: string | number, course: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CourseController::show
* @see app/Http/Controllers/CourseController.php:65
* @route '/{current_team}/courses/{course}'
*/
showForm.get = (args: { current_team: string | number, course: string | number } | [current_team: string | number, course: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CourseController::show
* @see app/Http/Controllers/CourseController.php:65
* @route '/{current_team}/courses/{course}'
*/
showForm.head = (args: { current_team: string | number, course: string | number } | [current_team: string | number, course: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

show.form = showForm

/**
* @see \App\Http\Controllers\CourseController::edit
* @see app/Http/Controllers/CourseController.php:73
* @route '/{current_team}/courses/{course}/edit'
*/
export const edit = (args: { current_team: string | number, course: string | number } | [current_team: string | number, course: string | number ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/{current_team}/courses/{course}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\CourseController::edit
* @see app/Http/Controllers/CourseController.php:73
* @route '/{current_team}/courses/{course}/edit'
*/
edit.url = (args: { current_team: string | number, course: string | number } | [current_team: string | number, course: string | number ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            current_team: args[0],
            course: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        current_team: args.current_team,
        course: args.course,
    }

    return edit.definition.url
            .replace('{current_team}', parsedArgs.current_team.toString())
            .replace('{course}', parsedArgs.course.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\CourseController::edit
* @see app/Http/Controllers/CourseController.php:73
* @route '/{current_team}/courses/{course}/edit'
*/
edit.get = (args: { current_team: string | number, course: string | number } | [current_team: string | number, course: string | number ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CourseController::edit
* @see app/Http/Controllers/CourseController.php:73
* @route '/{current_team}/courses/{course}/edit'
*/
edit.head = (args: { current_team: string | number, course: string | number } | [current_team: string | number, course: string | number ], options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\CourseController::edit
* @see app/Http/Controllers/CourseController.php:73
* @route '/{current_team}/courses/{course}/edit'
*/
const editForm = (args: { current_team: string | number, course: string | number } | [current_team: string | number, course: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CourseController::edit
* @see app/Http/Controllers/CourseController.php:73
* @route '/{current_team}/courses/{course}/edit'
*/
editForm.get = (args: { current_team: string | number, course: string | number } | [current_team: string | number, course: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CourseController::edit
* @see app/Http/Controllers/CourseController.php:73
* @route '/{current_team}/courses/{course}/edit'
*/
editForm.head = (args: { current_team: string | number, course: string | number } | [current_team: string | number, course: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
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
* @see \App\Http\Controllers\CourseController::update
* @see app/Http/Controllers/CourseController.php:0
* @route '/{current_team}/courses/{course}'
*/
export const update = (args: { current_team: string | number, course: string | number } | [current_team: string | number, course: string | number ], options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put","patch"],
    url: '/{current_team}/courses/{course}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \App\Http\Controllers\CourseController::update
* @see app/Http/Controllers/CourseController.php:0
* @route '/{current_team}/courses/{course}'
*/
update.url = (args: { current_team: string | number, course: string | number } | [current_team: string | number, course: string | number ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            current_team: args[0],
            course: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        current_team: args.current_team,
        course: args.course,
    }

    return update.definition.url
            .replace('{current_team}', parsedArgs.current_team.toString())
            .replace('{course}', parsedArgs.course.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\CourseController::update
* @see app/Http/Controllers/CourseController.php:0
* @route '/{current_team}/courses/{course}'
*/
update.put = (args: { current_team: string | number, course: string | number } | [current_team: string | number, course: string | number ], options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\CourseController::update
* @see app/Http/Controllers/CourseController.php:0
* @route '/{current_team}/courses/{course}'
*/
update.patch = (args: { current_team: string | number, course: string | number } | [current_team: string | number, course: string | number ], options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\CourseController::update
* @see app/Http/Controllers/CourseController.php:0
* @route '/{current_team}/courses/{course}'
*/
const updateForm = (args: { current_team: string | number, course: string | number } | [current_team: string | number, course: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\CourseController::update
* @see app/Http/Controllers/CourseController.php:0
* @route '/{current_team}/courses/{course}'
*/
updateForm.put = (args: { current_team: string | number, course: string | number } | [current_team: string | number, course: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\CourseController::update
* @see app/Http/Controllers/CourseController.php:0
* @route '/{current_team}/courses/{course}'
*/
updateForm.patch = (args: { current_team: string | number, course: string | number } | [current_team: string | number, course: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
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
* @see \App\Http\Controllers\CourseController::destroy
* @see app/Http/Controllers/CourseController.php:146
* @route '/{current_team}/courses/{course}'
*/
export const destroy = (args: { current_team: string | number, course: string | number } | [current_team: string | number, course: string | number ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/{current_team}/courses/{course}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\CourseController::destroy
* @see app/Http/Controllers/CourseController.php:146
* @route '/{current_team}/courses/{course}'
*/
destroy.url = (args: { current_team: string | number, course: string | number } | [current_team: string | number, course: string | number ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            current_team: args[0],
            course: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        current_team: args.current_team,
        course: args.course,
    }

    return destroy.definition.url
            .replace('{current_team}', parsedArgs.current_team.toString())
            .replace('{course}', parsedArgs.course.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\CourseController::destroy
* @see app/Http/Controllers/CourseController.php:146
* @route '/{current_team}/courses/{course}'
*/
destroy.delete = (args: { current_team: string | number, course: string | number } | [current_team: string | number, course: string | number ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\CourseController::destroy
* @see app/Http/Controllers/CourseController.php:146
* @route '/{current_team}/courses/{course}'
*/
const destroyForm = (args: { current_team: string | number, course: string | number } | [current_team: string | number, course: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\CourseController::destroy
* @see app/Http/Controllers/CourseController.php:146
* @route '/{current_team}/courses/{course}'
*/
destroyForm.delete = (args: { current_team: string | number, course: string | number } | [current_team: string | number, course: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

destroy.form = destroyForm

const CourseController = { subjects, updateSubjects, index, create, store, show, edit, update, destroy }

export default CourseController
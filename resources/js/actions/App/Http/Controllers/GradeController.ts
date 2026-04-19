import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\GradeController::edit
* @see app/Http/Controllers/GradeController.php:18
* @route '/teachers/grades/{courseSubject}'
*/
const edita6e6e2b6bd22d7e1c7a9dfc30ba813d1 = (args: { courseSubject: string | number } | [courseSubject: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edita6e6e2b6bd22d7e1c7a9dfc30ba813d1.url(args, options),
    method: 'get',
})

edita6e6e2b6bd22d7e1c7a9dfc30ba813d1.definition = {
    methods: ["get","head"],
    url: '/teachers/grades/{courseSubject}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\GradeController::edit
* @see app/Http/Controllers/GradeController.php:18
* @route '/teachers/grades/{courseSubject}'
*/
edita6e6e2b6bd22d7e1c7a9dfc30ba813d1.url = (args: { courseSubject: string | number } | [courseSubject: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { courseSubject: args }
    }

    if (Array.isArray(args)) {
        args = {
            courseSubject: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        courseSubject: args.courseSubject,
    }

    return edita6e6e2b6bd22d7e1c7a9dfc30ba813d1.definition.url
            .replace('{courseSubject}', parsedArgs.courseSubject.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\GradeController::edit
* @see app/Http/Controllers/GradeController.php:18
* @route '/teachers/grades/{courseSubject}'
*/
edita6e6e2b6bd22d7e1c7a9dfc30ba813d1.get = (args: { courseSubject: string | number } | [courseSubject: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edita6e6e2b6bd22d7e1c7a9dfc30ba813d1.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\GradeController::edit
* @see app/Http/Controllers/GradeController.php:18
* @route '/teachers/grades/{courseSubject}'
*/
edita6e6e2b6bd22d7e1c7a9dfc30ba813d1.head = (args: { courseSubject: string | number } | [courseSubject: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edita6e6e2b6bd22d7e1c7a9dfc30ba813d1.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\GradeController::edit
* @see app/Http/Controllers/GradeController.php:18
* @route '/teachers/grades/{courseSubject}'
*/
const edita6e6e2b6bd22d7e1c7a9dfc30ba813d1Form = (args: { courseSubject: string | number } | [courseSubject: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edita6e6e2b6bd22d7e1c7a9dfc30ba813d1.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\GradeController::edit
* @see app/Http/Controllers/GradeController.php:18
* @route '/teachers/grades/{courseSubject}'
*/
edita6e6e2b6bd22d7e1c7a9dfc30ba813d1Form.get = (args: { courseSubject: string | number } | [courseSubject: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edita6e6e2b6bd22d7e1c7a9dfc30ba813d1.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\GradeController::edit
* @see app/Http/Controllers/GradeController.php:18
* @route '/teachers/grades/{courseSubject}'
*/
edita6e6e2b6bd22d7e1c7a9dfc30ba813d1Form.head = (args: { courseSubject: string | number } | [courseSubject: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edita6e6e2b6bd22d7e1c7a9dfc30ba813d1.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

edita6e6e2b6bd22d7e1c7a9dfc30ba813d1.form = edita6e6e2b6bd22d7e1c7a9dfc30ba813d1Form
/**
* @see \App\Http\Controllers\GradeController::edit
* @see app/Http/Controllers/GradeController.php:18
* @route '/{current_team}/grades/{courseSubject}'
*/
const edit5ada30daf073685d879943d8b99dd875 = (args: { current_team: string | number, courseSubject: string | number } | [current_team: string | number, courseSubject: string | number ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit5ada30daf073685d879943d8b99dd875.url(args, options),
    method: 'get',
})

edit5ada30daf073685d879943d8b99dd875.definition = {
    methods: ["get","head"],
    url: '/{current_team}/grades/{courseSubject}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\GradeController::edit
* @see app/Http/Controllers/GradeController.php:18
* @route '/{current_team}/grades/{courseSubject}'
*/
edit5ada30daf073685d879943d8b99dd875.url = (args: { current_team: string | number, courseSubject: string | number } | [current_team: string | number, courseSubject: string | number ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            current_team: args[0],
            courseSubject: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        current_team: args.current_team,
        courseSubject: args.courseSubject,
    }

    return edit5ada30daf073685d879943d8b99dd875.definition.url
            .replace('{current_team}', parsedArgs.current_team.toString())
            .replace('{courseSubject}', parsedArgs.courseSubject.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\GradeController::edit
* @see app/Http/Controllers/GradeController.php:18
* @route '/{current_team}/grades/{courseSubject}'
*/
edit5ada30daf073685d879943d8b99dd875.get = (args: { current_team: string | number, courseSubject: string | number } | [current_team: string | number, courseSubject: string | number ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit5ada30daf073685d879943d8b99dd875.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\GradeController::edit
* @see app/Http/Controllers/GradeController.php:18
* @route '/{current_team}/grades/{courseSubject}'
*/
edit5ada30daf073685d879943d8b99dd875.head = (args: { current_team: string | number, courseSubject: string | number } | [current_team: string | number, courseSubject: string | number ], options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit5ada30daf073685d879943d8b99dd875.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\GradeController::edit
* @see app/Http/Controllers/GradeController.php:18
* @route '/{current_team}/grades/{courseSubject}'
*/
const edit5ada30daf073685d879943d8b99dd875Form = (args: { current_team: string | number, courseSubject: string | number } | [current_team: string | number, courseSubject: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit5ada30daf073685d879943d8b99dd875.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\GradeController::edit
* @see app/Http/Controllers/GradeController.php:18
* @route '/{current_team}/grades/{courseSubject}'
*/
edit5ada30daf073685d879943d8b99dd875Form.get = (args: { current_team: string | number, courseSubject: string | number } | [current_team: string | number, courseSubject: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit5ada30daf073685d879943d8b99dd875.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\GradeController::edit
* @see app/Http/Controllers/GradeController.php:18
* @route '/{current_team}/grades/{courseSubject}'
*/
edit5ada30daf073685d879943d8b99dd875Form.head = (args: { current_team: string | number, courseSubject: string | number } | [current_team: string | number, courseSubject: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit5ada30daf073685d879943d8b99dd875.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

edit5ada30daf073685d879943d8b99dd875.form = edit5ada30daf073685d879943d8b99dd875Form

export const edit = {
    '/teachers/grades/{courseSubject}': edita6e6e2b6bd22d7e1c7a9dfc30ba813d1,
    '/{current_team}/grades/{courseSubject}': edit5ada30daf073685d879943d8b99dd875,
}

/**
* @see \App\Http\Controllers\GradeController::exportPdf
* @see app/Http/Controllers/GradeController.php:127
* @route '/teachers/grades/{courseSubject}/pdf'
*/
const exportPdf708e77bb457f53d7f57ecfd1779fb8b4 = (args: { courseSubject: string | number } | [courseSubject: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: exportPdf708e77bb457f53d7f57ecfd1779fb8b4.url(args, options),
    method: 'get',
})

exportPdf708e77bb457f53d7f57ecfd1779fb8b4.definition = {
    methods: ["get","head"],
    url: '/teachers/grades/{courseSubject}/pdf',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\GradeController::exportPdf
* @see app/Http/Controllers/GradeController.php:127
* @route '/teachers/grades/{courseSubject}/pdf'
*/
exportPdf708e77bb457f53d7f57ecfd1779fb8b4.url = (args: { courseSubject: string | number } | [courseSubject: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { courseSubject: args }
    }

    if (Array.isArray(args)) {
        args = {
            courseSubject: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        courseSubject: args.courseSubject,
    }

    return exportPdf708e77bb457f53d7f57ecfd1779fb8b4.definition.url
            .replace('{courseSubject}', parsedArgs.courseSubject.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\GradeController::exportPdf
* @see app/Http/Controllers/GradeController.php:127
* @route '/teachers/grades/{courseSubject}/pdf'
*/
exportPdf708e77bb457f53d7f57ecfd1779fb8b4.get = (args: { courseSubject: string | number } | [courseSubject: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: exportPdf708e77bb457f53d7f57ecfd1779fb8b4.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\GradeController::exportPdf
* @see app/Http/Controllers/GradeController.php:127
* @route '/teachers/grades/{courseSubject}/pdf'
*/
exportPdf708e77bb457f53d7f57ecfd1779fb8b4.head = (args: { courseSubject: string | number } | [courseSubject: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: exportPdf708e77bb457f53d7f57ecfd1779fb8b4.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\GradeController::exportPdf
* @see app/Http/Controllers/GradeController.php:127
* @route '/teachers/grades/{courseSubject}/pdf'
*/
const exportPdf708e77bb457f53d7f57ecfd1779fb8b4Form = (args: { courseSubject: string | number } | [courseSubject: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: exportPdf708e77bb457f53d7f57ecfd1779fb8b4.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\GradeController::exportPdf
* @see app/Http/Controllers/GradeController.php:127
* @route '/teachers/grades/{courseSubject}/pdf'
*/
exportPdf708e77bb457f53d7f57ecfd1779fb8b4Form.get = (args: { courseSubject: string | number } | [courseSubject: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: exportPdf708e77bb457f53d7f57ecfd1779fb8b4.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\GradeController::exportPdf
* @see app/Http/Controllers/GradeController.php:127
* @route '/teachers/grades/{courseSubject}/pdf'
*/
exportPdf708e77bb457f53d7f57ecfd1779fb8b4Form.head = (args: { courseSubject: string | number } | [courseSubject: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: exportPdf708e77bb457f53d7f57ecfd1779fb8b4.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

exportPdf708e77bb457f53d7f57ecfd1779fb8b4.form = exportPdf708e77bb457f53d7f57ecfd1779fb8b4Form
/**
* @see \App\Http\Controllers\GradeController::exportPdf
* @see app/Http/Controllers/GradeController.php:127
* @route '/{current_team}/grades/{courseSubject}/pdf'
*/
const exportPdfa91fa546cb38faacf9c39c848bdfd99e = (args: { current_team: string | number, courseSubject: string | number } | [current_team: string | number, courseSubject: string | number ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: exportPdfa91fa546cb38faacf9c39c848bdfd99e.url(args, options),
    method: 'get',
})

exportPdfa91fa546cb38faacf9c39c848bdfd99e.definition = {
    methods: ["get","head"],
    url: '/{current_team}/grades/{courseSubject}/pdf',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\GradeController::exportPdf
* @see app/Http/Controllers/GradeController.php:127
* @route '/{current_team}/grades/{courseSubject}/pdf'
*/
exportPdfa91fa546cb38faacf9c39c848bdfd99e.url = (args: { current_team: string | number, courseSubject: string | number } | [current_team: string | number, courseSubject: string | number ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            current_team: args[0],
            courseSubject: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        current_team: args.current_team,
        courseSubject: args.courseSubject,
    }

    return exportPdfa91fa546cb38faacf9c39c848bdfd99e.definition.url
            .replace('{current_team}', parsedArgs.current_team.toString())
            .replace('{courseSubject}', parsedArgs.courseSubject.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\GradeController::exportPdf
* @see app/Http/Controllers/GradeController.php:127
* @route '/{current_team}/grades/{courseSubject}/pdf'
*/
exportPdfa91fa546cb38faacf9c39c848bdfd99e.get = (args: { current_team: string | number, courseSubject: string | number } | [current_team: string | number, courseSubject: string | number ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: exportPdfa91fa546cb38faacf9c39c848bdfd99e.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\GradeController::exportPdf
* @see app/Http/Controllers/GradeController.php:127
* @route '/{current_team}/grades/{courseSubject}/pdf'
*/
exportPdfa91fa546cb38faacf9c39c848bdfd99e.head = (args: { current_team: string | number, courseSubject: string | number } | [current_team: string | number, courseSubject: string | number ], options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: exportPdfa91fa546cb38faacf9c39c848bdfd99e.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\GradeController::exportPdf
* @see app/Http/Controllers/GradeController.php:127
* @route '/{current_team}/grades/{courseSubject}/pdf'
*/
const exportPdfa91fa546cb38faacf9c39c848bdfd99eForm = (args: { current_team: string | number, courseSubject: string | number } | [current_team: string | number, courseSubject: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: exportPdfa91fa546cb38faacf9c39c848bdfd99e.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\GradeController::exportPdf
* @see app/Http/Controllers/GradeController.php:127
* @route '/{current_team}/grades/{courseSubject}/pdf'
*/
exportPdfa91fa546cb38faacf9c39c848bdfd99eForm.get = (args: { current_team: string | number, courseSubject: string | number } | [current_team: string | number, courseSubject: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: exportPdfa91fa546cb38faacf9c39c848bdfd99e.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\GradeController::exportPdf
* @see app/Http/Controllers/GradeController.php:127
* @route '/{current_team}/grades/{courseSubject}/pdf'
*/
exportPdfa91fa546cb38faacf9c39c848bdfd99eForm.head = (args: { current_team: string | number, courseSubject: string | number } | [current_team: string | number, courseSubject: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: exportPdfa91fa546cb38faacf9c39c848bdfd99e.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

exportPdfa91fa546cb38faacf9c39c848bdfd99e.form = exportPdfa91fa546cb38faacf9c39c848bdfd99eForm

export const exportPdf = {
    '/teachers/grades/{courseSubject}/pdf': exportPdf708e77bb457f53d7f57ecfd1779fb8b4,
    '/{current_team}/grades/{courseSubject}/pdf': exportPdfa91fa546cb38faacf9c39c848bdfd99e,
}

/**
* @see \App\Http\Controllers\GradeController::update
* @see app/Http/Controllers/GradeController.php:241
* @route '/teachers/grades/{courseSubject}'
*/
const updatea6e6e2b6bd22d7e1c7a9dfc30ba813d1 = (args: { courseSubject: string | number } | [courseSubject: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: updatea6e6e2b6bd22d7e1c7a9dfc30ba813d1.url(args, options),
    method: 'post',
})

updatea6e6e2b6bd22d7e1c7a9dfc30ba813d1.definition = {
    methods: ["post"],
    url: '/teachers/grades/{courseSubject}',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\GradeController::update
* @see app/Http/Controllers/GradeController.php:241
* @route '/teachers/grades/{courseSubject}'
*/
updatea6e6e2b6bd22d7e1c7a9dfc30ba813d1.url = (args: { courseSubject: string | number } | [courseSubject: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { courseSubject: args }
    }

    if (Array.isArray(args)) {
        args = {
            courseSubject: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        courseSubject: args.courseSubject,
    }

    return updatea6e6e2b6bd22d7e1c7a9dfc30ba813d1.definition.url
            .replace('{courseSubject}', parsedArgs.courseSubject.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\GradeController::update
* @see app/Http/Controllers/GradeController.php:241
* @route '/teachers/grades/{courseSubject}'
*/
updatea6e6e2b6bd22d7e1c7a9dfc30ba813d1.post = (args: { courseSubject: string | number } | [courseSubject: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: updatea6e6e2b6bd22d7e1c7a9dfc30ba813d1.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\GradeController::update
* @see app/Http/Controllers/GradeController.php:241
* @route '/teachers/grades/{courseSubject}'
*/
const updatea6e6e2b6bd22d7e1c7a9dfc30ba813d1Form = (args: { courseSubject: string | number } | [courseSubject: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updatea6e6e2b6bd22d7e1c7a9dfc30ba813d1.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\GradeController::update
* @see app/Http/Controllers/GradeController.php:241
* @route '/teachers/grades/{courseSubject}'
*/
updatea6e6e2b6bd22d7e1c7a9dfc30ba813d1Form.post = (args: { courseSubject: string | number } | [courseSubject: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updatea6e6e2b6bd22d7e1c7a9dfc30ba813d1.url(args, options),
    method: 'post',
})

updatea6e6e2b6bd22d7e1c7a9dfc30ba813d1.form = updatea6e6e2b6bd22d7e1c7a9dfc30ba813d1Form
/**
* @see \App\Http\Controllers\GradeController::update
* @see app/Http/Controllers/GradeController.php:241
* @route '/{current_team}/grades/{courseSubject}'
*/
const update5ada30daf073685d879943d8b99dd875 = (args: { current_team: string | number, courseSubject: string | number } | [current_team: string | number, courseSubject: string | number ], options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: update5ada30daf073685d879943d8b99dd875.url(args, options),
    method: 'post',
})

update5ada30daf073685d879943d8b99dd875.definition = {
    methods: ["post"],
    url: '/{current_team}/grades/{courseSubject}',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\GradeController::update
* @see app/Http/Controllers/GradeController.php:241
* @route '/{current_team}/grades/{courseSubject}'
*/
update5ada30daf073685d879943d8b99dd875.url = (args: { current_team: string | number, courseSubject: string | number } | [current_team: string | number, courseSubject: string | number ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            current_team: args[0],
            courseSubject: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        current_team: args.current_team,
        courseSubject: args.courseSubject,
    }

    return update5ada30daf073685d879943d8b99dd875.definition.url
            .replace('{current_team}', parsedArgs.current_team.toString())
            .replace('{courseSubject}', parsedArgs.courseSubject.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\GradeController::update
* @see app/Http/Controllers/GradeController.php:241
* @route '/{current_team}/grades/{courseSubject}'
*/
update5ada30daf073685d879943d8b99dd875.post = (args: { current_team: string | number, courseSubject: string | number } | [current_team: string | number, courseSubject: string | number ], options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: update5ada30daf073685d879943d8b99dd875.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\GradeController::update
* @see app/Http/Controllers/GradeController.php:241
* @route '/{current_team}/grades/{courseSubject}'
*/
const update5ada30daf073685d879943d8b99dd875Form = (args: { current_team: string | number, courseSubject: string | number } | [current_team: string | number, courseSubject: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update5ada30daf073685d879943d8b99dd875.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\GradeController::update
* @see app/Http/Controllers/GradeController.php:241
* @route '/{current_team}/grades/{courseSubject}'
*/
update5ada30daf073685d879943d8b99dd875Form.post = (args: { current_team: string | number, courseSubject: string | number } | [current_team: string | number, courseSubject: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update5ada30daf073685d879943d8b99dd875.url(args, options),
    method: 'post',
})

update5ada30daf073685d879943d8b99dd875.form = update5ada30daf073685d879943d8b99dd875Form

export const update = {
    '/teachers/grades/{courseSubject}': updatea6e6e2b6bd22d7e1c7a9dfc30ba813d1,
    '/{current_team}/grades/{courseSubject}': update5ada30daf073685d879943d8b99dd875,
}

const GradeController = { edit, exportPdf, update }

export default GradeController
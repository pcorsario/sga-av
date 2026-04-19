import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../wayfinder'
/**
* @see \App\Http\Controllers\GradeController::edit
* @see app/Http/Controllers/GradeController.php:18
* @route '/{current_team}/grades/{courseSubject}'
*/
export const edit = (args: { current_team: string | number, courseSubject: string | number } | [current_team: string | number, courseSubject: string | number ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/{current_team}/grades/{courseSubject}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\GradeController::edit
* @see app/Http/Controllers/GradeController.php:18
* @route '/{current_team}/grades/{courseSubject}'
*/
edit.url = (args: { current_team: string | number, courseSubject: string | number } | [current_team: string | number, courseSubject: string | number ], options?: RouteQueryOptions) => {
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

    return edit.definition.url
            .replace('{current_team}', parsedArgs.current_team.toString())
            .replace('{courseSubject}', parsedArgs.courseSubject.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\GradeController::edit
* @see app/Http/Controllers/GradeController.php:18
* @route '/{current_team}/grades/{courseSubject}'
*/
edit.get = (args: { current_team: string | number, courseSubject: string | number } | [current_team: string | number, courseSubject: string | number ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\GradeController::edit
* @see app/Http/Controllers/GradeController.php:18
* @route '/{current_team}/grades/{courseSubject}'
*/
edit.head = (args: { current_team: string | number, courseSubject: string | number } | [current_team: string | number, courseSubject: string | number ], options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\GradeController::edit
* @see app/Http/Controllers/GradeController.php:18
* @route '/{current_team}/grades/{courseSubject}'
*/
const editForm = (args: { current_team: string | number, courseSubject: string | number } | [current_team: string | number, courseSubject: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\GradeController::edit
* @see app/Http/Controllers/GradeController.php:18
* @route '/{current_team}/grades/{courseSubject}'
*/
editForm.get = (args: { current_team: string | number, courseSubject: string | number } | [current_team: string | number, courseSubject: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\GradeController::edit
* @see app/Http/Controllers/GradeController.php:18
* @route '/{current_team}/grades/{courseSubject}'
*/
editForm.head = (args: { current_team: string | number, courseSubject: string | number } | [current_team: string | number, courseSubject: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
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
* @see \App\Http\Controllers\GradeController::pdf
* @see app/Http/Controllers/GradeController.php:127
* @route '/{current_team}/grades/{courseSubject}/pdf'
*/
export const pdf = (args: { current_team: string | number, courseSubject: string | number } | [current_team: string | number, courseSubject: string | number ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: pdf.url(args, options),
    method: 'get',
})

pdf.definition = {
    methods: ["get","head"],
    url: '/{current_team}/grades/{courseSubject}/pdf',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\GradeController::pdf
* @see app/Http/Controllers/GradeController.php:127
* @route '/{current_team}/grades/{courseSubject}/pdf'
*/
pdf.url = (args: { current_team: string | number, courseSubject: string | number } | [current_team: string | number, courseSubject: string | number ], options?: RouteQueryOptions) => {
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

    return pdf.definition.url
            .replace('{current_team}', parsedArgs.current_team.toString())
            .replace('{courseSubject}', parsedArgs.courseSubject.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\GradeController::pdf
* @see app/Http/Controllers/GradeController.php:127
* @route '/{current_team}/grades/{courseSubject}/pdf'
*/
pdf.get = (args: { current_team: string | number, courseSubject: string | number } | [current_team: string | number, courseSubject: string | number ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: pdf.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\GradeController::pdf
* @see app/Http/Controllers/GradeController.php:127
* @route '/{current_team}/grades/{courseSubject}/pdf'
*/
pdf.head = (args: { current_team: string | number, courseSubject: string | number } | [current_team: string | number, courseSubject: string | number ], options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: pdf.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\GradeController::pdf
* @see app/Http/Controllers/GradeController.php:127
* @route '/{current_team}/grades/{courseSubject}/pdf'
*/
const pdfForm = (args: { current_team: string | number, courseSubject: string | number } | [current_team: string | number, courseSubject: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: pdf.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\GradeController::pdf
* @see app/Http/Controllers/GradeController.php:127
* @route '/{current_team}/grades/{courseSubject}/pdf'
*/
pdfForm.get = (args: { current_team: string | number, courseSubject: string | number } | [current_team: string | number, courseSubject: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: pdf.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\GradeController::pdf
* @see app/Http/Controllers/GradeController.php:127
* @route '/{current_team}/grades/{courseSubject}/pdf'
*/
pdfForm.head = (args: { current_team: string | number, courseSubject: string | number } | [current_team: string | number, courseSubject: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: pdf.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

pdf.form = pdfForm

/**
* @see \App\Http\Controllers\GradeController::update
* @see app/Http/Controllers/GradeController.php:241
* @route '/{current_team}/grades/{courseSubject}'
*/
export const update = (args: { current_team: string | number, courseSubject: string | number } | [current_team: string | number, courseSubject: string | number ], options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: update.url(args, options),
    method: 'post',
})

update.definition = {
    methods: ["post"],
    url: '/{current_team}/grades/{courseSubject}',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\GradeController::update
* @see app/Http/Controllers/GradeController.php:241
* @route '/{current_team}/grades/{courseSubject}'
*/
update.url = (args: { current_team: string | number, courseSubject: string | number } | [current_team: string | number, courseSubject: string | number ], options?: RouteQueryOptions) => {
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

    return update.definition.url
            .replace('{current_team}', parsedArgs.current_team.toString())
            .replace('{courseSubject}', parsedArgs.courseSubject.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\GradeController::update
* @see app/Http/Controllers/GradeController.php:241
* @route '/{current_team}/grades/{courseSubject}'
*/
update.post = (args: { current_team: string | number, courseSubject: string | number } | [current_team: string | number, courseSubject: string | number ], options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: update.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\GradeController::update
* @see app/Http/Controllers/GradeController.php:241
* @route '/{current_team}/grades/{courseSubject}'
*/
const updateForm = (args: { current_team: string | number, courseSubject: string | number } | [current_team: string | number, courseSubject: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\GradeController::update
* @see app/Http/Controllers/GradeController.php:241
* @route '/{current_team}/grades/{courseSubject}'
*/
updateForm.post = (args: { current_team: string | number, courseSubject: string | number } | [current_team: string | number, courseSubject: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, options),
    method: 'post',
})

update.form = updateForm

const grades = {
    edit: Object.assign(edit, edit),
    pdf: Object.assign(pdf, pdf),
    update: Object.assign(update, update),
}

export default grades
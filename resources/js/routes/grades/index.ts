import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../wayfinder'
/**
* @see \App\Http\Controllers\GradeController::edit
* @see app/Http/Controllers/GradeController.php:17
* @route '/{current_team}/grades/{courseSubject}'
*/
export const edit = (args: { current_team: string | number, courseSubject: number | { id: number } } | [current_team: string | number, courseSubject: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/{current_team}/grades/{courseSubject}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\GradeController::edit
* @see app/Http/Controllers/GradeController.php:17
* @route '/{current_team}/grades/{courseSubject}'
*/
edit.url = (args: { current_team: string | number, courseSubject: number | { id: number } } | [current_team: string | number, courseSubject: number | { id: number } ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            current_team: args[0],
            courseSubject: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        current_team: args.current_team,
        courseSubject: typeof args.courseSubject === 'object'
        ? args.courseSubject.id
        : args.courseSubject,
    }

    return edit.definition.url
            .replace('{current_team}', parsedArgs.current_team.toString())
            .replace('{courseSubject}', parsedArgs.courseSubject.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\GradeController::edit
* @see app/Http/Controllers/GradeController.php:17
* @route '/{current_team}/grades/{courseSubject}'
*/
edit.get = (args: { current_team: string | number, courseSubject: number | { id: number } } | [current_team: string | number, courseSubject: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\GradeController::edit
* @see app/Http/Controllers/GradeController.php:17
* @route '/{current_team}/grades/{courseSubject}'
*/
edit.head = (args: { current_team: string | number, courseSubject: number | { id: number } } | [current_team: string | number, courseSubject: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\GradeController::edit
* @see app/Http/Controllers/GradeController.php:17
* @route '/{current_team}/grades/{courseSubject}'
*/
const editForm = (args: { current_team: string | number, courseSubject: number | { id: number } } | [current_team: string | number, courseSubject: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\GradeController::edit
* @see app/Http/Controllers/GradeController.php:17
* @route '/{current_team}/grades/{courseSubject}'
*/
editForm.get = (args: { current_team: string | number, courseSubject: number | { id: number } } | [current_team: string | number, courseSubject: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\GradeController::edit
* @see app/Http/Controllers/GradeController.php:17
* @route '/{current_team}/grades/{courseSubject}'
*/
editForm.head = (args: { current_team: string | number, courseSubject: number | { id: number } } | [current_team: string | number, courseSubject: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
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
* @see \App\Http\Controllers\GradeController::update
* @see app/Http/Controllers/GradeController.php:119
* @route '/{current_team}/grades/{courseSubject}'
*/
export const update = (args: { current_team: string | number, courseSubject: number | { id: number } } | [current_team: string | number, courseSubject: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: update.url(args, options),
    method: 'post',
})

update.definition = {
    methods: ["post"],
    url: '/{current_team}/grades/{courseSubject}',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\GradeController::update
* @see app/Http/Controllers/GradeController.php:119
* @route '/{current_team}/grades/{courseSubject}'
*/
update.url = (args: { current_team: string | number, courseSubject: number | { id: number } } | [current_team: string | number, courseSubject: number | { id: number } ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            current_team: args[0],
            courseSubject: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        current_team: args.current_team,
        courseSubject: typeof args.courseSubject === 'object'
        ? args.courseSubject.id
        : args.courseSubject,
    }

    return update.definition.url
            .replace('{current_team}', parsedArgs.current_team.toString())
            .replace('{courseSubject}', parsedArgs.courseSubject.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\GradeController::update
* @see app/Http/Controllers/GradeController.php:119
* @route '/{current_team}/grades/{courseSubject}'
*/
update.post = (args: { current_team: string | number, courseSubject: number | { id: number } } | [current_team: string | number, courseSubject: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: update.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\GradeController::update
* @see app/Http/Controllers/GradeController.php:119
* @route '/{current_team}/grades/{courseSubject}'
*/
const updateForm = (args: { current_team: string | number, courseSubject: number | { id: number } } | [current_team: string | number, courseSubject: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\GradeController::update
* @see app/Http/Controllers/GradeController.php:119
* @route '/{current_team}/grades/{courseSubject}'
*/
updateForm.post = (args: { current_team: string | number, courseSubject: number | { id: number } } | [current_team: string | number, courseSubject: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, options),
    method: 'post',
})

update.form = updateForm

const grades = {
    edit: Object.assign(edit, edit),
    update: Object.assign(update, update),
}

export default grades
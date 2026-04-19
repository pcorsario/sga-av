import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\TeacherController::update
* @see app/Http/Controllers/TeacherController.php:170
* @route '/{current_team}/teachers/{teacher}/subjects'
*/
export const update = (args: { current_team: string | number, teacher: number | { id: number } } | [current_team: string | number, teacher: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: update.url(args, options),
    method: 'post',
})

update.definition = {
    methods: ["post"],
    url: '/{current_team}/teachers/{teacher}/subjects',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\TeacherController::update
* @see app/Http/Controllers/TeacherController.php:170
* @route '/{current_team}/teachers/{teacher}/subjects'
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
* @see app/Http/Controllers/TeacherController.php:170
* @route '/{current_team}/teachers/{teacher}/subjects'
*/
update.post = (args: { current_team: string | number, teacher: number | { id: number } } | [current_team: string | number, teacher: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: update.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\TeacherController::update
* @see app/Http/Controllers/TeacherController.php:170
* @route '/{current_team}/teachers/{teacher}/subjects'
*/
const updateForm = (args: { current_team: string | number, teacher: number | { id: number } } | [current_team: string | number, teacher: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\TeacherController::update
* @see app/Http/Controllers/TeacherController.php:170
* @route '/{current_team}/teachers/{teacher}/subjects'
*/
updateForm.post = (args: { current_team: string | number, teacher: number | { id: number } } | [current_team: string | number, teacher: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, options),
    method: 'post',
})

update.form = updateForm

const subjects = {
    update: Object.assign(update, update),
}

export default subjects
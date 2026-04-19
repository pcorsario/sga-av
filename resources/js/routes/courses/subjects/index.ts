import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\CourseController::update
* @see app/Http/Controllers/CourseController.php:133
* @route '/{current_team}/courses/{course}/subjects'
*/
export const update = (args: { current_team: string | number, course: number | { id: number } } | [current_team: string | number, course: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: update.url(args, options),
    method: 'post',
})

update.definition = {
    methods: ["post"],
    url: '/{current_team}/courses/{course}/subjects',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\CourseController::update
* @see app/Http/Controllers/CourseController.php:133
* @route '/{current_team}/courses/{course}/subjects'
*/
update.url = (args: { current_team: string | number, course: number | { id: number } } | [current_team: string | number, course: number | { id: number } ], options?: RouteQueryOptions) => {
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

    return update.definition.url
            .replace('{current_team}', parsedArgs.current_team.toString())
            .replace('{course}', parsedArgs.course.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\CourseController::update
* @see app/Http/Controllers/CourseController.php:133
* @route '/{current_team}/courses/{course}/subjects'
*/
update.post = (args: { current_team: string | number, course: number | { id: number } } | [current_team: string | number, course: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: update.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\CourseController::update
* @see app/Http/Controllers/CourseController.php:133
* @route '/{current_team}/courses/{course}/subjects'
*/
const updateForm = (args: { current_team: string | number, course: number | { id: number } } | [current_team: string | number, course: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\CourseController::update
* @see app/Http/Controllers/CourseController.php:133
* @route '/{current_team}/courses/{course}/subjects'
*/
updateForm.post = (args: { current_team: string | number, course: number | { id: number } } | [current_team: string | number, course: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, options),
    method: 'post',
})

update.form = updateForm

const subjects = {
    update: Object.assign(update, update),
}

export default subjects
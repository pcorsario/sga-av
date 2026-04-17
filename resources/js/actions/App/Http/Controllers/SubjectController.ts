import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\SubjectController::store
* @see app/Http/Controllers/SubjectController.php:11
* @route '/{current_team}/subjects'
*/
export const store = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/{current_team}/subjects',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\SubjectController::store
* @see app/Http/Controllers/SubjectController.php:11
* @route '/{current_team}/subjects'
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
* @see \App\Http\Controllers\SubjectController::store
* @see app/Http/Controllers/SubjectController.php:11
* @route '/{current_team}/subjects'
*/
store.post = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\SubjectController::store
* @see app/Http/Controllers/SubjectController.php:11
* @route '/{current_team}/subjects'
*/
const storeForm = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\SubjectController::store
* @see app/Http/Controllers/SubjectController.php:11
* @route '/{current_team}/subjects'
*/
storeForm.post = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(args, options),
    method: 'post',
})

store.form = storeForm

const SubjectController = { store }

export default SubjectController
import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\AcademicDashboardController::__invoke
* @see app/Http/Controllers/AcademicDashboardController.php:13
* @route '/{current_team}/dashboard'
*/
const AcademicDashboardController = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: AcademicDashboardController.url(args, options),
    method: 'get',
})

AcademicDashboardController.definition = {
    methods: ["get","head"],
    url: '/{current_team}/dashboard',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\AcademicDashboardController::__invoke
* @see app/Http/Controllers/AcademicDashboardController.php:13
* @route '/{current_team}/dashboard'
*/
AcademicDashboardController.url = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return AcademicDashboardController.definition.url
            .replace('{current_team}', parsedArgs.current_team.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\AcademicDashboardController::__invoke
* @see app/Http/Controllers/AcademicDashboardController.php:13
* @route '/{current_team}/dashboard'
*/
AcademicDashboardController.get = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: AcademicDashboardController.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\AcademicDashboardController::__invoke
* @see app/Http/Controllers/AcademicDashboardController.php:13
* @route '/{current_team}/dashboard'
*/
AcademicDashboardController.head = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: AcademicDashboardController.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\AcademicDashboardController::__invoke
* @see app/Http/Controllers/AcademicDashboardController.php:13
* @route '/{current_team}/dashboard'
*/
const AcademicDashboardControllerForm = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: AcademicDashboardController.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\AcademicDashboardController::__invoke
* @see app/Http/Controllers/AcademicDashboardController.php:13
* @route '/{current_team}/dashboard'
*/
AcademicDashboardControllerForm.get = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: AcademicDashboardController.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\AcademicDashboardController::__invoke
* @see app/Http/Controllers/AcademicDashboardController.php:13
* @route '/{current_team}/dashboard'
*/
AcademicDashboardControllerForm.head = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: AcademicDashboardController.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

AcademicDashboardController.form = AcademicDashboardControllerForm

export default AcademicDashboardController
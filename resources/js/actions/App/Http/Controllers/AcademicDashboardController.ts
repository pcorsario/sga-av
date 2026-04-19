import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\AcademicDashboardController::__invoke
* @see app/Http/Controllers/AcademicDashboardController.php:13
* @route '/teachers/dashboard'
*/
const AcademicDashboardControllerbba0ffa2021da8f505250708bdf60610 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: AcademicDashboardControllerbba0ffa2021da8f505250708bdf60610.url(options),
    method: 'get',
})

AcademicDashboardControllerbba0ffa2021da8f505250708bdf60610.definition = {
    methods: ["get","head"],
    url: '/teachers/dashboard',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\AcademicDashboardController::__invoke
* @see app/Http/Controllers/AcademicDashboardController.php:13
* @route '/teachers/dashboard'
*/
AcademicDashboardControllerbba0ffa2021da8f505250708bdf60610.url = (options?: RouteQueryOptions) => {
    return AcademicDashboardControllerbba0ffa2021da8f505250708bdf60610.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AcademicDashboardController::__invoke
* @see app/Http/Controllers/AcademicDashboardController.php:13
* @route '/teachers/dashboard'
*/
AcademicDashboardControllerbba0ffa2021da8f505250708bdf60610.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: AcademicDashboardControllerbba0ffa2021da8f505250708bdf60610.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\AcademicDashboardController::__invoke
* @see app/Http/Controllers/AcademicDashboardController.php:13
* @route '/teachers/dashboard'
*/
AcademicDashboardControllerbba0ffa2021da8f505250708bdf60610.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: AcademicDashboardControllerbba0ffa2021da8f505250708bdf60610.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\AcademicDashboardController::__invoke
* @see app/Http/Controllers/AcademicDashboardController.php:13
* @route '/teachers/dashboard'
*/
const AcademicDashboardControllerbba0ffa2021da8f505250708bdf60610Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: AcademicDashboardControllerbba0ffa2021da8f505250708bdf60610.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\AcademicDashboardController::__invoke
* @see app/Http/Controllers/AcademicDashboardController.php:13
* @route '/teachers/dashboard'
*/
AcademicDashboardControllerbba0ffa2021da8f505250708bdf60610Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: AcademicDashboardControllerbba0ffa2021da8f505250708bdf60610.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\AcademicDashboardController::__invoke
* @see app/Http/Controllers/AcademicDashboardController.php:13
* @route '/teachers/dashboard'
*/
AcademicDashboardControllerbba0ffa2021da8f505250708bdf60610Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: AcademicDashboardControllerbba0ffa2021da8f505250708bdf60610.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

AcademicDashboardControllerbba0ffa2021da8f505250708bdf60610.form = AcademicDashboardControllerbba0ffa2021da8f505250708bdf60610Form
/**
* @see \App\Http\Controllers\AcademicDashboardController::__invoke
* @see app/Http/Controllers/AcademicDashboardController.php:13
* @route '/{current_team}/dashboard'
*/
const AcademicDashboardController7c56b49c1afb48e6321cba0b75b6ac61 = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: AcademicDashboardController7c56b49c1afb48e6321cba0b75b6ac61.url(args, options),
    method: 'get',
})

AcademicDashboardController7c56b49c1afb48e6321cba0b75b6ac61.definition = {
    methods: ["get","head"],
    url: '/{current_team}/dashboard',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\AcademicDashboardController::__invoke
* @see app/Http/Controllers/AcademicDashboardController.php:13
* @route '/{current_team}/dashboard'
*/
AcademicDashboardController7c56b49c1afb48e6321cba0b75b6ac61.url = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return AcademicDashboardController7c56b49c1afb48e6321cba0b75b6ac61.definition.url
            .replace('{current_team}', parsedArgs.current_team.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\AcademicDashboardController::__invoke
* @see app/Http/Controllers/AcademicDashboardController.php:13
* @route '/{current_team}/dashboard'
*/
AcademicDashboardController7c56b49c1afb48e6321cba0b75b6ac61.get = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: AcademicDashboardController7c56b49c1afb48e6321cba0b75b6ac61.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\AcademicDashboardController::__invoke
* @see app/Http/Controllers/AcademicDashboardController.php:13
* @route '/{current_team}/dashboard'
*/
AcademicDashboardController7c56b49c1afb48e6321cba0b75b6ac61.head = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: AcademicDashboardController7c56b49c1afb48e6321cba0b75b6ac61.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\AcademicDashboardController::__invoke
* @see app/Http/Controllers/AcademicDashboardController.php:13
* @route '/{current_team}/dashboard'
*/
const AcademicDashboardController7c56b49c1afb48e6321cba0b75b6ac61Form = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: AcademicDashboardController7c56b49c1afb48e6321cba0b75b6ac61.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\AcademicDashboardController::__invoke
* @see app/Http/Controllers/AcademicDashboardController.php:13
* @route '/{current_team}/dashboard'
*/
AcademicDashboardController7c56b49c1afb48e6321cba0b75b6ac61Form.get = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: AcademicDashboardController7c56b49c1afb48e6321cba0b75b6ac61.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\AcademicDashboardController::__invoke
* @see app/Http/Controllers/AcademicDashboardController.php:13
* @route '/{current_team}/dashboard'
*/
AcademicDashboardController7c56b49c1afb48e6321cba0b75b6ac61Form.head = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: AcademicDashboardController7c56b49c1afb48e6321cba0b75b6ac61.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

AcademicDashboardController7c56b49c1afb48e6321cba0b75b6ac61.form = AcademicDashboardController7c56b49c1afb48e6321cba0b75b6ac61Form

const AcademicDashboardController = {
    '/teachers/dashboard': AcademicDashboardControllerbba0ffa2021da8f505250708bdf60610,
    '/{current_team}/dashboard': AcademicDashboardController7c56b49c1afb48e6321cba0b75b6ac61,
}

export default AcademicDashboardController
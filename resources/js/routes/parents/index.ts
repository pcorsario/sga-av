import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../wayfinder'
/**
* @see \App\Http\Controllers\ParentController::index
* @see app/Http/Controllers/ParentController.php:18
* @route '/{current_team}/parents'
*/
export const index = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(args, options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/{current_team}/parents',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\ParentController::index
* @see app/Http/Controllers/ParentController.php:18
* @route '/{current_team}/parents'
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
* @see \App\Http\Controllers\ParentController::index
* @see app/Http/Controllers/ParentController.php:18
* @route '/{current_team}/parents'
*/
index.get = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ParentController::index
* @see app/Http/Controllers/ParentController.php:18
* @route '/{current_team}/parents'
*/
index.head = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\ParentController::index
* @see app/Http/Controllers/ParentController.php:18
* @route '/{current_team}/parents'
*/
const indexForm = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ParentController::index
* @see app/Http/Controllers/ParentController.php:18
* @route '/{current_team}/parents'
*/
indexForm.get = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ParentController::index
* @see app/Http/Controllers/ParentController.php:18
* @route '/{current_team}/parents'
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
* @see \App\Http\Controllers\ParentController::create
* @see app/Http/Controllers/ParentController.php:37
* @route '/{current_team}/parents/create'
*/
export const create = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(args, options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/{current_team}/parents/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\ParentController::create
* @see app/Http/Controllers/ParentController.php:37
* @route '/{current_team}/parents/create'
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
* @see \App\Http\Controllers\ParentController::create
* @see app/Http/Controllers/ParentController.php:37
* @route '/{current_team}/parents/create'
*/
create.get = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ParentController::create
* @see app/Http/Controllers/ParentController.php:37
* @route '/{current_team}/parents/create'
*/
create.head = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\ParentController::create
* @see app/Http/Controllers/ParentController.php:37
* @route '/{current_team}/parents/create'
*/
const createForm = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ParentController::create
* @see app/Http/Controllers/ParentController.php:37
* @route '/{current_team}/parents/create'
*/
createForm.get = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ParentController::create
* @see app/Http/Controllers/ParentController.php:37
* @route '/{current_team}/parents/create'
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
* @see \App\Http\Controllers\ParentController::store
* @see app/Http/Controllers/ParentController.php:64
* @route '/{current_team}/parents'
*/
export const store = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/{current_team}/parents',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\ParentController::store
* @see app/Http/Controllers/ParentController.php:64
* @route '/{current_team}/parents'
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
* @see \App\Http\Controllers\ParentController::store
* @see app/Http/Controllers/ParentController.php:64
* @route '/{current_team}/parents'
*/
store.post = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\ParentController::store
* @see app/Http/Controllers/ParentController.php:64
* @route '/{current_team}/parents'
*/
const storeForm = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\ParentController::store
* @see app/Http/Controllers/ParentController.php:64
* @route '/{current_team}/parents'
*/
storeForm.post = (args: { current_team: string | number } | [current_team: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(args, options),
    method: 'post',
})

store.form = storeForm

/**
* @see \App\Http\Controllers\ParentController::edit
* @see app/Http/Controllers/ParentController.php:103
* @route '/{current_team}/parents/{parent}/edit'
*/
export const edit = (args: { current_team: string | number, parent: number | { id: number } } | [current_team: string | number, parent: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/{current_team}/parents/{parent}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\ParentController::edit
* @see app/Http/Controllers/ParentController.php:103
* @route '/{current_team}/parents/{parent}/edit'
*/
edit.url = (args: { current_team: string | number, parent: number | { id: number } } | [current_team: string | number, parent: number | { id: number } ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            current_team: args[0],
            parent: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        current_team: args.current_team,
        parent: typeof args.parent === 'object'
        ? args.parent.id
        : args.parent,
    }

    return edit.definition.url
            .replace('{current_team}', parsedArgs.current_team.toString())
            .replace('{parent}', parsedArgs.parent.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\ParentController::edit
* @see app/Http/Controllers/ParentController.php:103
* @route '/{current_team}/parents/{parent}/edit'
*/
edit.get = (args: { current_team: string | number, parent: number | { id: number } } | [current_team: string | number, parent: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ParentController::edit
* @see app/Http/Controllers/ParentController.php:103
* @route '/{current_team}/parents/{parent}/edit'
*/
edit.head = (args: { current_team: string | number, parent: number | { id: number } } | [current_team: string | number, parent: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\ParentController::edit
* @see app/Http/Controllers/ParentController.php:103
* @route '/{current_team}/parents/{parent}/edit'
*/
const editForm = (args: { current_team: string | number, parent: number | { id: number } } | [current_team: string | number, parent: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ParentController::edit
* @see app/Http/Controllers/ParentController.php:103
* @route '/{current_team}/parents/{parent}/edit'
*/
editForm.get = (args: { current_team: string | number, parent: number | { id: number } } | [current_team: string | number, parent: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ParentController::edit
* @see app/Http/Controllers/ParentController.php:103
* @route '/{current_team}/parents/{parent}/edit'
*/
editForm.head = (args: { current_team: string | number, parent: number | { id: number } } | [current_team: string | number, parent: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
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
* @see \App\Http\Controllers\ParentController::update
* @see app/Http/Controllers/ParentController.php:133
* @route '/{current_team}/parents/{parent}'
*/
export const update = (args: { current_team: string | number, parent: number | { id: number } } | [current_team: string | number, parent: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put","patch"],
    url: '/{current_team}/parents/{parent}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \App\Http\Controllers\ParentController::update
* @see app/Http/Controllers/ParentController.php:133
* @route '/{current_team}/parents/{parent}'
*/
update.url = (args: { current_team: string | number, parent: number | { id: number } } | [current_team: string | number, parent: number | { id: number } ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            current_team: args[0],
            parent: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        current_team: args.current_team,
        parent: typeof args.parent === 'object'
        ? args.parent.id
        : args.parent,
    }

    return update.definition.url
            .replace('{current_team}', parsedArgs.current_team.toString())
            .replace('{parent}', parsedArgs.parent.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\ParentController::update
* @see app/Http/Controllers/ParentController.php:133
* @route '/{current_team}/parents/{parent}'
*/
update.put = (args: { current_team: string | number, parent: number | { id: number } } | [current_team: string | number, parent: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\ParentController::update
* @see app/Http/Controllers/ParentController.php:133
* @route '/{current_team}/parents/{parent}'
*/
update.patch = (args: { current_team: string | number, parent: number | { id: number } } | [current_team: string | number, parent: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\ParentController::update
* @see app/Http/Controllers/ParentController.php:133
* @route '/{current_team}/parents/{parent}'
*/
const updateForm = (args: { current_team: string | number, parent: number | { id: number } } | [current_team: string | number, parent: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\ParentController::update
* @see app/Http/Controllers/ParentController.php:133
* @route '/{current_team}/parents/{parent}'
*/
updateForm.put = (args: { current_team: string | number, parent: number | { id: number } } | [current_team: string | number, parent: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\ParentController::update
* @see app/Http/Controllers/ParentController.php:133
* @route '/{current_team}/parents/{parent}'
*/
updateForm.patch = (args: { current_team: string | number, parent: number | { id: number } } | [current_team: string | number, parent: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
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
* @see \App\Http\Controllers\ParentController::destroy
* @see app/Http/Controllers/ParentController.php:171
* @route '/{current_team}/parents/{parent}'
*/
export const destroy = (args: { current_team: string | number, parent: number | { id: number } } | [current_team: string | number, parent: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/{current_team}/parents/{parent}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\ParentController::destroy
* @see app/Http/Controllers/ParentController.php:171
* @route '/{current_team}/parents/{parent}'
*/
destroy.url = (args: { current_team: string | number, parent: number | { id: number } } | [current_team: string | number, parent: number | { id: number } ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            current_team: args[0],
            parent: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        current_team: args.current_team,
        parent: typeof args.parent === 'object'
        ? args.parent.id
        : args.parent,
    }

    return destroy.definition.url
            .replace('{current_team}', parsedArgs.current_team.toString())
            .replace('{parent}', parsedArgs.parent.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\ParentController::destroy
* @see app/Http/Controllers/ParentController.php:171
* @route '/{current_team}/parents/{parent}'
*/
destroy.delete = (args: { current_team: string | number, parent: number | { id: number } } | [current_team: string | number, parent: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\ParentController::destroy
* @see app/Http/Controllers/ParentController.php:171
* @route '/{current_team}/parents/{parent}'
*/
const destroyForm = (args: { current_team: string | number, parent: number | { id: number } } | [current_team: string | number, parent: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\ParentController::destroy
* @see app/Http/Controllers/ParentController.php:171
* @route '/{current_team}/parents/{parent}'
*/
destroyForm.delete = (args: { current_team: string | number, parent: number | { id: number } } | [current_team: string | number, parent: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

destroy.form = destroyForm

const parents = {
    index: Object.assign(index, index),
    create: Object.assign(create, create),
    store: Object.assign(store, store),
    edit: Object.assign(edit, edit),
    update: Object.assign(update, update),
    destroy: Object.assign(destroy, destroy),
}

export default parents
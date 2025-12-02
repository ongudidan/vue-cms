import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\BoardMemberController::index
 * @see app/Http/Controllers/BoardMemberController.php:12
 * @route '/admin/board-members'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/board-members',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\BoardMemberController::index
 * @see app/Http/Controllers/BoardMemberController.php:12
 * @route '/admin/board-members'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\BoardMemberController::index
 * @see app/Http/Controllers/BoardMemberController.php:12
 * @route '/admin/board-members'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\BoardMemberController::index
 * @see app/Http/Controllers/BoardMemberController.php:12
 * @route '/admin/board-members'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\BoardMemberController::index
 * @see app/Http/Controllers/BoardMemberController.php:12
 * @route '/admin/board-members'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\BoardMemberController::index
 * @see app/Http/Controllers/BoardMemberController.php:12
 * @route '/admin/board-members'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\BoardMemberController::index
 * @see app/Http/Controllers/BoardMemberController.php:12
 * @route '/admin/board-members'
 */
        indexForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    index.form = indexForm
/**
* @see \App\Http\Controllers\BoardMemberController::store
 * @see app/Http/Controllers/BoardMemberController.php:42
 * @route '/admin/board-members'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/admin/board-members',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\BoardMemberController::store
 * @see app/Http/Controllers/BoardMemberController.php:42
 * @route '/admin/board-members'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\BoardMemberController::store
 * @see app/Http/Controllers/BoardMemberController.php:42
 * @route '/admin/board-members'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\BoardMemberController::store
 * @see app/Http/Controllers/BoardMemberController.php:42
 * @route '/admin/board-members'
 */
    const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: store.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\BoardMemberController::store
 * @see app/Http/Controllers/BoardMemberController.php:42
 * @route '/admin/board-members'
 */
        storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: store.url(options),
            method: 'post',
        })
    
    store.form = storeForm
/**
* @see \App\Http\Controllers\BoardMemberController::update
 * @see app/Http/Controllers/BoardMemberController.php:78
 * @route '/admin/board-members/{boardMember}'
 */
export const update = (args: { boardMember: number | { id: number } } | [boardMember: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/admin/board-members/{boardMember}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\BoardMemberController::update
 * @see app/Http/Controllers/BoardMemberController.php:78
 * @route '/admin/board-members/{boardMember}'
 */
update.url = (args: { boardMember: number | { id: number } } | [boardMember: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { boardMember: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { boardMember: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    boardMember: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        boardMember: typeof args.boardMember === 'object'
                ? args.boardMember.id
                : args.boardMember,
                }

    return update.definition.url
            .replace('{boardMember}', parsedArgs.boardMember.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\BoardMemberController::update
 * @see app/Http/Controllers/BoardMemberController.php:78
 * @route '/admin/board-members/{boardMember}'
 */
update.put = (args: { boardMember: number | { id: number } } | [boardMember: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

    /**
* @see \App\Http\Controllers\BoardMemberController::update
 * @see app/Http/Controllers/BoardMemberController.php:78
 * @route '/admin/board-members/{boardMember}'
 */
    const updateForm = (args: { boardMember: number | { id: number } } | [boardMember: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: update.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'PUT',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\BoardMemberController::update
 * @see app/Http/Controllers/BoardMemberController.php:78
 * @route '/admin/board-members/{boardMember}'
 */
        updateForm.put = (args: { boardMember: number | { id: number } } | [boardMember: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: update.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'PUT',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    update.form = updateForm
/**
* @see \App\Http\Controllers\BoardMemberController::destroy
 * @see app/Http/Controllers/BoardMemberController.php:118
 * @route '/admin/board-members/{boardMember}'
 */
export const destroy = (args: { boardMember: number | { id: number } } | [boardMember: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/admin/board-members/{boardMember}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\BoardMemberController::destroy
 * @see app/Http/Controllers/BoardMemberController.php:118
 * @route '/admin/board-members/{boardMember}'
 */
destroy.url = (args: { boardMember: number | { id: number } } | [boardMember: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { boardMember: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { boardMember: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    boardMember: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        boardMember: typeof args.boardMember === 'object'
                ? args.boardMember.id
                : args.boardMember,
                }

    return destroy.definition.url
            .replace('{boardMember}', parsedArgs.boardMember.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\BoardMemberController::destroy
 * @see app/Http/Controllers/BoardMemberController.php:118
 * @route '/admin/board-members/{boardMember}'
 */
destroy.delete = (args: { boardMember: number | { id: number } } | [boardMember: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

    /**
* @see \App\Http\Controllers\BoardMemberController::destroy
 * @see app/Http/Controllers/BoardMemberController.php:118
 * @route '/admin/board-members/{boardMember}'
 */
    const destroyForm = (args: { boardMember: number | { id: number } } | [boardMember: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: destroy.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'DELETE',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\BoardMemberController::destroy
 * @see app/Http/Controllers/BoardMemberController.php:118
 * @route '/admin/board-members/{boardMember}'
 */
        destroyForm.delete = (args: { boardMember: number | { id: number } } | [boardMember: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: destroy.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'DELETE',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    destroy.form = destroyForm
const boardMembers = {
    index: Object.assign(index, index),
store: Object.assign(store, store),
update: Object.assign(update, update),
destroy: Object.assign(destroy, destroy),
}

export default boardMembers
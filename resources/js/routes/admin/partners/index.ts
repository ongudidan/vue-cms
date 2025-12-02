import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\PartnerController::index
 * @see app/Http/Controllers/PartnerController.php:11
 * @route '/admin/partners'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/partners',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\PartnerController::index
 * @see app/Http/Controllers/PartnerController.php:11
 * @route '/admin/partners'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\PartnerController::index
 * @see app/Http/Controllers/PartnerController.php:11
 * @route '/admin/partners'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\PartnerController::index
 * @see app/Http/Controllers/PartnerController.php:11
 * @route '/admin/partners'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\PartnerController::index
 * @see app/Http/Controllers/PartnerController.php:11
 * @route '/admin/partners'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\PartnerController::index
 * @see app/Http/Controllers/PartnerController.php:11
 * @route '/admin/partners'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\PartnerController::index
 * @see app/Http/Controllers/PartnerController.php:11
 * @route '/admin/partners'
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
* @see \App\Http\Controllers\PartnerController::store
 * @see app/Http/Controllers/PartnerController.php:37
 * @route '/admin/partners'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/admin/partners',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\PartnerController::store
 * @see app/Http/Controllers/PartnerController.php:37
 * @route '/admin/partners'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\PartnerController::store
 * @see app/Http/Controllers/PartnerController.php:37
 * @route '/admin/partners'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\PartnerController::store
 * @see app/Http/Controllers/PartnerController.php:37
 * @route '/admin/partners'
 */
    const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: store.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\PartnerController::store
 * @see app/Http/Controllers/PartnerController.php:37
 * @route '/admin/partners'
 */
        storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: store.url(options),
            method: 'post',
        })
    
    store.form = storeForm
/**
* @see \App\Http\Controllers\PartnerController::update
 * @see app/Http/Controllers/PartnerController.php:66
 * @route '/admin/partners/{partner}'
 */
export const update = (args: { partner: number | { id: number } } | [partner: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/admin/partners/{partner}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\PartnerController::update
 * @see app/Http/Controllers/PartnerController.php:66
 * @route '/admin/partners/{partner}'
 */
update.url = (args: { partner: number | { id: number } } | [partner: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { partner: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { partner: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    partner: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        partner: typeof args.partner === 'object'
                ? args.partner.id
                : args.partner,
                }

    return update.definition.url
            .replace('{partner}', parsedArgs.partner.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\PartnerController::update
 * @see app/Http/Controllers/PartnerController.php:66
 * @route '/admin/partners/{partner}'
 */
update.put = (args: { partner: number | { id: number } } | [partner: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

    /**
* @see \App\Http\Controllers\PartnerController::update
 * @see app/Http/Controllers/PartnerController.php:66
 * @route '/admin/partners/{partner}'
 */
    const updateForm = (args: { partner: number | { id: number } } | [partner: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: update.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'PUT',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\PartnerController::update
 * @see app/Http/Controllers/PartnerController.php:66
 * @route '/admin/partners/{partner}'
 */
        updateForm.put = (args: { partner: number | { id: number } } | [partner: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
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
* @see \App\Http\Controllers\PartnerController::destroy
 * @see app/Http/Controllers/PartnerController.php:99
 * @route '/admin/partners/{partner}'
 */
export const destroy = (args: { partner: number | { id: number } } | [partner: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/admin/partners/{partner}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\PartnerController::destroy
 * @see app/Http/Controllers/PartnerController.php:99
 * @route '/admin/partners/{partner}'
 */
destroy.url = (args: { partner: number | { id: number } } | [partner: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { partner: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { partner: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    partner: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        partner: typeof args.partner === 'object'
                ? args.partner.id
                : args.partner,
                }

    return destroy.definition.url
            .replace('{partner}', parsedArgs.partner.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\PartnerController::destroy
 * @see app/Http/Controllers/PartnerController.php:99
 * @route '/admin/partners/{partner}'
 */
destroy.delete = (args: { partner: number | { id: number } } | [partner: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

    /**
* @see \App\Http\Controllers\PartnerController::destroy
 * @see app/Http/Controllers/PartnerController.php:99
 * @route '/admin/partners/{partner}'
 */
    const destroyForm = (args: { partner: number | { id: number } } | [partner: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: destroy.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'DELETE',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\PartnerController::destroy
 * @see app/Http/Controllers/PartnerController.php:99
 * @route '/admin/partners/{partner}'
 */
        destroyForm.delete = (args: { partner: number | { id: number } } | [partner: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: destroy.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'DELETE',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    destroy.form = destroyForm
const partners = {
    index: Object.assign(index, index),
store: Object.assign(store, store),
update: Object.assign(update, update),
destroy: Object.assign(destroy, destroy),
}

export default partners
import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\ThemeController::index
 * @see app/Http/Controllers/ThemeController.php:22
 * @route '/admin/themes'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/themes',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\ThemeController::index
 * @see app/Http/Controllers/ThemeController.php:22
 * @route '/admin/themes'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\ThemeController::index
 * @see app/Http/Controllers/ThemeController.php:22
 * @route '/admin/themes'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\ThemeController::index
 * @see app/Http/Controllers/ThemeController.php:22
 * @route '/admin/themes'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\ThemeController::index
 * @see app/Http/Controllers/ThemeController.php:22
 * @route '/admin/themes'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\ThemeController::index
 * @see app/Http/Controllers/ThemeController.php:22
 * @route '/admin/themes'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\ThemeController::index
 * @see app/Http/Controllers/ThemeController.php:22
 * @route '/admin/themes'
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
* @see \App\Http\Controllers\ThemeController::activate
 * @see app/Http/Controllers/ThemeController.php:51
 * @route '/admin/themes/{id}/activate'
 */
export const activate = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: activate.url(args, options),
    method: 'post',
})

activate.definition = {
    methods: ["post"],
    url: '/admin/themes/{id}/activate',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\ThemeController::activate
 * @see app/Http/Controllers/ThemeController.php:51
 * @route '/admin/themes/{id}/activate'
 */
activate.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    id: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        id: args.id,
                }

    return activate.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\ThemeController::activate
 * @see app/Http/Controllers/ThemeController.php:51
 * @route '/admin/themes/{id}/activate'
 */
activate.post = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: activate.url(args, options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\ThemeController::activate
 * @see app/Http/Controllers/ThemeController.php:51
 * @route '/admin/themes/{id}/activate'
 */
    const activateForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: activate.url(args, options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\ThemeController::activate
 * @see app/Http/Controllers/ThemeController.php:51
 * @route '/admin/themes/{id}/activate'
 */
        activateForm.post = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: activate.url(args, options),
            method: 'post',
        })
    
    activate.form = activateForm
/**
* @see \App\Http\Controllers\ThemeController::deactivate
 * @see app/Http/Controllers/ThemeController.php:67
 * @route '/admin/themes/{id}/deactivate'
 */
export const deactivate = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: deactivate.url(args, options),
    method: 'post',
})

deactivate.definition = {
    methods: ["post"],
    url: '/admin/themes/{id}/deactivate',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\ThemeController::deactivate
 * @see app/Http/Controllers/ThemeController.php:67
 * @route '/admin/themes/{id}/deactivate'
 */
deactivate.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    id: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        id: args.id,
                }

    return deactivate.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\ThemeController::deactivate
 * @see app/Http/Controllers/ThemeController.php:67
 * @route '/admin/themes/{id}/deactivate'
 */
deactivate.post = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: deactivate.url(args, options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\ThemeController::deactivate
 * @see app/Http/Controllers/ThemeController.php:67
 * @route '/admin/themes/{id}/deactivate'
 */
    const deactivateForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: deactivate.url(args, options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\ThemeController::deactivate
 * @see app/Http/Controllers/ThemeController.php:67
 * @route '/admin/themes/{id}/deactivate'
 */
        deactivateForm.post = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: deactivate.url(args, options),
            method: 'post',
        })
    
    deactivate.form = deactivateForm
/**
* @see \App\Http\Controllers\ThemeController::sync
 * @see app/Http/Controllers/ThemeController.php:83
 * @route '/admin/themes/sync'
 */
export const sync = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: sync.url(options),
    method: 'post',
})

sync.definition = {
    methods: ["post"],
    url: '/admin/themes/sync',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\ThemeController::sync
 * @see app/Http/Controllers/ThemeController.php:83
 * @route '/admin/themes/sync'
 */
sync.url = (options?: RouteQueryOptions) => {
    return sync.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\ThemeController::sync
 * @see app/Http/Controllers/ThemeController.php:83
 * @route '/admin/themes/sync'
 */
sync.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: sync.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\ThemeController::sync
 * @see app/Http/Controllers/ThemeController.php:83
 * @route '/admin/themes/sync'
 */
    const syncForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: sync.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\ThemeController::sync
 * @see app/Http/Controllers/ThemeController.php:83
 * @route '/admin/themes/sync'
 */
        syncForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: sync.url(options),
            method: 'post',
        })
    
    sync.form = syncForm
/**
* @see \App\Http\Controllers\ThemeController::getActiveSections
 * @see app/Http/Controllers/ThemeController.php:109
 * @route '/api/themes/active/sections'
 */
export const getActiveSections = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getActiveSections.url(options),
    method: 'get',
})

getActiveSections.definition = {
    methods: ["get","head"],
    url: '/api/themes/active/sections',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\ThemeController::getActiveSections
 * @see app/Http/Controllers/ThemeController.php:109
 * @route '/api/themes/active/sections'
 */
getActiveSections.url = (options?: RouteQueryOptions) => {
    return getActiveSections.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\ThemeController::getActiveSections
 * @see app/Http/Controllers/ThemeController.php:109
 * @route '/api/themes/active/sections'
 */
getActiveSections.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getActiveSections.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\ThemeController::getActiveSections
 * @see app/Http/Controllers/ThemeController.php:109
 * @route '/api/themes/active/sections'
 */
getActiveSections.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: getActiveSections.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\ThemeController::getActiveSections
 * @see app/Http/Controllers/ThemeController.php:109
 * @route '/api/themes/active/sections'
 */
    const getActiveSectionsForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: getActiveSections.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\ThemeController::getActiveSections
 * @see app/Http/Controllers/ThemeController.php:109
 * @route '/api/themes/active/sections'
 */
        getActiveSectionsForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: getActiveSections.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\ThemeController::getActiveSections
 * @see app/Http/Controllers/ThemeController.php:109
 * @route '/api/themes/active/sections'
 */
        getActiveSectionsForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: getActiveSections.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    getActiveSections.form = getActiveSectionsForm
const ThemeController = { index, activate, deactivate, sync, getActiveSections }

export default ThemeController
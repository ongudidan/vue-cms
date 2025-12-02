import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\BlogController::index
 * @see app/Http/Controllers/BlogController.php:15
 * @route '/admin/blogs'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/blogs',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\BlogController::index
 * @see app/Http/Controllers/BlogController.php:15
 * @route '/admin/blogs'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\BlogController::index
 * @see app/Http/Controllers/BlogController.php:15
 * @route '/admin/blogs'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\BlogController::index
 * @see app/Http/Controllers/BlogController.php:15
 * @route '/admin/blogs'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\BlogController::index
 * @see app/Http/Controllers/BlogController.php:15
 * @route '/admin/blogs'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\BlogController::index
 * @see app/Http/Controllers/BlogController.php:15
 * @route '/admin/blogs'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\BlogController::index
 * @see app/Http/Controllers/BlogController.php:15
 * @route '/admin/blogs'
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
* @see \App\Http\Controllers\BlogController::store
 * @see app/Http/Controllers/BlogController.php:53
 * @route '/admin/blogs'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/admin/blogs',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\BlogController::store
 * @see app/Http/Controllers/BlogController.php:53
 * @route '/admin/blogs'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\BlogController::store
 * @see app/Http/Controllers/BlogController.php:53
 * @route '/admin/blogs'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\BlogController::store
 * @see app/Http/Controllers/BlogController.php:53
 * @route '/admin/blogs'
 */
    const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: store.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\BlogController::store
 * @see app/Http/Controllers/BlogController.php:53
 * @route '/admin/blogs'
 */
        storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: store.url(options),
            method: 'post',
        })
    
    store.form = storeForm
/**
* @see \App\Http\Controllers\BlogController::update
 * @see app/Http/Controllers/BlogController.php:103
 * @route '/admin/blogs/{blog}'
 */
export const update = (args: { blog: number | { id: number } } | [blog: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/admin/blogs/{blog}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\BlogController::update
 * @see app/Http/Controllers/BlogController.php:103
 * @route '/admin/blogs/{blog}'
 */
update.url = (args: { blog: number | { id: number } } | [blog: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { blog: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { blog: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    blog: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        blog: typeof args.blog === 'object'
                ? args.blog.id
                : args.blog,
                }

    return update.definition.url
            .replace('{blog}', parsedArgs.blog.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\BlogController::update
 * @see app/Http/Controllers/BlogController.php:103
 * @route '/admin/blogs/{blog}'
 */
update.put = (args: { blog: number | { id: number } } | [blog: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

    /**
* @see \App\Http\Controllers\BlogController::update
 * @see app/Http/Controllers/BlogController.php:103
 * @route '/admin/blogs/{blog}'
 */
    const updateForm = (args: { blog: number | { id: number } } | [blog: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: update.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'PUT',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\BlogController::update
 * @see app/Http/Controllers/BlogController.php:103
 * @route '/admin/blogs/{blog}'
 */
        updateForm.put = (args: { blog: number | { id: number } } | [blog: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
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
* @see \App\Http\Controllers\BlogController::destroy
 * @see app/Http/Controllers/BlogController.php:159
 * @route '/admin/blogs/{blog}'
 */
export const destroy = (args: { blog: number | { id: number } } | [blog: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/admin/blogs/{blog}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\BlogController::destroy
 * @see app/Http/Controllers/BlogController.php:159
 * @route '/admin/blogs/{blog}'
 */
destroy.url = (args: { blog: number | { id: number } } | [blog: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { blog: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { blog: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    blog: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        blog: typeof args.blog === 'object'
                ? args.blog.id
                : args.blog,
                }

    return destroy.definition.url
            .replace('{blog}', parsedArgs.blog.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\BlogController::destroy
 * @see app/Http/Controllers/BlogController.php:159
 * @route '/admin/blogs/{blog}'
 */
destroy.delete = (args: { blog: number | { id: number } } | [blog: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

    /**
* @see \App\Http\Controllers\BlogController::destroy
 * @see app/Http/Controllers/BlogController.php:159
 * @route '/admin/blogs/{blog}'
 */
    const destroyForm = (args: { blog: number | { id: number } } | [blog: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: destroy.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'DELETE',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\BlogController::destroy
 * @see app/Http/Controllers/BlogController.php:159
 * @route '/admin/blogs/{blog}'
 */
        destroyForm.delete = (args: { blog: number | { id: number } } | [blog: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: destroy.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'DELETE',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    destroy.form = destroyForm
const BlogController = { index, store, update, destroy }

export default BlogController
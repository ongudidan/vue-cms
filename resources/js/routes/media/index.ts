import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../wayfinder'
/**
 * @see routes/web.php:11
 * @route '/media-file/{path}'
 */
export const file = (args: { path: string | number } | [path: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: file.url(args, options),
    method: 'get',
})

file.definition = {
    methods: ["get","head"],
    url: '/media-file/{path}',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see routes/web.php:11
 * @route '/media-file/{path}'
 */
file.url = (args: { path: string | number } | [path: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { path: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    path: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        path: args.path,
                }

    return file.definition.url
            .replace('{path}', parsedArgs.path.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
 * @see routes/web.php:11
 * @route '/media-file/{path}'
 */
file.get = (args: { path: string | number } | [path: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: file.url(args, options),
    method: 'get',
})
/**
 * @see routes/web.php:11
 * @route '/media-file/{path}'
 */
file.head = (args: { path: string | number } | [path: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: file.url(args, options),
    method: 'head',
})

    /**
 * @see routes/web.php:11
 * @route '/media-file/{path}'
 */
    const fileForm = (args: { path: string | number } | [path: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: file.url(args, options),
        method: 'get',
    })

            /**
 * @see routes/web.php:11
 * @route '/media-file/{path}'
 */
        fileForm.get = (args: { path: string | number } | [path: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: file.url(args, options),
            method: 'get',
        })
            /**
 * @see routes/web.php:11
 * @route '/media-file/{path}'
 */
        fileForm.head = (args: { path: string | number } | [path: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: file.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    file.form = fileForm
const media = {
    file: Object.assign(file, file),
}

export default media
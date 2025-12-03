import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\ThemeController::sections
 * @see app/Http/Controllers/ThemeController.php:109
 * @route '/api/themes/active/sections'
 */
export const sections = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: sections.url(options),
    method: 'get',
})

sections.definition = {
    methods: ["get","head"],
    url: '/api/themes/active/sections',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\ThemeController::sections
 * @see app/Http/Controllers/ThemeController.php:109
 * @route '/api/themes/active/sections'
 */
sections.url = (options?: RouteQueryOptions) => {
    return sections.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\ThemeController::sections
 * @see app/Http/Controllers/ThemeController.php:109
 * @route '/api/themes/active/sections'
 */
sections.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: sections.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\ThemeController::sections
 * @see app/Http/Controllers/ThemeController.php:109
 * @route '/api/themes/active/sections'
 */
sections.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: sections.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\ThemeController::sections
 * @see app/Http/Controllers/ThemeController.php:109
 * @route '/api/themes/active/sections'
 */
    const sectionsForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: sections.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\ThemeController::sections
 * @see app/Http/Controllers/ThemeController.php:109
 * @route '/api/themes/active/sections'
 */
        sectionsForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: sections.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\ThemeController::sections
 * @see app/Http/Controllers/ThemeController.php:109
 * @route '/api/themes/active/sections'
 */
        sectionsForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: sections.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    sections.form = sectionsForm
const active = {
    sections: Object.assign(sections, sections),
}

export default active
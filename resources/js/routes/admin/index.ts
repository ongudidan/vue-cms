import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../wayfinder'
import services from './services'
import projects from './projects'
import blogs from './blogs'
import events from './events'
import boardMembers from './board-members'
import partners from './partners'
import clients from './clients'
import menus from './menus'
import pages from './pages'
import themes from './themes'
/**
* @see routes/web.php:22
* @route '/admin/components'
*/
export const components = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: components.url(options),
    method: 'get',
})

components.definition = {
    methods: ["get","head"],
    url: '/admin/components',
} satisfies RouteDefinition<["get","head"]>

/**
* @see routes/web.php:22
* @route '/admin/components'
*/
components.url = (options?: RouteQueryOptions) => {
    return components.definition.url + queryParams(options)
}

/**
* @see routes/web.php:22
* @route '/admin/components'
*/
components.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: components.url(options),
    method: 'get',
})

/**
* @see routes/web.php:22
* @route '/admin/components'
*/
components.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: components.url(options),
    method: 'head',
})

/**
* @see routes/web.php:22
* @route '/admin/components'
*/
const componentsForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: components.url(options),
    method: 'get',
})

/**
* @see routes/web.php:22
* @route '/admin/components'
*/
componentsForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: components.url(options),
    method: 'get',
})

/**
* @see routes/web.php:22
* @route '/admin/components'
*/
componentsForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: components.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

components.form = componentsForm

const admin = {
    components: Object.assign(components, components),
    services: Object.assign(services, services),
    projects: Object.assign(projects, projects),
    blogs: Object.assign(blogs, blogs),
    events: Object.assign(events, events),
    boardMembers: Object.assign(boardMembers, boardMembers),
    partners: Object.assign(partners, partners),
    clients: Object.assign(clients, clients),
    menus: Object.assign(menus, menus),
    pages: Object.assign(pages, pages),
    themes: Object.assign(themes, themes),
}

export default admin
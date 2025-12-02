import ServiceController from './ServiceController'
import ProjectController from './ProjectController'
import BlogController from './BlogController'
import EventController from './EventController'
import BoardMemberController from './BoardMemberController'
import PartnerController from './PartnerController'
import ClientController from './ClientController'
import MenuController from './MenuController'
import PageController from './PageController'
import Settings from './Settings'
const Controllers = {
    ServiceController: Object.assign(ServiceController, ServiceController),
ProjectController: Object.assign(ProjectController, ProjectController),
BlogController: Object.assign(BlogController, BlogController),
EventController: Object.assign(EventController, EventController),
BoardMemberController: Object.assign(BoardMemberController, BoardMemberController),
PartnerController: Object.assign(PartnerController, PartnerController),
ClientController: Object.assign(ClientController, ClientController),
MenuController: Object.assign(MenuController, MenuController),
PageController: Object.assign(PageController, PageController),
Settings: Object.assign(Settings, Settings),
}

export default Controllers
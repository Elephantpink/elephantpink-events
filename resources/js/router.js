import Events from './views/Events'

const eventsAdminRoutes = [
  {
    name: 'admin-events',
    path: '/events',
    component: Events,
    meta: {
      adminRoute: true
    }
  }
]

export default eventsAdminRoutes
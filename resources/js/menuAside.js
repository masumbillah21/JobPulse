import {
  mdiAccountCircle,
  mdiMonitor,
  mdiGithub,
  mdiLock,
  mdiAlertCircle,
  mdiSquareEditOutline,
  mdiTable,
  mdiViewList,
  mdiTelevisionGuide,
  mdiResponsive,
  mdiPalette,
  mdiReact,
  mdiPlus
} from '@mdi/js'

export default [
  {
    route: 'dashboard',
    icon: mdiMonitor,
    label: 'Dashboard',
    permission: 'viewDashboard',
  },
  {
    label: 'Employees',
    icon: mdiAccountCircle,
    permission: 'viewUser',
    menu: [
      {
        route: 'employee.index',
        icon: mdiAccountCircle,
        label: 'All',
        permission: 'viewUser',
      },
      {
        route: 'employee.create',
        icon: mdiPlus,
        label: 'Add New',
        permission: 'addEmployee',
      }
    ]
  },
]

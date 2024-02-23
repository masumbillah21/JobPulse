import {
  mdiAccountCircle,
  mdiMonitor,
  mdiOfficeBuilding,
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
  {
    route: 'company.index',
    icon: mdiOfficeBuilding,
    label: 'Company',
    permission: 'viewCompany',
  },
  {
    label: 'Roles',
    icon: mdiAccountCircle,
    permission: 'viewRole',
    menu: [
      {
        route: 'roles.index',
        icon: mdiAccountCircle,
        label: 'All',
        permission: 'viewRole',
      },
      {
        route: 'roles.create',
        icon: mdiPlus,
        label: 'Add New',
        permission: 'addRole',
      }
    ]
  },
  {
    label: 'Permissions',
    icon: mdiAccountCircle,
    permission: 'viewPermission',
    menu: [
      {
        route: 'permissions.index',
        icon: mdiAccountCircle,
        label: 'All',
        permission: 'viewPermission',
      },
      {
        route: 'permissions.create',
        icon: mdiPlus,
        label: 'Add New',
        permission: 'addPermission',
      }
    ]
  },
  {
    route: 'resume.index',
    icon: mdiMonitor,
    label: 'Resume',
    permission: 'viewResume',
  },
  {
    label: 'Jobs',
    icon: mdiAccountCircle,
    permission: 'viewJobs',
    menu: [
      {
        route: 'jobs.index',
        icon: mdiAccountCircle,
        label: 'All',
        permission: 'viewJobs',
      },
      {
        route: 'jobs.create',
        icon: mdiPlus,
        label: 'Add New',
        permission: 'addPermission',
      }
    ]
  },
  {
    label: 'Pages',
    icon: mdiAccountCircle,
    permission: 'viewPages',
    menu: [
      {
        route: 'pages.index',
        icon: mdiAccountCircle,
        label: 'All',
        permission: 'viewPages',
      },
      {
        route: 'pages.create',
        icon: mdiAccountCircle,
        label: 'Add New',
        permission: 'addPage',
      },
    ]
  },
  {
    label: 'Blogs',
    icon: mdiAccountCircle,
    permission: 'viewBlogs',
    menu: [
      {
        route: 'blogs.index',
        icon: mdiAccountCircle,
        label: 'All',
        permission: 'viewBlogs',
      },
      {
        route: 'blogs.create',
        icon: mdiPlus,
        label: 'Add New',
        permission: 'addBlog',
      }
    ]
  },
]

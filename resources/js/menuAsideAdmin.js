export default [
  {
     label : "Dashboard",
     icon : "fas fa-desktop",
     route : "admin.dashboard",
     permission: "dashboard.view"
  },
  {
     label : "Employees",
     icon : "fas fa-users",
     permission: "employee.view",
     menu :[
        {
           route : "admin.employee.index",
           icon : "fas fa-users",
           label : "All Employees",
           permission: "employee.view"
        },
        {
           route : "admin.employee.create",
           icon : "fas fa-plus",
           label : "Add Employee",
           permission: "employee.create"
        }
     ]
  },
  {
     label : "Company Profile",
     icon : "fas fa-building",
     route : "admin.company.create",
     permission: "company.create"
  },
  {
      label : "Company List",
      icon : "fas fa-building",
      route : "admin.company.index",
      permission: "company.view"
   },
  {
     label : "Roles",
     icon : "fas fa-users-cog",
     permission: "role.view",
     menu :[
        {
           route : "admin.roles.index",
           icon : "fas fa-users-cog",
           label : "All Roles",
           permission: "role.view",
        },
        {
           route : "admin.roles.create",
           icon : "fas fa-plus",
           label : "Add Role",
           permission: "role.create",
        }
     ]
  },
  {
     label : "Permissions",
     icon : "fas fa-key",
     permission: "permissions.view",
     menu :[
        {
           route : "admin.permissions.index",
           icon : "fas fa-key",
           label : "All Permissions",
           permission: "permissions.view",
        },
        {
           route : "admin.permissions.create",
           icon : "fas fa-plus",
           label : "Add Permission",
           permission: "permissions.view",
        }
     ]
  },
  {
     label : "Resume",
     icon : "fas fa-file",
     route : "admin.resume.index",
     permission: "resume.view",
  },
  {
     label : "Jobs",
     icon : "fas fa-sliders-h",
     permission: "jobs.view",
     menu :[
        {
           route : "admin.jobs.index",
           icon : "fas fa-sliders-h",
           label : "All Jobs",
           permission: "jobs.view",
        },
        {
           route : "admin.jobs.create",
           icon : "fas fa-plus",
           label : "Add Job",
           permission: "jobs.create",
        },
     ]
  },
  {
     label : "Jobs List",
     icon : "fas fa-sliders-h",
     permission: "jobs.view.list",
     menu :[
        {
            route : "admin.jobs.index",
            icon : "fas fa-list",
            label : "Job Lists",
            permission: "jobs.view.list",
         },
         {
            route : "admin.jobs.categories.index",
            icon : "fas fa-list",
            label : "Job Categories",
            permission: "job.categories.view",
         }
     ]
  },
  {
     label : "Pages",
     icon : "fas fa-folder",
     permission: "pages.view",
     menu :[
        {
           route : "admin.pages.index",
           icon : "fas fa-folder",
           label : "All Pages",
           permission: "pages.view",
        },
        {
           route : "admin.pages.create",
           icon : "fas fa-plus",
           label : "Add Page",
           permission: "pages.create",
        }
     ]
  },
  {
     label : "Blogs",
     icon : "fas fa-folder",
     permission: "blogs.view",
     menu :[
        {
           route : "admin.blogs.index",
           icon : "fas fa-folder",
           label : "All Blogs",
           permission: "blogs.view",
        },
        {
           route : "admin.blogs.create",
           icon : "fas fa-plus",
           label : "Add Blog",
           permission: "blogs.create",
        },
        {
            route : "admin.categories.index",
            icon : "fas fa-list",
            label : "Categories",
            permission: "categories.view",
         },
         {
            route : "admin.tags.index",
            icon : "fas fa-list",
            label : "Tags",
            permission: "tags.view",
         }
     ]
  },
  {
      label : "Plugins",
      icon : "fas fa-building",
      route : "admin.company.index",
      permission: "company.create"
   },
   {
      label: 'Settings',
      icon: 'fas fa-cogs',
      route: 'admin.settings.index',
      permission: 'settings.view'
    },
]
export default [
  {
     label : "Dashboard",
     icon : "fas fa-desktop",
     route : "admin.dashboard",
     permission: "dashboard.view",
     is_plugin: false,
  },
  {
     label : "Employees",
     icon : "fas fa-users",
     permission: "employee.view",
     is_plugin: true,
     plugin_id: 2,
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
     permission: "company.create",
     is_plugin: false,
  },
  {
      label : "Company List",
      icon : "fas fa-building",
      route : "admin.company.index",
      permission: "company.view",
      is_plugin: false,
   },
   {
      label : "User List",
      icon : "fas fa-users",
      route : "admin.users.list",
      permission: "users.list.view",
      is_plugin: false,
   },
  {
     label : "Roles",
     icon : "fas fa-users-cog",
     permission: "role.view",
     is_plugin: false,
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
     is_plugin: false,
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
     is_plugin: false,
  },
  {
     label : "Jobs",
     icon : "fas fa-sliders-h",
     permission: "jobs.view",
     is_plugin: false,
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
     is_plugin: false,
     menu :[
        {
            route : "admin.jobs.list",
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
      label : "Candidates",
      icon : "fas fa-users",
      route : "admin.jobs.cadidates.list",
      permission: "candidate.view.list",
      is_plugin: false,
   },
   {
      label : "Applications",
      icon : "fas fa-users",
      route : "admin.jobs.applications.list",
      permission: "application.view.list",
      is_plugin: false,
   },
  {
     label : "Pages",
     icon : "fas fa-folder",
     permission: "pages.view",
     is_plugin: false,
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
     is_plugin: true,
     plugin_id: 1,
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
   icon : "fas fa-folder",
   permission: "plugin.view",
   is_plugin: false,
   menu :[
      {
         label : "All Plugins",
         icon : "fas fa-building",
         route : "admin.plugins.index",
         permission: "plugin.view"
      },
      {
         route : "admin.plugins.create",
         icon : "fas fa-plus",
         label : "Add Plugin",
         permission: "plugin.create",
         plugin: '0'
      },
   ]
   },
]
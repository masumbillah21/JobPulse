export default [
  {
     label : "Dashboard",
     icon : "fas fa-desktop",
     route : "dashboard",
     permission: "dashboard.view"
  },
  {
     label : "Employees",
     icon : "fas fa-users",
     permission: "employee.view",
     menu :[
        {
           route : "employee.index",
           icon : "fas fa-users",
           label : "All Employees",
           permission: "employee.view"
        },
        {
           route : "employee.create",
           icon : "fas fa-plus",
           label : "Add Employee",
           permission: "employee.create"
        }
     ]
  },
  {
     label : "Company",
     icon : "fas fa-building",
     route : "company.index",
     permission: "company.create"
  },
  {
     label : "Roles",
     icon : "fas fa-users-cog",
     permission: "role.view",
     menu :[
        {
           route : "roles.index",
           icon : "fas fa-users-cog",
           label : "All Roles",
           permission: "role.view",
        },
        {
           route : "roles.create",
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
           route : "permissions.index",
           icon : "fas fa-key",
           label : "All Permissions",
           permission: "permissions.view",
        },
        {
           route : "permissions.create",
           icon : "fas fa-plus",
           label : "Add Permission",
           permission: "permissions.view",
        }
     ]
  },
  {
     label : "Resume",
     icon : "fas fa-file",
     route : "resume.index",
     permission: "resume.create",
  },
  {
     label : "Jobs",
     icon : "fas fa-sliders-h",
     permission: "jobs.view",
     menu :[
        {
           route : "jobs.index",
           icon : "fas fa-sliders-h",
           label : "All Jobs",
           permission: "jobs.view",
        },
        {
           route : "jobs.create",
           icon : "fas fa-plus",
           label : "Add Job",
           permission: "jobs.create",
        }
     ]
  },
  {
     label : "Pages",
     icon : "fas fa-folder",
     permission: "pages.view",
     menu :[
        {
           route : "pages.index",
           icon : "fas fa-folder",
           label : "All Pages",
           permission: "pages.view",
        },
        {
           route : "pages.create",
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
           route : "blogs.index",
           icon : "fas fa-folder",
           label : "All Blogs",
           permission: "blogs.view",
        },
        {
           route : "blogs.create",
           icon : "fas fa-plus",
           label : "Add Blog",
           permission: "blogs.create",
        }
     ]
  }
]
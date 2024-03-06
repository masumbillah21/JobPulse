export default [
  {
     label : "Dashboard",
     icon : "fas fa-desktop",
     route : "dashboard",
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
     label : "Company Profile",
     icon : "fas fa-building",
     route : "company.create",
     permission: "company.create",
     is_plugin: false,
  },
  {
     label : "Resume",
     icon : "fas fa-file",
     route : "resume.index",
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
     label : "Blogs",
     icon : "fas fa-folder",
     permission: "blogs.view",
     is_plugin: true,
     plugin_id: 1,
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
  },
  {
      label : "Candidates",
      icon : "fas fa-users",
      route : "jobs.cadidates.list",
      permission: "candidate.view.list",
      is_plugin: false,
   },
  {
      label : "Applications",
      icon : "fas fa-users",
      route : "jobs.applications.list",
      permission: "application.view.list",
      is_plugin: false,
   },
   {
      label : "Plugins",
      icon : "fas fa-building",
      route : "plugins.index",
      permission: "plugin.view",
      is_plugin: false,
   },
]
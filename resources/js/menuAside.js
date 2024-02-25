import {
  mdiAccountCircle,
  mdiMonitor,
  mdiOfficeBuilding,
  mdiPlus
} from '@mdi/js'


export default [
  {
    label: 'Asides',
    icon: mdiAccountCircle,
    menu: [
      {
        route: 'asides.index',
        icon: mdiAccountCircle,
        label: 'All Asides',
      },
      {
        route: 'asides.create',
        icon: mdiPlus,
        label: 'Add Aside',
      }
    ]
  },
]

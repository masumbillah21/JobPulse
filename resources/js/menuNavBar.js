export default [
  {
    isCurrentUser: true,
    menu: [
      {
        icon: 'fas fa-user',
        label: 'My Profile',
        route: 'profile.edit'
      },
      {
        isDivider: true
      },
      {
        icon: 'fas fa-sign-out-alt',
        label: 'Log Out',
        isLogout: true
      }
    ]
  },
  {
    icon: 'fas fa-globe',
    label: 'Site',
    isDesktopNoLabel: true,
    isSite: true
  },
  {
    icon: 'fas fa-sync-alt',
    label: 'Cache',
    isDesktopNoLabel: true,
    isCache: true
  },
  {
    icon: 'fas fa-sun',
    label: 'Light/Dark',
    isDesktopNoLabel: true,
    isToggleLightDark: true
  },
]

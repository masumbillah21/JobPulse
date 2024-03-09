<script setup>
import { ref } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import menuNavBar from '@/menuNavBar.js'
import menuNavBarAdmin from '@/menuNavBarAdmin.js'
import menuAside from '@/menuAside.js'
import menuAsideAdmin from '@/menuAsideAdmin.js'
import { useDarkModeStore } from '@/Stores/darkMode.js'
import BaseIcon from '@/Components/BaseIcon.vue'
import NavBar from '@/Components/NavBar.vue'
import NavBarItemPlain from '@/Components/NavBarItemPlain.vue'
import AsideMenu from '@/Components/AsideMenu.vue'
import FooterBar from '@/Components/FooterBar.vue'
import CacheCleanMessage from '@/Components/CacheCleanMessage.vue'
import { hasPermission } from '@/utils/hasPermission.js'
import { isSystemUser } from '@/utils/isSystemUser.js'
import { isSuperUser } from '@/utils/isSuperUser.js'

const layoutAsidePadding = 'xl:pl-72'

const darkModeStore = useDarkModeStore()

const message = ref('');

let filteredItems = filterItems(isSystemUser() ?  menuAsideAdmin : menuAside );

const navBar = isSystemUser() ? menuNavBarAdmin : menuNavBar;
function filterItems(items) {
  return items.reduce((filtered, item) => {
    if (hasPermission(item.permission)) {
      if (item.menu) {
        const filteredMenu = filterItems(item.menu);
        if (filteredMenu.length > 0) {
          filtered.push({ ...item, menu: filteredMenu });
        }
      } else {
        filtered.push(item);
      }
    }

    return filtered;
  }, []);
}
if(!isSystemUser()){
  filteredItems = filteredItems.filter(item => {
    if(item.is_plugin === true && usePage().props.auth.features){
      const features = usePage().props.auth.features
      return features.includes(item.plugin_id)
    }
    return true
  })
}


router.on('navigate', () => {
  isAsideMobileExpanded.value = false
  isAsideLgActive.value = false
})

const isAsideMobileExpanded = ref(false)
const isAsideLgActive = ref(false)

const menuClick = (event, item) => {
  if (item.isToggleLightDark) {
    darkModeStore.set(!darkModeStore.isEnabled)
  }

  if (item.isLogout) {
    router.post(route('logout'))
  }
  if (item.isCache) {
    clearCache()
  }
  if(item.isSite){
    router.get(route('home'))
  }
}


const showMessage = (msg) => {
  message.value = msg;
  setTimeout(() => {
    message.value = '';
  }, 5000);
};

const clearCache = async () => {
  try {
    const routeName = isSystemUser() ? "admin.cache.clear" : "cache.clear";
    await router.get(route(routeName));
    showMessage('Cache cleared successfully');
  } catch (error) {
    showMessage('Failed to clear cache ' + error);
  }
};
</script>

<template>
  <div :class="{
    'overflow-hidden lg:overflow-visible': isAsideMobileExpanded
  }">
    <div :class="[layoutAsidePadding, { 'ml-72 lg:ml-0': isAsideMobileExpanded }]"
      class="pt-14 min-h-screen w-screen transition-position lg:w-auto bg-gray-50 dark:bg-slate-800 dark:text-slate-100">
      <NavBar :menu="navBar" :class="[layoutAsidePadding, { 'ml-60 lg:ml-0': isAsideMobileExpanded }]"
        @menu-click="menuClick">
        <NavBarItemPlain display="flex lg:hidden" @click.prevent="isAsideMobileExpanded = !isAsideMobileExpanded">
          <BaseIcon :path="isAsideMobileExpanded ? 'fas fa-caret-square-left' : 'fas fa-caret-square-right'" size="24" />
        </NavBarItemPlain>
        <NavBarItemPlain display="hidden lg:flex xl:hidden" @click.prevent="isAsideLgActive = true">
          <BaseIcon path="fas fa-bars" size="24" />
        </NavBarItemPlain>
      </NavBar>
      <AsideMenu :is-aside-mobile-expanded="isAsideMobileExpanded" :is-aside-lg-active="isAsideLgActive"
        :menu="filteredItems" @menu-click="menuClick" @aside-lg-close-click="isAsideLgActive = false" />
      <CacheCleanMessage :message="message" icon="fas fa-sync-alt" />
      <div style="min-height: 90vh;">
        <slot />
      </div>
      <FooterBar />
    </div>
  </div>
</template>

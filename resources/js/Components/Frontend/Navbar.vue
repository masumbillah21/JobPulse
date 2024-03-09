<script setup lang="ts">
  import { ref } from 'vue';
  import ApplicationLogo from '@/Components/ApplicationLogo.vue';
  import { Link, usePage } from '@inertiajs/vue3';

  const showMenu = ref(false);
  const toggleNavbar = () => {
    showMenu.value = !showMenu.value;
  }

  const publicPages: any = usePage().props.publicPages ?? null

</script>

<template>
  <nav class="relative z-50 w-full flex flex-wrap items-center justify-between px-2 py-3 ">
    <div class="container px-4 mx-auto flex flex-wrap items-center justify-between">
      <div class="w-full relative flex justify-between lg:w-auto lg:static lg:block lg:justify-start">
        <button class="cursor-pointer text-xl leading-none px-3 py-1 border border-solid border-transparent rounded bg-transparent block lg:hidden outline-none focus:outline-none" type="button" @click="toggleNavbar">
          <i class="text-white dark:text-slate-800 fas fa-bars"></i>
        </button>
        <Link :href="route('home')" class="text-xl italic font-bold leading-relaxed inline-block mr-4 py-2 whitespace-nowrap uppercase text-stone-800 dark:text-white">
          <ApplicationLogo />
        </Link>
      </div>
      <div class="lg:flex flex-grow items-center bg-white lg:bg-transparent lg:shadow-none" :class="{'hidden': !showMenu, 'block': showMenu}">
        <ul class="flex flex-col lg:flex-row list-none mr-auto">
          <li class="flex items-center">
            <Link :href="route('home')" class="lg:text-stone-900 lg:hover:text-gray-500 text-gray-800 dark:text-white px-3 py-4 lg:py-2 flex items-center text-xs uppercase font-bold">
              Home
            </Link>
          </li>
          <template v-if="publicPages">
            <li v-for="page in publicPages" class="flex items-center">
            <Link :href="route('public.page', page.slug)" class="lg:text-stone-900 lg:hover:text-gray-500 text-gray-800 dark:text-white px-3 py-4 lg:py-2 flex items-center text-xs uppercase font-bold">
              {{ page.title }}
            </Link>
          </li>
          </template>
          <li class="flex items-center">
            <Link :href="route('job')" class="lg:text-stone-900 lg:hover:text-gray-500 text-gray-800 dark:text-white px-3 py-4 lg:py-2 flex items-center text-xs uppercase font-bold">
              Jobs
            </Link>
          </li>
          <li class="flex items-center">
            <Link :href="route('blog')" class="lg:text-stone-900 lg:hover:text-gray-500 text-gray-800 dark:text-white px-3 py-4 lg:py-2 flex items-center text-xs uppercase font-bold">
              Blog
            </Link>
          </li>
          <li class="flex items-center">
            <Link :href="route('contact')" class="lg:text-stone-900 lg:hover:text-gray-500 text-gray-800 dark:text-white px-3 py-4 lg:py-2 flex items-center text-xs uppercase font-bold">
              Contact
            </Link>
          </li>
        </ul>

        <ul class="flex flex-col lg:flex-row list-none lg:ml-auto">
          <li v-if="$page.props.auth.user" class="flex items-center">
            <Link :href="route('dashboard')"
            class="lg:text-stone-900 lg:hover:text-gray-500 text-gray-800 dark:text-white px-3 py-4 lg:py-2 flex items-center text-xs uppercase font-bold">
            Dashboard</Link>
          </li>
          <template v-else>
            <li class="flex items-center">
              <Link :href="route('login')"
              class="lg:text-stone-900 lg:hover:text-gray-500 text-gray-800 dark:text-white px-3 py-4 lg:py-2 flex items-center text-xs uppercase font-bold">
              Log in</Link>
            </li>
            <li class="flex items-center">
              <Link  :href="route('register')"
              class="lg:text-stone-900 lg:hover:text-gray-500 text-gray-800 dark:text-white px-3 py-4 lg:py-2 flex items-center text-xs uppercase font-bold">
              Register</Link>
            </li>
          </template>
        </ul>
      </div>
    </div>
  </nav>
</template>
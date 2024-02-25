<script setup lang="ts">
  import { ref } from 'vue';
  import { Link } from '@inertiajs/vue3';

  const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
  });

  const showMenu = ref(false);
  const toggleNavbar = () => {
    showMenu.value = !showMenu.value;
  }
</script>

<template>
  <nav class="relative z-50 w-full flex flex-wrap items-center justify-between px-2 py-3 ">
    <div class="container px-4 mx-auto flex flex-wrap items-center justify-between">
      <div class="w-full relative flex justify-between lg:w-auto lg:static lg:block lg:justify-start">
        <button class="cursor-pointer text-xl leading-none px-3 py-1 border border-solid border-transparent rounded bg-transparent block lg:hidden outline-none focus:outline-none" type="button" @click="toggleNavbar">
          <i class="text-white fas fa-bars"></i>
        </button>
        <Link :href="route('home')" class="text-xl italic font-bold leading-relaxed inline-block mr-4 py-2 whitespace-nowrap uppercase text-white">
          JobPulse
        </Link>
      </div>
      <div class="lg:flex flex-grow items-center bg-white lg:bg-transparent lg:shadow-none" :class="{'hidden': !showMenu, 'block': showMenu}">
        <ul class="flex flex-col lg:flex-row list-none mr-auto">
          <li class="flex items-center">
            <Link :href="route('home')" class="lg:text-white lg:hover:text-gray-300 text-gray-800 px-3 py-4 lg:py-2 flex items-center text-xs uppercase font-bold">
              Home
            </Link>
          </li>
          <li class="flex items-center">
            <Link :href="route('about')" class="lg:text-white lg:hover:text-gray-300 text-gray-800 px-3 py-4 lg:py-2 flex items-center text-xs uppercase font-bold">
              About
            </Link>
          </li>
          <li class="flex items-center">
            <Link :href="route('job')" class="lg:text-white lg:hover:text-gray-300 text-gray-800 px-3 py-4 lg:py-2 flex items-center text-xs uppercase font-bold">
              Jobs
            </Link>
          </li>
          <li class="flex items-center">
            <Link :href="route('blog')" class="lg:text-white lg:hover:text-gray-300 text-gray-800 px-3 py-4 lg:py-2 flex items-center text-xs uppercase font-bold">
              Blog
            </Link>
          </li>
          <li class="flex items-center">
            <Link :href="route('contact')" class="lg:text-white lg:hover:text-gray-300 text-gray-800 px-3 py-4 lg:py-2 flex items-center text-xs uppercase font-bold">
              Contact
            </Link>
          </li>
        </ul>

        <ul class="flex flex-col lg:flex-row list-none lg:ml-auto">
          <li v-if="$page.props.auth.user" class="flex items-center">
            <Link :href="route('dashboard')"
              class="lg:text-white lg:hover:text-gray-300 text-gray-800 px-3 py-4 lg:py-2 flex items-center text-xs uppercase font-bold">
            Dashboard</Link>
          </li>
          <template v-else>
            <li v-if="canLogin" class="flex items-center">
              <Link :href="route('login')"
                class="lg:text-white lg:hover:text-gray-300 text-gray-800 px-3 py-4 lg:py-2 flex items-center text-xs uppercase font-bold">
              Log in</Link>
            </li>
            <li v-if="canRegister" class="flex items-center">
              <Link  :href="route('register')"
                class="lg:text-white lg:hover:text-gray-300 text-gray-800 px-3 py-4 lg:py-2 flex items-center text-xs uppercase font-bold">
              Register</Link>
            </li>
          </template>
        </ul>
      </div>
    </div>
  </nav>
</template>
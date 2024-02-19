<script setup lang="ts">
  import LayoutGuest from '@/Layouts/LayoutGuest.vue';
  import Pagination from '@/Components/Pagination.vue';
  import { Head, Link } from '@inertiajs/vue3';


  const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    blogsList: Object
  });
</script>
<template>
  <LayoutGuest :canLogin="canLogin" :canRegister="canRegister">
    <Head title="Blog" />
    <main>
      <div class="relative pt-16 pb-32 flex content-center items-center justify-center" style="min-height: 45vh;">
        <div class="absolute top-0 w-full h-full bg-center bg-cover"
          style='background-image: url("https://images.unsplash.com/photo-1557804506-669a67965ba0?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=1267&amp;q=80");'>
          <span id="blackOverlay" class="w-full h-full absolute opacity-75 bg-black"></span>
        </div>
        <div class="container relative mx-auto">
          <div class="items-center flex flex-wrap">
            <div class="w-full lg:w-6/12 px-4 ml-auto mr-auto text-center">
              <div class="pr-12">
                <h1 class="text-white font-semibold text-5xl">
                  Blog
                </h1>
              </div>
            </div>
          </div>
        </div>
        <div class="top-auto bottom-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden"
          style="height: 70px;">
          <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"
            version="1.1" viewBox="0 0 2560 100" x="0" y="0">
            <polygon class="text-gray-300 fill-current" points="2560 0 2560 100 0 100"></polygon>
          </svg>
        </div>
      </div>

      <section class="relative py-20 bg-white">
        <div class="bottom-auto top-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden -mt-20"
          style="height: 80px;">
          <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"
            version="1.1" viewBox="0 0 2560 100" x="0" y="0">
            <polygon class="text-white fill-current" points="2560 0 2560 100 0 100"></polygon>
          </svg>
        </div>
        <div class="container mx-auto px-4">
          <div class="grid gap-x-8 gap-y-4 grid-cols-3">
              <div v-for="(post, index) in blogsList?.data" :key="index" class="bg-gray-100 text-center rounded">
                
                <Link :href="route('blog.show', post.slug)">
                  <img :src="post.image" class="rounded h-60 w-full" :alt="post.title"  />
                  <div class="p-4 text-slate-900">
                    <h1 class="font-semibold text-xl">
                      {{ post.title }}
                    </h1>
                    <p class="text-sm text-ellipsis" >
                      {{ post.body.substring(0,40)+".." }}
                    </p>
                  </div>
                </Link>
              </div>
          </div>
          <Pagination class="mt-6" :links="blogsList?.links"/>
        </div>
      </section>
     
    </main>
  </LayoutGuest>
</template>
<script setup lang="ts">
  import LayoutGuest from '@/Layouts/LayoutGuest.vue';
  import { Head, Link } from '@inertiajs/vue3';


  const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    post: Object,
    recentPosts: Object,
  });
</script>
<template>
  <LayoutGuest :canLogin="canLogin" :canRegister="canRegister">
    <Head title="Blog" />
    <main>
      <div class="relative pt-16 pb-32 flex content-center items-center justify-center" style="min-height: 45vh;">
        <div class="absolute top-0 w-full h-full bg-center bg-cover"
          :style="'background-image: url(' + post?.image + ');'">"
          <span id="blackOverlay" class="w-full h-full absolute opacity-75 bg-black"></span>
        </div>
        <div class="container relative mx-auto">
          <div class="items-center flex flex-wrap">
            <div class="w-full lg:w-6/12 px-4 ml-auto mr-auto text-center">
              <div class="pr-12">
                <h1 class="text-white font-semibold text-5xl">
                  {{ post?.title }}
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
          <div class="flex">
            <div class="w-full lg:w-9/12 px-4 ml-auto mr-auto text-stone-900">
                <h2 class="text-4xl mb-2 font-semibold">{{ post?.title }}</h2>
                <p class="text-lg mb-2">Posted At: {{ post?.created_at }} | By: {{ post?.user?.name }}</p>
                <p class="text-lg">{{ post?.body  }}</p>
            </div>
            <div class="w-full lg:w-3/12 px-4 ml-auto mr-auto text-stone-900">
                <h4 class="text-lg font-semibold">
                    Recent Posts
                </h4>
                <hr>
                <ul class="list-disc mt-6">
                    <li v-for="(recentPost, index) in recentPosts" :key="index" class="py-1">
                        <Link class="py-2" :href="route('blog.show', recentPost.slug)">
                            {{ recentPost.title }}
                        </Link>
                    </li>
                </ul>
            </div>
          </div>
        </div>
      </section>
    </main>
  </LayoutGuest>
</template>
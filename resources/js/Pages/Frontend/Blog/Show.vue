<script setup lang="ts">
import Shape from '@/Components/Frontend/Shape.vue';
import LayoutGuest from '@/Layouts/LayoutGuest.vue';
import { Head, Link } from '@inertiajs/vue3';


defineProps({
  post: Object,
  recentPosts: Object,
  postCategories: Object
});

</script>
<template>
  <LayoutGuest>

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
        <Shape sectionClass="top-auto bottom-0" />
      </div>

      <section class="relative py-20 bg-white">
        <Shape polygonClass="text-white" />
        <div class="container mx-auto px-4">
          <div class="flex flex-row">
            <div class="w-full lg:w-9/12 px-4 ml-auto mr-auto text-stone-900">
              <h2 class="text-4xl mb-2 font-semibold">{{ post?.title }}</h2>
              <p class="text-lg mb-2 font-semibold">Posted: {{ post?.created_at }} | By: {{ post?.user?.name }}</p>
              <hr class="mb-5">
              <prev class="text-lg text-justify">{{ post?.body }}</prev>
            </div>
            <div class="w-full lg:w-3/12 px-4 ml-5 mr-auto text-stone-900">
              <h4 class="text-2xl font-semibold">
                Recent Posts
              </h4>
              <ul class="mt-3">
                <li v-for="(recentPost, index) in recentPosts" :key="index" class="py-1 border-b">
                  <Link class="py-2" :href="route('blog.show', recentPost.slug)">
                  {{ recentPost.title }}
                  </Link>
                </li>
              </ul>

              <h4 class="text-2xl font-semibold mt-8">
                Categories
              </h4>
              <ul class="mt-3">
                <li v-for="(category, index) in postCategories" :key="index" class="py-1 border-b">
                  <Link class="py-2" :href="route('blog.category', category.slug)">
                  {{ category.name }} ({{ category.blogs_count }})
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
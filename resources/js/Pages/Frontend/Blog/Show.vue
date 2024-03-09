<script setup lang="ts">
import BannerSection from '@/Components/Frontend/BannerSection.vue';
import SectionTitle from '@/Components/Frontend/SectionTitle.vue';
import LayoutGuest from '@/Layouts/LayoutGuest.vue';
import { Head, Link } from '@inertiajs/vue3';


defineProps({
  post: Object,
  recentPosts: Object,
  postCategories: Object,
  postTags: Object
});

</script>
<template>
  <LayoutGuest>
    <Head :title="post?.title ?? 'Blog'" />
    <main v-if="post">
      <BannerSection :bgImage="post?.image">
        <SectionTitle :title="post?.title" />
      </BannerSection>

      <section class="relative py-20 bg-gray-200">
        <div class="container mx-auto px-4">
          <div class="flex flex-row">
            <div class="w-full lg:w-9/12 p-4 ml-auto mr-auto text-stone-900 bg-white rounded shadow">
              <h2 class="text-4xl mb-2 font-semibold">{{ post?.title }}</h2>
              <p class="text-lg mb-2 font-semibold">Posted: {{ post?.created_at }} | By: {{ post?.user?.name }}</p>
              <hr class="mb-5">
              <p class="text-lg text-justify">{{ post?.body }}</p>
              <p class="mt-5"><span class="font-bold">Categories:</span> <Link v-for="(category, index) in post?.categories" :key="index" :href="route('blog.category', category.slug)" class="inline-block bg-slate-200 rounded-full px-3 py-1 text-sm font-semibold text-slate-700 mr-2 mb-2">{{ category.name }}</Link></p>
              <p class="mt-5"><span class="font-bold">Tags:</span> <Link v-for="(tag, index) in post?.tags" :key="index" :href="route('blog.tag', tag.slug)" class="inline-block bg-slate-200 rounded-full px-3 py-1 text-sm font-semibold text-slate-700 mr-2 mb-2">{{ tag.name }}</Link></p>
            </div>
            <div class="w-full lg:w-3/12 px-4 ml-5 mr-auto text-stone-900">
              <div class="bg-white rounded shadow p-4 mb-4">
                <h4 class="text-2xl font-semibold">
                  Recent Posts
                </h4>
                <hr>
                <ul class="mt-3">
                  <li v-for="(recentPost, index) in recentPosts" :key="index" class="py-1 border-b">
                    <Link class="py-2" :href="route('blog.show', recentPost.slug)">
                    {{ recentPost.title }}
                    </Link>
                  </li>
                </ul>
              </div>
              <div class="bg-white rounded shadow p-4 mb-3">
                <h4 class="text-2xl font-semibold">
                  Categories
                </h4>
                <hr>
                <ul class="mt-3">
                  <li v-for="(category, index) in postCategories" :key="index" class="py-1 border-b">
                    <Link class="py-2" :href="route('blog.category', category.slug)">
                    {{ category.name }} ({{ category.blogs_count }})
                    </Link>
                  </li>
                </ul>
              </div>
              <div class="bg-white rounded shadow p-4">
                <h4 class="text-2xl font-semibold">
                  Tags
                </h4>
                <hr>
                <ul class="mt-3">
                  <li v-for="(tag, index) in postTags" :key="index" class="inline-block p-2">
                    <Link class="py-2" :href="route('blog.tag', tag.slug)">
                    <span class="inline-block bg-slate-200 rounded-full px-3 py-1 text-sm font-semibold text-slate-700">{{ tag.name }}</span>
                    </Link>
                  </li>
                </ul>
                
              </div>
              
            </div>
          </div>
        </div>
      </section>
    </main>
    <main v-else class="mt-40">
      <div class="container mx-auto px-4">
        <div class="items-center justify-center flex flex-wrap">
          <div class="w-full ml-auto mr-auto px-4">
            <h3 class="text-4xl font-semibold">Not Found</h3>
          </div>
        </div>
      </div>
    </main>
  </LayoutGuest>
</template>
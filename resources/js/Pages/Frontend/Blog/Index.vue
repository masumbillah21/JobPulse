<script setup lang="ts">
  import LayoutGuest from '@/Layouts/LayoutGuest.vue';
  import Pagination from '@/Components/Pagination.vue';
  import Shape from '@/Components/Frontend/Shape.vue';
  import SectionTitle from '@/Components/Frontend/SectionTitle.vue';
  import { Head, Link, usePage } from '@inertiajs/vue3';


  const blogPageData: any = usePage().props.blogPageData;
  const blogsList: any = usePage().props.blogsList;

  const props = defineProps({
    storageUrl: String,
  });

  const blogConents: any = {
    banner: '',
  }

  if(blogPageData){
    blogPageData.contents.forEach((item: any) => {
      if(item.slug === 'banner'){
        blogConents.banner = item.data[0]
      }
    })
  }

</script>
<template>
  <LayoutGuest>
    <Head title="Blog" />
    <main v-if="blogPageData">
      <div class="relative pt-16 pb-32 flex content-center items-center justify-center" style="min-height: 45vh;">
        <div class="absolute top-0 w-full h-full bg-center bg-cover"
          :style="'background-image: url(' + props.storageUrl +  blogPageData.featured_image + ');'">
          <span id="blackOverlay" class="w-full h-full absolute opacity-75 bg-black"></span>
        </div>
        <div class="container relative mx-auto">
          <div class="items-center flex flex-wrap">
            <div class="w-full lg:w-6/12 px-4 ml-auto mr-auto text-center text-white">
              <SectionTitle :title="blogConents.banner.title" :description="blogConents.banner.description" :subtitle="blogConents.banner.subtitle" />
            </div>
          </div>
        </div>
        <Shape polygonClass="text-gray-100" sectionClass="top-auto bottom-0"/>
      </div>

      <section class="relative py-20 bg-gray-50">
        <Shape polygonClass="text-gray-50"/>
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
<script setup lang="ts">
  import LayoutGuest from '@/Layouts/LayoutGuest.vue';
  import Pagination from '@/Components/Pagination.vue';
  import SectionTitle from '@/Components/Frontend/SectionTitle.vue';
  import PostGrid from '@/Components/Frontend/PostGrid.vue';
  import BannerSection from '@/Components/Frontend/BannerSection.vue';
  import { Head, usePage } from '@inertiajs/vue3';
import ComingSoon from '@/Components/Frontend/ComingSoon.vue';


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
      <BannerSection :bgImage="blogPageData.featured_image">
        <SectionTitle :title="blogConents.banner.title" :description="blogConents.banner.description" :subtitle="blogConents.banner.subtitle" />
      </BannerSection>
      <section class="relative py-20 bg-gray-200">
        <div class="container mx-auto px-4">
          <div class="grid gap-x-8 gap-y-4 grid-cols-3">
              <div v-for="(post, index) in blogsList?.data" :key="index" class="bg-gray-100 text-center rounded">
                <PostGrid :post="post" />
              </div>
          </div>
          <Pagination class="mt-6" :links="blogsList?.links"/>
        </div>
      </section>
    </main>
    <ComingSoon v-else />
  </LayoutGuest>
</template>
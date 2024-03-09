<script setup lang="ts">
  import LayoutGuest from '@/Layouts/LayoutGuest.vue';
  import Pagination from '@/Components/Pagination.vue';
  import BannerSection from '@/Components/Frontend/BannerSection.vue';
  import SectionTitle from '@/Components/Frontend/SectionTitle.vue';
  import PostGrid from '@/Components/Frontend/PostGrid.vue';
  import { Head, usePage } from '@inertiajs/vue3';


  const postTag: any = usePage().props.postTag;
  const postList: any = usePage().props.postList;
  const cateBgImage: any = usePage().props.cateBgImage ?? null

  const props = defineProps({
    storageUrl: String,
  });

</script>
<template>
  <LayoutGuest>
    <Head :title="postTag.name" />
    <main v-if="postTag">
      <BannerSection :bgImage="cateBgImage">
        <SectionTitle :title="postTag.name" />
      </BannerSection>

      <section class="relative py-20 bg-gray-50">
        <div class="container mx-auto px-4">
          <div class="grid gap-x-8 gap-y-4 grid-cols-3">
              <div v-for="(post, index) in postList.data" :key="index" class="bg-gray-100 text-center rounded">
                <PostGrid :post="post" />
              </div>
          </div>
          <Pagination class="mt-6" :links="postList?.links"/>
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
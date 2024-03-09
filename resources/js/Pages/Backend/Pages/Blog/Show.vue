<script setup lang="ts">
import Shape from '@/Components/Frontend/Shape.vue';
import LayoutGuest from '@/Layouts/LayoutGuest.vue';
import { Head, Link } from '@inertiajs/vue3';


defineProps({
  blogData: Object,
});

</script>
<template>
  <LayoutGuest>

    <Head title="Blog" />
    <main v-if="blogData">
      <div class="relative pt-16 pb-32 flex content-center items-center justify-center" style="min-height: 45vh;">
        <div class="absolute top-0 w-full h-full bg-center bg-cover"
          :style="'background-image: url(' + blogData?.image + ');'">"
          <span id="blackOverlay" class="w-full h-full absolute opacity-75 bg-black"></span>
        </div>
        <div class="container relative mx-auto">
          <div class="items-center flex flex-wrap">
            <div class="w-full lg:w-6/12 px-4 ml-auto mr-auto text-center">
              <div class="pr-12">
                <h1 class="text-white font-semibold text-5xl">
                  {{ blogData?.title }}
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
              <h2 class="text-4xl mb-2 font-semibold">{{ blogData?.title }}</h2>
              <p class="text-lg mb-2 font-semibold">Date: {{ blogData?.created_at }}</p>
              <hr class="mb-5">
              <prev class="text-lg text-justify">{{ blogData?.body }}</prev>
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
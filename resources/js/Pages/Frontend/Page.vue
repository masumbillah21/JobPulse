<script setup lang="ts">
import SectionTitle from '@/Components/Frontend/SectionTitle.vue';
import LayoutGuest from '@/Layouts/LayoutGuest.vue';
import Shape from '@/Components/Frontend/Shape.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';

const pageData: any = usePage().props.pageData;
defineProps({
  storageUrl: String
});
</script>
<template>
  <LayoutGuest>
    <Head :title="pageData.title ?? 'Page'" />
    <main v-if="pageData">
      <div class="relative pt-16 pb-32 flex content-center items-center justify-center" style="min-height: 45vh;">
        <div class="absolute top-0 w-full h-full bg-center bg-cover"
          :style="'background-image: url(' + storageUrl +  pageData.featured_image + ');'" style="background-position: center; background-size: cover;">
          <span id="blackOverlay" class="w-full h-full absolute opacity-75 bg-black"></span>
        </div>
        <div class="container relative mx-auto">
          <div class="items-center flex flex-wrap">
            <div class="w-full lg:w-6/12 px-4 ml-auto mr-auto text-center text-white">
              <SectionTitle :title="pageData.title" />
            </div>
          </div>
        </div>
        <Shape sectionClass="top-auto bottom-0"/>
      </div>

      <section v-for="(item, index) in pageData.contents" :key="index" class="relative py-20" :class="(index % 2 === 0 && pageData.contents.length > 1) ? 'dark:bg-slate-800 bg-gray-100 dark:text-white' : 'dark:bg-gray-100 dark:text-slate-800'">
        <Shape :polygonClass="(index % 2 === 0 && pageData.contents.length > 1) ? 'dark:text-slate-800 text-gray-100' : 'dark:text-gray-100 text-gray-50'"/>

          <div class="container mx-auto px-4">
          <div v-for="(data, itemIndex) in item.data" :key="itemIndex" class="items-center flex" :class="data.imagePosition === 'right' ? 'flex-row-reverse text-slate-800' : 'flex-row'">
            <div class="w-full md:w-4/12 ml-auto mr-auto px-4">
              <img :alt="data.title" class="max-w-full rounded-lg shadow-lg"
                :src="`data:image/jpg;base64,${data.image}`" />
            </div>
            <div class="w-full md:w-5/12 ml-auto mr-auto px-4">
              <div class="md:pr-12">
                <h4 class="text-xl mb-2">{{ data.subtitle }}</h4>
                <h3 class="text-3xl font-semibold">{{ data.title }}</h3>
                <p class="mt-4 text-lg leading-relaxed">
                  {{ data.description }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
    <main v-else>
      <div class="container mx-auto px-4">
        <div class="items-center justify-center flex flex-wrap">
          <div class="w-full ml-auto mr-auto px-4">
            <h3 class="text-4xl text-center font-semibold">Coming Soon</h3>
          </div>
        </div>
      </div>
    </main>
  </LayoutGuest>
</template>
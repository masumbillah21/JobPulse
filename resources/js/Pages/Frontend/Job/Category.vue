<script setup lang="ts">
  import LayoutGuest from '@/Layouts/LayoutGuest.vue';
  import Pagination from '@/Components/Pagination.vue';
  import { Head, usePage } from '@inertiajs/vue3';
  import JobSection from '@/Components/Frontend/JobSection.vue';
  import Shape from '@/Components/Frontend/Shape.vue';
  import SectionTitle from '@/Components/Frontend/SectionTitle.vue';

  const jobsData: any = usePage().props.jobsData;
  const categoryData: any = usePage().props.categoryData;

  const props = defineProps({
    storageUrl: String,
  });

</script>
<template>
  <LayoutGuest>
    <Head :title="categoryData.name" />
    
    <main v-if="jobsData">
      <div class="relative pt-16 pb-32 flex content-center items-center justify-center" style="min-height: 45vh;">
        <div class="absolute top-0 w-full h-full bg-center bg-cover"
          :style="'background-image: url(' + categoryData.logo + ');'" style="background-position: center; background-size: contain; background-repeat: no-repeat;">
          <span id="blackOverlay" class="w-full h-full absolute opacity-75 bg-black"></span>
        </div>
        <div class="container relative mx-auto">
          <div class="items-center flex flex-wrap">
            <div class="w-full lg:w-6/12 px-4 ml-auto mr-auto text-center text-white">
              <SectionTitle :title="categoryData.name" />
            </div>
          </div>
        </div>
        <Shape polygonClass="text-gray-100" sectionClass="top-auto bottom-0"/>
      </div>
      <section class="pb-20 bg-gray-100">
        <div class="container mx-auto px-4">
          <div class="flex flex-wrap">
            <div class="lg:pt-12 pt-6 w-full px-4">
              <div class="w-full lg:w-6/12 px-4 ml-auto mr-auto text-center text-slate-800 mb-5">
                <SectionTitle :title="categoryData.name" />
              </div>
              <div class="relative flex flex-col min-w-0 break-words bg-white text-slate-900 w-full mb-8 py-10 px-3 shadow-lg rounded-lg">
                <JobSection :jobList="jobsData.data" :allJobs="jobsData.data" :displayTotal="10"/>
                <Pagination class="mt-6 text-white" :links="jobsData?.links"/>
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
            <h3 class="text-4xl font-semibold">Coming Soon</h3>
          </div>
        </div>
      </div>
    </main>
  </LayoutGuest>
</template>
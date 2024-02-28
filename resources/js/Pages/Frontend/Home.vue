<script setup lang="ts">
  import { ref } from 'vue';
  import LayoutGuest from '@/Layouts/LayoutGuest.vue';
  import { Head, usePage } from '@inertiajs/vue3';
  import Shape from '@/Components/Frontend/Shape.vue';

  import SectionTitle from '@/Components/Frontend/SectionTitle.vue';
  import JobSection from '@/Components/Frontend/JobSection.vue';

  const homePageData: any = usePage().props.homePageData ?? null;
  const jobList: any = usePage().props.jobList ?? null;
  const allActiveJobs: any = usePage().props.allActiveJobs ?? null;

  const props = defineProps({
    storageUrl: String,
  });


  const homeConents: any = {
    banner: '',
    logo: '',
    job_category: '',
    jobs: ''
  }

  if(homePageData){
    homePageData.contents.forEach((item: any) => {
      if(item.slug === 'banner'){
        homeConents.banner = item.data[0]
      }
      if(item.slug === 'logo'){
        homeConents.logo = item.data[0]
      }
      if(item.slug === 'job_category'){
        homeConents.job_category = item.data[0]
      }
      if(item.slug === 'jobs'){
        homeConents.jobs = item.data[0]
      }
    })
  }
  const numbers: any = ref([]);

for (let i: number = 1; i <= 8; i++) {
  numbers.value.push(i);
}

</script>
<template>
  <LayoutGuest>
    <Head title="Home" />
    <main v-if="homePageData">
      <div class="relative pt-16 pb-32 flex content-center items-center justify-center" style="min-height: 75vh;">
        <div class="absolute top-0 w-full h-full bg-center bg-cover"
          :style="'background-image: url(' + props.storageUrl +  homePageData.featured_image + ');'">
          <span id="blackOverlay" class="w-full h-full absolute opacity-75 bg-black"></span>
        </div>
        <div class="container relative mx-auto">
          <div class="items-center flex flex-wrap">
            <div class="w-full lg:w-6/12 px-4 ml-auto mr-auto text-center">
              <SectionTitle :title="homeConents.banner.title" :description="homeConents.banner.description" :subtitle="homeConents.banner.subtitle" />
            </div>
          </div>
        </div>
        <Shape sectionClass="top-auto bottom-0"/>
      </div>
      
      <section v-if="homeConents.logo" class="relative py-20 bg-gray-100 text-slate-800">
        <Shape/>
        <div class="container mx-auto px-4">
          <div class="items-center justify-center flex flex-wrap">
            <div class="w-1/2 ml-auto mr-auto px-4">
              <SectionTitle :title="homeConents.logo.title" :description="homeConents.logo.description" :subtitle="homeConents.logo.subtitle" />
            </div>
            <div class="mt-1 mb-10">
              <div class="grid grid-cols-4 gap-4">
                <div v-for="_ in numbers" class="rounded shadow-sm p-2 shadow-slate-300 m-3">
                  <img src="https://fakeimg.pl/250x250" alt="">
                  <p class="text-center text-sm font-semibold mt-1">Logo section</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section v-if="homeConents.job_category" class="relative pb-20 bg-slate-800 text-gray-100">
        <Shape polygonClass="text-slate-800"/>
        <div class="container mx-auto px-4">
          <div class="flex justify-center flex-col items-center">
            <div class="w-1/2 ml-auto mr-auto px-4 py-6">
              <SectionTitle :title="homeConents.job_category.title" :description="homeConents.job_category.description" :subtitle="homeConents.job_category.subtitle" />
            </div>
            <div class="mt-1 mb-10">
              <div class="grid grid-cols-4 gap-2">
                <div v-for="_ in numbers" class="text-center rounded shadow-sm p-2 text-stone-900 bg-white shadow-slate-300 m-3 w-full">
                  <img class="mx-auto" src="https://fakeimg.pl/150x150" alt="">
                  <p class="text-center text-sm font-semibold mt-1">Software Engineers</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section v-if="homeConents.jobs" class="relative py-20 bg-gray-100 text-slate-800">
        <Shape/>
        <div class="container mx-auto px-4">
          <div class="items-center justify-center flex flex-wrap">
            <div class="w-1/2 ml-auto mr-auto px-4">
              <SectionTitle :title="homeConents.jobs.title" :description="homeConents.jobs.description" :subtitle="homeConents.jobs.subtitle" />
              <div class="mt-12">
              </div>
            </div>
            <JobSection :jobList="jobList" :allJobs="allActiveJobs"/>
          </div>
        </div>
      </section>
    </main>
  </LayoutGuest>
</template>
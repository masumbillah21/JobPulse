<script setup lang="ts">
  import { ref } from 'vue';
  import LayoutGuest from '@/Layouts/LayoutGuest.vue';
  import { Head, usePage, Link } from '@inertiajs/vue3';
  import SectionTitle from '@/Components/Frontend/SectionTitle.vue';
  import Slider from '@/Components/Frontend/Slider.vue';
  import JobSection from '@/Components/Frontend/JobSection.vue';
import ComingSoon from '@/Components/Frontend/ComingSoon.vue';

  const homePageData: any = usePage().props.homePageData ?? null;
  const jobList: any = usePage().props.jobList ?? null;
  const jobCategories: any = usePage().props.jobCategories ?? null;
  const companies: any = usePage().props.companies ?? null;

  const homeConents: any = {
    slider: [],
    logo: '',
    job_category: '',
    jobs: ''
  }

  if(homePageData != null){
    homePageData.contents?.forEach((item: any) => {
      if(item.slug === 'slider'){
        item.data.forEach((sliderItem: any) => {
          homeConents.slider.push(sliderItem)
        })
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
    <Head :title="homePageData.title ?? 'Home'" />
    <main v-if="homePageData">
      <Slider :sliderData="homeConents.slider" />
      <section v-if="homeConents.logo" class="relative py-20 bg-gray-100 text-slate-800">
        <div class="container mx-auto px-4">
          <div class="items-center justify-center flex flex-wrap">
            <div class="w-1/2 ml-auto mr-auto px-4">
              <SectionTitle :title="homeConents.logo.title" :description="homeConents.logo.description" :subtitle="homeConents.logo.subtitle" />
            </div>
            <div class="mt-1 mb-10">
              <template v-if="companies">
                <div class="grid grid-cols-4 gap-4">
                  <div v-for="compnay in companies" class="rounded shadow-sm p-2 shadow-slate-300 m-3 flex items-center flex-col bg-white">
                    <Link :href="route('job.by.company', compnay.slug)">
                      <img class="mx-auto max-w-40" :src="compnay.logo" :alt="compnay.name">
                      <p class="text-center text-sm font-semibold mt-1">{{ compnay.name }}</p>
                    </Link>
                  </div>
                </div>
              </template>
            </div>
          </div>
        </div>
      </section>
      
      <section v-if="homeConents.job_category" class="relative py-20 bg-slate-800 text-gray-100">
        <div class="container mx-auto px-4">
          <div class="flex justify-center flex-col items-center">
            <div class="w-1/2 ml-auto mr-auto px-4 py-6">
              <SectionTitle :title="homeConents.job_category.title" :description="homeConents.job_category.description" :subtitle="homeConents.job_category.subtitle" />
            </div>
            <div class="mt-1 mb-10">
              <div class="grid grid-cols-5 gap-4">
                <template v-if="jobCategories">
                    <div v-for="category in jobCategories" class="text-center rounded shadow-sm p-2 text-stone-900 bg-white shadow-slate-300 m-3 w-full">
                      <Link :href="route('job.by.category', category.slug)">
                        <img class="mx-auto max-w-40" :src="category.logo" alt="">
                        <p class="text-center text-lg font-semibold mt-3">{{ category.name }}</p>
                      </Link>
                    </div>
                </template>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section v-if="homeConents.jobs" class="relative py-20 bg-gray-100 text-slate-800">
        <div class="container mx-auto px-4">
          <div class="items-center justify-center flex flex-wrap">
            <div class="w-1/2 ml-auto mr-auto px-4">
              <SectionTitle :title="homeConents.jobs.title" :description="homeConents.jobs.description" :subtitle="homeConents.jobs.subtitle" />
              <div class="mt-12">
              </div>
            </div>
            <JobSection :jobList="jobList" :allJobs="jobList"/>
          </div>
        </div>
      </section>
    </main>
    <ComingSoon v-else />
  </LayoutGuest>
</template>
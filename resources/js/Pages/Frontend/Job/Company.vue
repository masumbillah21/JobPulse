<script setup lang="ts">
  import LayoutGuest from '@/Layouts/LayoutGuest.vue';
  import Pagination from '@/Components/Pagination.vue';
  import { Head, usePage } from '@inertiajs/vue3';
  import JobSection from '@/Components/Frontend/JobSection.vue';
  import SectionTitle from '@/Components/Frontend/SectionTitle.vue';
  import BannerSection from '@/Components/Frontend/BannerSection.vue';

  const jobsData: any = usePage().props.jobsData;
  const companyData: any = usePage().props.companyData;

  const props = defineProps({
    storageUrl: String,
  });

</script>
<template>
  <LayoutGuest>
    <Head :title="companyData?.name ?? 'Not Found'" />
    
    <main v-if="jobsData">
      <BannerSection :bgImage="companyData.logo" backgroundSize="contain">
        <SectionTitle :title="companyData.name" />
      </BannerSection>
      
      <section class="pb-20 bg-gray-100">
        <div class="container mx-auto px-4">
          <div class="flex flex-wrap">
            <div class="lg:pt-12 pt-6 w-full px-4">
              <div class="w-full lg:w-6/12 px-4 ml-auto mr-auto text-center text-slate-800 mb-5">
                <SectionTitle :title="companyData.name" />
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
<script setup lang="ts">
  import { computed } from 'vue';
  import { Head, usePage, useForm } from '@inertiajs/vue3';
  import LayoutGuest from '@/Layouts/LayoutGuest.vue';
  import Pagination from '@/Components/Pagination.vue';
  import FormCheckRadioGroup from '@/Components/FormCheckRadioGroup.vue';
  import JobSection from '@/Components/Frontend/JobSection.vue';
  import SectionTitle from '@/Components/Frontend/SectionTitle.vue';
  import BannerSection from '@/Components/Frontend/BannerSection.vue';

  const jobPageData: any = usePage().props.jobPageData;
  const jobList: any = usePage().props.jobList;
  const allActiveJobs: any = usePage().props.allActiveJobs;
  const jobCategories: any = usePage().props.jobCategories;

  const props = defineProps({
    storageUrl: String,
  });

  const form = useForm({
    categories: [],
    jobLevel: [],
    jobType: [],
    workType: [],
  });

  const jobCategoriesList = jobCategories


  const jobPageContent: any = {
    banner: '',
    jobs: ''
  }

  if(jobPageData){
    jobPageData.contents.forEach((item: any) => {
      if(item.slug === 'banner'){
        jobPageContent.banner = item.data[0]
      }
      if(item.slug === 'jobs'){
        jobPageContent.jobs = item.data[0]
      }
    })
  }

  const jobTypes = { 
    'Full Time': 'Full Time',
    'Part Time': 'Part Time',
    'Contract': 'Contract'
  }

  const jobLevel = {
    'Beginner': 'Beginner',
    'Intermiddiate': 'Intermidiate', 
    'Advanced': 'Advanced',
  };

  const workType = {
    'Remote': 'Remote',
    'On Site': 'On Site', 
    'Hybrid': 'Hybrid',
  };

  const filteredJobs = computed(() => {
    if (form.categories.length > 0 || form.jobLevel.length > 0 || form.jobType.length > 0 || form.workType.length > 0) {
        return jobList.data.filter((job: any) => {
            const categoryMatch = form.categories.length === 0 || form.categories.includes(job.job_category_id.toString());
            const jobLevelMatch = form.jobLevel.length === 0 || form.jobLevel.includes(job.job_level);
            const jobTypeMatch = form.jobType.length === 0 || form.jobType.includes(job.job_type);
            const workTypeMatch = form.workType.length === 0 || form.workType.includes(job.work_type);

            return categoryMatch && jobLevelMatch && jobTypeMatch && workTypeMatch;
        });
    } else {
        return jobList.data;
    }
});




</script>
<template>
  <LayoutGuest>
    <Head title="Jobs" />
    <main v-if="jobPageData">
      <BannerSection :bgImage="jobPageData?.featured_image">
        <SectionTitle :title="jobPageContent.banner.title" :description="jobPageContent.banner.description" :subtitle="jobPageContent.banner.subtitle" />
      </BannerSection>
      <section class="pb-20 bg-gray-100">
        <div class="container mx-auto px-4">
          <div class="flex flex-wrap">
            <div class="lg:pt-12 pt-6 w-full px-4">
              <div class="w-full lg:w-6/12 px-4 ml-auto mr-auto text-center text-slate-800 mb-5">
                <SectionTitle :title="jobPageContent.jobs.title" :description="jobPageContent.jobs.description" :subtitle="jobPageContent.jobs.subtitle" />
              </div>
              <div class="flex">
                <div class="md:w-3/12 w-full md:mr-2">
                  <h2 class="text-xl font-semibold px-4">Filters</h2>
                  <hr>
                  <div class="mt-4 bg-white rounded shadow p-4">
                    <h2 class="text-xl font-semibold">Categories</h2>
                    <hr>
                    <FormCheckRadioGroup class="mt-6" componentClass="w-full" v-model="form.categories" name="categories" type="checkbox"
                        :options="jobCategoriesList" />
                  </div>
                  <div class="mt-4 bg-white rounded shadow p-4">
                    <h2 class="text-xl font-semibold">Level</h2>
                    <hr>
                    <FormCheckRadioGroup class="mt-6" componentClass="w-full" v-model="form.jobLevel" name="levels" type="checkbox"
                        :options="jobLevel" />
                  </div>
                  <div class="mt-4 bg-white rounded shadow p-4">
                    <h2 class="text-xl font-semibold">Job Type</h2>
                    <hr>
                    <FormCheckRadioGroup class="mt-6" componentClass="w-full" v-model="form.jobType" name="types" type="checkbox"
                        :options="jobTypes" />
                  </div>
                  <div class="mt-4 bg-white rounded shadow p-4">
                    <h2 class="text-xl font-semibold">Work Type</h2>
                    <hr>
                    <FormCheckRadioGroup class="mt-6" componentClass="w-full" v-model="form.workType" name="workType" type="checkbox"
                        :options="workType" />
                  </div>
                </div>
                <div class="relative flex flex-col min-w-0 break-words bg-white text-slate-900 w-full mb-8 py-10 px-3 shadow-lg rounded-lg">
                  <p class="mb-2" v-if="form.categories.length > 0">
                    Category(s): <span v-for="category in form.categories" class="font-bold bg-black rounded m-1 p-1 text-white">{{ jobCategoriesList[category] }} </span> 
                  </p>
                  <p class="mb-2" v-if="form.jobLevel.length > 0">
                    Level: <span v-for="level in form.jobLevel" class="font-bold bg-black rounded m-1 p-1 text-white">{{ level }} </span> 
                  </p>
                  <p class="mb-2" v-if="form.jobType.length > 0">
                    Job Type: <span v-for="job in form.jobType" class="font-bold bg-black rounded m-1 p-1 text-white">{{ job }} </span> 
                  </p>
                  <p class="mb-2" v-if="form.workType.length > 0">
                    Work Type: <span v-for="work in form.workType" class="font-bold bg-black rounded m-1 p-1 text-white">{{ work }} </span> 
                  </p>
                  <template v-if="filteredJobs.length > 0">
                    <JobSection :jobList="filteredJobs" :allJobs="allActiveJobs" :displayTotal="10"/>
                    <Pagination class="mt-6 text-white" :links="jobList?.links"/>
                  </template>
                  <p v-else class="text-center bg-red-500 text-white font-semibold rounded py-5 text-xl">No jobs found</p>
                </div>
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
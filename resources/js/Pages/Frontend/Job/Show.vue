<script setup lang="ts">
  import LayoutGuest from '@/Layouts/LayoutGuest.vue';
  import CardBox from '@/Components/CardBox.vue';
  import { Head, Link } from '@inertiajs/vue3';


  const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    jobDetail: Object,
  });
</script>
<template>
  <LayoutGuest :canLogin="canLogin" :canRegister="canRegister">
    <Head :title="jobDetail?.title" />
    <main>
      <div class="relative pt-16 pb-32 flex content-center items-center justify-center" style="min-height: 45vh;">
        <div class="absolute top-0 w-full h-full bg-center bg-cover"
          style='background-image: url("https://images.unsplash.com/photo-1557804506-669a67965ba0?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=1267&amp;q=80");'>
          <span id="blackOverlay" class="w-full h-full absolute opacity-75 bg-black"></span>
        </div>
        <div class="container relative mx-auto">
          <div class="items-center flex flex-wrap">
            <div class="w-full lg:w-6/12 px-4 ml-auto mr-auto text-center">
              <div class="pr-12">
                <h1 class="text-white font-semibold text-5xl">
                  {{ jobDetail?.title }}
                </h1>
              </div>
            </div>
          </div>
        </div>
        <div class="top-auto bottom-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden"
          style="height: 70px;">
          <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"
            version="1.1" viewBox="0 0 2560 100" x="0" y="0">
            <polygon class="text-gray-300 fill-current" points="2560 0 2560 100 0 100"></polygon>
          </svg>
        </div>
      </div>

      <section class="relative py-20 bg-white">
        <div class="bottom-auto top-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden -mt-20"
          style="height: 80px;">
          <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"
            version="1.1" viewBox="0 0 2560 100" x="0" y="0">
            <polygon class="text-white fill-current" points="2560 0 2560 100 0 100"></polygon>
          </svg>
        </div>
        <div class="container mx-auto px-4">
            <div class="flex justify-center">
                <div class="my-2 w-9/12 mr-3 text-black bg-white dark:bg-gray-100 rounded p-5">
                    <h2 class="text-3xl font-semibold">Title: {{ jobDetail?.title }}</h2>
                    <hr class="mb-2">

                    <h2 class="text-2xl font-semibold">About Company</h2>
                    <p class="mb-2">{{ jobDetail?.company.description }}</p>

                    <h2 class="text-2xl font-semibold">Location</h2>
                    <p class="mb-2">{{ jobDetail?.location }}</p>

                    <h2 class="text-2xl font-semibold">Description</h2>
                    <p class="mb-2">{{ jobDetail?.description }}</p>

                    <h2 class="text-2xl font-semibold">Requirements</h2>
                    <p class="mb-2">{{ jobDetail?.requirements }}</p>

                    <h2 class="text-2xl font-semibold">Responsibilities</h2>
                    <p class="mb-2">{{ jobDetail?.responsibilities }}</p>

                    <h2 class="text-2xl font-semibold">Job type</h2>
                    <p class="mb-2">{{ jobDetail?.job_type }}</p>

                    <h2 class="text-2xl font-semibold">Salary</h2>
                    <p class="mb-2">${{ jobDetail?.salary }}</p>

                    <h2 class="text-2xl font-semibold">Facilities</h2>
                    <p class="mb-2">{{ jobDetail?.facilities }}</p>
                </div>
                <div class="my-2 w-3/12 mr-3 text-black bg-white dark:bg-gray-100 rounded p-5">
                    <p class="text-xl mb-1">Job Post By: {{ jobDetail?.user.name }}</p>

                    <p class="text-xl mb-1">Posted on: {{ jobDetail?.created_at }}</p>

                    <p class="text-xl mb-1">Closing on: {{ jobDetail?.closing_date }}</p>

                    <p class="text-xl mb-1">Status: {{ jobDetail?.status == 1 ? 'Active' : 'Draft' }}</p>

                </div>
            </div>
        </div>
      </section>
    </main>
  </LayoutGuest>
</template>
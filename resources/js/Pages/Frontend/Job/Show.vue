<script setup lang="ts">
  import LayoutGuest from '@/Layouts/LayoutGuest.vue';
  import CardBox from '@/Components/CardBox.vue';
  import Shape from '@/Components/Frontend/Shape.vue';
  import BaseButtons from '@/Components/BaseButtons.vue';
  import FormField from '@/Components/FormField.vue';
  import BaseButtonLink from '@/Components/BaseButtonLink.vue';
  import BaseDivider from '@/Components/BaseDivider.vue';
  import FormControl from '@/Components/FormControl.vue';
  import InputError from '@/Components/InputError.vue';
  import {isCandidateUser} from '@/utils/isCandidateUser.js';
  import { Head, useForm, usePage } from '@inertiajs/vue3';

  const authUser = usePage().props.auth.user

  const jobDetail: any = usePage().props.jobDetail;
  const isApplied = usePage().props.isApplied

  const form = useForm({
    id: jobDetail?.id,
    expected_salary: ''
  })

  const submit = () => {
    form.post(route('job.apply'), {
      onSuccess: () => {
        form.reset()
      }
    })
  }
</script>
<template>
  <LayoutGuest>
    <Head :title="jobDetail?.title" />

    <main v-if="jobDetail">
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
        <Shape sectionClass="top-auto bottom-0"/>
      </div>

      <section class="relative py-20 bg-gray-50">
        <Shape polygonClass="dark:text-gray-900 text-gray-50"/>
        <div class="container mx-auto px-4">
            <div class="flex justify-center">
                <div class="my-2 w-9/12 mr-3 text-black bg-white dark:bg-gray-100 rounded p-5 shadow">
                    <h2 class="text-3xl font-semibold">Title: {{ jobDetail?.title }}</h2>
                    <hr class="mb-2">

                    <h2 class="text-xl font-semibold">About Company</h2>
                    <p class="mb-2">{{ jobDetail?.company.description }}</p>
                    
                    <h2 class="text-xl font-semibold">Web</h2>
                    <p class="mb-2">{{ jobDetail?.company.website }}</p>

                    <h2 class="text-xl font-semibold">Location</h2>
                    <p class="mb-2">{{ jobDetail?.location }}</p>

                    <h2 class="text-xl font-semibold">Description</h2>
                    <p class="mb-2">{{ jobDetail?.description }}</p>

                    <h2 class="text-xl font-semibold">Requirements</h2>
                    <p class="mb-2">{{ jobDetail?.requirements }}</p>

                    <h2 class="text-xl font-semibold">Responsibilities</h2>
                    <p class="mb-2">{{ jobDetail?.responsibilities }}</p>

                    <h2 class="text-xl font-semibold">Job type</h2>
                    <p class="mb-2">{{ jobDetail?.job_type }}</p>

                    <h2 class="text-xl font-semibold">Salary</h2>
                    <p class="mb-2">৳{{ jobDetail?.salary }}</p>

                    <h2 class="text-xl font-semibold">Facilities</h2>
                    <p class="mb-2">{{ jobDetail?.facilities }}</p>
                </div>
                <div class="flex flex-col justify-between my-2 w-3/12 mr-3 text-black bg-white dark:bg-gray-100 rounded p-5 shadow">
                    <div>
                      <p class="text-xl mb-1"><span class="font-bold">Post By:</span> {{ jobDetail?.user.name }}</p>

                      <p class="text-xl mb-1"><span class="font-bold">Posted on:</span> {{ jobDetail?.created_at }}</p>

                      <p class="text-xl mb-1"><span class="font-bold">Closing on:</span> <span class="text-red-800">{{ jobDetail?.closing_date }}</span></p>

                      <p class="text-xl mb-1"><span class="font-bold">Status:</span> {{ jobDetail?.status == 1 ? 'Active' : 'Draft' }}</p>
                    </div>
                    <CardBox v-if="authUser && isCandidateUser()" class="my-24 w-full" is-form @submit.prevent="submit">
                      <template v-if="!isApplied">
                        <FormField label="Expected Salary">
                            <FormControl
                            icon="fas fa-dollar-sign"
                            v-model="form.expected_salary" 
                            type="text" />
                        </FormField>
                        <InputError class="mt-2" :message="form.errors.expected_salary" />
                        <BaseDivider />
                        <BaseButtons>
                            <BaseButtonLink icon="far fa-save" type="submit" color="info" label="Apply"
                                :class="{ 'opacity-25': form.processing }" :disabled="form.processing" />
                        </BaseButtons>
                        <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">Applied.</p>
                      </template>
                      <template v-else>
                        <p class="text-xl font-semibold text-red-600">You Already Applied.</p>
                      </template>
                        
                  </CardBox>
                  <div v-else class="text-center">
                      <BaseButtonLink 
                        icon="far fa-save" 
                        type="button" 
                        color="danger" 
                        label="Login To Apply"
                        routeName="login"
                        />
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
            <h3 class="text-4xl font-semibold">Not Found</h3>
          </div>
        </div>
      </div>
    </main>
  </LayoutGuest>
</template>
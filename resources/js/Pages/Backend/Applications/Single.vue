<script setup lan='ts'>
import { Head, usePage } from '@inertiajs/vue3'
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue'
import SectionMain from '@/Components/SectionMain.vue'
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue'
import BaseButtonLink from '@/Components/BaseButtonLink.vue'
import CardBox from '@/Components/CardBox.vue'


const applicationData = usePage().props.applicationData;


</script>

<template>
    <LayoutAuthenticated>
        <Head :title="applicationData.job.title" />
        <SectionMain>
            <SectionTitleLineWithButton icon="far fa-arrow-alt-circle-right" :title="applicationData.job.title" main>
                <BaseButtonLink icon="far fa-arrow-alt-circle-left" label="Back" routeName="jobs.applications.list" color="contrast"
                        rounded-full small />
            </SectionTitleLineWithButton>
            <div class="flex justify-center">
                <CardBox class="w-1/5 dark:bg-white dark:text-blue-950">
                    <p class="text-xl mb-1">Job Post By: {{ applicationData.job.user.name }}</p>
                    <p class="text-xl mb-1">Posted on: {{ applicationData.job.created_at }}</p>
                    <p class="text-xl mb-1">Closing on: {{ applicationData.job.closing_date }}</p>
                    <p class="text-xl mb-1">Status: {{ applicationData.job.status == 1 ? 'Active' : 'Draft' }}</p>
                </CardBox>
                <CardBox class="w-4/5 ml-3 dark:bg-white dark:text-slate-950">
                    <h2 class="text-3xl font-bold">Title: {{ applicationData.job.title }}</h2>
                    <hr class="mb-2">

                    <h2 class="mb-2"><span class="font-bold text-lg">Category:</span> <span>{{ applicationData.job.category.name
                    }}</span></h2>
                    <h2 class="mb-2"><span class="font-bold text-lg">Job type:</span> <span>{{ applicationData.job.job_type }}</span>
                    </h2>
                    <h2 class="mb-2"><span class="font-bold text-lg">Level:</span> <span>{{ applicationData.job.job_level }}</span></h2>

                    <h2 class="mb-2"><span class="font-bold text-lg">Category:</span> <span>{{ applicationData.job.category.name
                    }}</span></h2>

                    <h2 class="mb-2"><span class="font-bold text-lg">Category:</span> <span>{{ applicationData.job.category.name
                    }}</span></h2>

                    <h2 class="mb-2"><span class="font-bold text-lg">Location:</span> <span>{{ applicationData.job.location }}</span>
                    </h2>
                    <h2 class="mb-2"><span class="font-bold text-lg">Description:</span> <span>{{ applicationData.job.description
                    }}</span></h2>

                    <h2 class="mb-2"><span class="font-bold text-lg">Requirements:</span> <span>{{ applicationData.job.requirements
                    }}</span></h2>

                    <h2 class="mb-2"><span class="font-bold text-lg">Responsibilities:</span> <span>{{
                            applicationData.responsibilities }}</span></h2>
                    <h2 class="mb-2"><span class="font-bold text-lg">Salary:</span> <span>{{ applicationData.job.salary }}</span></h2>

                    <h2 class="mb-2"><span class="font-bold text-lg">Facilities:</span> <span>{{ applicationData.job.facilities
                    }}</span></h2>

                    <h2 class="mb-2"><span class="font-bold text-lg">Skills:</span> <span>{{ applicationData.skills }}</span></h2>
            </CardBox>
            </div>
    </SectionMain>
</LayoutAuthenticated></template>
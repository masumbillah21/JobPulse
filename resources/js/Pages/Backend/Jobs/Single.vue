<script setup lan='ts'>
import { Head, usePage } from '@inertiajs/vue3'
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue'
import SectionMain from '@/Components/SectionMain.vue'
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue'
import BaseButtonLink from '@/Components/BaseButtonLink.vue'
import CardBox from '@/Components/CardBox.vue'


const jobData = usePage().props.jobData;


</script>

<template>
    <LayoutAuthenticated>

        <Head :title="jobData.title" />
        <SectionMain>
            <SectionTitleLineWithButton icon="far fa-arrow-alt-circle-right" :title="jobData.title" main>
                <BaseButtonLink icon="far fa-arrow-alt-circle-left" label="Back" routeName="jobs.list" color="contrast"
                        rounded-full small />
            </SectionTitleLineWithButton>

            <div class="flex justify-center">
                <CardBox class="my-24 w-1/5 dark:bg-white dark:text-blue-950">
                    <p class="text-xl mb-1">Job Post By: {{ jobData.user.name }}</p>

                    <p class="text-xl mb-1">Posted on: {{ jobData.created_at }}</p>

                    <p class="text-xl mb-1">Closing on: {{ jobData.closing_date }}</p>

                    <p class="text-xl mb-1">Status: {{ jobData.status == 1 ? 'Active' : 'Draft' }}</p>

                </CardBox>
                <CardBox class="my-24 w-4/5 ml-3 dark:bg-white dark:text-slate-950">
                    <h2 class="text-3xl font-bold">Title: {{ jobData.title }}</h2>
                    <hr class="mb-2">

                    <h2 class="mb-2"><span class="font-bold text-lg">Category:</span> <span>{{ jobData.category.name
                    }}</span></h2>
                    <h2 class="mb-2"><span class="font-bold text-lg">Job type:</span> <span>{{ jobData.job_type }}</span>
                    </h2>
                    <h2 class="mb-2"><span class="font-bold text-lg">Level:</span> <span>{{ jobData.job_level }}</span></h2>

                    <h2 class="mb-2"><span class="font-bold text-lg">Category:</span> <span>{{ jobData.category.name
                    }}</span></h2>

                    <h2 class="mb-2"><span class="font-bold text-lg">Category:</span> <span>{{ jobData.category.name
                    }}</span></h2>

                    <h2 class="mb-2"><span class="font-bold text-lg">Location:</span> <span>{{ jobData.location }}</span>
                    </h2>
                    <h2 class="mb-2"><span class="font-bold text-lg">Description:</span> <span>{{ jobData.description
                    }}</span></h2>

                    <h2 class="mb-2"><span class="font-bold text-lg">Requirements:</span> <span>{{ jobData.requirements
                    }}</span></h2>

                    <h2 class="mb-2"><span class="font-bold text-lg">Responsibilities:</span> <span>{{
                            jobData.responsibilities }}</span></h2>
                    <h2 class="mb-2"><span class="font-bold text-lg">Salary:</span> <span>{{ jobData.salary }}</span></h2>

                    <h2 class="mb-2"><span class="font-bold text-lg">Facilities:</span> <span>{{ jobData.facilities
                    }}</span></h2>

                    <h2 class="mb-2"><span class="font-bold text-lg">Skills:</span> <span>{{ jobData.skills }}</span></h2>
            </CardBox>
        </div>
    </SectionMain>
</LayoutAuthenticated></template>
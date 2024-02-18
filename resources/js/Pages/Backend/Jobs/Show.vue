<script setup lan='ts'>
import { mdiArrowRightCircle, mdiArrowLeftCircle, mdiNoteEditOutline } from '@mdi/js'
import { ref } from 'vue'
import { Head, router, usePage } from '@inertiajs/vue3'
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
            <SectionTitleLineWithButton :icon="mdiArrowRightCircle"
                :title="jobData.title" main>
                <div>
                    <BaseButtonLink class="mr-1" routeName="jobs.edit" :routeParams="jobData.id" :icon="mdiNoteEditOutline" label="Edit" color="info" rounded-full small />
                    <BaseButtonLink :icon="mdiArrowLeftCircle" label="Back" routeName="jobs.index" color="contrast"
                    rounded-full small />
                </div>
            </SectionTitleLineWithButton>
            <div class="flex justify-center">
                <CardBox class="my-24 w-1/5">
                    <p class="text-xl mb-1">Job Post By: {{ jobData.user.name }}</p>

                    <p class="text-xl mb-1">Posted on: {{ jobData.created_at }}</p>

                    <p class="text-xl mb-1">Closing on: {{ jobData.closing_date }}</p>

                    <p class="text-xl mb-1">Status: {{ jobData.status == 1 ? 'Active' : 'Draft' }}</p>

                </CardBox>
                <CardBox class="my-24 w-4/5 ml-3">
                    <h2 class="text-3xl font-bold">Title: {{ jobData.title }}</h2>
                    <hr class="mb-2">

                    <h2 class="text-2xl font-bold">Location</h2>
                    <p class="mb-2">{{ jobData.location }}</p>

                    <h2 class="text-2xl font-bold">Description</h2>
                    <p class="mb-2">{{ jobData.description }}</p>

                    <h2 class="text-2xl font-bold">Requirements</h2>
                    <p class="mb-2">{{ jobData.requirements }}</p>

                    <h2 class="text-2xl font-bold">Responsibilities</h2>
                    <p class="mb-2">{{ jobData.responsibilities }}</p>

                    <h2 class="text-2xl font-bold">Job type</h2>
                    <p class="mb-2">{{ jobData.job_type }}</p>

                    <h2 class="text-2xl font-bold">Salary</h2>
                    <p class="mb-2">{{ jobData.salary }}</p>
                </CardBox>
            </div>
        </SectionMain>
    </LayoutAuthenticated>

</template>
<script setup lang='ts'>
import { Head, usePage } from '@inertiajs/vue3'
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue'
import SectionMain from '@/Components/SectionMain.vue'
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue'
import BaseButtonLink from '@/Components/BaseButtonLink.vue'
import CardBox from '@/Components/CardBox.vue'
import BaseDivider from '@/Components/BaseDivider.vue'
import { capitalize } from '@/utils/capitalize'


const resumeData: any = usePage().props.resumeData;
const authUser: any = usePage().props.auth.user;

</script>

<template>
    <LayoutAuthenticated>

        <Head :title="authUser.name" />
        <SectionMain>
            <SectionTitleLineWithButton icon="far fa-arrow-alt-circle-right" title="Resume" main>
                <div>
                    <BaseButtonLink class="mr-1" icon="fas fa-edit"
                        label="Edit" color="info"  routeName="resume.index" rounded-full small />
                    <BaseButtonLink icon="far fa-arrow-alt-circle-left" label="Back" routeName="resume.index" color="contrast"
                        rounded-full small />
                </div>
            </SectionTitleLineWithButton>

            <div class="flex">
                <CardBox class="w-1/3 mr-2 flex flex-col items-center">
                    <div class="flex flex-col items-center justify-center">
                        <img class="rounded-full" :src="resumeData.resume.image" alt="">
                        <p class="text-xl font-bold">{{ authUser.name }}</p>
                        <p class="text-sm">{{ authUser.email }}</p>
                        <p class="text-sm">+88 {{ resumeData.resume.phone }}</p>
                        <p class="text-sm">{{ resumeData.resume.address }}</p>
                    </div>
                    <BaseDivider/>
                    <p class="mb-1"><span class="font-semibold">Father Name:</span> {{ resumeData.resume.father_name }}</p>
                    <p class="mb-1"><span class="font-semibold">Mother Name:</span> {{ resumeData.resume.mother_name }}</p>
                    <p class="mb-1"><span class="font-semibold">DOB:</span> {{ resumeData.resume.dob }}</p>
                    <p class="mb-1"><span class="font-semibold">Marital Status:</span> {{ resumeData.resume.marital_status }}</p>
                    <p class="mb-1"><span class="font-semibold">Religion:</span> {{ resumeData.resume.religion }}</p>
                    <p class="mb-1"><span class="font-semibold">Present Address:</span> {{ resumeData.resume.present_address }}</p>
                    <p class="mb-1"><span class="font-semibold">Permanent Address:</span> {{ resumeData.resume.permanent_address }}</p>
                    <p class="mb-1"><span class="font-semibold">Nationality:</span> {{ resumeData.resume.nationality }}</p>
                    
                </CardBox>
                <CardBox class="w-2/3">
                    <p class="text-3xl font-bold mb-1">Educations</p>
                    <BaseDivider/>
                    <div  v-if="resumeData.education" v-for="education in resumeData.education" :key="education.id">
                        <div class="flex flex-row justify-between mb-1">
                            <p class="text-xl font-semibold">{{ education.degree }}</p>
                            <div class="text-right">
                                <p><span class="font-semibold">Institution:</span> {{ education.institute }}</p>
                                <p><span class="font-semibold">Board/University: </span> {{ education.board_university }}</p>
                                <p><span class="font-semibold">Passing year: </span> {{ education.passing_year }}</p>
                                <p><span class="font-semibold">{{ capitalize(education.result_type) }}:</span>  {{ education.result }}</p>
                            </div>
                        </div>
                        <BaseDivider/>
                    </div>
                    <p class="text-3xl font-semibold">Trainings</p>
                    <BaseDivider/>
                    <div  v-if="resumeData.training" v-for="training in resumeData.training" :key="training.id">
                        <div class="flex flex-row justify-between mb-1">
                            <div>
                                <p class="text-xl font-semibold">{{ training.title }}</p>
                                <p>{{ training.description }}</p>
                            </div>
                            <div class="text-right">
                                <p><span class="font-semibold">Organization:</span>{{ training.organization }}</p>
                                <p><span class="font-semibold">Location:</span>{{ training.location }}</p>
                                <p><span class="font-semibold">Start Date:</span>{{ training.start_date }}</p>
                                <p><span class="font-semibold">End Date:</span>{{ training.end_date }}</p>
                            </div>
                        </div>
                        <BaseDivider/>
                    </div>

                    <p class="text-3xl font-semibold">Experiences</p>
                    <BaseDivider/>
                    <div  v-if="resumeData.experience" v-for="experience in resumeData.experience" :key="experience.id">
                        <div class="flex flex-row justify-between mb-1">
                            <div>
                                <p class="text-xl font-semibold">{{ experience.title }}</p>
                                <p>{{ experience.description }}</p>
                            </div>
                            <div class="text-right">
                                <p><span class="font-semibold">Company:</span>{{ experience.company }}</p>
                                <p><span class="font-semibold">Location:</span>{{ experience.location }}</p>
                                <p><span class="font-semibold">Start Date:</span>{{ experience.start_date }}</p>
                                <p><span class="font-semibold">End Date:</span>{{ experience.end_date }}</p>
                            </div>
                        </div>
                        <BaseDivider/>
                    </div>

                    <p class="text-3xl font-semibold">References</p>
                    <BaseDivider/>
                    <div  v-if="resumeData.reference" v-for="reference in resumeData.reference" :key="reference.id">
                        <div class="flex flex-row justify-between mb-1">
                            <div>
                                <p class="text-xl font-semibold">{{ reference.name }}</p>
                                <p>{{ reference.organization }}</p>
                            </div>
                            <div class="text-right">
                                <p><span class="font-semibold">Phone:</span>{{ reference.phone }}</p>
                                <p><span class="font-semibold">Email:</span>{{ reference.email }}</p>
                                <p><span class="font-semibold">Relationship:</span>{{ reference.relationship }}</p>
                            </div>
                        </div>
                        <BaseDivider/>
                    </div>
                </CardBox>
            </div>
    </SectionMain>
</LayoutAuthenticated></template>
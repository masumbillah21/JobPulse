<script setup lan='ts'>
import { Head, usePage } from '@inertiajs/vue3'
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue'
import SectionMain from '@/Components/SectionMain.vue'
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue'
import BaseButtonLink from '@/Components/BaseButtonLink.vue'
import CardBox from '@/Components/CardBox.vue'


const companyData = usePage().props.companyDetails;


</script>

<template>
    <LayoutAuthenticated>

        <Head :title="companyData.name" />
        <SectionMain>
            <SectionTitleLineWithButton icon="far fa-arrow-alt-circle-right" :title="companyData.name" main>
                <BaseButtonLink icon="far fa-arrow-alt-circle-left" label="Back" routeName="company.index" color="contrast"
                    rounded-full small />
            </SectionTitleLineWithButton>

            <div class="flex">
                <CardBox class="my-24 w-1/5 ml-3">
                    <img class="mb-10" :src="companyData.logo" alt="" width="200">

                    <h2 class="mb-3"><span class="text-3xl font-bold">Title: {{ companyData.name }} </span></h2>
                    <hr class="mb-6">

                    <h2 class="mb-3"><span class="font-bold">Company Type:</span> {{ companyData.company_type }}</h2>

                    <h2 class="mb-3"><span class="font-bold">Company Size:</span>  {{ companyData.company_size }}</h2>

                    <h2 class="mb-3"><span class="font-bold">Address:</span>  {{ companyData.address }}</h2>

                    <h2 class="mb-3"><span class="font-bold">Phone:</span>  {{ companyData.phone }}</h2>

                    <h2 class="mb-3"><span class="font-bold">Email: </span> {{ companyData.email }}</h2>

                    <h2 class="mb-3"><span class="font-bold">Website:</span>  {{ companyData.website }}</h2>
                </CardBox>
                <CardBox class="my-24 w-4/5 ml-3">
                    <h2 class="text-2xl font-bold">Company Description</h2>
                    <hr class="mb-3">
                    <p class="mb-2">{{ companyData.description }}</p>
                </CardBox>
            </div>
        </SectionMain>
    </LayoutAuthenticated>
</template>
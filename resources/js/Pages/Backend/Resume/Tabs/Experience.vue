<script setup lang="ts">
    import {
        mdiPlus,
        mdiMinus,
        mdiArrowRightCircle,
        mdiContentSave,
    } from '@mdi/js'
    import { computed, ref, reactive } from 'vue'
    import BaseButtonLink from '@/Components/BaseButtonLink.vue'
    import BaseButtons from "@/Components/BaseButtons.vue";
    import BaseDivider from "@/Components/BaseDivider.vue";
    import FormValidationErrors from "@/Components/FormValidationErrors.vue";
    import FormSuccess from "@/Components/FormSuccess.vue";
    import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue'
    import CardBox from '@/Components/CardBox.vue'
    import FormField from "@/Components/FormField.vue";
    import FormControl from "@/Components/FormControl.vue";
    import { useForm, usePage, router } from '@inertiajs/vue3'


    const experienceInfo = usePage().props.experienceInfo

    const form = useForm({
        'tableRow': [
            {
                id: 0,
                title: '',
                company: '',
                location: '',
                start_date: '',
                end_date: '',
                description: '',
            },
        ],
    });

    if(experienceInfo) {
        form.tableRow = experienceInfo
    }

    const addRow = () => {
        form.tableRow.push({
            id: 0,
            title: '',
            company: '',
            location: '',
            start_date: '',
            end_date: '',
            description: '',
        });
    }

    const remove = (index, id) => {
        form.tableRow.splice(index, 1);
        if(id != 0){
            router.delete(route("resume.deleteExperience", id));
        }
    }

    const submit = (data) => {
        router.post(route("resume.saveExperience"), data);
    }

</script>

<template>
    <SectionTitleLineWithButton :icon="mdiArrowRightCircle" title="Working Experience" main>
        <BaseButtonLink
            :icon="mdiPlus"
            @click="addRow"
            label="Add New"
            color="contrast"
            rounded-full
            small
        />
    </SectionTitleLineWithButton>
    <CardBox is-form @submit.prevent="submit">
        <FormValidationErrors />
        <FormSuccess />
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Title
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Organization
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Location
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Start Date
                    </th>
                    <th scope="col" class="px-6 py-3">
                        End Date
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Description
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row, index)  in form.tableRow" :key="index"
                    class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <FormControl v-model="row.title" type="text" required />
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <FormControl v-model="row.company" type="text" required />
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <FormControl v-model="row.location" type="text" required />
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <FormControl v-model="row.start_date" type="date" required />
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <FormControl v-model="row.end_date" type="date" required />
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <FormControl v-model="row.description" type="text" required />
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <BaseButtonLink :icon="mdiContentSave" color="info" :class="{ 'opacity-25': form.processing }" @click="submit(row)" />
                        <BaseButtonLink :icon="mdiMinus" @click="remove(index, row.id)" class="ml-2" color="danger"
                            rounded-full small />
                    </td>
                </tr>
            </tbody>
        </table>
    </CardBox>
</template>
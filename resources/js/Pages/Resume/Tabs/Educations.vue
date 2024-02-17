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


    const educationInfo = usePage().props.educationInfo ?? null;

    const gradeType = [
        { id: 'division', label: 'Division' },
        { id: 'grade', label: 'Grade' },
    ]

    const form = useForm({
        'educations': [
            {
                id: 0,
                degree: 'test',
                institute: 'test1',
                board_university: 'test2',
                passing_year: '2012',
                result_type: 'grade',
                result: '5'
            },
        ],
        _method: 'post'
    });

    if(educationInfo){
        form.educations = [];
        educationInfo.forEach(
            (item, index) => form.educations.push({
                id: item.id,
                degree: item.degree,
                institute: item.institute,
                board_university: item.board_university,
                passing_year: item.passing_year,
                result_type: item.result_type,
                result: item.result,
            })
        );
    }
    const addRow = () => {
        form.educations.push({
            id: 0,
            degree: '',
            institute: '',
            board_university: '',
            passing_year: '',
            result_type: 'grade',
            result: '5'
        });
    }

    const remove = (index, id) => {
        form.educations.splice(index, 1);
        if(id != 0){
            router.delete(route("resume.deleteEducation", id));
        }
    }

    const submit = (data) => {
        router.post(route("resume.saveEducation"), data);
    }

</script>

<template>
    <SectionTitleLineWithButton :icon="mdiArrowRightCircle" title="Educational Qualification" main>
        <BaseButtonLink :icon="mdiPlus" @click="addRow" label="Add New" color="contrast" rounded-full small />
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
                        Institution
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Board / University
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Passing Year
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Result Type
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Result
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row, index)  in form.educations" :key="index"
                    class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <FormControl v-model="row.degree" type="text" required />
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <FormControl v-model="row.institute" type="text" required />
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <FormControl v-model="row.board_university" type="text" required />
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <FormControl v-model="row.passing_year" type="text" required />
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white" width="180">
                        <FormControl v-model="row.result_type"  :options="gradeType" required />
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <FormControl v-model="row.result" type="text" required />
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
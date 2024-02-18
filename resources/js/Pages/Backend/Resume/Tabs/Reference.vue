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


    const referenceInfo = usePage().props.referenceInfo

    const form = useForm({
        'tableRow': [
            {
                id: 0,
                name: '',
                organization: '',
                phone: '',
                email: '',
                relationship: '',
            },
        ],
    });

    if(referenceInfo) {
        form.tableRow = referenceInfo
    }

    const addRow = () => {
        form.tableRow.push({
            id: 0,
            name: '',
            organization: '',
            phone: '',
            email: '',
            relationship: '',
        });
    }

    const remove = (index, id) => {
        form.tableRow.splice(index, 1);
        if(id != 0){
            router.delete(route("resume.deleteReference", id));
        }
    }

    const submit = (data) => {
        router.post(route("resume.saveReference"), data);
    }

</script>

<template>
    <SectionTitleLineWithButton :icon="mdiArrowRightCircle" title="Reference" main>
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
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Organization
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Phone
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Email
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Relationship
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
                        <FormControl v-model="row.name" type="text" required />
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <FormControl v-model="row.organization" type="text" required />
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <FormControl v-model="row.phone" type="tel" required />
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <FormControl v-model="row.email" type="email" required />
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <FormControl v-model="row.relationship" type="text" required />
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
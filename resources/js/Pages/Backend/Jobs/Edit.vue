<script setup lang="ts">
    import { computed, ref, watch } from 'vue'
    import { mdiArrowRightCircle, mdiArrowLeftCircle, mdiAccount, mdiEmail, mdiFormTextboxPassword, mdiNoteEditOutline, mdiFormatListBulletedType } from '@mdi/js'
    import SectionMain from '@/Components/SectionMain.vue'
    import CardBox from '@/Components/CardBox.vue'
    import FormField from "@/Components/FormField.vue";
    import FormControl from "@/Components/FormControl.vue";
    import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue'
    import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue'
    import BaseButtonLink from '@/Components/BaseButtonLink.vue'
    import BaseButtons from "@/Components/BaseButtons.vue";
    import BaseDivider from "@/Components/BaseDivider.vue";
    import FormValidationErrors from "@/Components/FormValidationErrors.vue";
    import FormSuccess from "@/Components/FormSuccess.vue";
    import FormCheckRadioGroup from "@/Components/FormCheckRadioGroup.vue";
    import { Head, useForm, usePage } from '@inertiajs/vue3'

    const jobData: any = usePage().props.jobData ?? null

    const jobTypes = [
        { id: '', label: 'Select Job Type' },
        { id: 'Full Time', label: 'Full Time' },
        { id: 'Part Time', label: 'Part Time' },
        { id: 'Contract', label: 'Contract' },
    ];
    const form: any = useForm({
        id: 0,
        title: '',
        location: '',
        job_type: jobTypes[0].id,
        description: '',
        requirements: '',
        responsibilities: '',
        salary: '',
        facilities: '',
        closing_date: '',
        status: '',
        _method: "post",
    });

    if (jobData !== null) {
        form.id = jobData.id
        form.title = jobData.title
        form.location = jobData.location
        form.job_type = jobData.job_type
        form.description = jobData.description
        form.requirements = jobData.requirements
        form.responsibilities = jobData.responsibilities
        form.salary = jobData.salary
        form.facilities = jobData.facilities
        form.status = jobData.status
        form._method = 'put'
    }

    const submit = () => {
        if (jobData !== null) {
            update();
        } else {
            create();
        }
    };

    const create = () => {
        form
            .transform((data: any) => ({
                ...data,
                terms: form.terms && form.terms.length,
            }))
            .post(route("jobs.store"), {
                onSuccess: () => form.reset(),
            });
    };

    const update = () => {
        form
            .transform((data: any) => ({
                ...data,
                terms: form.terms && form.terms.length,
            }))
            .post(route("jobs.update", form.id));
    };
</script>

<template>
    <LayoutAuthenticated>

        <Head :title="(jobData !== null) ? 'Edit job' : 'Create job'" />
        <SectionMain>
            <SectionTitleLineWithButton icon="far fa-arrow-alt-circle-right"
                :title="jobData !== null ? 'Edit job' : 'Create job'" main>
                <BaseButtonLink :icon="mdiArrowLeftCircle" label="Back" routeName="jobs.index" color="contrast"
                    rounded-full small />
            </SectionTitleLineWithButton>
            <div class="flex justify-center items-center">
                <CardBox class="my-24 w-1/2" is-form @submit.prevent="submit">
                    <FormValidationErrors />
                    <FormSuccess />
                    <FormField label="Title" label-for="title" help="Please enter job title">
                        <FormControl v-model="form.title" id="title" :icon="mdiAccount" type="text" required />
                    </FormField>
                    <FormField label="Location" label-for="location" help="Please enter job location">
                        <FormControl v-model="form.location" id="location" :icon="mdiAccount" type="text" required />
                    </FormField>
                    <FormField label="Job type" help="Please select job type">
                        <FormControl v-model="form.job_type" :icon="mdiFormatListBulletedType" :options="jobTypes" />
                    </FormField>

                    <FormField label="Description" label-for="description" help="Please enter job description">
                        <FormControl v-model="form.description" id="description" type="textarea" required />
                    </FormField>

                    <FormField label="Requirements" label-for="requirements" help="Please enter job requirements">
                        <FormControl v-model="form.requirements" id="requirements" type="textarea" required />
                    </FormField>

                    <FormField label="Responsibilities" label-for="responsibilities"
                        help="Please enter job responsibilities">
                        <FormControl v-model="form.responsibilities" id="responsibilities" type="textarea" required />
                    </FormField>

                    <FormField label="Salary" label-for="salary" help="Please enter job salary">
                        <FormControl v-model="form.salary" id="salary" :icon="mdiAccount" type="text" required />
                    </FormField>

                    <FormField label="Facilities" label-for="facilities" help="Please enter job facilities">
                        <FormControl v-model="form.facilities" id="facilities" type="textarea" required />
                    </FormField>
                    <p v-if="jobData && jobData.closing_date" class="text-red-500">Closing Date: {{ jobData.closing_date }}</p>
                    <FormField label="Closing date" label-for="closing-date" help="Please enter job closing date">
                        <FormControl v-model="form.closing_date" id="closing-date" :icon="mdiAccount" type="date" />
                    </FormField>
                    <FormCheckRadioGroup v-model="form.status" name="status" type="radio"
                        :options="{ '1': 'Active', '0': 'Inactive' }" />

                    <BaseDivider />
                    <BaseButtons>
                        <BaseButtonLink type="submit" color="info" :label="jobData !== null ? 'Update' : 'Create'"
                            :class="{ 'opacity-25': form.processing }" :disabled="form.processing" />
                    </BaseButtons>
                </CardBox>
            </div>

        </SectionMain>
    </LayoutAuthenticated>
</template>
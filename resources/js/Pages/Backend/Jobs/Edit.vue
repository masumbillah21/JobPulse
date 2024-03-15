<script setup lang="ts">
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
    import { isSystemUser } from '@/utils/isSystemUser';
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
    import CKEditor from "@ckeditor/ckeditor5-vue";

    const jobData: any = usePage().props.jobData ?? null
    const jobCateLists: any = usePage().props.jobCateLists ?? null

    const jobTypes = [
        { id: '', label: 'Select Job Type' },
        { id: 'Full Time', label: 'Full Time' },
        { id: 'Part Time', label: 'Part Time' },
        { id: 'Contract', label: 'Contract' },
    ];
    const jobLevel = [
        { id: '', label: 'Select Experience Level' },
        { id: 'Beginner', label: 'Beginner' },
        { id: 'Intermiddiate', label: 'Intermidiate' }, 
        { id: 'Advanced', label: 'Advanced' },
    ];

    const workType = [
        { id: '', label: 'Select a type' },
        { id: 'Remote', label: 'Remote' },
        { id: 'On Site', label: 'On Site' }, 
        { id: 'Hybrid', label: 'Hybrid' },
    ];

    const jobCates = [
        {id: 0, label: 'Select a category'},
    ]
    if(jobCateLists){
        jobCates.push(...jobCateLists)
    }
    const editor = ClassicEditor;

    // Add custom CSS to increase the height of CKEditor
    const style = `
        .ck-editor__editable {
            min-height: 300px; /* Adjust the height as per your requirement */
        }
        .ck-powered-by-balloon {
            display: none !important;
        }
    `;

    // Apply the custom style
    const addStyle = () => {
        const styleElement = document.createElement('style');
        styleElement.textContent = style;
        document.head.appendChild(styleElement);
    };

    const form: any = useForm({
        id: 0,
        title: '',
        location: '',
        job_type: jobTypes[0].id,
        job_level: jobLevel[0].id,
        job_category_id: jobCates[0].id,
        work_type: workType[0].id,
        description: '',
        requirements: '',
        responsibilities: '',
        salary: '',
        facilities: '',
        skills: '',
        closing_date: '',
        status: '',
        _method: "post",
    });

    if (jobData !== null) {
        form.id = jobData.id
        form.title = jobData.title
        form.location = jobData.location
        form.job_type = jobData.job_type
        form.job_level = jobData.job_level
        form.job_category_id = jobData.job_category_id
        form.work_type = jobData.work_type
        form.description = jobData.description
        form.requirements = jobData.requirements
        form.responsibilities = jobData.responsibilities
        form.salary = jobData.salary
        form.facilities = jobData.facilities
        form.skills = jobData.skills
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
        const routeName = isSystemUser() ? "admin.jobs.store" : "jobs.store";
        
        form.post(route(routeName), {
            onSuccess: () => form.reset(),
        });
    };

    const update = () => {
        const routeName = isSystemUser() ? "admin.jobs.update" : "jobs.update";
        form.post(route(routeName, form.id));
    };

    addStyle()
</script>

<template>
    <LayoutAuthenticated>

        <Head :title="(jobData !== null) ? 'Edit job' : 'Create job'" />
        <SectionMain>
            <SectionTitleLineWithButton icon="far fa-arrow-alt-circle-right"
                :title="jobData !== null ? 'Edit job' : 'Create job'" main>
                <BaseButtonLink icon="far fa-arrow-alt-circle-left" label="Back" routeName="jobs.index" color="contrast"
                    rounded-full small />
            </SectionTitleLineWithButton>
            <div class="flex justify-center items-center">
                <CardBox class="my-24 w-1/2" is-form @submit.prevent="submit">
                    <FormValidationErrors />
                    <FormSuccess />
                    <FormField label="Title" label-for="title" help="Please enter job title">
                        <FormControl v-model="form.title" id="title" icon="fas fa-pencil-alt" type="text" required />
                    </FormField>
                    <FormField label="Job Category" help="Please select a category">
                        <FormControl v-model="form.job_category_id" icon="fas fa-list-alt" :options="jobCates" />
                    </FormField>

                    <FormField label="Location" label-for="location" help="Please enter job location">
                        <FormControl v-model="form.location" id="location" icon="fas fa-map-marker" type="text" required />
                    </FormField>
                    <FormField label="Job Type" help="Please select job type">
                        <FormControl v-model="form.job_type" icon="fas fa-list-alt" :options="jobTypes" />
                    </FormField>

                    <FormField label="Experience Level" help="Please select one">
                        <FormControl v-model="form.job_level" icon="fas fa-list-alt" :options="jobLevel" />
                    </FormField>

                    <FormField label="Work Place" help="Please select one">
                        <FormControl v-model="form.work_type" icon="fas fa-list-alt" :options="workType" />
                    </FormField>

                    <!-- <FormField label="Description" label-for="description" help="Please enter job description">
                        <FormControl v-model="form.description" id="description" type="textarea" required />
                    </FormField> -->
                    <p>Description</p>
                    <div class="dark:text-black min-h-24">
                        <CKEditor.component v-model="form.description" :editor="editor"/>
                    </div>

                    <!-- <FormField label="Requirements" label-for="requirements" help="Please enter job requirements">
                        <FormControl v-model="form.requirements" id="requirements" type="textarea" required />
                    </FormField> -->
                    <p>Requirements</p>
                    <div class="dark:text-black min-h-24">
                        <CKEditor.component v-model="form.requirements" :editor="editor"/>
                    </div>

                    <!-- <FormField label="Responsibilities" label-for="responsibilities"
                        help="Please enter job responsibilities">
                        <FormControl v-model="form.responsibilities" id="responsibilities" type="textarea" required />
                    </FormField> -->

                    <p>Responsibilities</p>
                    <div class="dark:text-black min-h-24">
                        <CKEditor.component v-model="form.responsibilities" :editor="editor"/>
                    </div>

                    <FormField label="Salary" label-for="salary" help="Please enter job salary">
                        <FormControl v-model="form.salary" id="salary" icon="fas fa-dollar-sign" type="number" step="0.01" min="1" required />
                    </FormField>

                    <!-- <FormField label="Facilities" label-for="facilities" help="Please enter job facilities">
                        <FormControl v-model="form.facilities" id="facilities" type="textarea" required />
                    </FormField> -->
                    <p>Facilities</p>
                    <div class="dark:text-black min-h-24">
                        <CKEditor.component v-model="form.facilities" :editor="editor"/>
                    </div>

                    <FormField label="Skills" label-for="skills" help="Write skill sets seprated by comma">
                        <FormControl v-model="form.skills" id="skills" type="text" required />
                    </FormField>
                    <p v-if="jobData && jobData.closing_date" class="text-red-500">Closing Date: {{ jobData.closing_date }}</p>
                    <FormField label="Closing date" label-for="closing-date" help="Please enter job closing date">
                        <FormControl v-model="form.closing_date" id="closing-date" type="date" />
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
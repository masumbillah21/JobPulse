<script setup lan='ts'>
import { ref } from 'vue'
import { Head, router, usePage, useForm } from '@inertiajs/vue3'
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue'
import SectionMain from '@/Components/SectionMain.vue'
import SectionTitle from '@/Components/SectionTitle.vue'
import BaseButtons from '@/Components/BaseButtons.vue'
import BaseButtonLink from '@/Components/BaseButtonLink.vue'
import CardBox from '@/Components/CardBox.vue'
import FormValidationErrors from '@/Components/FormValidationErrors.vue'
import FormSuccess from '@/Components/FormSuccess.vue'
import FormField from '@/Components/FormField.vue'
import FormControl from '@/Components/FormControl.vue'
import FormFilePicker from '@/Components/FormFilePicker.vue'
import { mdiArrowRightCircle, mdiPlus, mdiMinus, mdiContentSave, mdiChevronUp, mdiChevronDown } from '@mdi/js'


const form = useForm({
    id: 0,
    title: "",
    featured_image: "",
    contents: [],
});

const addSection = () => {
    form.contents.push({
        name: `Section ${form.contents.length + 1}`,
        data: [{'title': '', 'description': '', 'image': '', 'hidden': false, 'imageKey': Date.now()}],
    });
}

const removeSection = (sectionIndex) => {
    form.contents.splice(sectionIndex, 1);
}

const save = (data) => {
    router.post(route('permissions.store'), data);
};

const toggleSection = (sectionIndex) => {
    form.contents[sectionIndex].hidden = !form.contents[sectionIndex].hidden;
}


</script>

<template>
    <LayoutAuthenticated>

        <Head title="Edit Page" />
        <SectionMain>
            <SectionTitle title="About Page"/>
            <CardBox class="w-full" is-form @submit.prevent="save">
                <FormValidationErrors />
                <FormSuccess />
                <div class="flex">
                    <CardBox class="w-9/12">
                        <div class="border border-gray-500 rounded p-2">
                          <FormField label="Title" help="Enter Page Title">
                            <FormControl v-model="form.title" type="text" placeholder="Enter Page Title" />
                          </FormField>
                          <FormField label="Description" label-for="description">
                              <FormControl v-model="form.description" id="description"
                                  placeholder="Description here" type="textarea" required />
                          </FormField>
                          <FormField label="Featued Image" help="Max 500kb">
                              <FormFilePicker label="Upload Image"
                                  color="success" @update:modelValue="form.image = $event" />
                          </FormField>
                        </div>
                        <div class="border border-gray-500 rounded p-2 mt-4">
                          <FormField label="Title" help="Enter Page Title">
                            <FormControl v-model="form.title" type="text" placeholder="Enter Page Title" />
                          </FormField>
                          <FormField label="Description" label-for="description">
                              <FormControl v-model="form.description" id="description"
                                  placeholder="Description here" type="textarea" required />
                          </FormField>
                          <FormField label="Featued Image" help="Max 500kb">
                              <FormFilePicker label="Upload Image"
                                  color="success" @update:modelValue="form.image = $event" />
                          </FormField>
                        </div>
                    </CardBox>
                    <CardBox class="w-3/12 ml-2">
                        <FormField label="Featued Image" help="Max 500kb">
                            <FormFilePicker label="Upload Image"
                                color="success" @update:modelValue="form.image = $event" />
                        </FormField>
                        <BaseButtons>
                            <BaseButtonLink :icon="mdiContentSave" @click="save(slider)" label="Save" color="info" rounded-full
                                small />
                        </BaseButtons>
                    </CardBox>
                </div>
        </CardBox>
    </SectionMain>
</LayoutAuthenticated></template>
<script setup lan='ts'>
import { ref } from 'vue'
import { Head, router, usePage, useForm } from '@inertiajs/vue3'
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue'
import SectionMain from '@/Components/SectionMain.vue'
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue'
import BaseButtons from '@/Components/BaseButtons.vue'
import BaseButtonLink from '@/Components/BaseButtonLink.vue'
import CardBox from '@/Components/CardBox.vue'
import FormValidationErrors from '@/Components/FormValidationErrors.vue'
import FormSuccess from '@/Components/FormSuccess.vue'
import FormField from '@/Components/FormField.vue'
import FormControl from '@/Components/FormControl.vue'
import FormFilePicker from '@/Components/FormFilePicker.vue'
import FormCheckRadioGroup from '@/Components/FormCheckRadioGroup.vue'
import { mdiArrowRightCircle, mdiPlus, mdiMinus, mdiContentSave, mdiChevronUp, mdiChevronDown } from '@mdi/js'

const pageType = [
  {id: 'general', label: 'General'},
  {id: 'home', label: 'Home'},
  {id: 'blog', label: 'Blog'},
  {id: 'contact', label: 'Contact'},
]
const form = useForm({
  id: 0,
  title: "",
  featured_image: "",
  pageType: pageType[0].id,
  forNav: 0,
  contents: [{
    name: 'Section 1',
    data: [{
      title: "",
      description: "",
      image: '',
      imageKey: Date.now()
    }],
  }],
});

const addSection = () => {
  form.contents.push({
    name: `Section ${form.contents.length + 1}`,
    data: [{
      title: "",
      description: "",
      image: '',
      imageKey: Date.now()
    }],
  });
}

const removeSection = (sectionIndex) => {
  form.contents[sectionIndex].data.forEach(row => {
    delete row.image;
  });

  form.contents.splice(sectionIndex, 1);
}

const removeRow = (sectionIndex, rowIndex) => {
  form.contents[sectionIndex].data.splice(rowIndex, 1);
}

const addRow = (sectionIndex) => {
  form.contents[sectionIndex].data.push({
    title: "",
    description: "",
    image: '',
    imageKey: Date.now()
  });
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
        <CardBox class="w-full" is-form @submit.prevent="save">
            <FormValidationErrors />
            <FormSuccess />
            <SectionTitleLineWithButton title="Add New">
                <BaseButtons>
                    <BaseButtonLink class="mr-1" :icon="mdiPlus" @click="addSection" label="Back" color="contrast" rounded-full
                        small />
                </BaseButtons>
            </SectionTitleLineWithButton>

            
            <div class="flex flex-row justify-center">
              <div class="w-9/12">
                  <FormField label="Title" help="Enter Page Title">
                    <FormControl v-model="form.title" type="text" placeholder="Enter Page Title" />
                  </FormField>
                  <div v-for="(row, sectionIndex) in form.contents" :key="sectionIndex">
                    <SectionTitleLineWithButton :title="row.name" main>
                    <BaseButtons>
                        <BaseButtonLink class="mr-1" :icon="mdiPlus" @click="addSection" label="Add Section" color="contrast" rounded-full
                        small />
                        <BaseButtonLink v-if="sectionIndex > 0" :icon="mdiMinus" @click="removeSection(sectionIndex)" label="Remove Section" color="danger"
                        rounded-full small />
                        <BaseButtonLink class="mr-1" :icon="row.hidden ? mdiChevronDown : mdiChevronUp" @click="toggleSection(sectionIndex)"
                        :label="row.hidden ? 'Show' : 'Hide'" color="contrast" rounded-full small />
                    </BaseButtons>
                    </SectionTitleLineWithButton>

                    <div v-show="!row.hidden" v-for="(data, rowIndex) in row.data" :key="rowIndex + sectionIndex" class="mb-2 flex-col justify-end items-end h-full">
                        <div class="w-full mb-7 p-5 bg-slate-900 rounded">
                            <BaseButtons class="mt-auto justify-end">
                                <BaseButtonLink class="mr-1" :icon="mdiPlus" @click="addRow(sectionIndex)" label="Add Row" color="contrast" rounded-full
                        small />
                                <BaseButtonLink v-if="rowIndex > 0" :icon="mdiMinus" @click="removeRow(sectionIndex, rowIndex)" label="Remove Row" color="danger"
                                rounded-full small />
                            </BaseButtons>
                            <FormField :label="'Title: ' + data.title " :label-for="'headline-' + rowIndex">
                                <FormControl v-model="data.title" :id="'headline-' + rowIndex" placeholder="Headline here" type="text"
                                required />
                            </FormField>
                            <FormField label="Description" :label-for="'description-' + rowIndex">
                                <FormControl v-model="data.description" :id="'description-' + rowIndex" placeholder="Description here"
                                type="textarea" required />
                            </FormField>
                            <FormField label="Image" help="Max 500kb">
                                <FormFilePicker :key="data.imageKey" label="Upload Image" :modelValue="data.image" color="success" @update:modelValue="data.image = $event" />
                            </FormField>
                        </div>
                    </div>
                </div>
              </div>
              
              <div class="w-3/12 ml-5 flex flex-col items-center justify-start mt-10 border border-gray-50 rounded p-5">
                <img v-if="form.featured_image" :src="form.featured_image" alt="">
                <div v-else class="h-52 w-11/12 mb-4 border-dashed border border-gray-50 flex justify-center items-center">Featured Image</div>
                <FormField label="Featured Image" help="Max 500kb">
                    <FormFilePicker label="Upload Photo" :modelValue="form.featured_image" color="success" @update:modelValue="form.featured_image = $event" />
                </FormField>

                <FormField class="w-full" label="Page Type">
                <FormControl 
                  v-model="form.pageType" 
                  :options="pageType" />
                </FormField>

                <FormField class="w-full" label="Show On Navigation Bar?">
                  <FormCheckRadioGroup v-model="form.forNav" name="for_nav" type="radio"
                        :options="{ '1': 'Yes', '0': 'No' }" />
                </FormField>

                <BaseButtonLink class="w-full mt-10" :icon="mdiContentSave" @click="save(slider)" label="Save" color="info" rounded-full small />

              </div>
            </div>
        </CardBox>
    </SectionMain>
    </LayoutAuthenticated>
</template>
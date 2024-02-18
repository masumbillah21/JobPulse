<script setup lan='ts'>
import { ref } from 'vue'
import { Head, router, usePage, useForm } from '@inertiajs/vue3'
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue'
import SectionMain from '@/Components/SectionMain.vue'
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue'
import SectionTitle from '@/Components/SectionTitle.vue'
import BaseButtons from '@/Components/BaseButtons.vue'
import BaseButtonLink from '@/Components/BaseButtonLink.vue'
import CardBox from '@/Components/CardBox.vue'
import FormValidationErrors from '@/Components/FormValidationErrors.vue'
import FormSuccess from '@/Components/FormSuccess.vue'
import FormField from '@/Components/FormField.vue'
import FormControl from '@/Components/FormControl.vue'
import FormFilePicker from '@/Components/FormFilePicker.vue'
import BaseDivider from '@/Components/FormFilePicker.vue'

import { mdiArrowRightCircle, mdiPlus, mdiMinus, mdiContentSave, mdiChevronUp, mdiChevronDown } from '@mdi/js'

const isCollapsed = ref(true);

const form = useForm({
  id: 0,
  title: "",
  featured_image: "",
  contents: [],
});

const sliderSection = {
  name: "Slider Section",
  data: [
    {
      title: "",
      description: "",
      image: "",
    }
  ]
}



const addSection = () => {
  form.contents.push({
    name: sliderSection.name,
    data: [...sliderSection.data],
  });
}

const removeSection = (index) => {
  form.contents.splice(index, 1);
}

const removeRow = (sectionIndex, rowIndex) => {
  form.contents[sectionIndex].data.splice(rowIndex, 1);
}

const addRow = (sectionIndex) => {
  form.contents[sectionIndex].data.push({
    title: "",
    description: "",
    image: "",
  });
}

const save = (data) => {
  router.post(route('permissions.store'), data);
};

const collapsed = () => {
  isCollapsed.value = !isCollapsed.value
}


</script>

<template>
  <LayoutAuthenticated>

    <Head title="Home" />
    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiArrowRightCircle" title="Home" main>
        <BaseButtonLink class="mr-1" :icon="mdiPlus" @click="addSection" label="Add Section" color="contrast" rounded-full
          small />
      </SectionTitleLineWithButton>
      <FormValidationErrors />
      <FormSuccess class="pt-5 pl-5" />

      <CardBox v-for="(row, sectionIndex) in form.contents" :key="sectionIndex" class="mb-6 relative overflow-x-auto shadow-md sm:rounded-lg">
        <SectionTitleLineWithButton :title="row.name" main>
          <BaseButtons>
            <BaseButtonLink class="mr-1" :icon="mdiPlus" @click="addRow(sectionIndex)" label="Add" color="contrast" rounded-full
              small />
            <BaseButtonLink :icon="mdiMinus" @click="removeSection(sectionIndex)" label="Remove" color="danger"
              rounded-full small />
            <BaseButtonLink class="mr-1" :icon="isCollapsed ? mdiChevronDown : mdiChevronUp" @click="collapsed"
              :label="isCollapsed ? 'Show' : 'Hide'" color="contrast" rounded-full small />
          </BaseButtons>
        </SectionTitleLineWithButton>
        <div v-if="isCollapsed" v-for="(data, rowIndex) in row.data" :key="rowIndex" class="flex mb-2">
          <CardBox class="w-4/5 mr-3">
            <FormField :label="'Headline-' + rowIndex " :label-for="'headline-' + rowIndex">
              <FormControl v-model="form.title" :id="'headline-' + rowIndex" placeholder="Slider headline here" type="text"
                required />
            </FormField>
            <FormField label="Description" :label-for="'description-' + rowIndex">
              <FormControl v-model="form.description" :id="'description-' + rowIndex" placeholder="Description here"
                type="textarea" required />
            </FormField>
          </CardBox>
          <CardBox class="w-1/5">

            <FormField label="Image" help="Max 500kb">
              <FormFilePicker label="Upload Image" color="success" @update:modelValue="form.image = $event" />
            </FormField>

            <BaseButtons>
              <BaseButtonLink :icon="mdiContentSave" @click="save(slider)" label="Save" color="info" rounded-full small />

              <BaseButtonLink :icon="mdiMinus" @click="removeRow(sectionIndex, rowIndex)" label="Remove" color="danger"
                rounded-full small />
            </BaseButtons>
          </CardBox>

        </div>

      </CardBox>
    </SectionMain>
  </LayoutAuthenticated>
  </template>
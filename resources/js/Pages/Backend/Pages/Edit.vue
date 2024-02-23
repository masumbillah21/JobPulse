<script setup lang='ts'>
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
import { base64ToFile } from '@/utils/base64ToFile.js'
import Home from '@/Pages/Backend/Pages/Parts/Home.vue'
import Blog from '@/Pages/Backend/Pages/Parts/Blog.vue'
import Contact from '@/Pages/Backend/Pages/Parts/Contact.vue'
import General from '@/Pages/Backend/Pages/Parts/General.vue'

const pageData: any = usePage().props.pageData ?? null
const urls: any = usePage().props.urls
const storage = urls.storeUrl

const pageType = [
  { id: 'general', label: 'General' },
  { id: 'home', label: 'Home' },
  { id: 'blog', label: 'Blog' },
  { id: 'contact', label: 'Contact' },
]
const imagePosition = [
  { id: 'left', label: 'Left' },
  { id: 'light', label: 'Right' },
]

const iconList = [
  { id: 'fa fa-phone', label: 'Phone' },
  { id: 'fa fa-email', label: 'Email' },
  { id: 'fa fa-map', label: 'Map Marker' },
  { id: 'fa fa-fax', label: 'Fax' },
]

const form: any = useForm({
  id: 0,
  title: "",
  featured_image: "",
  page_type: pageType[0].id,
  for_nav: 0,
  page_order: 0,
  email_to: "",
  status: 1,
  contents: [{
    name: 'Section 1',
    data: [{
      title: "",
      subtitle: "",
      description: "",
      image: '',
      imagePosition: imagePosition[0].id,
      imageKey: Date.now()
    }],
  }],
  _method: 'post',
});

if (pageData) {
  form.id = pageData.id
  form.title = pageData.title
  form.page_type = pageData.page_type
  form.for_nav = pageData.for_nav
  form.page_order = pageData.page_order
  form.email_to = pageData.email_to
  form.status = pageData.status
  form.contents = pageData.contents
  form._method = 'put'

  form.contents.forEach((section: any) => {
    section.data.forEach((row: any) => {
      if (row.image) {
        row.image = base64ToFile(row.image, row.imageKey)
      }
    })
  })
}

const featuredKey = ref(1);
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

const removeSection = (sectionIndex: any) => {
  form.contents[sectionIndex].data.forEach((row: any) => {
    delete row.image;
  });

  form.contents.splice(sectionIndex, 1);
}

const removeRow = (sectionIndex: any, rowIndex: any) => {
  form.contents[sectionIndex].data.splice(rowIndex, 1);
}

const addRow = (sectionIndex: any) => {
  if (form.pageType === 'contact') {
    form.contents[sectionIndex].data.push({
      title: "",
      info: "",
      icon: iconList[0].id,
    });
  } else {
    form.contents[sectionIndex].data.push({
      title: "",
      description: "",
      image: '',
      imageKey: Date.now()
    });
  }
}

const save = () => {
  if (form.id == 0) {
    create();
  } else {
    update();
  }
};

const create = () => {
  form
    .transform((data: any) => ({
      ...data,
      terms: form.terms && form.terms.length,
    }))
    .post(route("pages.store"));
}

const update = () => {
  form
    .transform((data: any) => ({
      ...data,
      terms: form.terms && form.terms.length,
    }))
    .post(route("pages.update", form.id));
}

const toggleSection = (sectionIndex: any) => {
  form.contents[sectionIndex].hidden = !form.contents[sectionIndex].hidden;
}

const chooseLayout = (layout: String) => {
  if (layout === 'contact') {
    form.contents = [
      {
        name: 'Contact Info',
        data: [{
          title: "",
          info: "",
          icon: iconList[0].id,
        }],
      },
    ]
  } else if (layout === 'blog') {
    form.contents = []
  } else if(layout === 'home') {
    form.contents = [
      {
        name: 'Compnay Logo Section',
        slug: 'logo',
        data: [{
          title: "",
          description: "",
        }],
      },
      {
        name: 'Available Jobs Section',
        slug: 'jobs',
        data: [{
          title: "",
          description: "",
        }],
      },
    ]
  }
  else {
    form.contents = [
      {
        name: 'Section 1',
        data: [{
          title: "",
          description: "",
          image: '',
          imagePosition: imagePosition[0].id,
          imageKey: Date.now()
        }],
      },
    ]
  }
}



</script>

<template>
  <LayoutAuthenticated>

    <Head title="Edit Page" />
    <SectionMain>
      <SectionTitleLineWithButton title="Page">
        <BaseButtons>
          <BaseButtonLink class="mr-1" :icon="mdiArrowRightCircle" routeName="pages.index" label="Back" color="contrast"
            rounded-full small />
          <BaseButtonLink v-if="pageData" class="mr-1" :icon="mdiArrowRightCircle" routeName="pages.create" label="Add New" color="info"
            rounded-full small />
        </BaseButtons>
      </SectionTitleLineWithButton>
      <CardBox class="w-full" is-form @submit.prevent="save">
        <FormValidationErrors />
        <FormSuccess />
        <div class="flex flex-row justify-center">
          <div class="w-9/12">
            <FormField label="Title" help="Enter Page Title">
              <FormControl v-model="form.title" type="text" placeholder="Enter Page Title" required />
            </FormField>
            
            <div v-if="form.page_type === 'general'" v-for="(row, sectionIndex) in form.contents" :key="sectionIndex">
              <General :sectionIndex="sectionIndex" :row="row" :imagePosition="imagePosition" @addRow="addRow" @removeRow="removeRow" @toggleSection="toggleSection" @addSection="addSection" @removeSection="removeSection" />
            </div>
            <div v-if="form.page_type === 'blog'">
              <Blog />
            </div>
            <div v-if="form.page_type === 'contact'" v-for="(row, sectionIndex) in form.contents" :key="sectionIndex">
              <Contact :sectionIndex="sectionIndex" :row="row" :iconList="iconList" @addRow="addRow" @removeRow="removeRow" />
            </div>
            <div v-if="form.page_type === 'home'" v-for="(row, sectionIndex) in form.contents" :key="sectionIndex">
              <Home :sectionIndex="sectionIndex" :row="row" />
            </div>
          </div>
          
          <!-- Right part -->
          <div class="w-3/12 ml-5 flex flex-col items-center justify-start mt-10 border border-gray-50 rounded p-5">
            <div v-show="!form.featured_image" class="w-full">
              <img v-if="pageData != null && pageData.featured_image" :src="`${storage}/${pageData.featured_image}`"
                class="h-52 w-11/12 mb-4" alt="">
              <div v-else class="h-52 w-11/12 mb-4 border-dashed border border-gray-50 flex justify-center items-center">
                Featured Image</div>
            </div>
            <FormField label="Featured Image" help="Max 500kb">
              <FormFilePicker :key="featuredKey" label="Upload Image" :modelValue="form.featured_image" color="success"
                @update:modelValue="form.featured_image = $event" />
            </FormField>

            <FormField class="w-full" label="Page Type">
              <FormControl @change="chooseLayout(form.page_type)" v-model="form.page_type" :options="pageType" />
            </FormField>

            <FormField v-show="form.pageType === 'contact'" class="w-full" label="Email To" label-for="email-to">
              <FormControl v-model="form.email_to" id="email-to" placeholder="Email To" type="text" />
            </FormField>

            <FormField class="w-full" label="Page Order" label-for="page-order">
              <FormControl v-model="form.page_order" id="page-order" placeholder="Page Order" type="number" min="0"
                step="1" required />
            </FormField>

            <FormField class="w-full" label="Show On Navigation Bar?">
              <FormCheckRadioGroup v-model="form.for_nav" name="for_nav" type="radio"
                :options="{ '1': 'Yes', '0': 'No' }" />
            </FormField>

            <FormField class="w-full" label="Status">
              <FormCheckRadioGroup v-model="form.status" name="status" type="radio"
                :options="{ '1': 'Enable', '0': 'Disable' }" />
            </FormField>

            <BaseButtonLink :icon="mdiContentSave" class="w-full mt-10" color="info" type="submit" label="Save"
              :class="{ 'opacity-25': form.processing }" :disabled="form.processing" rounded-full />
          </div>
        </div>
      </CardBox>
    </SectionMain>
  </LayoutAuthenticated>
</template>
<script setup lang='ts'>
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
import FormCheckRadioGroup from '@/Components/FormCheckRadioGroup.vue'
import { mdiArrowRightCircle, mdiPlus, mdiMinus, mdiContentSave, mdiChevronUp, mdiChevronDown } from '@mdi/js'


const pageData: any = usePage().props.pageData ?? null

const pageType = [
  {id: 'general', label: 'General'},
  {id: 'home', label: 'Home'},
  {id: 'blog', label: 'Blog'},
  {id: 'contact', label: 'Contact'},
]
const imagePosition = [
  {id: 'left', label: 'Left'},
  {id: 'light', label: 'Right'},
]
const iconList = [
  {id: 'fa fa-phone', label: 'Phone'},
  {id: 'fa fa-email', label: 'Email'},
  {id: 'fa fa-map', label: 'Map Marker'},
  {id: 'fa fa-fax', label: 'Fax'},
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
});

if(pageData) {
  form.id = pageData.id
  form.title = pageData.title
  form.page_type = pageData.page_type
  form.for_nav = pageData.for_nav
  form.page_order = pageData.page_order
  form.email_to = pageData.email_to
  form.status = pageData.status
  form.contents = pageData.contents
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
  if(form.pageType === 'contact') {
    form.contents[sectionIndex].data.push({
      title: "",
      info: "",
      icon: iconList[0].id,
    });
  }else{
    form.contents[sectionIndex].data.push({
      title: "",
      description: "",
      image: '',
      imageKey: Date.now()
    });
  }
}

const save = () => {
  form
      .transform((data: any) => ({
      ...data,
      terms: form.terms && form.terms.length,
      }))
      .post(route("pages.store"), {
          onSuccess: () => {
              form.reset();
              featuredKey.value = featuredKey.value + 1
          },
      });
    console.log(form)
};

const toggleSection = (sectionIndex: any) => {
  form.contents[sectionIndex].hidden = !form.contents[sectionIndex].hidden;
}

const chooseLayout = (layout: String) => {
  if(layout === 'contact') {
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
  }else if(layout === 'blog') {
    form.contents = []
  }else{
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
        <SectionTitleLineWithButton title="Add New">
            <BaseButtons>
              <BaseButtonLink class="mr-1" :icon="mdiPlus" @click="addSection" label="Back" color="contrast" rounded-full
                  small />
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
                  <div v-if="form.pageType !== 'blog' && form.pageType !== 'contact'" v-for="(row, sectionIndex) in form.contents" :key="sectionIndex">
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
                                <FormControl v-model="data.title" :id="'headline-' + rowIndex" placeholder="Title here" type="text"
                                required />
                            </FormField>
                            <FormField label="Subtitle" :label-for="'subtitle-' + rowIndex">
                                <FormControl v-model="data.subtitle" :id="'subtitle-' + rowIndex" placeholder="Subtitle here" type="text"/>
                            </FormField>
                            <FormField label="Description" :label-for="'description-' + rowIndex">
                                <FormControl v-model="data.description" :id="'description-' + rowIndex" placeholder="Description here"
                                type="textarea" required />
                            </FormField>

                            <div class="flex flex-row justify-between items-center">
                              <FormField label="Image" help="Max 500kb">
                                <FormFilePicker :key="data.imageKey" label="Upload Image" :modelValue="data.image" color="success" @update:modelValue="data.image = $event" />
                              </FormField>

                              <FormField class="ml-auto w-auto" label="Image Position">
                                <FormControl 
                                  v-model="data.imagePosition" 
                                  :options="imagePosition" />
                              </FormField>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div v-if="form.pageType === 'blog'">
                    <h3 class="text-center">Blog Page: You Can't add Section Here</h3>
                  </div>
                  <div v-if="form.pageType === 'contact'" v-for="(row, sectionIndex) in form.contents" :key="sectionIndex">
                    <SectionTitle :title="row.name" main />

                    <div v-show="!row.hidden" v-for="(data, rowIndex) in row.data" :key="rowIndex + sectionIndex" class="mb-2 flex-col justify-end items-end h-full">
                        <div class="w-full mb-7 p-5 bg-slate-900 rounded">
                            <BaseButtons class="mt-auto justify-end">
                                <BaseButtonLink class="mr-1" :icon="mdiPlus" @click="addRow(sectionIndex)" label="Add Row" color="contrast" rounded-full
                        small />
                                <BaseButtonLink v-if="rowIndex > 0" :icon="mdiMinus" @click="removeRow(sectionIndex, rowIndex)" label="Remove Row" color="danger"
                                rounded-full small />
                            </BaseButtons>
                            <FormField :label="'Title: ' + data.title " :label-for="'headline-' + rowIndex">
                                <FormControl v-model="data.title" :id="'headline-' + rowIndex" placeholder="Title here" type="text"
                                required />
                            </FormField>
                            <FormField label="Info" :label-for="'info-' + rowIndex">
                                <FormControl v-model="data.info" :id="'info-' + rowIndex" placeholder="Contact Info here" type="text"
                                required />
                            </FormField>
                            <FormField label="Choose Icon">
                              <FormControl 
                                v-model="data.icon" 
                                :options="iconList" />
                            </FormField>
                        </div>
                    </div>
                  </div>
              </div>
              
              <div class="w-3/12 ml-5 flex flex-col items-center justify-start mt-10 border border-gray-50 rounded p-5">
                <div v-show="!form.featured_image" class="w-full">
                  <img v-if="pageData != null && pageData.featured_image" :src="pageData.featured_image" alt="">
                  <div v-else class="h-52 w-11/12 mb-4 border-dashed border border-gray-50 flex justify-center items-center">Featured Image</div>
                </div>
                <FormField label="Featured Image" help="Max 500kb">
                    <FormFilePicker :key="featuredKey" label="Upload Image" :modelValue="form.featured_image" color="success" @update:modelValue="form.featured_image = $event" />
                </FormField>

                <FormField class="w-full" label="Page Type">
                  <FormControl 
                    @change="chooseLayout(form.pageType)"
                    v-model="form.page_type" 
                    :options="pageType" />
                </FormField>

                <FormField v-show="form.pageType === 'contact'" class="w-full" label="Email To" label-for="email-to">
                    <FormControl v-model="form.email_to" id="email-to" placeholder="Email To" type="text"
                     />
                </FormField>

                <FormField class="w-full" label="Page Order" label-for="page-order">
                    <FormControl v-model="form.page_order" id="page-order" placeholder="Page Order" type="number" min="0" step="1"
                    required />
                </FormField>

                <FormField class="w-full" label="Show On Navigation Bar?">
                  <FormCheckRadioGroup v-model="form.forNav" name="for_nav" type="radio"
                        :options="{ '1': 'Yes', '0': 'No' }" />
                </FormField>

                <FormField class="w-full" label="Status">
                  <FormCheckRadioGroup v-model="form.status" name="status" type="radio"
                        :options="{ '1': 'Enable', '0': 'Disable' }" />
                </FormField>

                <BaseButtonLink
                    class="w-full mt-10"
                    color="info"
                    type="submit"
                    label="Save"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    rounded-full
                />
              </div>
            </div>
        </CardBox>
    </SectionMain>
    </LayoutAuthenticated>
</template>
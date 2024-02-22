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
    data: [],
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
    image: "",
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
                    <BaseButtonLink class="mr-1" :icon="mdiPlus" @click="addSection" label="Add Section" color="contrast" rounded-full
                        small />
                    <BaseButtonLink :icon="mdiContentSave" @click="save(slider)" label="Save" color="info" rounded-full small />
                </BaseButtons>
            </SectionTitleLineWithButton>

            <FormField label="Title" help="Enter Page Title">
                <FormControl v-model="form.title" type="text" placeholder="Enter Page Title" />
            </FormField>

            <CardBox v-for="(row, sectionIndex) in form.contents" :key="sectionIndex" class="w-full">
                <SectionTitleLineWithButton :title="row.name" main>
                <BaseButtons>
                    <BaseButtonLink class="mr-1" :icon="mdiPlus" @click="addRow(sectionIndex)" label="Add Row" color="contrast" rounded-full
                    small />
                    <BaseButtonLink :icon="mdiMinus" @click="removeSection(sectionIndex)" label="Remove Section" color="danger"
                    rounded-full small />
                    <BaseButtonLink class="mr-1" :icon="row.hidden ? mdiChevronDown : mdiChevronUp" @click="toggleSection(sectionIndex)"
                    :label="row.hidden ? 'Show' : 'Hide'" color="contrast" rounded-full small />
                </BaseButtons>
                </SectionTitleLineWithButton>

                <div v-show="!row.hidden" v-for="(data, rowIndex) in row.data" :key="rowIndex + sectionIndex" class="flex mb-2">
                    <CardBox class="w-9/12">
                        <FormField :label="'Headline-' + rowIndex " :label-for="'headline-' + rowIndex">
                            <FormControl v-model="form.contents[sectionIndex].data[rowIndex].title" :id="'headline-' + rowIndex" placeholder="Headline here" type="text"
                            required />
                        </FormField>
                        <FormField label="Description" :label-for="'description-' + rowIndex">
                            <FormControl v-model="data.description" :id="'description-' + rowIndex" placeholder="Description here"
                            type="textarea" required />
                        </FormField>
                    </CardBox>
                    <CardBox class="w-3/12 ml-1">
                        <BaseButtons class="justify-end mb-2">
                            <BaseButtonLink :icon="mdiMinus" @click="removeRow(sectionIndex, rowIndex)" label="Remove Row" color="danger"
                            rounded-full small />
                        </BaseButtons>
                        {{ form.contents[sectionIndex].data[rowIndex].imageKey }}
                        <FormField label="Photo" help="Max 500kb">
                            <FormFilePicker :key="data.imageKey" label="Upload Photo" color="success" @update:modelValue="form.image = $event" />
                        </FormField>
                    </CardBox>
                </div>

            </CardBox>
        </CardBox>
    </SectionMain>
    </LayoutAuthenticated>
</template>
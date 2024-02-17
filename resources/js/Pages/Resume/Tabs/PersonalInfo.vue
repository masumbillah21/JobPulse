<script setup lang="ts">
import { computed, ref } from 'vue'
  import {
    mdiArrowRightCircle,
    mdiPlus,
    mdiNoteEditOutline,
    mdiAccount,
    mdiFormatListBulletedType,
    mdiMapMarkerOutline,
    mdiPhone,
    mdiWeb,
    mdiEmail,
  } from '@mdi/js'

  import CardBox from '@/Components/CardBox.vue'
  import FormField from "@/Components/FormField.vue";
  import FormControl from "@/Components/FormControl.vue";
  import SectionTitle from '@/Components/SectionTitle.vue'
  import BaseButtonLink from '@/Components/BaseButtonLink.vue'
  import BaseButtons from "@/Components/BaseButtons.vue";
  import BaseDivider from "@/Components/BaseDivider.vue";
  import FormValidationErrors from "@/Components/FormValidationErrors.vue";
  import FormSuccess from "@/Components/FormSuccess.vue";
  import FormFilePicker from '@/Components/FormFilePicker.vue'
  import { Head, router, useForm, usePage } from '@inertiajs/vue3'


const resumeData = usePage().props.resumeData ?? null;

const genderType = [
  { id: 'Male', label: 'Male' },
  { id: 'Female', label: 'Female' },
  { id: 'Other', label: 'Other' },
]

const maritalStatus = [
  { id: 'Single', label: 'Single' },
  { id: 'Maried', label: 'Maried' },
  { id: 'Divorced', label: 'Divorced' },
  { id: 'Widowed', label: 'Widowed' },
]

const religionStatus = [
  { id: 'Islam', label: 'Islam' },
  { id: 'Hindhu', label: 'Hindhu' },
  { id: 'Christian', label: 'Christian' },
]

const form = useForm({
  'id': 0,
  'father_name': '',
  'mother_name': '',
  'dob': '',
  'gender': genderType[0].id,
  'marital_status': maritalStatus[0].id,
  'nationality': 'Bangladeshi',
  'religion': religionStatus[0].id,
  'present_address': '',
  'permanent_address': '',
  'alt_email': '',
  'phone': '',
  'image': '',
  _method: 'post'
});


const submit = () => {
    if (form.id == 0) {
      create();
    } else {
      update();
    }
  }
  const create = () => {

    form
      .transform((data) => ({
        ...data,
        terms: form.terms && form.terms.length,
      }))
      .post(route("resume.store"));
  }
  const update = () => {
    form
      .transform((data) => ({
        ...data,
        terms: form.terms && form.terms.length,
      }))
      .post(route("resume.update", form.id));
  }

</script>

<template>
    <CardBox class="w-1/2" is-form @submit.prevent="submit">
        <FormValidationErrors />
        <FormSuccess />
        <SectionTitle title="Personal Information" />
        <div v-if="resumeData && resumeData.image" class="mb-10">
          <img :src="resumeData.image" width="300" />
        </div>
        <FormField label="Father Name" label-for="father-name" help="Please write your father name">
          <FormControl v-model="form.father_name" id="father-name" :icon="mdiAccount" type="text" required />
        </FormField>

        <FormField label="Mother Name" label-for="mother-name" help="Please write your mother name">
          <FormControl v-model="form.mother_name" id="mother-name" :icon="mdiAccount" type="text" required />
        </FormField>

        <FormField label="Date of Birth" label-for="dob" help="Please write your date of birth">
          <FormControl v-model="form.mother_name" id="dob" :icon="mdiAccount" type="date" required />
        </FormField>

        <FormField label="Gender">
          <FormControl v-model="form.gender" :icon="mdiFormatListBulletedType" :options="genderType" />
        </FormField>

        <FormField label="Marital Status">
          <FormControl v-model="form.marital_status" :icon="mdiFormatListBulletedType"
            :options="maritalStatus" />
        </FormField>

        <FormField label="Nationality" label-for="nationality" help="Please write your nationality">
          <FormControl v-model="form.mother_name" id="nationality" :icon="mdiAccount" type="text" required />
        </FormField>

        <FormField label="Religion">
          <FormControl v-model="form.religion" :icon="mdiFormatListBulletedType" :options="religionStatus" />
        </FormField>

        <FormField label="Present Address" label-for="present-address" help="Please enter your present address">
          <FormControl v-model="form.present_address" id="present-address" :icon="mdiMapMarkerOutline"
            autocomplete="address" type="address" required />
        </FormField>

        <FormField label="Permanent Address" label-for="permanent-address"
          help="Please enter your permanent address">
          <FormControl v-model="form.permanent_address" id="permanent-address" :icon="mdiMapMarkerOutline"
            autocomplete="address" type="address" required />
        </FormField>

        <FormField label="Phone Number" label-for="phone" help="Please enter your company phone">
          <FormControl v-model="form.phone" id="phone" :icon="mdiPhone" autocomplete="phone" type="tel"
            required />
        </FormField>

        <FormField label="Email" label-for="email" help="Please enter your email">
          <FormControl v-model="form.alt_email" id="email" :icon="mdiEmail" autocomplete="email" type="email"
            required />
        </FormField>

        <FormField label="Photo" help="Max 500kb">
          <FormFilePicker label="Upload Photo" color="success" @update:modelValue="form.image = $event" />
        </FormField>
        <BaseDivider />

        <BaseButtons>
          <BaseButtonLink type="submit" color="info" label="Update" :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing" />
        </BaseButtons>
      </CardBox>
</template>
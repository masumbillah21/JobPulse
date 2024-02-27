<script setup>
import { useForm, usePage, Head } from "@inertiajs/vue3";
import { computed, watch, ref } from "vue";
import LayoutGuest from "@/Layouts/LayoutGuest.vue";
import SectionFullScreen from "@/Components/SectionFullScreen.vue";
import CardBox from "@/Components/CardBox.vue";
import FormCheckRadioGroup from "@/Components/FormCheckRadioGroup.vue";
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import BaseDivider from "@/Components/BaseDivider.vue";
import BaseButtonLink from "@/Components/BaseButtonLink.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import FormValidationErrors from "@/Components/FormValidationErrors.vue";
import { UserTypeEnum } from "@/utils/userTypeEnum";

const companyTypes = [
  { id: '', label: 'Select Company Type' },
  { id: 'Business development', label: 'Business development' },
  { id: 'Marketing', label: 'Marketing' },
  { id: 'Sales', label: 'Sales' },
  { id: 'Tech', label: 'Tech' },
]

const companySize = [
  { id: '', label: 'Select Company Size' },
  { id: '0-10 Employees', label: '0-10 Employees' },
  { id: '11-20 Employees', label: '11-20 Employees' },
  { id: '21-30 Employees', label: '21-30 Employees' },
  { id: '31-40 Employees', label: '31-40 Employees' },
  { id: '41-50 Employees', label: '41-50 Employees' },
]

const isCompany = ref(false);

const form = useForm({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
  user_type: UserTypeEnum.CANDIDATE,
  company_name: "",
  description: "",
  company_type: "",
  address: "",
  phone: "",
  company_size: "",
  website: "",
  terms: [],
});

watch(isCompany, (newValue) => {
  if (newValue) {
    form.user_type = UserTypeEnum.COMPANY;
  } else {
    form.user_type = UserTypeEnum.CANDIDATE;
  }
});

const hasTermsAndPrivacyPolicyFeature = computed(
  () => usePage().props.jetstream?.hasTermsAndPrivacyPolicyFeature ?? {}
);



const submit = () => {
  form
    .transform((data) => ({
      ...data,
      terms: form.terms && form.terms.length,
    }))
    .post(route("register"), {
      onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
  <LayoutGuest>

    <Head title="Register" />

    <SectionFullScreen class="flex-col" v-slot="{ cardClass }" bg="purplePink">
      <BaseButtons class="mt-10">
        <BaseButtonLink label="Looking For Jobs" :color="isCompany ? 'secondary' : 'info'" @click="isCompany = false" />
        <BaseButtonLink label="Looking To Hire" :color="isCompany ? 'info' : 'secondary'" @click="isCompany = true" />
      </BaseButtons>

      <CardBox :class="cardClass" class="mb-24 mt-4" is-form @submit.prevent="submit">
        <FormValidationErrors />

        <FormField label="Name" label-for="name" help="Please enter your name">
          <FormControl v-model="form.name" id="name" icon="fas fa-user" autocomplete="name" type="text" required />
        </FormField>

        <template v-if="isCompany">
          <FormField label="Company Name" label-for="company-name" help="Please enter your company name">
            <FormControl v-model="form.company_name" id="company-name" icon="fas fa-user" autocomplete="company_name"
              type="text" required />
          </FormField>
          <FormField label="Description" label-for="description" help="Please enter your company description">
            <FormControl v-model="form.description" id="description" icon="fas fa-info" autocomplete="description"
              type="text" required />
          </FormField>

          <FormField label="Company type">
            <FormControl v-model="form.company_type" icon="fas fa-list" :options="companyTypes" />
          </FormField>

          <FormField label="Address" label-for="address" help="Please enter your company address">
            <FormControl v-model="form.address" id="address" icon="fas fa-map-marker" autocomplete="address"
              type="address" required />
          </FormField>

          <FormField label="Phone Number" label-for="phone" help="Please enter your company phone">
            <FormControl v-model="form.phone" id="phone" icon="fas fa-phone" autocomplete="phone" type="tel" required />
          </FormField>

          <FormField label="Company Size">
            <FormControl v-model="form.company_size" icon="fas fa-list" :options="companySize" />
          </FormField>

          <FormField label="Website" label-for="website" help="Please enter company website">
            <FormControl v-model="form.website" id="website" icon="fas fa-globe" type="url" autocomplete="website" />
          </FormField>
        </template>


        <FormField label="Email" label-for="email" help="Please enter your email">
          <FormControl v-model="form.email" id="email" icon="fas fa-envelope" autocomplete="email" type="email"
            required />
        </FormField>

        <FormField label="Password" label-for="password" help="Please enter new password">
          <FormControl v-model="form.password" id="password" icon="fas fa-key" type="password" autocomplete="new-password"
            required />
        </FormField>

        <FormField label="Confirm Password" label-for="password_confirmation" help="Please confirm your password">
          <FormControl v-model="form.password_confirmation" id="password_confirmation" icon="fas fa-key" type="password"
            autocomplete="new-password" required />
        </FormField>

        <FormCheckRadioGroup v-if="hasTermsAndPrivacyPolicyFeature" v-model="form.terms" name="remember"
          :options="{ agree: 'I agree to the Terms' }" required />

        <BaseDivider />

        <BaseButtons>
          <BaseButtonLink type="submit" color="info" label="Register" :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing" />
          <BaseButtonLink route-name="login" color="info" outline label="Already Have Account ? Login" />
        </BaseButtons>
      </CardBox>
    </SectionFullScreen>
  </LayoutGuest>
</template>

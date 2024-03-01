<script setup lang="ts">
import LayoutGuest from '@/Layouts/LayoutGuest.vue';
import Shape from '@/Components/Frontend/Shape.vue';
import CardBox from '@/Components/CardBox.vue'
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import FormValidationErrors from "@/Components/FormValidationErrors.vue";
import FormSuccess from "@/Components/FormSuccess.vue";
import SectionTitle from '@/Components/Frontend/SectionTitle.vue';
import BaseButtonLink from '@/Components/BaseButtonLink.vue';
import BaseDivider from '@/Components/BaseDivider.vue';
import BaseButtons from '@/Components/BaseButtons.vue';
import { Head, usePage, useForm } from '@inertiajs/vue3';


const contactPageData: any = usePage().props.contactPageData;
defineProps({
  storageUrl: String
});

const form = useForm({
  name: '',
  email: '',
  subject: '',
  message: '',
});

const contactContent: any = {
    banner: '',
    contact_info: '',
  }

  if(contactPageData){
    contactPageData.contents.forEach((item: any) => {
      if(item.slug === 'banner'){
        contactContent.banner = item.data[0]
      }
      if(item.slug === 'contact_info'){
        contactContent.contact_info = item.data
      }
    })
  }

  const submit = () => {
    form.post(route('contact.email'),{
      onSuccess: () => {
        form.reset()
      }
    })
  }

</script>
<template>
  <LayoutGuest>

    <Head :title="contactPageData.title ?? 'Contact'" />
    <main v-if="contactPageData">
      <div class="relative pt-16 pb-32 flex content-center items-center justify-center" style="min-height: 45vh;">
        <div class="absolute top-0 w-full h-full bg-center bg-cover"
          :style="'background-image: url(' + storageUrl +  contactPageData.featured_image + ');'">
          <span id="blackOverlay" class="w-full h-full absolute opacity-75 bg-black"></span>
        </div>
        <div class="container relative mx-auto">
          <div class="items-center flex flex-wrap">
            <div class="w-full lg:w-6/12 px-4 ml-auto mr-auto text-center text-white">
              <SectionTitle :title="contactPageData.title" />
            </div>
          </div>
        </div>
        <Shape sectionClass="top-auto bottom-0"/>
      </div>
      <section class="pb-20 relative block dark:bg-gray-900">
        <Shape polygonClass="dark:text-gray-900 text-gray-50"/>
        <div class="container mx-auto px-4 lg:pt-24 lg:pb-64">
          <div class="flex flex-wrap text-center justify-center">
            <div class="w-full lg:w-6/12 px-4">
              <SectionTitle :title="contactContent.banner.title" :description="contactContent.banner.description" :subtitle="contactContent.banner.subtitle" />
            </div>
          </div>
          <div class="flex flex-wrap">
            <div v-for="item in contactContent.contact_info" class="lg:pt-12 pt-6 w-full md:w-4/12 px-4 text-center">
              <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-8 shadow-lg rounded-lg">
                <div class="px-4 py-5 flex-auto">
                  <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 mb-5 shadow-lg rounded-full bg-red-400">
                    <i :class="item.icon"></i>
                  </div>
                  <h6 class="text-xl font-semibold text-stone-900">{{ item.title }}</h6>
                  <p class="mt-2 mb-4 text-gray-600">
                    {{ item.info }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="relative block py-24 lg:pt-0 dark:bg-gray-900 dark:text-slate-800">
        <div class="container mx-auto px-4">
          <div class="flex flex-wrap justify-center lg:-mt-64 -mt-48">
            <div class="w-full lg:w-6/12 px-4">
              <CardBox class="my-24 bg-white dark:bg-white" is-form @submit.prevent="submit">
                <FormValidationErrors />
                <FormSuccess />
                <h4 class="text-2xl font-semibold text-slate-800">Want to work with us?</h4>
                <p class="leading-relaxed mt-1 mb-4 text-gray-600">
                  Complete this form and we will get back to you in 24 hours.
                </p>
                <FormField label="Full Name" label-for="name" help="Please enter your full name">
                    <FormControl v-model="form.name" id="name" icon="fas fa-user" type="text" required />
                </FormField>
                <FormField label="Email" label-for="email" help="Please enter your email">
                    <FormControl v-model="form.email" id="email" icon="fas fa-envelope" type="email" required />
                </FormField>
                <FormField label="Subject" label-for="subject" help="Please enter your subject">
                    <FormControl v-model="form.subject" id="subject" icon="fas fa-sticky-note" type="text" required />
                </FormField>
                <FormField label="Message" label-for="message" help="Please enter your message">
                    <FormControl v-model="form.message" id="message" type="textarea" required />
                </FormField>

                <BaseDivider />
                <BaseButtons>
                    <BaseButtonLink type="submit" color="primary" label="SENT MESSAGE"
                        :class="{ 'opacity-25': form.processing }" :disabled="form.processing" />
                </BaseButtons>
              </CardBox>
            </div>
          </div>
        </div>
      </section>
    </main>
    <main v-else>
      <div class="container mx-auto px-4">
        <div class="items-center justify-center flex flex-wrap">
          <div class="w-full ml-auto mr-auto px-4">
            <h3 class="text-4xl text-center font-semibold">Coming Soon</h3>
          </div>
        </div>
      </div>
    </main>
  </LayoutGuest>
</template>
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
  import SectionMain from '@/Components/SectionMain.vue'
  import CardBox from '@/Components/CardBox.vue'
  import FormField from "@/Components/FormField.vue";
  import FormControl from "@/Components/FormControl.vue";
  import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue'
  import SectionTitle from '@/Components/SectionTitle.vue'
  import BaseButtonLink from '@/Components/BaseButtonLink.vue'
  import BaseButtons from "@/Components/BaseButtons.vue";
  import BaseDivider from "@/Components/BaseDivider.vue";
  import FormValidationErrors from "@/Components/FormValidationErrors.vue";
  import FormSuccess from "@/Components/FormSuccess.vue";
  import CardBoxModal from '@/Components/CardBoxModal.vue'
  import FormFilePicker from '@/Components/FormFilePicker.vue'
  import Educations from '@/Pages/Resume/Tabs/Educations.vue'
  import PersonalInfo from '@/Pages/Resume/Tabs/PersonalInfo.vue'
  import Experience from '@/Pages/Resume/Tabs/Experience.vue'
  import Training from '@/Pages/Resume/Tabs/Training.vue'
  import Reference from '@/Pages/Resume/Tabs/Reference.vue'
  import { Head } from '@inertiajs/vue3'


  const openTab = ref(1)
  const toggleTabs = (tabNumber) => {
    openTab.value = tabNumber
  }

  const submit = () => {
    //
  }

</script>

<template>
  <LayoutAuthenticated>

    <Head title="Resume" />
    <SectionMain>
      <SectionTitle title="Resume" :icon="mdiArrowRightCircle" />
      
        <div class="w-full">
          <ul class="flex w-full mb-0 list-none pt-3 pb-4 flex-row">
            <li class="mb-3 mr-2 last:mr-0">
              <a class="w-full inline-block text-xs font-bold uppercase px-5 py-3 shadow-lg rounded leading-normal"
                v-on:click="toggleTabs(1)"
                v-bind:class="{'text-slate-900 bg-white': openTab !== 1, 'text-white bg-slate-900': openTab === 1}">
                Personal Information
              </a>
            </li>
            <li class="mb-3 mr-2 last:mr-0">
              <a class="w-full inline-block text-xs font-bold uppercase px-5 py-3 shadow-lg rounded leading-normal"
                v-on:click="toggleTabs(2)"
                v-bind:class="{'text-slate-900 bg-white': openTab !== 2, 'text-white bg-slate-900': openTab === 2}">
                Education
              </a>
            </li>
            <li class="mb-3 mr-2 last:mr-0">
              <a class="w-full inline-block text-xs font-bold uppercase px-5 py-3 shadow-lg rounded leading-normal"
                v-on:click="toggleTabs(3)"
                v-bind:class="{'text-slate-900 bg-white': openTab !== 3, 'text-white bg-slate-900': openTab === 3}">
                Training
              </a>
            </li>
            <li class="mb-3 mr-2">
              <a class="w-full inline-block text-xs font-bold uppercase px-5 py-3 shadow-lg rounded leading-normal"
                v-on:click="toggleTabs(4)"
                v-bind:class="{'text-slate-900 bg-white': openTab !== 4, 'text-white bg-slate-900': openTab === 4}">
                Experiance
              </a>
            </li>
            <li class="mb-3 mr-2">
              <a class="w-full inline-block text-xs font-bold uppercase px-5 py-3 shadow-lg rounded leading-normal"
                v-on:click="toggleTabs(5)"
                v-bind:class="{'text-slate-900 bg-white': openTab !== 5, 'text-white bg-slate-900': openTab === 5}">
                Reference
              </a>
            </li>
          </ul>
        </div>
        <div class="w-full">
            <div class="tab-content tab-space w-full">
            <!-- Tab Personal Information -->
            <div class="flex justify-center items-center" :class="{'hidden': openTab !== 1, 'block': openTab === 1}">
              <PersonalInfo />
            </div>
            <!-- Tab Education -->
            <div class="tab-content tab-space">
              <div v-bind:class="{'hidden': openTab !== 2, 'block': openTab === 2}">
                <Educations />
              </div>
            </div>
            <!-- Tab Trainig -->
            <div class="tab-content tab-space">
              <div v-bind:class="{'hidden': openTab !== 3, 'block': openTab === 3}">
                <Training />
              </div>
            </div>
            <!-- Tab Experiance -->
            <div class="tab-content tab-space">
              <div v-bind:class="{'hidden': openTab !== 4, 'block': openTab === 4}">
                <Experience />
              </div>
            </div>
            <!-- Tab Reference -->
            <div class="tab-content tab-space">
              <div v-bind:class="{'hidden': openTab !== 5, 'block': openTab === 5}">
                <Reference />
              </div>
            </div>
          
        </div>
      </div>
    </SectionMain>
  </LayoutAuthenticated>
</template>
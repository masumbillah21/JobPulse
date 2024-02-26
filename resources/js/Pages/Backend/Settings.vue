<script setup lang="ts">
import { ref } from 'vue'
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
import FormFilePicker from "@/Components/FormFilePicker.vue";
import { Head, useForm, usePage } from '@inertiajs/vue3'

const settingList: any = usePage().props.settingList ?? null

const homePages: any = usePage().props.homePages
const blogPages: any = usePage().props.blogPages
const contactPages: any = usePage().props.contactPages

const homeList: any = [
    {
        id: '', label: 'Select Page',
    }
]

homeList.push(...homePages)

const blogList: any = [
    {
        id: '', label: 'Select Page',
    }
]

blogList.push(...blogPages)

const contactList: any = [
    {
        id: '', label: 'Select Page',
    }
]

contactList.push(...contactPages)

const urls: any = usePage().props.urls
const storage = urls.storeUrl

const form: any = useForm({
    logo: "",
    home: "",
    blog: "",
    contact: "",
});
const logoUrl = ref('')
if(settingList) {
    settingList.forEach((item: any) => {
        if(item.name == 'logo') {
            logoUrl.value = storage + '/' + item.value
        }
        if(item.name == 'home') {
            form.home = item.value
        }
        if(item.name == 'blog') {
            form.blog = item.value
        }
        if(item.name == 'contact') {
            form.contact = item.value
        }
    })
}

const submit = () => {
    form.post(route("settings.store"));
};

</script>
    
<template>
    <LayoutAuthenticated>

        <Head title="Settings" />
        <SectionMain>
            <SectionTitle icon="fas fa-arrow-circle-right" title="Settings" main />
            <div class="flex justify-center items-center">
                <CardBox class="my-24 w-9/12" is-form @submit.prevent="submit">
                    <FormValidationErrors />
                    <FormSuccess />
                    <img class="mb-2" v-if="logoUrl" :src="logoUrl" alt="logo" width="300">
                    <FormField label="Logo" help="Max 500kb">
                        <FormFilePicker label="Upload Logo" color="success" @update:modelValue="form.logo = $event" />
                    </FormField>
                    <BaseDivider />

                    <FormField label="Home Page">
                        <FormControl 
                        v-model="form.home" 
                        :options="homeList" />
                    </FormField>

                    <FormField label="Blog Page">
                        <FormControl 
                        v-model="form.blog" 
                        :options="blogList" />
                    </FormField>

                    <FormField label="Contact Page">
                        <FormControl 
                        v-model="form.contact" 
                        :options="contactList" />
                    </FormField>


                    <BaseDivider />

                    <BaseButtons>
                        <BaseButtonLink icon="far fa-save" type="submit" color="info" label="Save"
                            :class="{ 'opacity-25': form.processing }" :disabled="form.processing" />
                    </BaseButtons>
                </CardBox>
            </div>

        </SectionMain>
    </LayoutAuthenticated>
</template>
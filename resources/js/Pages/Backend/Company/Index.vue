<script setup lang="ts">
    import { computed, ref } from 'vue'
    import { mdiArrowRightCircle, 
      mdiPlus,  
      mdiNoteEditOutline, 
      mdiAccount, 
      mdiFormatListBulletedType,
      mdiMapMarkerOutline,
      mdiPhone,
      mdiWeb,
      mdiEmail, } from '@mdi/js'
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
    import { Head, router, useForm, usePage } from '@inertiajs/vue3'

    const companyData: any = usePage().props.companyData;
    
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

    let form: any = useForm({
      'id': 0,
      'name': '',
      'description': '',
      'company_type': '',
      'address': '',
      'phone': '',
      'email': '',
      'company_size': '',
      'website': '',
      'logo': '',
      _method: 'post'
    });

    if(companyData != null) {
      form = companyData
      form._method = 'put';
    }

    const submit = () => {
      if(form.id == 0) {
        create();
      } else {
        update();
      }
    }
    const create = () => {
      
      form
          .transform((data: any) => ({
          ...data,
          terms: form.terms && form.terms.length,
          }))
          .post(route("company.store"));
  }
    const update = () => {
        form
            .transform((data: any) => ({
            ...data,
            terms: form.terms && form.terms.length,
            }))
            .post(route("company.update", form.id));
    }
</script>
    
    <template>
      <LayoutAuthenticated>
        <Head title="Company" />
        <SectionMain>
          <SectionTitle title="Company Profile" icon="far fa-arrow-alt-circle-right"/>
          <div class="flex justify-center items-center">
            <CardBox
                class="my-24 w-1/2"
                is-form
                @submit.prevent="submit"
            >
            <FormValidationErrors />
            <FormSuccess />
            <div v-if="companyData && companyData.logo" class="mb-10">
              <img :src="companyData.logo" width="300"/>
            </div>
            <FormField label="Name" label-for="name" help="Please enter your company name">
            <FormControl
                v-model="form.name"
                id="name"
                :icon="mdiAccount"
                autocomplete="name"
                type="text"
                required
            />
            </FormField>

            <FormField label="Description" label-for="description" help="Please enter your company description">
              <FormControl
                  v-model="form.description"
                  id="description"
                  :icon="mdiNoteEditOutline"
                  autocomplete="description"
                  type="text"
                  required
              />
            </FormField>

            <FormField label="Company type">
              <FormControl 
              v-model="form.company_type" 
              :icon="mdiFormatListBulletedType"
              :options="companyTypes" />
            </FormField>

            <FormField label="Address" label-for="address" help="Please enter your company address">
              <FormControl
                  v-model="form.address"
                  id="address"
                  :icon="mdiMapMarkerOutline"
                  autocomplete="address"
                  type="address"
                  required
              />
            </FormField>

            <FormField label="Phone Number" label-for="phone" help="Please enter your company phone">
              <FormControl
                  v-model="form.phone"
                  id="phone"
                  :icon="mdiPhone"
                  autocomplete="phone"
                  type="tel"
                  required
              />
            </FormField>

            <FormField
            label="Email"
            label-for="email"
            help="Please enter your email"
            >
            <FormControl
                v-model="form.email"
                id="email"
                :icon="mdiEmail"
                autocomplete="email"
                type="email"
                required
            />
            </FormField>

            <FormField label="Company Size">
              <FormControl 
              v-model="form.company_size" 
              :icon="mdiFormatListBulletedType"
              :options="companySize" />
            </FormField>

            <FormField
              label="Website"
              label-for="website"
              help="Please enter company website"
            >
            <FormControl
                v-model="form.website"
                id="website"
                :icon="mdiWeb"
                type="url"
                autocomplete="website"
            />
            </FormField>

            <FormField label="Logo" help="Max 500kb">
              <FormFilePicker 
                label="Upload Logo" 
                color="success"
                @update:modelValue="form.logo = $event" />
            </FormField>
            <BaseDivider />

            <BaseButtons>
            <BaseButtonLink
                type="submit"
                color="info"
                label="Update"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            />
            </BaseButtons>
            </CardBox>
        </div>
      </SectionMain>
      </LayoutAuthenticated>
    </template>
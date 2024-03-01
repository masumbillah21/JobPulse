<script setup lang="ts">
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
    import { isSystemUser } from '@/utils/isSystemUser';

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
      form.id = companyData.id;
      form.name = companyData.name;
      form.description = companyData.description;
      form.company_type = companyData.company_type;
      form.address = companyData.address;
      form.phone = companyData.phone;
      form.email = companyData.email;
      form.company_size = companyData.company_size;
      form.website = companyData.website;
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
      const routeName = isSystemUser() ? "admin.company.store" : "company.store";
      form.post(route(routeName),{
        onSuccess: () => form.reset(),
      });
  }
    const update = () => {
        const routeName = isSystemUser() ? "admin.company.update" : "company.update";
        form.post(route(routeName, form.id));
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
                icon="fas fa-user"
                autocomplete="name"
                type="text"
                required
            />
            </FormField>

            <FormField label="Description" label-for="description" help="Please enter your company description">
              <FormControl
                  v-model="form.description"
                  id="description"
                  icon="fas fa-info"
                  autocomplete="description"
                  type="text"
                  required
              />
            </FormField>

            <FormField label="Company type">
              <FormControl 
              v-model="form.company_type" 
              icon="fas fa-list"
              :options="companyTypes" />
            </FormField>

            <FormField label="Address" label-for="address" help="Please enter your company address">
              <FormControl
                  v-model="form.address"
                  id="address"
                  icon="fas fa-map-marker"
                  autocomplete="address"
                  type="address"
                  required
              />
            </FormField>

            <FormField label="Phone Number" label-for="phone" help="Please enter your company phone">
              <FormControl
                  v-model="form.phone"
                  id="phone"
                  icon="fas fa-phone"
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
                icon="fas fa-envelope"
                autocomplete="email"
                type="email"
                required
            />
            </FormField>

            <FormField label="Company Size">
              <FormControl 
              v-model="form.company_size" 
              icon="fas fa-list"
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
                icon="fas fa-globe"
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
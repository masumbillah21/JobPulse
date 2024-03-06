<script setup lang="ts">
    import SectionMain from '@/Components/SectionMain.vue'
    import CardBox from '@/Components/CardBox.vue'
    import FormField from "@/Components/FormField.vue";
    import FormControl from "@/Components/FormControl.vue";
    import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue'
    import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue'
    import BaseButtonLink from '@/Components/BaseButtonLink.vue'
    import BaseButtons from "@/Components/BaseButtons.vue";
    import BaseDivider from "@/Components/BaseDivider.vue";
    import FormValidationErrors from "@/Components/FormValidationErrors.vue";
    import FormSuccess from "@/Components/FormSuccess.vue";
    import FormCheckRadioGroup from "@/Components/FormCheckRadioGroup.vue";
    import { isSystemUser } from '@/utils/isSystemUser';
    import { Head, useForm, usePage} from '@inertiajs/vue3'

    const feature: any = usePage().props.feature ?? null
    
    const form: any = useForm({
        id: 0,
        name: "",
        description: "",
        status: 1,
        _method: "post",
    });

    if(feature !== null) {
        form.id = feature.id
        form.name = feature.name
        form.description = feature.description
        form.status = feature.status
        form._method = "put"
    }

    const submit = () => {
        if(form.id == 0) {
            create();
        } else {
            update();
        }
    }


    const create = () => {
        const routeName = isSystemUser() ? "admin.plugins.store" : "employee.plugins";
        form.post(route(routeName));
    };
    

    const update = () => {
        const routeName = isSystemUser() ? "admin.plugins.update" : "plugins.update";
        console.log(form)
        form.post(route(routeName, form.id));
    };
    
</script>
    fa fa-map
    <template>
      <LayoutAuthenticated>
        <Head :title="feature !== null ? 'Edit Plugin' : 'Create Plugin'" />
        <SectionMain>
            <SectionTitleLineWithButton icon="far fa-arrow-alt-circle-right" :title="feature !== null ? 'Edit Plugin' : 'Create Plugin'" main>
                <BaseButtonLink
                    icon="far fa-arrow-alt-circle-left"
                    label="Back"
                    routeName="plugins.index"
                    color="contrast"
                    rounded-full
                    small
                />
            </SectionTitleLineWithButton>
            <div class="flex justify-center items-center">
                <CardBox
                    class="my-24 w-1/2"
                    is-form
                    @submit.prevent="submit"
                >
                <FormValidationErrors />
                <FormSuccess />
                <FormField label="Name" label-for="name" help="Please enter plugin name">
                <FormControl
                    v-model="form.name"
                    id="name"
                    autocomplete="name"
                    type="text"
                    required
                />
                </FormField>

                <FormField
                label="Description"
                label-for="description"
                help="Please enter plugin description"
                >
                <FormControl
                    v-model="form.description"
                    id="description"
                    autocomplete="description"
                    type="textarea"
                    required
                />
                </FormField>

                <FormField class="w-full" label="Status">
                    <FormCheckRadioGroup v-model="form.status" name="status" type="radio"
                        :options="{ '1': 'Enable', '0': 'Disable' }" />
                </FormField>

                <BaseDivider />

                <BaseButtons>
                <BaseButtonLink
                    type="submit"
                    color="info"
                    :label="feature !== null ? 'Update' : 'Create'"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                />
                </BaseButtons>
                </CardBox>
            </div>

        </SectionMain>
      </LayoutAuthenticated>
    </template>
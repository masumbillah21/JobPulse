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
    import { Head, useForm, usePage} from '@inertiajs/vue3'

    const employeeData: any = usePage().props.employeeData ?? null

    const form: any = useForm({
        id: 0,
        name: "",
        email: "",
        password: "",
    });

    if(employeeData !== null) {
        form.id = employeeData.id
        form.name = employeeData.name
        form.email = employeeData.email
        form.password = ""
    }
    

    const update = () => {
        form
            .transform((data: any) => ({
            ...data,
            terms: form.terms && form.terms.length,
            }))
            .put(route("employee.update", form.id), {
                onFinish: () => form.reset("password"),
            });
    };
</script>
    
    <template>
      <LayoutAuthenticated>
        <Head :title="employeeData !== null ? 'Edit Employee' : 'Create Employee'" />
        <SectionMain>
            <SectionTitleLineWithButton icon="far fa-arrow-alt-circle-right" :title="employeeData !== null ? 'Edit Employee' : 'Create Employee'" main>
                <BaseButtonLink
                    icon="far fa-arrow-alt-circle-left"
                    label="Back"
                    routeName="employee.index"
                    color="contrast"
                    rounded-full
                    small
                />
            </SectionTitleLineWithButton>
            <div class="flex justify-center items-center">
                <CardBox
                    class="my-24 w-1/2"
                    is-form
                    @submit.prevent="update"
                >
                <FormValidationErrors />
                <FormSuccess />
                <FormField label="Name" label-for="name" help="Please enter your name">
                <FormControl
                    v-model="form.name"
                    id="name"
                    icon="fas fa-user"
                    autocomplete="name"
                    type="text"
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

                <FormField
                label="Password"
                label-for="password"
                help="Please enter new password"
                >
                <FormControl
                    v-model="form.password"
                    id="password"
                    icon="fas fa-mask"
                    type="password"
                    autocomplete="new-password"
                />
                </FormField>

                <BaseDivider />

                <BaseButtons>
                <BaseButtonLink
                    type="submit"
                    color="info"
                    :label="employeeData !== null ? 'Update' : 'Create'"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                />
                </BaseButtons>
                </CardBox>
            </div>

        </SectionMain>
      </LayoutAuthenticated>
    </template>
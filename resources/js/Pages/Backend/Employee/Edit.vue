<script setup lang="ts">
    import { computed, ref, watch } from 'vue'
    import { mdiArrowRightCircle, mdiArrowLeftCircle, mdiAccount, mdiEmail, mdiFormTextboxPassword, mdiNoteEditOutline } from '@mdi/js'
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
    import { Head, useForm } from '@inertiajs/vue3'

    const props: any = defineProps(
        {
            employee: Object,
        }
    )
    
    const form: any = useForm({
        id: props.employee !== null ? props.employee.id : null,
        name: props.employee !== null ? props.employee.name : "",
        email: props.employee !== null ? props.employee.email : "",
        password: "",
    });

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
        <Head title="Edit Employee" />
        <SectionMain>
            <SectionTitleLineWithButton icon="far fa-arrow-alt-circle-right" :title="employee !== null ? 'Edit Employee' : 'Create Employee'" main>
                <BaseButtonLink
                    :icon="mdiArrowLeftCircle"
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
                    :icon="mdiAccount"
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
                    :icon="mdiEmail"
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
                    :icon="mdiFormTextboxPassword"
                    type="password"
                    autocomplete="new-password"
                />
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
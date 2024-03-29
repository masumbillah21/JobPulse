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
    import { Head, useForm, usePage } from '@inertiajs/vue3'

    const permissionData: any = usePage().props.permission ?? null

    
    const form: any = useForm({
        id: 0,
        name: "",
        permission: "",
        _method: "post",
    });

    if(permissionData !== null) {
        form.id = permissionData.id
        form.name = permissionData.name
        form.permission = permissionData.permission
        form._method = 'put'
    }

    const submit = () => {
        if (permissionData !== null) {
            update();
        } else {
            create();
        }
    };

    const create = () => {
        form
            .transform((data: any) => ({
            ...data,
            terms: form.terms && form.terms.length,
            }))
            .post(route("admin.permissions.store"), {
                onSuccess: () => form.reset(),
            });
    };

    const update = () => {
        form
            .transform((data: any) => ({
            ...data,
            terms: form.terms && form.terms.length,
            }))
            .post(route("admin.permissions.update", form.id));
    };
</script>
    
    <template>
      <LayoutAuthenticated>
        <Head :title="(permissionData !== null) ? 'Edit permission' : 'Create permission'" />
        <SectionMain>
            <SectionTitleLineWithButton icon="fas fa-arrow-circle-right" :title="permissionData !== null ? 'Edit permission' : 'Create permission'" main>
                <BaseButtonLink
                    icon="fas fa-arrow-circle-left"
                    label="Back"
                    routeName="permissions.index"
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
                <FormField label="Name" label-for="name" help="Please enter permission name">
                    <FormControl
                        v-model="form.name"
                        id="name"
                        icon="fas fa-lock"
                        autocomplete="name"
                        type="text"
                        required
                    />
                </FormField>
                <FormField label="Permission" label-for="permission" help="Please enter permission">
                    <FormControl
                        v-model="form.permission"
                        id="permission"
                        icon="fas fa-key"
                        autocomplete="permission"
                        type="text"
                        required
                    />
                </FormField>

                <BaseDivider />

                <BaseButtons>
                <BaseButtonLink
                    type="submit"
                    color="info"
                    :label="permissionData !== null ? 'Update' : 'Create'"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                />
                </BaseButtons>
                </CardBox>
            </div>

        </SectionMain>
      </LayoutAuthenticated>
    </template>
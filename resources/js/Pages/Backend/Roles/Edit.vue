<script setup lang="ts">
    import { computed, ref, watch } from 'vue'
    import { mdiArrowRightCircle, mdiArrowLeftCircle, mdiAccount, mdiEmail, mdiFormTextboxPassword, mdiNoteEditOutline } from '@mdi/js'
    import SectionMain from '@/Components/SectionMain.vue'
    import CardBox from '@/Components/CardBox.vue'
    import FormField from "@/Components/FormField.vue";
    import FormControl from "@/Components/FormControl.vue";
    import FormCheckRadioGroup from "@/Components/FormCheckRadioGroup.vue";
    import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue'
    import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue'
    import BaseButtonLink from '@/Components/BaseButtonLink.vue'
    import BaseButtons from "@/Components/BaseButtons.vue";
    import BaseDivider from "@/Components/BaseDivider.vue";
    import FormValidationErrors from "@/Components/FormValidationErrors.vue";
    import FormSuccess from "@/Components/FormSuccess.vue";
    import { Head, useForm, usePage } from '@inertiajs/vue3'

    const roleData = usePage().props.role ?? null
    const permissionList = usePage().props.permissionList ?? null

    
    const form = useForm({
        id: 0,
        name: "",
        permissions: [],
        _method: "post",
    });

    if(roleData !== null) {
        form.id = roleData.id
        form.name = roleData.name
        form.permissions = roleData.permissions.map((item) => item.id)
        form._method = 'put'
    }

    const submit = () => {
        if (roleData !== null) {
            update();
        } else {
            create();
        }
    };

    const create = () => {
        form
            .transform((data) => ({
            ...data,
            terms: form.terms && form.terms.length,
            }))
            .post(route("roles.store"), {
                onSuccess: () => form.reset(),
            });
    };

    const update = () => {
        form
            .transform((data) => ({
            ...data,
            terms: form.terms && form.terms.length,
            }))
            .post(route("roles.update", form.id));
    };
</script>
    
    <template>
      <LayoutAuthenticated>
        <Head :title="(roleData !== null) ? 'Edit Role' : 'Create Role'" />
        <SectionMain>
            <SectionTitleLineWithButton :icon="mdiArrowRightCircle" :title="roleData !== null ? 'Edit Role' : 'Create Role'" main>
                <BaseButtonLink
                    :icon="mdiArrowLeftCircle"
                    label="Back"
                    routeName="roles.index"
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
                <FormField label="Name" label-for="name" help="Please enter role name">
                <FormControl
                    v-model="form.name"
                    id="name"
                    :icon="mdiAccount"
                    autocomplete="name"
                    type="text"
                    required
                />
                </FormField>
                <FormField label="Permission(s)" help="Select Permission(s)">
                    <FormCheckRadioGroup
                        v-model="form.permissions"
                        name="permissions[]"
                        :options="permissionList"
                    />
                </FormField>

                <BaseDivider />

                <BaseButtons>
                <BaseButtonLink
                    type="submit"
                    color="info"
                    :label="roleData !== null ? 'Update' : 'Create'"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                />
                </BaseButtons>
                </CardBox>
            </div>

        </SectionMain>
      </LayoutAuthenticated>
    </template>
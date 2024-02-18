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
    import { Head, useForm, usePage } from '@inertiajs/vue3'

    const permissionData = usePage().props.permission ?? null

    
    const form = useForm({
        id: 0,
        name: "",
        _method: "post",
    });

    if(permissionData !== null) {
        form.id = permissionData.id
        form.name = permissionData.name
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
            .transform((data) => ({
            ...data,
            terms: form.terms && form.terms.length,
            }))
            .post(route("permissions.store"), {
                onSuccess: () => form.reset(),
            });
    };

    const update = () => {
        form
            .transform((data) => ({
            ...data,
            terms: form.terms && form.terms.length,
            }))
            .post(route("permissions.update", form.id));
    };
</script>
    
    <template>
      <LayoutAuthenticated>
        <Head :title="(permissionData !== null) ? 'Edit permission' : 'Create permission'" />
        <SectionMain>
            <SectionTitleLineWithButton :icon="mdiArrowRightCircle" :title="permissionData !== null ? 'Edit permission' : 'Create permission'" main>
                <BaseButtonLink
                    :icon="mdiArrowLeftCircle"
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
                    :icon="mdiAccount"
                    autocomplete="name"
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
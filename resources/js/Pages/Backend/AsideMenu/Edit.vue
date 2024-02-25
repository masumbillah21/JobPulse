<script setup lang="ts">
    import { computed, ref, watch } from 'vue'
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

    const parentMenuList: any = usePage().props.parentMenuList ?? null
    const asideMenu: any = usePage().props.asideMenuData ?? null
    console.log(asideMenu);
    const parentMenus = [
        {id: '', label: 'Select Parent Menu'},
    ]

    if(parentMenuList !== null && parentMenuList.length > 0) {
        parentMenus.push(...parentMenuList)
    }
    const iconList = [
        {id: '', label: 'Select Icon'},
        {id: 'fas fa-users', label: 'Users'},
        {id: 'fas fa-desktop', label: 'Desktop'},
        {id: 'fas fa-building', label: 'Building'},
        {id: 'fas fa-plus', label: 'Plus'},
        {id: 'fas fa-users-cog', label: 'Users Cog'},
        {id: 'fas fa-sliders-h', label: 'Sliders'},
        {id: 'fas fa-key', label: 'Key'},
        {id: 'far fa-edit', label: 'mdiArchiveEditOutline'},
        {id: 'fas fa-user-lock', label: 'User Lock'},
        {id: 'fas fa-file', label: 'File'},
        {id: 'fas fa-folder', label: 'Folder'},
    ]

    const form: any = useForm({
        id: 0,
        label: "",
        route: "",
        icon: "",
        parent_id: "",
        status: 1,
        _method: "post",
    });

    if(asideMenu !== null) {
        form.id = asideMenu.id
        form.label = asideMenu.label
        form.route = asideMenu.route
        form.icon = asideMenu.icon
        form.parent_id = asideMenu.parent_id
        form.status = asideMenu.status
        form._method = 'put'
    }

    const submit = () => {
        if (form.id != 0 ) {
            update();
        } else {
            create();
        }
    };

    const create = () => {
        form.post(route("asides.store"), {
                onSuccess: () => form.reset(),
            });
    };

    const update = () => {
        form.post(route("asides.update", form.id));
    };
</script>
    
    <template>
      <LayoutAuthenticated>
        <Head :title="(asideMenu !== null) ? 'Edit Asides' : 'Create Asides'" />
        
        <SectionMain>
            {{  asideMenu  }}
            <SectionTitleLineWithButton icon="far fa-arrow-alt-circle-right" :title="asideMenu !== null ? 'Edit Asides Menu' : 'Create Asides Menu'" main>
                <BaseButtonLink
                    icon="fas fa-arrow-circle-left"
                    label="Back"
                    routeName="asides.index"
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

                <FormField label="Label" label-for="label" help="Please write menu title">
                    <FormControl
                        v-model="form.label"
                        id="label"
                        autocomplete="name"
                        type="text"
                        required
                    />
                </FormField>

                <FormField label="Route" label-for="route" help="Please write route name">
                    <FormControl
                        v-model="form.route"
                        id="route"
                        type="text"
                    />
                </FormField>

                <FormField label="Icon">
                    <FormControl 
                    v-model="form.icon" 
                    :options="iconList"
                    required />
                </FormField>

                <FormField label="Parent">
                    <FormControl 
                    v-model="form.parent_id" 
                    :options="parentMenus" />
                </FormField>

                <FormCheckRadioGroup 
                    v-model="form.status" 
                    name="status" type="radio"
                    :options="{ 1: 'Active', 0: 'Inactive' }" />

                <BaseDivider />

                <BaseButtons>
                <BaseButtonLink
                    type="submit"
                    color="info"
                    :label="asideMenu !== null ? 'Update' : 'Create'"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                />
                </BaseButtons>
                </CardBox>
            </div>

        </SectionMain>
      </LayoutAuthenticated>
    </template>
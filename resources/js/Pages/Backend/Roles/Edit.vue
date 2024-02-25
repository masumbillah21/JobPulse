<script setup lang="ts">
import { computed, ref, reactive } from 'vue'
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

const roleData: any = usePage().props.role ?? null
const permissionList: any = usePage().props.permissionList ?? null

const form: any = useForm({
    id: 0,
    name: "",
    permissions: permissionList.map((item: any) => {
        if (item.route !== null) {
            return { ...item, permissions: [] };
        } else if (item.children.length > 0) {
            return {
                ...item,
                children: item.children.map((child: any) => ({
                    ...child,
                    permissions: []
                }))
            };
        }
    }),
    _method: "post",
});


// if (roleData !== null) {
//     form.id = roleData.id
//     form.name = roleData.name
//     form.permissions = roleData.permissions.map((item: any) => ({
//         ...item,
//         permission: null // Initialize permission property
//     }));
//     form._method = 'put'
// }

const crudList = {
    'create': 'Create',
    'read': 'Read',
    'update': 'Update',
    'delete': 'Delete'
};
const submit = () => {
    if (roleData !== null) {
        update();
    } else {
        create();
    }
};

const filteredPermissions = computed(() => {
    return form.permissions.filter((item: any) => {
        if (item.permissions && item.permissions.length > 0) {
            return true;
        }
        if (item.children && Array.isArray(item.children) && item.children.some((child: any) => child.permissions && child.permissions.length > 0)) {
            return true;
        }
        return false;
    });
});

const create = () => {
    form.permissions = filteredPermissions.value;
    form.post(route("roles.store"), {
        onSuccess: () => form.reset(),
    });
};


const update = () => {
    form.post(route("roles.update", form.id));
};
</script>
    
<template>
    <LayoutAuthenticated>

        <Head :title="(roleData !== null) ? 'Edit Role' : 'Create Role'" />
        <SectionMain>
            <SectionTitleLineWithButton icon="far fa-arrow-alt-circle-right"
                :title="roleData !== null ? 'Edit Role' : 'Create Role'" main>
                <BaseButtonLink icon="far fa-arrow-alt-circle-left" label="Back" routeName="roles.index" color="contrast"
                    rounded-full small />
            </SectionTitleLineWithButton>
            <div class="flex justify-center items-center">
                <CardBox class="my-24 w-9/12" is-form @submit.prevent="submit">
                    <FormValidationErrors />
                    <FormSuccess />
                    <FormField label="Name" label-for="name" help="Please enter role name">
                        <FormControl v-model="form.name" id="name" autocomplete="name" type="text" required />
                    </FormField>

                    <ul v-for="(permission, index) in form.permissions" :key="index">
                        <li class="mb-5 pb-2 border-b">
                            <div class="flex justify-between">
                                {{ permission.label }}
                                <FormField v-if="permission.route" label="Permission(s)" help="Select Permission(s)">
                                    <FormCheckRadioGroup v-model="permission.permissions" name="permissions[]"
                                        :options="crudList" />
                                </FormField>
                            </div>
                            <ul class="ml-3 mt-1" v-for="(subItem, subIndex) in permission.children" :key="subIndex">
                                <li class="mb-5 mt-5">
                                    <div class="flex justify-between">
                                        {{ subItem.label }}
                                        <FormField v-if="subItem.route" label="Permission(s)" help="Select Permission(s)">
                                            <FormCheckRadioGroup v-model="subItem.permissions" name="permissions[]"
                                                :options="crudList" />
                                        </FormField>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <BaseDivider />

                    <BaseButtons>
                        <BaseButtonLink type="submit" color="info" :label="roleData !== null ? 'Update' : 'Create'"
                            :class="{ 'opacity-25': form.processing }" :disabled="form.processing" />
                    </BaseButtons>
                </CardBox>
            </div>

        </SectionMain>
    </LayoutAuthenticated>
</template>

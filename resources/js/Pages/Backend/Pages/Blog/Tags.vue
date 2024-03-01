<script setup lang="ts">
    import { ref, watch } from 'vue'
    import SectionMain from '@/Components/SectionMain.vue'
    import CardBox from '@/Components/CardBox.vue'
    import FormField from "@/Components/FormField.vue";
    import FormControl from "@/Components/FormControl.vue";
    import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue'
    import SectionTitle from '@/Components/SectionTitle.vue'
    import BaseButtonLink from '@/Components/BaseButtonLink.vue'
    import CardBoxModal from '@/Components/CardBoxModal.vue'
    import Pagination from '@/Components/Pagination.vue'
    import FormSuccess from "@/Components/FormSuccess.vue";
    import { hasPermission } from '@/utils/hasPermission.js'

    import { Head, router, usePage, useForm } from '@inertiajs/vue3'


    const tagsData: any = usePage().props.tagsData

    const isModalDangerActive = ref(false)
    const deleteId = ref<string | number>('')

    const form = useForm({
        id: 0,
        name: '',
        created_at: '',
        updated_at: '',
    })

    const submit = () => {
        form.post(route('admin.tags.store'), {
            onSuccess: () => {
                const items: any = usePage().props.tagsData
                tagsData.data = items.data
                form.reset()
            }
        })
    }


    const dataEdit = (data: any) => {
        form.id = data.id
        form.name = data.name
    }

    const deleteData = () => {
        isModalDangerActive.value = false
        router.delete(route('admin.tags.destroy', deleteId.value))

        const index = tagsData.data.findIndex((category: any) => category.id === deleteId.value)
        if (index !== -1) {
            tagsData.data.splice(index, 1)
        }

    }
    const showModle = (id : string | number) => {
        isModalDangerActive.value = true
        deleteId.value = id
    }
</script>
    
    <template>
      <LayoutAuthenticated>
        <Head title="Tags" />
        <SectionMain>
          <SectionTitle icon="far fa-arrow-alt-circle-right" title="Tags" main/>
          
          <CardBoxModal v-model="isModalDangerActive" title="Warning" button="danger" :onConfirm="deleteData" buttonLabel="Delete" has-cancel>
            <p>Do you really want to delete?</p>
          </CardBoxModal>
            <div class="flex">
                <CardBox v-if="hasPermission('tags.create') || hasPermission('tags.update')" class="w-1/2 mb-6 mr-4"  is-form @submit.prevent="submit">
                    <FormSuccess/>
                    <FormField label="Name" label-for="name" help="Please enter tag name">
                        <FormControl
                            v-model="form.name"
                            id="name"
                            autocomplete="title"
                            type="text"
                            required
                        />
                    </FormField>
                    <BaseButtonLink
                        type="submit"
                        color="info"
                        label="Save"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    />
                </CardBox>
                <CardBox class="mb-6 relative overflow-x-auto shadow-md sm:rounded-lg w-1/2" has-table>
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">SL</th>
                            <th scope="col" class="px-6 py-3">Title</th>
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(category, index) in tagsData.data" :key="category.id" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ index + 1 }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ category.name }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <BaseButtonLink v-if="hasPermission('tags.update')" icon="fas fa-edit" label="Edit" color="info" small @click="dataEdit(category)" />
                                <BaseButtonLink v-if="hasPermission('tags.delete')" class="ml-2" icon="fas fa-trash-alt" label="Delete" color="danger" small @click="showModle(category.id)"/>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <Pagination class="mt-6" :links="tagsData.links"/>
                </CardBox>
            </div>
            
        </SectionMain>
      </LayoutAuthenticated>
    </template>
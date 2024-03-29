<script setup lang="ts">
    import { ref, watch, reactive, computed } from 'vue'
    import SectionMain from '@/Components/SectionMain.vue'
    import CardBox from '@/Components/CardBox.vue'
    import FormField from "@/Components/FormField.vue";
    import FormControl from "@/Components/FormControl.vue";
    import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue'
    import SectionTitle from '@/Components/SectionTitle.vue'
    import BaseButtonLink from '@/Components/BaseButtonLink.vue'
    import CardBoxModal from '@/Components/CardBoxModal.vue'
    import FormSuccess from "@/Components/FormSuccess.vue";
    import { hasPermission } from '@/utils/hasPermission.js'
    import Vue3Datatable from '@bhplugin/vue3-datatable'
    import '@bhplugin/vue3-datatable/dist/style.css'
    import { Head, router, usePage, useForm } from '@inertiajs/vue3'
import FormValidationErrors from '@/Components/FormValidationErrors.vue';


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

        const index = tagsData.findIndex((category: any) => category.id === deleteId.value)
        if (index !== -1) {
            tagsData.splice(index, 1)
        }

    }
    const showModle = (id : string | number) => {
        isModalDangerActive.value = true
        deleteId.value = id
    }

    const params = reactive({
        current_page: 1,
        pagesize: 10,
        sort_column: 'id',
        sort_direction: 'asc',
        search: '',
    });

    const cols = ref([
      {title: 'SL', field: 'id', isUnique: true, type: 'number', width: '100px', hide:false},
      {title: 'Title', field: 'name', hide:false},
      {title: 'Action', field: 'action', hide:false},
    ])

    const rows = ref(tagsData.map((tag: any, index: number) => {
        return {
          sl: index + 1,
          id: tag.id,
          name: tag.name,
        }
    }))

    const filterdJobList = computed(() => {
      if(!params.search) return tagsData.slice(0, params.pagesize);
      const query = params.search.toLowerCase();
      return tagsData?.filter((item: any) => item.name.toLowerCase().includes(query));
    })
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
                    <FormValidationErrors/>
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
                <CardBox class="mb-6 relative overflow-x-auto shadow-md sm:rounded-lg" has-table>
                    <div class="flex justify-between px-3 pt-4">
                        <FormControl  v-model="params.search" type="text" placeholder="Search..." />
                    </div>
                    <Vue3Datatable 
                        :rows="rows" 
                        :columns="cols" 
                        :sortable="true"
                        :sortColumn="params.sort_column"
                        :sortDirection="params.sort_direction"
                        :search="params.search"
                        :columnFilter="true"
                        @change="filterdJobList"
                        :cloneHeaderInFooter="true"
                        skin="bh-table-compact"
                        class="column-filter p-4"
                        rowClass="bg-white dark:bg-slate-800 dark:text-slate-300 dark:border-gray-600"
                    >
                    <template #action="data">
                        <template class="flex">
                            <BaseButtonLink v-if="hasPermission('tags.update')" icon="fas fa-edit" label="Edit" color="info" small @click="dataEdit(data.value)" />
                            <BaseButtonLink v-if="hasPermission('tags.delete')" class="ml-2" icon="fas fa-trash-alt" label="Delete" color="danger" small @click="showModle(data.value.id)"/>
                        </template>
                    </template>
                    </Vue3Datatable>
                </CardBox>
            </div>
        </SectionMain>
      </LayoutAuthenticated>
    </template>
<script setup lang="ts">
    import { ref, watch, computed, reactive } from 'vue'
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


    const categoriesData: any = usePage().props.categoriesData

    const isModalDangerActive = ref(false)
    const deleteId = ref<string | number>('')
    const form = useForm({
        id: 0,
        name: '',
        created_at: '',
        updated_at: '',
    })

    const submit = () => {
        form.post(route('admin.categories.store'), {
            onSuccess: () => {
                const items: any = usePage().props.categoriesData
                categoriesData.data = items.data
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
        router.delete(route('admin.categories.destroy', deleteId.value))

        const index = categoriesData.findIndex((category: any) => category.id === deleteId.value)
        if (index !== -1) {
            categoriesData.splice(index, 1)
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

    const rows = ref(categoriesData.map((cate: any, index: number) => {
        return {
          sl: index + 1,
          id: cate.id,
          name: cate.name,
        }
    }))

    const filterdJobList = computed(() => {
      if(!params.search) return categoriesData.slice(0, params.pagesize);
      const query = params.search.toLowerCase();
      return categoriesData?.filter((item: any) => item.name.toLowerCase().includes(query));
    })
</script>
    <template>
      <LayoutAuthenticated>
        <Head title="Categories" />
        <SectionMain>
          <SectionTitle icon="far fa-arrow-alt-circle-right" title="Categories" main/>
          
          <CardBoxModal v-model="isModalDangerActive" title="Warning" button="danger" :onConfirm="deleteData" buttonLabel="Delete" has-cancel>
            <p>Do you really want to delete?</p>
          </CardBoxModal>
            <div class="flex">
                <CardBox v-if="hasPermission('categories.create') || hasPermission('categories.update')" class="w-1/2 mb-6 mr-4"  is-form @submit.prevent="submit">
                    <FormSuccess/>
                    <FormField label="Name" label-for="name" help="Please enter category name">
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
                    <FormSuccess class="pt-5 pl-5" />
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
                            <BaseButtonLink v-if="hasPermission('categories.update')" icon="fas fa-edit" label="Edit" color="info" small @click="dataEdit(data.value)" />
                            <BaseButtonLink v-if="hasPermission('categories.delete')" class="ml-2" icon="fas fa-trash-alt" label="Delete" color="danger" small @click="showModle(data.value.id)"/>
                        </template>
                    </template>
                    </Vue3Datatable>
                </CardBox>
            </div>
        </SectionMain>
      </LayoutAuthenticated>
    </template>
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
    import FormValidationErrors from '@/Components/FormValidationErrors.vue';
    import FormFilePicker from "@/Components/FormFilePicker.vue";
    import { hasPermission } from '@/utils/hasPermission.js'
    import Vue3Datatable from '@bhplugin/vue3-datatable'
    import '@bhplugin/vue3-datatable/dist/style.css'
    import { Head, router, usePage, useForm } from '@inertiajs/vue3'


    const jobCategoriesData: any = usePage().props.jobCateList

    const isModalDangerActive = ref(false)
    const deleteId = ref<string | number>('')
    const form = useForm({
        id: 0,
        name: '',
        logo: '',
    })
    const imageKey = ref(1)
    const submit = () => {
        form.post(route('admin.jobs.categories.store'), {
            onSuccess: () => {
                const items: any = usePage().props.jobCateList
                rows.value = items

                form.reset()
                imageKey.value = imageKey.value + 1
            }
        })
    }


    const dataEdit = (data: any) => {
        form.id = data.id
        form.name = data.name
        imageKey.value = 1
    }

    const deleteData = () => {
        isModalDangerActive.value = false
        router.delete(route('admin.jobs.categories.destroy', deleteId.value))

        const index = rows.value.findIndex((category: any) => category.id === deleteId.value)
        if (index !== -1) {
            rows.value.splice(index, 1)
            rows.value = [...rows.value]
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
      {title: 'SL', field: 'id', isUnique: true, type: 'number', width: '100px'},
      {title: 'Logo', field: 'logo'},
      {title: 'Title', field: 'name'},
      {title: 'Action', field: 'action'},
    ])

    const rows = ref(jobCategoriesData.map((cate: any, index: number) => {
        return {
          sl: index + 1,
          id: cate.id,
          logo: cate.logo,
          name: cate.name,
        }
    }))

    const filterdJobList = computed(() => {
      if(!params.search) return jobCategoriesData.slice(0, params.pagesize);
      const query = params.search.toLowerCase();
      return jobCategoriesData?.filter((item: any) => item.name.toLowerCase().includes(query));
    })
</script>
    
    <template>
      <LayoutAuthenticated>
        <Head title="Job Categories" />
        <SectionMain>
          <SectionTitle icon="far fa-arrow-alt-circle-right" title="Job Categories" main/>
          
          <CardBoxModal v-model="isModalDangerActive" title="Warning" button="danger" :onConfirm="deleteData" buttonLabel="Delete" has-cancel>
            <p>Do you really want to delete?</p>
          </CardBoxModal>
            <div class="flex">
                <CardBox v-if="hasPermission('job.categories.create') || hasPermission('job.categories.update')" class="w-1/2 mb-6 mr-4"  is-form @submit.prevent="submit">
                    <FormSuccess/>
                    <FormValidationErrors/>
                    <FormField label="Name" label-for="name" help="Please enter category name">
                        <FormControl
                            v-model="form.name"
                            id="name"
                            autocomplete="title"
                            type="text"
                            required
                        />
                    </FormField>

                    <FormField label="Logo" help="Max 500kb">
                        <FormFilePicker 
                            label="Upload Logo" 
                            color="success"
                            :key="imageKey"
                            @update:modelValue="form.logo = $event" />
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
                    <template #logo="data">
                        <img :src="data.value.logo" v-if="data.value.logo" alt="" class="w-10 h-10 rounded-full">
                    </template>
                    <template #action="data">
                        <template class="flex">
                            <BaseButtonLink v-if="hasPermission('job.categories.update')" icon="fas fa-edit" label="Edit" color="info" small @click="dataEdit(data.value)" />
                            <BaseButtonLink v-if="hasPermission('job.categories.delete')" class="ml-2" icon="fas fa-trash-alt" label="Delete" color="danger" small @click="showModle(data.value.id)"/>
                        </template>
                    </template>
                    </Vue3Datatable>
                </CardBox>
            </div>
        </SectionMain>
      </LayoutAuthenticated>
    </template>
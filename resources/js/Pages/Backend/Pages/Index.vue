<script setup lang="ts">
    import { ref, computed, reactive } from 'vue'
    import SectionMain from '@/Components/SectionMain.vue'
    import CardBox from '@/Components/CardBox.vue'
    import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue'
    import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue'
    import BaseButtonLink from '@/Components/BaseButtonLink.vue'
    import CardBoxModal from '@/Components/CardBoxModal.vue'
    import FormSuccess from "@/Components/FormSuccess.vue";
    import FormValidationErrors from '@/Components/FormValidationErrors.vue'
    import Vue3Datatable from '@bhplugin/vue3-datatable'
    import FormControl from '@/Components/FormControl.vue'
    import '@bhplugin/vue3-datatable/dist/style.css'
    import { hasPermission } from '@/utils/hasPermission.js'
    import { Head, useForm, usePage } from '@inertiajs/vue3'

    const pageList: any = usePage().props.pageList
    const urls: any = usePage().props.urls

    const storage = urls.storeUrl

    const form: any = useForm({
        id: 0,
        _method: 'delete'
    });

    const isModalDangerActive = ref(false)
    const isOpen = ref(false);

    const deletePage = async () => {
        isModalDangerActive.value = false
        await form.delete(route('admin.pages.destroy', form.id),{
            onSuccess: () => {
              const index = rows.value.findIndex((page: any) => page.id === form.id)
              if (index !== -1) {
                  rows.value.splice(index, 1)
                  rows.value = [...rows.value]
              }
            }
        })
        

    }
    const showModle = (id : string | number) => {
        isModalDangerActive.value = true
        form.id = id
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
      {title: 'Page Title', field: 'title'},
      {title: 'Image', field: 'featured_image'},
      {title: 'Order', field: 'page_order'},
      {title: 'Status', field: 'status'},
      {title: 'Created', field: 'created_at'},
      {title: 'Updated', field: 'updated_at'},
      {title: 'Action', field: 'action'},
    ])

    const rows = ref(pageList.map((page: any, index: number) => {
        return {
          sl: index + 1,
          id: page.id,
          title: page.title,
          featured_image: page.featured_image,
          page_order: page.page_order,
          status: page.status == 1 ? 'Active' : 'Inactive',
          created_at: page.created_at,
          updated_at: page.updated_at,
        }
    }))

    const filterdJobList = computed(() => {
      if(!params.search) return pageList.slice(0, params.pagesize);
      const query = params.search.toLowerCase();
      return pageList?.filter((item: any) => item.title.toLowerCase().includes(query));
    })
</script>
    
    <template>
      <LayoutAuthenticated>
        <Head title="Roles" />
        <SectionMain>
          <SectionTitleLineWithButton icon="fas fa-arrow-circle-right" title="Pages" main>
            <BaseButtonLink v-if="hasPermission('pages.create')"
              icon="fas fa-plus"
              routeName="pages.create"
              label="Add New"
              color="contrast"
              rounded-full
              small
            />
          </SectionTitleLineWithButton>
          
          <CardBoxModal v-model="isModalDangerActive" title="Warning" button="danger" :onConfirm="deletePage" buttonLabel="Delete" has-cancel>
            <p>Do you really want to delete?</p>
          </CardBoxModal>
          <CardBox class="mb-6 relative overflow-x-auto shadow-md sm:rounded-lg" has-table>
            <FormValidationErrors class="pt-5 pl-5" />
            <FormSuccess class="pt-5 pl-5" />
            <div class="flex justify-between px-3 pt-4">
                <div class="mb-5 relative">
                  <button type="button" class="bg-slate-800 text-white p-2 inline-block rounded" @click="isOpen = !isOpen">
                      Column Compose <i :class="isOpen ? 'fa fa-chevron-up' : 'fa fa-chevron-down'" aria-hidden="true"></i>
                  </button>
                  <ul v-if="isOpen" class="absolute left-0 mt-0.5 p-2.5 min-w-[150px] bg-white rounded shadow-md space-y-1 z-10">
                      <li v-for="col in cols" :key="col.field">
                          <label class="flex items-center gap-2 w-full cursor-pointer text-gray-600 hover:text-black">
                              <input type="checkbox" class="form-checkbox" :checked="!col.hide" @change="col.hide = !$event.target.checked" />
                              <span>{{ col.title }}</span>
                          </label>
                      </li>
                  </ul>
                </div>
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
            <template #featured_image="data">
              <img :src="`${storage}/${data.value.featured_image}`" v-if="data.value.featured_image" alt="" class="w-10 h-10 rounded-full">
            </template>
            <template #action="data">
              <template class="flex">
                <BaseButtonLink v-if="hasPermission('pages.update')" routeName="pages.edit" :routeParams="data.value.id" icon="fas fa-edit" label="Edit" color="info" small />
                <BaseButtonLink v-if="hasPermission('pages.delete')" class="ml-2" icon="fas fa-trash-alt" label="Delete" color="danger" small @click="showModle(data.value.id)"/>
              </template>
            </template>
            </Vue3Datatable>
          </CardBox>
        </SectionMain>
      </LayoutAuthenticated>
    </template>
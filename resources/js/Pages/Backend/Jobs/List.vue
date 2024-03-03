<script setup lang="ts">
    import { computed, ref, reactive } from 'vue'
    import SectionMain from '@/Components/SectionMain.vue'
    import CardBox from '@/Components/CardBox.vue'
    import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue'
    import SectionTitle from '@/Components/SectionTitle.vue'
    import BaseButtonLink from '@/Components/BaseButtonLink.vue'
    import CardBoxModal from '@/Components/CardBoxModal.vue'
    import Pagination from '@/Components/Pagination.vue'
    import FormSuccess from "@/Components/FormSuccess.vue";
    import FormControl from "@/Components/FormControl.vue";
    import FormCheckRadioGroup from "@/Components/FormCheckRadioGroup.vue";
    import { hasPermission } from '@/utils/hasPermission.js'
    import { isSystemUser } from '@/utils/isSystemUser.js'
    import { Head, router, usePage } from '@inertiajs/vue3'
    import Vue3Datatable from '@bhplugin/vue3-datatable'
    import '@bhplugin/vue3-datatable/dist/style.css'

    const jobsData:any = usePage().props.jobsData

    jobsData.forEach(function(obj: any) {
      obj.status = obj.status == 1 ? true : false;
    });

    const loading: any = ref(true);
    const total_rows = ref(0);
    const params = reactive({
        current_page: 1,
        pagesize: 10,
        sort_column: 'id',
        sort_direction: 'asc',
        column_filters: [],
        search: '',
    });

    const cols = ref([
        { field: 'id', title: 'SL', isUnique: true, type: 'number' },
        { title: 'Title', field: 'title'},
        { title: 'Company', field: 'company'},
        { title: 'Category', field: 'category'},
        { title: 'Closing Date', field: 'closing_date'},
        { title: 'Created', field: 'created_at'},
        { title: 'Updated', field: 'updated_at'},
        { title: 'Action', field: 'action'},
    ])

    const rows = ref(jobsData.map((job: any, index: number) => {
        return {
          sl: index + 1,
          id: job.id,
          title: job.title,
          company: job.company.name,
          category: job.category.name,
          status: job.status,
          closing_date: job.closing_date,
          created_at: job.created_at,
          updated_at: job.updated_at,
        }
    }))

    const isModalDangerActive = ref(false)
    const actionId = ref<string | number>('');
    const isOpen = ref(false);

    const updateStatus = () => {
    isModalDangerActive.value = false
    const routeName = isSystemUser() ? 'admin.jobs.status' : 'jobs.status'
    router.get(route(routeName, actionId.value))

}
const showModle = (id: number, updatedStatus: number) => {
    isModalDangerActive.value = true
    actionId.value = id
}

const filterdJobList = (data: any) => {
    params.current_page = 1
console.log(data);
    if(data.change_type === 'search'){
      const query = params.search.toLowerCase();
      return jobsData.filter((item: any) => item.title.toLowerCase().includes(query));
    }else if(data.change_type === 'filter'){
      
    }else{
      return jobsData.slice(0, params.pagesize);
    }
}

</script>
    
    <template>
      <LayoutAuthenticated>
        <Head title="Jobs List" />
        <SectionMain>
          <SectionTitle icon="far fa-arrow-alt-circle-right" title="Jobs List" main />
            <CardBoxModal v-model="isModalDangerActive" title="Warning" button="danger" :onConfirm="updateStatus" buttonLabel="Change" has-cancel>
                <p>Are you sure?</p>
            </CardBoxModal>
            <CardBox class="mb-6 relative overflow-x-auto shadow-md sm:rounded-lg" has-table>
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
                class="column-filter p-4"
              >
              <template #action="jobsData">
                <template class="flex">
                  <BaseButtonLink routeName="jobs.list.single" :routeParams="jobsData.value.id" icon="far fa-eye" label="View" color="success" small />
                  <FormCheckRadioGroup 
                        v-model="jobsData.value.status"
                        name="status"
                        type="switch"
                        class="ml-2"
                        :options="{ 1 : 'Active'}"
                        @click="showModle(jobsData.value.id, jobsData.value.status)"
                    />
                  </template>
              </template>
              </Vue3Datatable>
            </CardBox>
            <!-- <Pagination class="mt-6" :links="jobsData.links"/> -->
        </SectionMain>
      </LayoutAuthenticated>
    </template>
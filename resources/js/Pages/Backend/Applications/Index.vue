<script setup lang="ts">
    import { computed, ref, reactive } from 'vue'
    import SectionMain from '@/Components/SectionMain.vue'
    import CardBox from '@/Components/CardBox.vue'
    import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue'
    import SectionTitle from '@/Components/SectionTitle.vue'
    import BaseButtonLink from '@/Components/BaseButtonLink.vue'
    import FormControl from '@/Components/FormControl.vue'
    import Vue3Datatable from '@bhplugin/vue3-datatable'
    import '@bhplugin/vue3-datatable/dist/style.css'
    import { hasPermission } from '@/utils/hasPermission.js'
    import { Head, usePage } from '@inertiajs/vue3'
    import { capitalize } from '@/utils/capitalize'

    const applicationList:any = usePage().props.applicationList

    const statusList = [
        { id: '', label: 'Select One' },
        { id: 'selected', label: 'Selected' },
        { id: 'rejected', label: 'Rejected' },
    ]

    const isOpen = ref(false);

    const params = reactive({
        current_page: 1,
        pagesize: 10,
        sort_column: 'id',
        sort_direction: 'asc',
        search: '',
    });

    const cols = ref([
      {title: 'SL', field: 'sl', isUnique: true, type: 'number', width: '100px', hide:false},
      {title: 'Job', field: 'job'},
      {title: 'Compnay', field: 'company', hide:false},
      {title: 'Location', field: 'location', hide:false},
      {title: 'Job Type', field: 'jobType', hide:false},
      {title: 'Work Type', field: 'workType', hide:false},
      {title: 'Expected Salary', field: 'salary', hide:false},
      {title: 'Closing Data', field: 'closing', hide:false},
      {title: 'Status', field: 'status', hide:false},
      {title: 'Action', field: 'action', hide:false},
    ])

    const rows = ref(applicationList.map((application: any, index: number) => {
        return {
          sl: index + 1,
          id: application.id,
          job: application.job.title,
          company: application.job.company.name,
          location: application.job.location,
          jobType: application.job.job_type,
          workType: application.job.work_type,
          salary: application.expected_salary,
          closing: application.job.closing_date,
          status: capitalize(application.status),
        }
    }))

    const filterdJobList = computed(() => {
      if(!params.search) return applicationList.slice(0, params.pagesize);
      const query = params.search.toLowerCase();
      return applicationList?.filter((item: any) => item.title.toLowerCase().includes(query));
    })
</script>
    
    <template>
      <LayoutAuthenticated>
        <Head title="Applications" />
        <SectionMain>
          <SectionTitle icon="far fa-arrow-alt-circle-right" title="Applications" main/>

          <CardBox class="mb-6 relative overflow-x-auto shadow-md sm:rounded-lg" has-table>
            <div class="flex justify-between px-3 pt-4">
                <div class="mb-5 relative">
                <button type="button" class="bg-slate-800 text-white p-2 inline-block rounded" @click="isOpen = !isOpen">
                    Column Compose <i :class="isOpen ? 'fa fa-chevron-up' : 'fa fa-chevron-down'" aria-hidden="true"></i>
                </button>
                <ul v-if="isOpen" class="absolute left-0 mt-0.5 p-2.5 min-w-[150px] bg-white rounded shadow-md space-y-1 z-10">
                    <li v-for="col in cols" :key="col.field">
                        <label class="flex items-center gap-2 w-full cursor-pointer text-gray-600 hover:text-black">
                            <input type="checkbox" class="form-checkbox" :checked="!col.hide" @change="col.hide = !($event.target as HTMLInputElement)?.checked" />
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
            <template #action="data">
                <BaseButtonLink v-if="hasPermission('application.view.list')" routeName="jobs.applications.single" :routeParams="data.value.id" icon="far fa-eye" label="View" color="success" small />
            </template>
            </Vue3Datatable>
          </CardBox>
        </SectionMain>
      </LayoutAuthenticated>
    </template>
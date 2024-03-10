<script setup lang="ts">
    import { computed, ref, reactive } from 'vue'
    import SectionMain from '@/Components/SectionMain.vue'
    import CardBox from '@/Components/CardBox.vue'
    import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue'
    import SectionTitle from '@/Components/SectionTitle.vue'
    import BaseButtonLink from '@/Components/BaseButtonLink.vue'
    import CardBoxModal from '@/Components/CardBoxModal.vue'
    import FormSuccess from "@/Components/FormSuccess.vue";
    import FormValidationErrors from '@/Components/FormValidationErrors.vue'
    import FormControl from "@/Components/FormControl.vue";
    import FormField from "@/Components/FormField.vue";
    import Vue3Datatable from '@bhplugin/vue3-datatable'
    import '@bhplugin/vue3-datatable/dist/style.css'
    import { hasPermission } from '@/utils/hasPermission.js'
    import { isSystemUser } from '@/utils/isSystemUser.js'
    import { Head, router, usePage, useForm } from '@inertiajs/vue3'
    import { capitalize } from '@/utils/capitalize'

    const candidatesList:any = usePage().props.candidatesList

    const statusList = [
        { id: '', label: 'Select One' },
        { id: 'selected', label: 'Selected' },
        { id: 'rejected', label: 'Rejected' },
    ]

    const form = useForm({
        candidate_id: 0,
        status: statusList[0].id,
        _method: 'put',
    })

    const isModalDangerActive = ref(false)
    const isOpen = ref(false);
    const changeStatus = () => {
        isModalDangerActive.value = false
        const routeName = isSystemUser() ? 'admin.jobs.cadidates.status' : 'jobs.cadidates.status'
        form.post(route(routeName), {
            onSuccess: () => {
              rows.value.find((candidate: any) => candidate.id == form.candidate_id).status = form.status
            },
        })
    }
    const showModel = (candidateId: number) => {
        isModalDangerActive.value = true
        form.candidate_id = candidateId
    }

    const params = reactive({
        current_page: 1,
        pagesize: 10,
        sort_column: 'id',
        sort_direction: 'asc',
        search: '',
    });

    const cols = ref([
      {title: 'SL', field: 'sl', isUnique: true, type: 'number', width: '100px'},
      {title: 'Job', field: 'job'},
      {title: 'Candidate', field: 'candidate'},
      {title: 'Email', field: 'email'},
      {title: 'Expected Salary', field: 'salary'},
      {title: 'Closing Data', field: 'closing'},
      {title: 'Status', field: 'status'},
      {title: 'Action', field: 'action'},
    ])

    const rows = ref(candidatesList.map((candidate: any, index: number) => {
        return {
          sl: index + 1,
          id: candidate.id,
          job: candidate.job.title,
          candidate: candidate.user.name,
          email: candidate.user.email,
          salary: candidate.expected_salary,
          closing: candidate.job.closing_date,
          status: capitalize(candidate.status),
        }
    }))

    const filterdJobList = computed(() => {
      if(!params.search) return candidatesList.slice(0, params.pagesize);
      const query = params.search.toLowerCase();
      return candidatesList?.filter((item: any) => item.title.toLowerCase().includes(query));
    })
</script>
    
    <template>
      <LayoutAuthenticated>
        <Head title="Candidates" />
        <SectionMain>
          <SectionTitle icon="far fa-arrow-alt-circle-right" title="Candidates List" main/>
          <CardBoxModal v-model="isModalDangerActive" title="Change Status" button="info" :onConfirm="changeStatus" buttonLabel="Change" has-cancel>
            <FormField class="w-full" label="Status">
              <FormControl v-model="form.status" :options="statusList" />
            </FormField>
          </CardBoxModal>
          <CardBox class="mb-6 relative overflow-x-auto shadow-md sm:rounded-lg" has-table>
            <FormSuccess class="pt-5 pl-5" />
            <FormValidationErrors />
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
            <template #action="data">
                <template class="flex">
                  <BaseButtonLink v-if="hasPermission('candidate.view')" routeName="jobs.cadidate.single" :routeParams="data.value.id" icon="far fa-eye" label="View" color="success" small />
                  <BaseButtonLink v-if="hasPermission('candidate.select')" class="ml-2" icon="fas fa-edit" label="Action" color="info" small @click="showModel(data.value.id, )"/>
                </template>
            </template>
            </Vue3Datatable>
          </CardBox>
        </SectionMain>
      </LayoutAuthenticated>
    </template>
<script setup lang="ts">
    import { ref, computed, reactive } from 'vue'
    import SectionMain from '@/Components/SectionMain.vue'
    import CardBox from '@/Components/CardBox.vue'
    import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue'
    import SectionTitle from '@/Components/SectionTitle.vue'
    import FormCheckRadioGroup from '@/Components/FormCheckRadioGroup.vue'
    import CardBoxModal from '@/Components/CardBoxModal.vue'
    import BaseButtonLink from '@/Components/BaseButtonLink.vue'
    import FormSuccess from "@/Components/FormSuccess.vue"
    import FormControl from "@/Components/FormControl.vue";
    import { hasPermission } from '@/utils/hasPermission.js'
    import Vue3Datatable from '@bhplugin/vue3-datatable'
    import '@bhplugin/vue3-datatable/dist/style.css'
    import { Head, router, usePage } from '@inertiajs/vue3'

    const usersList: any = usePage().props.usersList

    usersList.forEach(function(obj: any) {
      obj.status = obj.status == 1 ? true : false;
    });

    const params = reactive({
        current_page: 1,
        pagesize: 10,
        sort_column: 'id',
        sort_direction: 'asc',
        search: '',
    });

    const isModalDangerActive = ref(false)

    const cols = ref([
        { field: 'sl', title: 'SL', isUnique: true, type: 'number', width: '50px' },
        { title: 'Name', field: 'name'},
        { title: 'Email', field: 'email'},
        { title: 'Type', field: 'type'},
        { title: 'Status', field: 'is_active'},
        { title: 'Created', field: 'created_at'},
        { title: 'Updated', field: 'updated_at'},
        { title: 'Action', field: 'action'},
    ])

    const rows = ref(usersList.map((user: any, index: number) => {
        return {
          sl: index + 1,
          id: user.id,
          name: user.name,
          email: user.email,
          type: user.user_type,
          status: user.is_active == 1 ? true : false,
          is_active: user.is_active == 1 ? 'Active' : 'Inactive',
          created_at: user.created_at,
          updated_at: user.updated_at,
        }
    }))

    const isOpen = ref(false);
    const userId = ref<string | number>('');
    const comStatus = ref<string | number>('');
    const changeStatus = () => {
        isModalDangerActive.value = false
        router.get(route('admin.users.status', userId.value))
    }
    const showModle = (id: number) => {
        isModalDangerActive.value = true
        userId.value = id
    }

    const filterdJobList = computed(() => {
      if(!params.search) return usersList.slice(0, params.pagesize);
      const query = params.search.toLowerCase();
      return usersList?.filter((item: any) => item.name.toLowerCase().includes(query));
    })
</script>
    
    <template>
      <LayoutAuthenticated>
        <Head title="User List" />
        <SectionMain>
          <SectionTitle icon="far fa-arrow-alt-circle-right" title="User List" main />
          <CardBoxModal v-model="isModalDangerActive" title="Warning" button="danger" :onConfirm="changeStatus" buttonLabel="Change" has-cancel>
            <p>Do you really want to change status?</p>
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
              skin="bh-table-compact"
              class="column-filter p-4"
              rowClass="bg-white dark:bg-slate-800 dark:text-slate-300 dark:border-gray-600"
            >
            <template #action="data">
              <template class="flex">
                <FormCheckRadioGroup v-if="hasPermission('users.list.status')"
                    v-model="data.value.status"
                    name="status"
                    type="switch"
                    :options="{ 1 : 'Active'}"
                    @click="showModle(data.value.id)"
                  />
                </template>
            </template>
            </Vue3Datatable>
          </CardBox>
            
        </SectionMain>
      </LayoutAuthenticated>
    </template>
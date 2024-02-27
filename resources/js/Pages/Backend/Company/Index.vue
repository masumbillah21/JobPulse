<script setup lang="ts">
    import { ref } from 'vue'
    import SectionMain from '@/Components/SectionMain.vue'
    import CardBox from '@/Components/CardBox.vue'
    import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue'
    import SectionTitle from '@/Components/SectionTitle.vue'
    import FormCheckRadioGroup from '@/Components/FormCheckRadioGroup.vue'
    import CardBoxModal from '@/Components/CardBoxModal.vue'
    import BaseButtonLink from '@/Components/BaseButtonLink.vue'
    import Pagination from '@/Components/Pagination.vue'
    import FormSuccess from "@/Components/FormSuccess.vue"
    import { hasPermission } from '@/utils/hasPermission.js'
    import { Head, router, usePage } from '@inertiajs/vue3'

    const companyData: any = usePage().props.companyData

   

    companyData.data.forEach(function(obj: any) {
      obj.status = obj.status == 1 ? true : false;
    });

    const isModalDangerActive = ref(false)

    const comId = ref<string | number>('');
    const comStatus = ref<string | number>('');
    const changeStatus = () => {
        isModalDangerActive.value = false
        router.get(route('company.status', {id: comId.value, status: comStatus.value}))
        companyData.data.findIndex((com: any) => com.id === comId.value)
    }
    const showModle = (id: number, status: number) => {
        isModalDangerActive.value = true
        comId.value = id
        comStatus.value = status
    }
</script>
    
    <template>
      <LayoutAuthenticated>
        <Head title="Company List" />
        <SectionMain>
          <SectionTitle icon="far fa-arrow-alt-circle-right" title="Company List" main />
          <CardBoxModal v-model="isModalDangerActive" title="Warning" button="danger" :onConfirm="changeStatus" buttonLabel="Change" has-cancel>
            <p>Do you really want to change status?</p>
          </CardBoxModal>
            <CardBox class="mb-6 relative overflow-x-auto shadow-md sm:rounded-lg" has-table>
              <FormSuccess class="pt-5 pl-5" />
              <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                  <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                      <tr>
                          <th scope="col" class="px-6 py-3">SL</th>
                          <th scope="col" class="px-6 py-3">Name</th>
                          <th scope="col" class="px-6 py-3">Logo</th>
                          <th scope="col" class="px-6 py-3">Email</th>
                          <th scope="col" class="px-6 py-3">Phone</th>
                          <th scope="col" class="px-6 py-3">Address</th>
                          <th scope="col" class="px-6 py-3">Type</th>
                          <th scope="col" class="px-6 py-3">Created</th>
                          <th scope="col" class="px-6 py-3">Update</th>
                          <th scope="col" class="px-6 py-3">
                              Action
                          </th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr v-for="(compnay, index) in companyData.data" :key="compnay.id" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ index + 1 }}</td>
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ compnay.name }}</td>
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"><img :src="compnay.logo" alt="" width="100"></td>
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ compnay.email }}</td>
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ compnay.phone }}</td>
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ compnay.address }}</td>
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ compnay.company_type }}</td>
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ compnay.created_at }}</td>
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ compnay.updated_at }}</td>
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <div class="flex">
                              <BaseButtonLink class="mr-3" routeName="company.show" :routeParams="compnay.id" icon="fas fa-eye" label="Show" color="success" small />
                              <FormCheckRadioGroup v-if="hasPermission('company.delete')"
                                  v-model="compnay.status"
                                  name="status"
                                  type="switch"
                                  :options="{ 1 : 'Active'}"
                                  @click="showModle(compnay.id, compnay.status)"
                                />
                            </div>
                          </td>
                      </tr>
                  </tbody>
              </table>
            </CardBox>
            <Pagination class="mt-6" :links="companyData.links"/>
        </SectionMain>
      </LayoutAuthenticated>
    </template>
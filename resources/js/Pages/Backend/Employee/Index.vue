<script setup lang="ts">
    import { ref } from 'vue'
    import SectionMain from '@/Components/SectionMain.vue'
    import CardBox from '@/Components/CardBox.vue'
    import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue'
    import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue'
    import BaseButtonLink from '@/Components/BaseButtonLink.vue'
    import CardBoxModal from '@/Components/CardBoxModal.vue'
    import { Head, router, usePage } from '@inertiajs/vue3'
    import Pagination from '@/Components/Pagination.vue'
    import FormSuccess from "@/Components/FormSuccess.vue";

    const employees: any = usePage().props.employees

    const isModalDangerActive = ref(false)
    const deleteId = ref<string | number>('');
    const deleteEmployee = () => {
        isModalDangerActive.value = false
        router.delete(route('employee.destroy', deleteId.value))

        const index = employees.data.findIndex((emp: any) => emp.id === deleteId.value)
        // if (index !== -1) {
        //     rolesemployeesData.data.splice(index, 1)
        // }

    }
    const showModle = (id: number) => {
        isModalDangerActive.value = true
        deleteId.value = id
    }
</script>
    
    <template>
      <LayoutAuthenticated>
        <Head title="Employees" />
        <SectionMain>
          <SectionTitleLineWithButton icon="far fa-arrow-alt-circle-right" title="Employees" main>
            <BaseButtonLink
              icon="fas fa-plus"
              routeName="employee.create"
              label="Add New"
              color="contrast"
              rounded-full
              small
            />
          </SectionTitleLineWithButton>
          
          <CardBoxModal v-model="isModalDangerActive" title="Warning" button="danger" :onConfirm="deleteEmployee" buttonLabel="Delete" has-cancel>
            <p>Do you really want to delete?</p>
          </CardBoxModal>
            <CardBox class="mb-6 relative overflow-x-auto shadow-md sm:rounded-lg" has-table>
              <FormSuccess class="pt-5 pl-5" />
              <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                  <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                      <tr>
                          <th scope="col" class="px-6 py-3">SL</th>
                          <th scope="col" class="px-6 py-3">Name</th>
                          <th scope="col" class="px-6 py-3">Email</th>
                          <th scope="col" class="px-6 py-3">Created</th>
                          <th scope="col" class="px-6 py-3">
                              Action
                          </th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr v-for="(employee, index) in employees.data" :key="employee.id" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ index + 1 }}</td>
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ employee.name }}</td>
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ employee.email }}</td>
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ employee.created_at }}</td>
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                              <BaseButtonLink routeName="employee.edit" :routeParams="employee.id" icon="fas fa-edit" label="Edit" color="info" small />
                              <BaseButtonLink class="ml-2" icon="fas fa-trash-alt" label="Delete" color="danger" small @click="showModle(employee.id)"/>

                          </td>
                      </tr>
                  </tbody>
              </table>
            </CardBox>
            <Pagination class="mt-6" :links="employees.links"/>
        </SectionMain>
      </LayoutAuthenticated>
    </template>
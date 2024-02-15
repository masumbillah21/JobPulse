<script setup lang="ts">
    import { computed, ref } from 'vue'
    import { mdiArrowRightCircle, mdiPlus, mdiEye, mdiTrashCan, mdiNoteEditOutline } from '@mdi/js'
    import SectionMain from '@/Components/SectionMain.vue'
    import CardBox from '@/Components/CardBox.vue'
    import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue'
    import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue'
    import BaseButtonLink from '@/Components/BaseButtonLink.vue'
    import CardBoxModal from '@/Components/CardBoxModal.vue'
    import { Head, router } from '@inertiajs/vue3'
    import Pagination from '@/Components/Pagination.vue'
    import FormSuccess from "@/Components/FormSuccess.vue";

    defineProps(['employees'])

    const isModalDangerActive = ref(false)
    const deleteId = ref(null)
    const deleteEmployee = () => {
        isModalDangerActive.value = false
        console.log('delete' + deleteId.value)
        router.delete(route('employee.destroy', deleteId.value))

    }
    const showModle = (id) => {
        isModalDangerActive.value = true
        deleteId.value = id
    }
</script>
    
    <template>
      <LayoutAuthenticated>
        <Head title="Employees" />
        <SectionMain>
          <SectionTitleLineWithButton :icon="mdiArrowRightCircle" title="Employees" main>
            <BaseButtonLink
              :icon="mdiPlus"
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
                          <th scope="col" class="px-6 py-3">Name</th>
                          <th scope="col" class="px-6 py-3">Email</th>
                          <th scope="col" class="px-6 py-3">Created</th>
                          <th scope="col" class="px-6 py-3">
                              Action
                          </th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr v-for="employee in employees.data" :key="employee.id" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ employee.name }}</td>
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ employee.email }}</td>
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ employee.created_at }}</td>
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                              <BaseButtonLink :href="route('employee.edit', employee.id)" :icon="mdiNoteEditOutline" label="Edit" color="info" small />
                              <BaseButtonLink class="ml-2" :icon="mdiTrashCan" label="Delete" color="danger" small @click="showModle(employee.id)"/>

                          </td>
                      </tr>
                  </tbody>
              </table>
            </CardBox>
            <Pagination class="mt-6" :links="employees.links"/>
        </SectionMain>
      </LayoutAuthenticated>
    </template>
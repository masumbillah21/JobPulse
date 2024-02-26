<script setup lang="ts">
    import { computed, ref } from 'vue'
    import { mdiArrowRightCircle, mdiPlus, mdiEye, mdiTrashCan, mdiNoteEditOutline } from '@mdi/js'
    import SectionMain from '@/Components/SectionMain.vue'
    import CardBox from '@/Components/CardBox.vue'
    import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue'
    import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue'
    import BaseButtonLink from '@/Components/BaseButtonLink.vue'
    import CardBoxModal from '@/Components/CardBoxModal.vue'
    import Pagination from '@/Components/Pagination.vue'
    import FormSuccess from "@/Components/FormSuccess.vue";
    import { Head, router, usePage } from '@inertiajs/vue3'

    const permissionsData: any = usePage().props.permissionsData

    const isModalDangerActive = ref(false)
    const deleteId = ref<string | number>('');
    const deleteRole = () => {
        isModalDangerActive.value = false
        router.delete(route('permissions.destroy', deleteId.value))

        const index = permissionsData.data.findIndex((role: any) => role.id === deleteId.value)
        if (index !== -1) {
            permissionsData.data.splice(index, 1)
        }

    }
    const showModle = (id: number) => {
        isModalDangerActive.value = true
        deleteId.value = id
    }
</script>
    
    <template>
      <LayoutAuthenticated>
        <Head title="Permissions" />
        <SectionMain>
          <SectionTitleLineWithButton icon="fas fa-arrow-circle-right" title="Permissions" main>
            <BaseButtonLink
              icon="fas fa-plus"
              routeName="permissions.create"
              label="Add New"
              color="contrast"
              rounded-full
              small
            />
          </SectionTitleLineWithButton>
          
          <CardBoxModal v-model="isModalDangerActive" title="Warning" button="danger" :onConfirm="deleteRole" buttonLabel="Delete" has-cancel>
            <p>Do you really want to delete?</p>
          </CardBoxModal>
            <CardBox class="mb-6 relative overflow-x-auto shadow-md sm:rounded-lg" has-table>
              <FormSuccess class="pt-5 pl-5" />
              <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                  <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                      <tr>
                          <th scope="col" class="px-6 py-3">SL</th>
                          <th scope="col" class="px-6 py-3">Name</th>
                          <th scope="col" class="px-6 py-3">Permission</th>
                          <th scope="col" class="px-6 py-3">Created</th>
                          <th scope="col" class="px-6 py-3">Updated</th>
                          <th scope="col" class="px-6 py-3">
                              Action
                          </th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr v-for="(permission, index) in permissionsData.data" :key="permission.id" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ index + 1 }}</td>
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ permission.name }}</td>
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ permission.permission }}</td>
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ permission.created_at }}</td>
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ permission.updated_at }}</td>
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                              <BaseButtonLink routeName="permissions.edit" :routeParams="permission.id" icon="fas fa-edit" label="Edit" color="info" small />
                              <BaseButtonLink class="ml-2" icon="fas fa-trash-alt" label="Delete" color="danger" small @click="showModle(permission.id)"/>
                          </td>
                      </tr>
                  </tbody>
              </table>
            </CardBox>
            <Pagination class="mt-6" :links="permissionsData.links"/>
        </SectionMain>
      </LayoutAuthenticated>
    </template>
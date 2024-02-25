<script setup lang="ts">
    import { computed, ref } from 'vue'
    import SectionMain from '@/Components/SectionMain.vue'
    import CardBox from '@/Components/CardBox.vue'
    import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue'
    import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue'
    import BaseButtonLink from '@/Components/BaseButtonLink.vue'
    import CardBoxModal from '@/Components/CardBoxModal.vue'
    import Pagination from '@/Components/Pagination.vue'
    import FormSuccess from "@/Components/FormSuccess.vue";
    import { Head, router, usePage } from '@inertiajs/vue3'

    const asideMenuList: any = usePage().props.asideMenuList

    const isModalDangerActive = ref(false)
    const deleteId = ref<string | number>('')
    const deleteRole = () => {
        isModalDangerActive.value = false
        router.delete(route('asides.destroy', deleteId.value))

        const index = asideMenuList.data.findIndex((menu: any) => menu.id === deleteId.value)
        if (index !== -1) {
            asideMenuList.data.splice(index, 1)
        }

    }
    const showModle = (id : string | number) => {
        isModalDangerActive.value = true
        deleteId.value = id
    }
</script>
    
    <template>
      <LayoutAuthenticated>
        <Head title="Aside Menus" />
        <SectionMain>
          <SectionTitleLineWithButton icon="far fa-arrow-alt-circle-right" title="Aside Menus" main>
            <BaseButtonLink
              icon="fas fa-plus"
              routeName="asides.create"
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
                          <th scope="col" class="px-6 py-3">Label</th>
                          <th scope="col" class="px-6 py-3">Route</th>
                          <th scope="col" class="px-6 py-3">Icon</th>
                          <th scope="col" class="px-6 py-3">Parent</th>
                          <th scope="col" class="px-6 py-3">Created</th>
                          <th scope="col" class="px-6 py-3">Updated</th>
                          <th scope="col" class="px-6 py-3">
                              Action
                          </th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr v-for="(menu, index) in asideMenuList.data" :key="menu.id" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ index + 1 }}</td>
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ menu.label }}</td>
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ menu.route }}</td>
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ menu.icon }}</td>
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ menu.parent_id != null ? menu.parent.label : 'No Parent' }}</td>
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ menu.created_at }}</td>
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ menu.updated_at }}</td>
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                              <BaseButtonLink routeName="asides.edit" :routeParams="menu.id" icon="far fa-edit" label="Edit" color="info" small />
                              <BaseButtonLink class="ml-2" icon="far fa-trash-alt" label="Delete" color="danger" small @click="showModle(menu.id)"/>
                          </td>
                      </tr>
                  </tbody>
              </table>
            </CardBox>
            <Pagination class="mt-6" :links="asideMenuList.links"/>
        </SectionMain>
      </LayoutAuthenticated>
    </template>
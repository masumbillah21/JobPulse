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

    const blogsData: any = usePage().props.blogsData

    const isModalDangerActive = ref(false)
    const deleteId = ref<string | number>('')

    const deleteData = () => {
        isModalDangerActive.value = false
        router.delete(route('blogs.destroy', deleteId.value))

        const index = blogsData.data.findIndex((role: any) => role.id === deleteId.value)
        if (index !== -1) {
            blogsData.data.splice(index, 1)
        }

    }
    const showModle = (id : string | number) => {
        isModalDangerActive.value = true
        deleteId.value = id
    }
</script>
    
    <template>
      <LayoutAuthenticated>
        <Head title="Blog Posts" />
        <SectionMain>
          <SectionTitleLineWithButton :icon="mdiArrowRightCircle" title="Blog Posts" main>
            <BaseButtonLink
              :icon="mdiPlus"
              routeName="blogs.create"
              label="Add New"
              color="contrast"
              rounded-full
              small
            />
          </SectionTitleLineWithButton>
          
          <CardBoxModal v-model="isModalDangerActive" title="Warning" button="danger" :onConfirm="deleteData" buttonLabel="Delete" has-cancel>
            <p>Do you really want to delete?</p>
          </CardBoxModal>
            <CardBox class="mb-6 relative overflow-x-auto shadow-md sm:rounded-lg" has-table>
              <FormSuccess class="pt-5 pl-5" />
              <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                  <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                      <tr>
                          <th scope="col" class="px-6 py-3">SL</th>
                          <th scope="col" class="px-6 py-3">Title</th>
                          <th scope="col" class="px-6 py-3">Posted By</th>
                          <th scope="col" class="px-6 py-3">Status</th>
                          <th scope="col" class="px-6 py-3">Created</th>
                          <th scope="col" class="px-6 py-3">Updated</th>
                          <th scope="col" class="px-6 py-3">
                              Action
                          </th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr v-for="(blog, index) in blogsData.data" :key="blog.id" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ index + 1 }}</td>
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ blog.title }}</td>
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ blog.user.name }}</td>
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ blog.status ? 'Published' : 'Draft' }}</td>
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ blog.created_at }}</td>
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ blog.updated_at }}</td>
                          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                              <BaseButtonLink routeName="blogs.edit" :routeParams="blog.id" :icon="mdiNoteEditOutline" label="Edit" color="info" small />
                              <BaseButtonLink class="ml-2" :icon="mdiTrashCan" label="Delete" color="danger" small @click="showModle(blog.id)"/>
                          </td>
                      </tr>
                  </tbody>
              </table>
            </CardBox>
            <Pagination class="mt-6" :links="blogsData.links"/>
        </SectionMain>
      </LayoutAuthenticated>
    </template>
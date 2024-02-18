<script setup lan='ts'>
    import { ref } from 'vue'
    import { Head, router, usePage } from '@inertiajs/vue3'
    import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue'
    import SectionMain from '@/Components/SectionMain.vue'
    import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue'
    import BaseButtonLink from '@/Components/BaseButtonLink.vue'
    import CardBox from '@/Components/CardBox.vue'
    import FormValidationErrors from '@/Components/FormValidationErrors.vue'
    import FormSuccess from '@/Components/FormSuccess.vue'
    import { mdiArrowRightCircle, mdiPlus } from '@mdi/js'
    
    
    // Write your code here
    
    
    </script>
    
    <template>
        <LayoutAuthenticated>
            <Head title="About" />
            <SectionMain>
              <SectionTitleLineWithButton :icon="mdiArrowRightCircle" title="About" main>
                <BaseButtonLink
                  :icon="mdiPlus"
                  routeName="permissions.create"
                  label="Add New"
                  color="contrast"
                  rounded-full
                  small
                />
              </SectionTitleLineWithButton>
       
                <CardBox class="mb-6 relative overflow-x-auto shadow-md sm:rounded-lg">
                    <FormValidationErrors />
                    <FormSuccess class="pt-5 pl-5" />
                  
                </CardBox>
            </SectionMain>
          </LayoutAuthenticated>
    </template>
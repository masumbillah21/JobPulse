<script setup lang="ts">
    import { computed, ref, watch } from 'vue'
    import { mdiArrowRightCircle, mdiArrowLeftCircle, mdiAccount, mdiEmail, mdiFormTextboxPassword, mdiNoteEditOutline } from '@mdi/js'
    import SectionMain from '@/Components/SectionMain.vue'
    import CardBox from '@/Components/CardBox.vue'
    import FormField from "@/Components/FormField.vue";
    import FormControl from "@/Components/FormControl.vue";
    import FormCheckRadioGroup from "@/Components/FormCheckRadioGroup.vue";
    import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue'
    import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue'
    import BaseButtonLink from '@/Components/BaseButtonLink.vue'
    import BaseButtons from "@/Components/BaseButtons.vue";
    import FormFilePicker from "@/Components/FormFilePicker.vue";
    import FormValidationErrors from "@/Components/FormValidationErrors.vue";
    import FormSuccess from "@/Components/FormSuccess.vue";
    import { Head, useForm, usePage } from '@inertiajs/vue3'

    const blogData: any = usePage().props.blogData ?? null

    const fileInputKey = ref(0);


    const form: any = useForm({
        id: 0,
        title: "",
        body: "",
        image: "",
        status: "",
        _method: "post",
    });

    if(blogData !== null) {
        form.id = blogData.id
        form.title = blogData.title
        form.body = blogData.body
        form.status = blogData.status
        form._method = 'put'
    }

    const submit = () => {
        if (blogData !== null) {
            update();
        } else {
            create();
        }
    };

    const create = () => {
        form
            .transform((data: any) => ({
            ...data,
            terms: form.terms && form.terms.length,
            }))
            .post(route("blogs.store"), {
                onSuccess: () => {
                    form.reset();
                    fileInputKey.value = fileInputKey.value + 1;
                },
            });
    };

    const update = () => {
        form
            .transform((data: any) => ({
            ...data,
            terms: form.terms && form.terms.length,
            }))
            .post(route("blogs.update", form.id));
    };
</script>
    
    <template>
      <LayoutAuthenticated>
        <Head :title="(blogData !== null) ? 'Edit Post' : 'Create Post'" />
        <SectionMain>
            <SectionTitleLineWithButton :icon="mdiArrowRightCircle" :title="blogData !== null ? 'Edit Post' : 'Create Post'" main>
                <BaseButtonLink
                    :icon="mdiArrowLeftCircle"
                    label="Back"
                    routeName="blogs.index"
                    color="contrast"
                    rounded-full
                    small
                />
            </SectionTitleLineWithButton>
           
                <CardBox class="my-24 w-full" is-form @submit.prevent="submit" >
                    <FormValidationErrors />
                    <FormSuccess />
                    <div class="flex justify-center">
                        <CardBox class="w-4/5">
                            <FormField label="Tilte" label-for="title" help="Please enter post title">
                                <FormControl
                                    v-model="form.title"
                                    id="title"
                                    autocomplete="title"
                                    type="text"
                                    required
                                />
                            </FormField>
                            <FormField label="Content" label-for="content" help="Please enter post content">
                                <FormControl
                                    v-model="form.body"
                                    id="content"
                                    autocomplete="content"
                                    type="textarea"
                                    required
                                />
                            </FormField>
                        </CardBox>
                        <CardBox class="ml-2 w-1/5">
                            <img v-if="(blogData && blogData.image)" :src="blogData.image" alt="">
                            <FormField label="Featued Image" help="Max 500kb">
                                <FormFilePicker 
                                    :key="fileInputKey"
                                    label="Upload Image" 
                                    color="success"
                                    @update:modelValue="form.image = $event" />
                            </FormField>

                            <FormCheckRadioGroup
                                label="Status"
                                class="mb-3"
                                v-model="form.status"
                                name="status"
                                type="radio"
                                :options="{ '1': 'Publish', '0': 'Draft' }"
                            />
                            <BaseButtons>
                            <BaseButtonLink
                                type="submit"
                                color="info"
                                :label="blogData !== null ? 'Update' : 'Create'"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            />
                            </BaseButtons>
                        </CardBox>
                    </div>
                </CardBox>
            

        </SectionMain>
      </LayoutAuthenticated>
    </template>
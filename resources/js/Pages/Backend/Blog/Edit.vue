<script setup lang="ts">
    import { ref } from 'vue'
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
    import { isSystemUser } from '@/utils/isSystemUser.js'
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
    import CKEditor from "@ckeditor/ckeditor5-vue";

    const blogData: any = usePage().props.blogData ?? null
    const categoryData: any = usePage().props.categoryData ?? null

    const fileInputKey = ref(0);

    const editor = ClassicEditor;

    const onChange = (data: any) => {
        form.body = data;
        addStyle();
    };

    // Add custom CSS to increase the height of CKEditor
    const style = `
        .ck-editor__editable {
            min-height: 300px; /* Adjust the height as per your requirement */
        }
        .ck-powered-by-balloon {
            display: none !important;
        }
    `;

    // Apply the custom style
    const addStyle = () => {
        const styleElement = document.createElement('style');
        styleElement.textContent = style;
        document.head.appendChild(styleElement);
    };


    const form: any = useForm({
        id: 0,
        title: "",
        body: "",
        image: "",
        status: "",
        categories: [],
        tags: '',
        _method: "post",
    });

    if(blogData !== null) {
        form.id = blogData.id
        form.title = blogData.title
        form.body = blogData.body
        form.status = blogData.status
        form.categories = blogData.category_ids
        form.tags = blogData.tags.map((tag: any) => tag.name)
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
        const routeName: string = isSystemUser() ? "admin.blogs.store" : "blogs.store";
        form.post(route(routeName), {
            onSuccess: () => {
                form.reset();
                fileInputKey.value = fileInputKey.value + 1;
            },
        });
    };

    const update = () => {
        form.post(route(isSystemUser() ? "admin.blogs.update" : "blogs.update", form.id));
    };
    addStyle()
</script>
    
    <template>
      <LayoutAuthenticated>
        <Head :title="(blogData !== null) ? 'Edit Post' : 'Create Post'" />
        <SectionMain>
            <SectionTitleLineWithButton icon="far fa-arrow-alt-circle-right" :title="blogData !== null ? 'Edit Post' : 'Create Post'" main>
                <BaseButtonLink
                    icon="far fa-arrow-alt-circle-left"
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
                            <p>Content</p>
                            <div class="dark:text-black min-h-24">
                                <CKEditor.component v-model="form.body" :editor="editor" @change="onChange" />
                            </div>
                        </CardBox>
                        <CardBox class="ml-2 w-1/5">
                            <FormField class="w-full" label="Select Categories">
                                <div class="overflow-y-auto max-h-[150px]">
                                    <FormCheckRadioGroup componentClass="w-full" v-model="form.categories" name="categories[]" type="checkbox"
                                    :options="categoryData" />
                                </div>
                            </FormField>

                            <FormField label="Tags" label-for="tag" help="Please write tag (add multiple tags seperated by coma.)">
                                <FormControl
                                    v-model="form.tags"
                                    id="tag"
                                    autocomplete="tag"
                                    type="text"
                                    required
                                />
                            </FormField>

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
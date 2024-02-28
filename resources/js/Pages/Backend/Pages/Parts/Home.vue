<script setup lang='ts'>

import FormField from '@/Components/FormField.vue'
import FormControl from '@/Components/FormControl.vue'
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue'
import BaseButtonLink from '@/Components/BaseButtonLink.vue'



defineProps({
    row: {
        type: Object,
        required: true
    },
    sectionIndex: {
        type: Number,
        required: true
    },
})

const emit = defineEmits(['toggleSection'])

const onToggleSection = (sectionIndex: number) => {
    emit('toggleSection', sectionIndex)
}

</script>

<template>
    <SectionTitleLineWithButton :title="row.name" main>
        <BaseButtonLink class="mr-1" :icon="row.hidden ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"
                @click="onToggleSection(sectionIndex)" :label="row.hidden ? 'Show' : 'Hide'" color="contrast" rounded-full
                small />
    </SectionTitleLineWithButton>
    <div v-show="!row.hidden" v-for="(data, rowIndex) in row.data" :key="rowIndex + sectionIndex"
        class="mb-2 flex-col justify-end items-end h-full">
        <div class="w-full mb-7 p-5 bg-slate-900 rounded">
            <FormField :label="'Title: ' + data.title" :label-for="'headline-' + (rowIndex + sectionIndex)">
                <FormControl v-model="data.title" :id="'headline-' + (rowIndex + sectionIndex)" placeholder="Title here"
                    type="text" required />
            </FormField>
            <FormField label="Subtitle" :label-for="'subtitle-' + (rowIndex + sectionIndex)">
                <FormControl v-model="data.subtitle" :id="'subtitle-' + (rowIndex + sectionIndex)"
                    placeholder="Subtitle here" type="text" />
            </FormField>
            <FormField label="Description" :label-for="'description-' + (rowIndex + sectionIndex)">
                <FormControl v-model="data.description" :id="'description-' + (rowIndex + sectionIndex)"
                    placeholder="Description here" type="textarea" required />
            </FormField>
        </div>
    </div>
</template>
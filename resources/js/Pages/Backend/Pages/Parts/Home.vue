<script setup lang='ts'>

import FormField from '@/Components/FormField.vue'
import FormControl from '@/Components/FormControl.vue'
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue'
import BaseButtons from '@/Components/BaseButtons.vue'
import BaseButtonLink from '@/Components/BaseButtonLink.vue'
import FormFilePicker from '@/Components/FormFilePicker.vue'


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

const emit = defineEmits(['toggleSection', 'addRow', 'removeRow' ])

const onAddRow = (sectionIndex: number) => {
    emit('addRow', sectionIndex)
}

const onRemoveRow = (sectionIndex: number, rowIndex: number) => {
    emit('removeRow', sectionIndex, rowIndex)
}

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
        <div class="w-full mb-7 p-5 dark:bg-slate-900 bg-gray-100 rounded">
            <BaseButtons class="mt-auto justify-end" v-if="row.slug === 'slider'">
                <BaseButtonLink class="mr-1" icon="fas fa-plus" @click="onAddRow(sectionIndex)" label="Add Row"
                    color="contrast" rounded-full small />
                <BaseButtonLink v-if="rowIndex > 0" icon="fas fa-minus" @click="onRemoveRow(sectionIndex, rowIndex)"
                    label="Remove Row" color="danger" rounded-full small />
            </BaseButtons>

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

            <FormField v-if="row.slug === 'slider'" label="Image" help="Max 500kb">
                <FormFilePicker :key="data.imageKey" label="Upload Image" :modelValue="data.image" color="success"
                    @update:modelValue="data.image = $event" />
            </FormField>

        </div>
    </div>
</template>
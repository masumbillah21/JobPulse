<script setup lang='ts'>
import { ref } from 'vue'
import FormField from '@/Components/FormField.vue'
import FormControl from '@/Components/FormControl.vue'
import BaseButtons from '@/Components/BaseButtons.vue'
import BaseButtonLink from '@/Components/BaseButtonLink.vue'
import FormFilePicker from '@/Components/FormFilePicker.vue'
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue'
import { mdiPlus, mdiMinus, mdiChevronUp, mdiChevronDown } from '@mdi/js'


defineProps({
    row: {
        type: Object,
        required: true
    },
    sectionIndex: {
        type: Number,
        required: true
    },
    imagePosition: {
        type: Array,
        required: true
    }
})

const emit = defineEmits(['addRow', 'removeRow', 'addSection', 'removeSection', 'toggleSection'])

const onAddRow = (sectionIndex: number) => {
    emit('addRow', sectionIndex)
}

const onRemoveRow = (sectionIndex: number, rowIndex: number) => {
    emit('removeRow', sectionIndex, rowIndex)
}

const onAddSection = (sectionIndex: number) => {
    emit('addSection', sectionIndex)
}

const onRemoveSection = (sectionIndex: number) => {
    emit('removeSection', sectionIndex)
}

const onToggleSection = (sectionIndex: number) => {
    emit('toggleSection', sectionIndex)
}


</script>

<template>
    <SectionTitleLineWithButton :title="row.name" main>
        <BaseButtons>
            <BaseButtonLink class="mr-1" :icon="mdiPlus" @click="onAddSection" label="Add Section" color="contrast"
                rounded-full small />
            <BaseButtonLink v-if="sectionIndex > 0" :icon="mdiMinus" @click="onRemoveSection(sectionIndex)"
                label="Remove Section" color="danger" rounded-full small />
            <BaseButtonLink class="mr-1" :icon="row.hidden ? mdiChevronDown : mdiChevronUp"
                @click="onToggleSection(sectionIndex)" :label="row.hidden ? 'Show' : 'Hide'" color="contrast" rounded-full
                small />
        </BaseButtons>
    </SectionTitleLineWithButton>

    <div v-show="!row.hidden" v-for="(data, rowIndex) in row.data" :key="rowIndex + sectionIndex"
        class="mb-2 flex-col justify-end items-end h-full">
        <div class="w-full mb-7 p-5 bg-slate-900 rounded">
            <BaseButtons class="mt-auto justify-end">
                <BaseButtonLink class="mr-1" :icon="mdiPlus" @click="onAddRow(sectionIndex)" label="Add Row"
                    color="contrast" rounded-full small />
                <BaseButtonLink v-if="rowIndex > 0" :icon="mdiMinus" @click="onRemoveRow(sectionIndex, rowIndex)"
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
            <div class="flex flex-row justify-between items-center">
                <FormField label="Image" help="Max 500kb">
                    <FormFilePicker :key="data.imageKey" label="Upload Image" :modelValue="data.image" color="success"
                        @update:modelValue="data.image = $event" />
                </FormField>

                <FormField class="ml-auto w-auto" label="Image Position">
                    <FormControl v-model="data.imagePosition" :options="imagePosition" />
                </FormField>
            </div>
        </div>
    </div>
</template>
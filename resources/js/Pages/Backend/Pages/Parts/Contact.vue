<script setup lang='ts'>
import { ref } from 'vue'
import FormField from '@/Components/FormField.vue'
import FormControl from '@/Components/FormControl.vue'
import BaseButtons from '@/Components/BaseButtons.vue'
import BaseButtonLink from '@/Components/BaseButtonLink.vue'
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue'


defineProps({
    row: {
        type: Object,
        required: true
    },
    sectionIndex: {
        type: Number,
        required: true
    },
    iconList: {
        type: Array,
        required: true
    }
})

const emit = defineEmits(['addRow', 'removeRow', 'toggleSection'])

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

    <template v-if="!row.hidden">
        <div v-if="row.slug === 'banner'" class="w-full mb-7 p-5 bg-slate-900 rounded">
            <FormField :label="'Title: ' + row.data[sectionIndex].title" label-for="'headline-banner'">
                <FormControl v-model="row.data[sectionIndex].title" id="'headline-banner" placeholder="Title here"
                    type="text" required />
            </FormField>
            <FormField label="Subtitle" label-for="'subtitle-banner">
                <FormControl v-model="row.data[sectionIndex].subtitle" id="'subtitle-banner"
                    placeholder="Subtitle here" type="text" />
            </FormField>
            <FormField label="Description" label-for="'description-banner">
                <FormControl v-model="row.data[sectionIndex].description" id="'description-banner"
                    placeholder="Description here" type="textarea" required />
            </FormField>
        </div>
    </template>
    <div v-show="!row.hidden" v-for="(data, rowIndex) in row.data" :key="rowIndex + sectionIndex"
        class="mb-2 flex-col justify-end items-end h-full">
        <div class="w-full mb-7 p-5 bg-slate-900 rounded" v-if="row.slug !== 'banner'">
            <BaseButtons class="mt-auto justify-end">
                <BaseButtonLink class="mr-1" icon="fas fa-plus" @click="onAddRow(sectionIndex)" label="Add Row"
                    color="contrast" rounded-full small />
                <BaseButtonLink v-if="rowIndex > 0" icon="fas fa-minus" @click="onRemoveRow(sectionIndex, rowIndex)"
                    label="Remove Row" color="danger" rounded-full small />
            </BaseButtons>
            <FormField :label="'Title: ' + data.title" :label-for="'title-' + (rowIndex + sectionIndex)">
                <FormControl v-model="data.title" :id="'title-' + (rowIndex + sectionIndex)" placeholder="Title here"
                    type="text" required />
            </FormField>
            <FormField label="Info" :label-for="'info-' + (rowIndex + sectionIndex)">
                <FormControl v-model="data.info" :id="'info-' + (rowIndex + sectionIndex)" placeholder="Contact Info here"
                    type="text" required />
            </FormField>
            <FormField label="Choose Icon">
                <FormControl v-model="data.icon" :options="iconList" />
            </FormField>
        </div>
    </div>
</template>
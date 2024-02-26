<script setup lang='ts'>
import { ref } from 'vue'
import FormField from '@/Components/FormField.vue'
import FormControl from '@/Components/FormControl.vue'
import BaseButtons from '@/Components/BaseButtons.vue'
import BaseButtonLink from '@/Components/BaseButtonLink.vue'
import SectionTitle from '@/Components/SectionTitle.vue'


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

const emit = defineEmits(['addRow', 'removeRow'])

const onAddRow = (sectionIndex: number) => {
    emit('addRow', sectionIndex)
}

const onRemoveRow = (sectionIndex: number, rowIndex: number) => {
    emit('removeRow', sectionIndex, rowIndex)
}

</script>

<template>
    <SectionTitle :title="row.name" main />
    <div v-show="!row.hidden" v-for="(data, rowIndex) in row.data" :key="rowIndex + sectionIndex"
        class="mb-2 flex-col justify-end items-end h-full">
        <div class="w-full mb-7 p-5 bg-slate-900 rounded">
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
<script setup lang='ts'>

defineProps({
    subtitle: {
        type: String,
        default: null
    },
    title: {
        type: String,
        required: true
    },
    description: {
        type: String,
        default: null
    },
    sectionClass: {
        type: String,
        default: 'text-center'
    }
})


</script>

<template>
    <div class="pr-12" :class="sectionClass">
        <h4 v-if="subtitle"> {{ subtitle }} </h4>
        <h1 v-if="title" class="font-semibold text-5xl">
            {{ title }}
        </h1>
        <p v-if="description" class="mt-4 text-lg">
            {{ description }}
        </p>
    </div>
</template>
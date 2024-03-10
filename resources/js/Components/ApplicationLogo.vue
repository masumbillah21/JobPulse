<script setup lang='ts'>
import { usePage } from '@inertiajs/vue3'

const siteLogo = usePage().props.logo
const urls: any = usePage().props.urls

const siteTitle: any = usePage().props.siteTitle ?? 'JobPulse'

defineProps({
    logoSize: {
        type: String,
        default: '250',
    }
})
</script>

<template>
    <img v-if="siteLogo" :src="urls.storeUrl + '/' + siteLogo" :width="logoSize" :alt="siteTitle">
    <span v-else>{{ siteTitle }}</span>
</template>

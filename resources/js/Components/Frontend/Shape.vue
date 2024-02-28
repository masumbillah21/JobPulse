<script setup lang='ts'>
import { ref } from 'vue'
import { Head, router, usePage } from '@inertiajs/vue3'


defineProps({
    polygonClass: {
        type: String,
        default: 'text-gray-100'
    },
    sectionClass:{
        type: String,
        default: 'bottom-auto top-0 '
    }

})


</script>

<template>

    <div :class="sectionClass" class="left-0 right-0 w-full absolute pointer-events-none overflow-hidden -mt-20" style="height: 80px;">
        <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"
            version="1.1" viewBox="0 0 2560 100" x="0" y="0">
            <polygon class="fill-current" :class="polygonClass" points="2560 0 2560 100 0 100"></polygon>
        </svg>
    </div>


</template>
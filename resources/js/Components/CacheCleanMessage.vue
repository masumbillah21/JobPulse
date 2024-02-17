<script setup lang="ts">
    import BaseButtonLink from '@/Components/BaseButtonLink.vue'
    import NotificationBar from '@/Components/NotificationBar.vue'


    defineProps({
        message: {
            type: String,
            required: true
        },
        icon: {
            type: String,
            default: null
        },
    });

</script>
<template>
    <div>

        <NotificationBar v-if="message" class="mx-10 my-1" color="info" :icon="icon">
            <b>Cache:</b> {{ message }}
        </NotificationBar>

    </div>
</template>
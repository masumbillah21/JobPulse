<script setup>
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import NotificationBarInCard from "@/Components/NotificationBarInCard.vue";

const success = computed(() => usePage().props.session.success ?? '');
</script>

<template>
  <NotificationBarInCard v-if="success" color="success">
    <span>{{ success }}</span>
  </NotificationBarInCard>
</template>

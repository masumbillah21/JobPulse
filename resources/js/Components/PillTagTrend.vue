<script setup>
import { computed } from 'vue'
import PillTag from '@/Components/PillTag.vue'

const props = defineProps({
  trend: {
    type: String,
    required: true
  },
  trendType: {
    type: String,
    default: null
  },
  small: Boolean
})

const trendStyle = computed(() => {
  if (props.trendType === 'up') {
    return {
      icon: 'fas fa-chevron-up',
      style: 'success'
    }
  }

  if (props.trendType === 'down') {
    return {
      icon: 'fas fa-chevron-down',
      style: 'danger'
    }
  }

  if (props.trendType === 'alert') {
    return {
      icon: 'fas fa-exclamation-circle',
      style: 'warning'
    }
  }

  return {
    style: 'info'
  }
})
</script>

<template>
  <PillTag :label="trend" :color="trendStyle.style" :icon="trendStyle.icon" :small="small" />
</template>

<script setup>
import { useSlots, computed } from 'vue'
import BaseIcon from '@/Components/BaseIcon.vue'
import BaseButtonLink from '@/Components/BaseButtonLink.vue'
import IconRounded from '@/Components/IconRounded.vue'

defineProps({
  icon: {
    type: String,
    default: null
  },
  title: {
    type: String,
    required: true
  },
  main: Boolean
})

const hasSlot = computed(() => useSlots().default)
</script>

<template>
  <section :class="{ 'pt-6': !main }" class="mb-6 flex items-center justify-between">
    <div class="flex items-center justify-start">
      <IconRounded v-if="icon && main" :icon="icon" color="light" class="mr-3" bg />
      <BaseIcon v-else-if="icon" :path="icon" class="mr-2" size="20" />
      <h1 :class="main ? 'text-3xl' : 'text-2xl'" class="leading-tight">
        {{ title }}
      </h1>
    </div>
    <slot v-if="hasSlot" />
    <BaseButtonLink v-else icon="fas fa-cog" color="whiteDark" />
  </section>
</template>

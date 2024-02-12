<script setup>
import { containerMaxW } from '@/config.js'
import BaseLevel from '@/Components/BaseLevel.vue'

const year = new Date().getFullYear()
</script>

<template>
  <footer class="py-2 px-6" :class="containerMaxW">
    <BaseLevel>
      <div class="text-center">
        &copy; {{ year }} All rights reserved, H. M. Masum Billah
        <slot />
      </div>
    </BaseLevel>
  </footer>
</template>

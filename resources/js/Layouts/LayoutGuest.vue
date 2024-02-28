<script setup lang="ts">
import Navbar from '@/Components/Frontend/Navbar.vue'
import Footer from "@/Components/Frontend/Footer.vue";

</script>

<template>
  <div class="bg-gray-50 dark:bg-slate-800 dark:text-slate-100">
    <Navbar/>
    <div style="min-height: 90vh;">
      <slot />
    </div>
    <Footer />
  </div>
</template>

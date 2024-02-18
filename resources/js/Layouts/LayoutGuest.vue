<script setup lang="ts">
import Navbar from '@/Components/Frontend/Navbar.vue'
import Footer from "@/Components/Frontend/Footer.vue";
defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
})

</script>

<template>
  <div class="bg-gray-50 dark:bg-slate-800 dark:text-slate-100">
    <Navbar :canLogin="canLogin" :canRegister="canRegister"/>
    <slot />
    <Footer />
  </div>
</template>

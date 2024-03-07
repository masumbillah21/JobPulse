<script setup>
import { computed, ref, onMounted } from 'vue'
import { useMainStore } from '@/Stores/main'
import * as chartConfig from '@/Components/Charts/chart.config.js'
import LineChart from '@/Components/Charts/LineChart.vue'
import SectionMain from '@/Components/SectionMain.vue'
import CardBoxWidget from '@/Components/CardBoxWidget.vue'
import CardBox from '@/Components/CardBox.vue'
import BaseButtonLink from '@/Components/BaseButtonLink.vue'
import CardBoxTransaction from '@/Components/CardBoxTransaction.vue'
import CardBoxClient from '@/Components/CardBoxClient.vue'
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue'
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue'
import SectionTitle from '@/Components/SectionTitle.vue'
import { Head, usePage } from '@inertiajs/vue3'


const totalEmployees = usePage().props.totalEmployees ?? 0

const totalCompanies = usePage().props.totalCompanies ?? 0

const totalJobs = usePage().props.totalJobs ?? 0

const totalCandidates = usePage().props.totalCandidates ?? 0

const chartInfo = usePage().props.chartInfo ?? []



const chartData = ref(null)

const fillChartData = () => {
  chartData.value = chartConfig.chartTemplate()
  chartInfo.data.forEach((item, index) => {
    chartData.value.datasets[index].data = item
  })
}

onMounted(() => {
  fillChartData()
})

</script>

<template>
  <LayoutAuthenticated>
    <Head title="Dashboard" />
    <SectionMain>
      <SectionTitle icon="fas fa-sliders-h" title="Overview" main/>

      <div class="grid grid-cols-1 gap-6 lg:grid-cols-4 mb-6">
        <CardBoxWidget
          color="text-emerald-500"
          icon="fas fa-users"
          :number="totalEmployees"
          label="Employees"
        />
        <CardBoxWidget
          color="text-blue-500"
          icon="fas fa-building"
          :number="totalCompanies"
          label="Companies"
        />
        <CardBoxWidget
          color="text-red-500"
          icon="fas fa-suitcase"
          :number="totalJobs"
          label="Jobs"
        />
        <CardBoxWidget
          color="text-red-500"
          icon="fas fa-users"
          :number="totalCandidates"
          label="Candiates"
        />
      </div>

      <SectionTitleLineWithButton icon="fas fa-chart-pie" title="This Year">
        <BaseButtonLink icon="fas fa-sync-alt" color="whiteDark" @click="fillChartData" />
      </SectionTitleLineWithButton>
      <CardBox class="mb-6">
        <div v-if="chartData">
          <line-chart :data="chartData" class="h-96" />
        </div>
      </CardBox>
    </SectionMain>
  </LayoutAuthenticated>
</template>

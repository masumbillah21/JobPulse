<script setup>
import { computed, ref, onMounted } from 'vue'
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
import { isCompanyUser } from '@/utils/isCompanyUser.js'
import { isCandidateUser } from '@/utils/isCandidateUser.js'
import { Head, usePage } from '@inertiajs/vue3'

const chartInfo = usePage().props.chartInfo
const totalEmployees = usePage().props.totalEmployees
const totalJobs = usePage().props.totalJobs
const totalCandidates = usePage().props.totalCandidates

const totalApplied = usePage().props.totalApplied
const totalSelected = usePage().props.totalSelected
const totalRejected = usePage().props.totalRejected

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

      <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 mb-6">
        <CardBoxWidget
          v-if="isCompanyUser()"
          color="text-emerald-500"
          icon="fas fa-users"
          :number="totalEmployees"
          label="Employees"
        />
        <CardBoxWidget
          v-if="isCompanyUser()"
          color="text-blue-500"
          icon="fas fa-building"
          :number="totalJobs"
          label="Jobs"
        />
        <CardBoxWidget
          v-if="isCompanyUser()"
          color="text-red-500"
          icon="fas fa-suitcase"
          :number="totalCandidates"
          label="Applications"
        />
        <CardBoxWidget
          v-if="isCandidateUser()"
          color="text-emerald-500"
          icon="fas fa-suitcase"
          :number="totalApplied"
          label="Applied"
        />
        <CardBoxWidget
          v-if="isCandidateUser()"
          color="text-blue-500"
          icon="fas fa-suitcase"
          :number="totalSelected"
          label="Selected"
        />
        <CardBoxWidget
          v-if="isCandidateUser()"
          color="text-red-500"
          icon="fas fa-suitcase"
          :number="totalRejected"
          label="Rejected"
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

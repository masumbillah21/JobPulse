<script setup lang='ts'>
import { ref, computed } from 'vue'
import FormField from '@/Components/FormField.vue';
import FormControl from '@/Components/FormControl.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    jobList: {
        type: [Object, Array],
        required: true,
    },
    allJobs: {
        type: [Object, Array],
        required: true,
    },
    displayTotal: {
        type: Number,
        default: 5
    }
});

const searchQuery = ref('');

const filterdJobList = computed(() => {
  if (!searchQuery.value) return props.jobList.slice(0, props.displayTotal);

  const query = searchQuery.value.toLowerCase();

  return props.allJobs?.filter((item: any) => {
    for (const key in item) {
      if (Object.prototype.hasOwnProperty.call(item, key)) {
        const value = item[key];
        if (typeof value === 'string' && value.toLowerCase().includes(query)) {
          return true;
        }
      }
    }
    return false;
  });
});


</script>

<template>
    <div class="mt-1 mb-10 w-full">
        <FormField help="Search your job">
            <FormControl
                inputClass="dark:bg-white dark:text-black"
                v-model="searchQuery"
                id="name"
                icon="fas fa-search"
                autocomplete="name"
                type="text"
                placeholder="Search...."
                required
            />
        </FormField>
        <div v-for="(job, index) in filterdJobList" :key="index" class="border rounded mb-2 p-3 shadow-sm shadow-slate-300 py-6 px-3">
            <Link class="flex items-center justify-between" :href="route('job.show', job.slug)">
                <div>
                    <p><span class="text-xl font-bold">{{ job.title }}</span> | <span class="inline-block bg-blue-950 rounded-full px-3 py-1 text-sm font-semibold text-white mr-2 mb-2">{{ job.job_type }}</span> | <span class="inline-block bg-green-800 rounded-full px-3 py-1 text-sm font-semibold text-white mr-2 mb-2">{{ job.work_type }}</span> | <span class="inline-block bg-black rounded-full px-3 py-1 text-sm font-semibold text-white mr-2 mb-2">{{ job.company.name }}</span></p>
                    <p>{{ job.description.split(" ").slice(0, 20).join(" ") }}</p>
                    <p v-for="skill in job.skills.split(',')" class="mt-4 inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{ skill }}</p>
                </div>
                <div class="text-right">
                    <span class="inline-block bg-red-700 rounded-full px-3 py-1 text-sm font-semibold text-white mr-2 mb-2">Deadline: {{ job.closing_date }}</span>
                    <p class="pr-2">${{ job.salary }}</p>
                </div>
            </Link>
        </div>
    </div>
</template>
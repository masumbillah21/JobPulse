<script setup lang='ts'>
    import { ref, onMounted } from 'vue'
    import SectionTitle from '@/Components/Frontend/SectionTitle.vue';
    import BannerSection from '@/Components/Frontend/BannerSection.vue';
    import { usePage } from '@inertiajs/vue3';

    const urls: any = usePage().props.urls
    const props = defineProps({
        sliderData: {
            type: Array as () => Array<{ image: string; title: string; subtitle: string; description: string }>,
            required: true
        }
    });

    const active = ref(0);

    onMounted(() => {
        let i = 0;
        setInterval(() => {
            if (i > props.sliderData.length - 1) {
                i = 0;
            }
            active.value = i;
            i++;
        }, 5000);
    });
</script>

<template>
    <div class="relative slide">
        <div class="carousel-indicators absolute bottom-0 flex bg-stone-800 h-24 w-full justify-center items-center">
            <ol class="z-50 flex w-4/12 justify-center">
                <li v-for="(_, i) in sliderData" :key="i"
                    class="md:w-4 md:h-4 bg-gray-300 rounded-full cursor-pointer mx-2" @click="active = i" :class="`${active === i ? 'bg-slate-800 dark:bg-gray-600' : ''}`"></li>
            </ol>
        </div>
        <div class="carousel-inner relative overflow-hidden w-full">
            <div v-for="(slider, i) in sliderData" :key="i"
                :class="{ 'active': active === i }"
                class="carousel-item inset-0 absolute w-full opacity-0 transition-opacity duration-500 ease-linear"
                :style="`background-image: url( ${urls.storeUrl}/${slider.image})`"
                style="background-position: center; background-size: cover;">
                <BannerSection :bgImage="slider.image" banerHeight="70vh">
                    <SectionTitle :title="slider.title" :subtitle="slider.subtitle" :description="slider.description"/>
                </BannerSection>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .carousel-item.active {
        display: block;
        position: relative;
        opacity: 1;
        z-index: 1;
    }
</style>

<script setup lang='ts'>
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const urls: any = usePage().props.urls

const props = defineProps({
    bgImage:{
        type: String,
        default: 'images/job-portal-banner.jpg'
    },
    backgroundSize: {
        type: String,
        default: 'cover'
    },
    banerHeight: {
        type: String,
        default: '45vh'
    }
})

const imageUrl = ref('')

if(props.bgImage && (props.bgImage.startsWith('http://') || props.bgImage.startsWith('https://'))) {
    imageUrl.value =  props.bgImage
}else if(props.bgImage && props.bgImage.startsWith('data:')){
  imageUrl.value = props.bgImage
}else{
  imageUrl.value =  urls.storeUrl + '/' + props.bgImage
}



</script>

<template>
    <div class="relative pt-16 pb-32 flex content-center items-center justify-center" :style="`min-height: ${banerHeight};`">
        <div class="absolute top-0 w-full h-full bg-center bg-cover" style="background-repeat: no-repeat; background-position: center;"
        :style="'background-image: url(' + imageUrl + '); background-size: ' + backgroundSize + ';'">
          <span id="blackOverlay" class="w-full h-full absolute opacity-75 bg-black left-0"></span>
        </div>
        <div class="container relative mx-auto">
          <div class="items-center flex flex-wrap">
            <div class="w-full lg:w-6/12 px-4 ml-auto mr-auto text-center text-white">
              <slot />
            </div>
          </div>
        </div>
      </div>
</template>
<script setup lang='ts'>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'

defineProps({
    post: Object
})
</script>

<template>
    <Link :href="route('blog.show', post?.slug)" class="bg-white shadow rounded mb-3">
        <img :src="post?.image" class="rounded h-60 w-full" :alt="post?.title"  />
        <div class="p-4 text-slate-900">
        <h1 v-html="post?.title.substring(0,40)" class="font-semibold text-xl">
        </h1>
        <div v-html="post?.body.substring(0,160)+'..'" class="text-sm text-ellipsis text-left mt-2" >
        </div>
        <p class="text-right mt-2 text-slate-800 font-semibold">
            Read More <i class="fas fa-angle-double-right"></i>
        </p>
        </div>
    </Link>

</template>
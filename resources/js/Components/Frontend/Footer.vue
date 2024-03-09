<script setup lang="ts">
  import Shape from './Shape.vue';

  const date = new Date().getFullYear()
</script>

<template>
  <footer class="relative pt-8 pb-6 bg-white dark:bg-slate-800">
    <div class="container mx-auto px-4">
      <div class="flex flex-wrap">
        <div class="w-full lg:w-6/12 px-4">
          <h4 class="text-3xl font-semibold">Let's keep in touch!</h4>
          <h5 class="text-lg mt-0 mb-2 text-gray-400">
            Find us on any of these platforms, we respond 1-2 business days.
          </h5>
        </div>
        <div class="w-full lg:w-6/12 px-4">
          <div class="flex flex-wrap items-top mb-6">
            <div class="w-full lg:w-4/12 px-4 ml-auto">
              <span class="block uppercase dark:text-gray-100 text-gray-700 text-sm font-semibold mb-2">Follow Me</span>
              <div class="mt-6">
                <a href="https://facebook.com/masumbillah21"
                  class="bg-white text-blue-600 shadow-lg font-normal h-10 w-10 items-center justify-center align-center rounded-full outline-none focus:outline-none mr-2 px-3 py-2">
                  <i class="flex fab fa-facebook-square"></i>
                </a>

                <a href="https://bd.linkedin.com/in/h-m-masum-billah"
                  class="bg-white text-blue-500 shadow-lg font-normal h-10 w-10 items-center justify-center align-center rounded-full outline-none focus:outline-none mr-2 px-3 py-2">
                  <i class="flex fab fa-linkedin"></i>
                </a>

                <a href="https://github.com/masumbillah21"
                  class="bg-white text-black shadow-lg font-normal h-10 w-10 items-center justify-center align-center rounded-full outline-none focus:outline-none mr-2 px-3 py-2">
                  <i class="flex fab fa-github"></i>
                </a>
                <a href="http://masum-billah.com"
                  class="bg-white text-black shadow-lg font-normal h-10 w-10 items-center justify-center align-center rounded-full outline-none focus:outline-none mr-2 px-3 py-2">
                  <i class="flex fas fa-globe"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <hr class="my-6 border-gray-400" />
      <div class="flex flex-wrap items-center md:justify-between justify-center">
        <div class="w-full md:w-4/12 px-4 mx-auto text-center">
          <div class="text-sm text-gray-600 font-semibold py-1">
            © {{ date }} JobPulse by
            <a href="http://www.masum-billah.com" class="text-gray-600 hover:text-gray-900">H. M. Masum Billah</a>.
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>
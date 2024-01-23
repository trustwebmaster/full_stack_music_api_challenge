<template>
  <div
    class="w-full p-4 bg-gradient-to-r bg-white from-gray-900 via-gray-800 to-gray-600 sm:p-8">
    <div class="flex justify-between items-center sm:flex sm:space-y-0 sm:space-x-4">
      <div class="hidden lg:mt-0 lg:col-span-5 lg:flex ">

      </div>

      <div>
        <div class="grid grid-rows-3 grid-flow-col gap-4">
          <div class="row-span-3 ...">
            <slot name="name-rank"></slot>
          </div>
          <div class="col-span-2 ...">
            <slot name="artist"></slot>
          </div>
          <div class="row-span-2 col-span-2 ...">
          </div>
        </div>
      </div>


      <div class="hidden lg:mt-0 lg:col-span-5 lg:flex ">

      </div>

    </div>
  </div>
  <main>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
      <!-- Your content -->
      <div class="px-4 py-6 sm:px-0">
        <slot></slot>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  name: "PageViewHead"
}
</script>

<style scoped>

</style>

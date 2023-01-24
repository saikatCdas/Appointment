<template>
  <form class="flex items-center" @submit.prevent="search">
    <label for="simple-search" class="sr-only">Search</label>
    <div class="relative w-full">
      <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
        <svg aria-hidden="true" class="w-5 h-5text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
    </div>
      <input v-model="searchInp.search" type="text" id="simple-search" class=" border text-sm rounded-l-lg focus:ring-[0.5px] block w-full pl-10 p-2.5  bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500"
      placeholder="Search" required>
    </div>
    <button type="submit" class="p-2.5 text-sm font-medium text-white rounded-r-lg border border-blue-700 focus:ring-[0.5px] focus:outline-none bg-blue-600 hover:bg-blue-700 focus:ring-blue-600">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
      <span class="sr-only">Search</span>
    </button>
  </form>
</template>

<script setup>
import { ref } from "@vue/reactivity";

const searchInp = ref({
    search: ''
});

const emit = defineEmits(['search']);

function search(){
  emit('search', searchInp.value.search)
}

</script>

<style>

</style>

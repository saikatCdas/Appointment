<template>
  <!-- component -->
<div class="bg-yellow-100 h-screen overflow-hidden flex items-center justify-center">
  <p v-if="loading">Loading...</p>
  <div v-else class="bg-white md:6/12 w-10/12 shadow-3xl">
    <div class="absolute left-1/2 transform -translate-x-1/2 -translate-y-1/2 rounded-full">
      <svg v-if="!faculty.image_url" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-gray-600 rounded-full">
        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
      </svg>
      <img v-else :src="faculty.image_url" alt="" class="w-16 h-16 rounded-full">
    </div>
    <form class="p-12 md:p-24" @submit="acceptUser">
      <div class="text-lg mb-4 rounded-md">
        <label for="faculty-name" class="font-semibold text-gray-700 mb-2 ml-1">Name</label>
        <input v-model="faculty.name" type="text" id="faculty-name" class=" rounded-md border-gray-300 pl-2 focus:outline-none w-full" disabled/>
      </div>
      <div class="text-lg mb-4 rounded-md">
        <label for="faculty-department" class="font-semibold text-gray-700 mb-2 ml-1">Department</label>
        <input v-model="faculty.department" type="text" id="faculty-department" class=" rounded-md border-gray-300 pl-2 focus:outline-none w-full" disabled/>
      </div>
      <div class="text-lg mb-4 rounded-md">
        <label for="faculty-courses" class="font-semibold text-gray-700 mb-2 ml-1">Courses</label>
        <input v-model="faculty.course" type="text" id="faculty-courses" class=" rounded-md border-gray-300 pl-2 focus:outline-none w-full" disabled/>
      </div>
      <div class="text-lg mb-4 rounded-md">
        <label for="faculty-position" class="font-semibold text-gray-700 mb-2 ml-1">Position</label>
        <input v-model="faculty.position" type="text" id="faculty-position" class=" rounded-md border-gray-300 pl-2 focus:outline-none w-full" required placeholder="User Position" />
      </div>
      <button class="bg-gradient-to-b from-sky-400 to-sky-600 font-medium p-2 md:p-4 text-white uppercase w-full">Submit</button>
    </form>
  </div>
 </div>
</template>

<script setup>
import { onMounted, ref } from "@vue/runtime-core";
import { useRoute, useRouter } from "vue-router";
import store from "../../store";


const loading = ref(false);
const faculty = ref({})
const route = useRoute();
const router = useRouter();
onMounted(()=>{
  loading.value = true;
  store.dispatch('facultyMember', route.query.id)
      .then(()=>{
        faculty.value =  store.state.facultyMemberData;
        loading.value = false;
   })
})

function acceptUser(ev){
  ev.preventDefault();
  store.dispatch('acceptUser', faculty.value)
  .then(()=>{
    router.back();
  })
}
</script>

<style>

</style>

<template>
  <!-- component -->
  <div class="flex justify-center bg-gradient-to-t from-[#e7e9fe] via-[#c8ebfd] to-[#e7e9fe]  min-h-screen h-full p-6">
      <div class="flex flex-col bg-transparent rounded-lg flex-none max-w-7xl max-h-fit ">
        <div v-for="(user,index) in users" :key="index"  class="flex flex-col space-y-2 shadow-lg rounded-md">
          <div class="flex justify-between space-x-6 items-center p-6 ml-2 my-2 bg-white rounded-md">
            <div class="max-sm:flex-col sm:space-x-4 max-sm:space-y-3 flex justify-center items-center ">
              <img :src="user.image_url" class="rounded-full h-14 w-14" alt="">
              <div class="flex flex-col max-sm:items-center  space-y-2 ">
                <a :href="`/profile/${user.id}`" class=" font-bold text-lg text-blue-600 hover:text-blue-800 underline">{{ user.name }}</a>
                <p class="text-gray-700">{{ user.role }}</p>
                <p class="text-sm text-gray-700">{{ user.department }}</p>
              </div>
              <div>
                <a :href="`/make-appointment/${user.id}`" class="text-center bg-blue-500 hover:bg-blue-700 text-white shadow-sm px-4 py-2 rounded text-lg space-x-2 transition duration-100">
                    Make an appointment
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>
</template>

<script setup>
import { computed, onMounted } from "@vue/runtime-core";
import { useRoute } from "vue-router";
import store from "../store";


const users = computed(()=> store.state.searchData);
const route = useRoute();

onMounted(()=>{
  if(Object.keys(users.value).length === 0 && route.params.slug) {
    store.dispatch('search', route.params.slug);
  }
})
</script>

<style>

</style>

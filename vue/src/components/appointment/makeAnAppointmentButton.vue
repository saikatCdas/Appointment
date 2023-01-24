<template>
    <div v-show="open" class="fixed bottom-0 right-0 w-full bottom-8 right-12 w-auto z-60" >
        <div class="bg-gray-800 text-gray-50 text-sm p-3 md:rounded shadow-lg flex justify-between">
            <div>👉
                <router-link class="hover:underline ml-1" :to="{name: 'MakeAppointment'}">Make An Appointment</router-link>
            </div>
            <button class="text-gray-500 hover:text-gray-400 ml-5" @click="open = false">
                        <span class="sr-only">Close</span>
                        <svg class="w-4 h-4 flex-shrink-0 fill-current" viewBox="0 0 16 16">
                            <path d="M12.72 3.293a1 1 0 00-1.415 0L8.012 6.586 4.72 3.293a1 1 0 00-1.414 1.414L6.598 8l-3.293 3.293a1 1 0 101.414 1.414l3.293-3.293 3.293 3.293a1 1 0 001.414-1.414L9.426 8l3.293-3.293a1 1 0 000-1.414z" />
                        </svg>
                    </button>
        </div>
    </div>
</template>

<script setup>
import { ref } from "@vue/reactivity";
import { onMounted } from "@vue/runtime-core";
import { useRoute } from "vue-router";

const open = ref(true)
const route = useRoute();


switch (route.name, open.value) {
  case route.name === 'Home':
    open.value = true;
    break;
  case route.name === 'Faculty':
    open.value = true;
    break;
  case route.name === 'Blogs':
    open.value = true;
    break;
  default:
    open.value = false;
}
</script>

<style>

</style>

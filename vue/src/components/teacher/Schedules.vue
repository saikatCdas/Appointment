<template>
  <div>
      <section class="flex flex-col antialiased bg-gray-100 text-gray-600 min-h-screen  p-4">
          <div class="h-full">
            <h1 v-if="loading" class="text-gray-800 font-bold text-center">Loading...</h1>
              <!-- Table -->
              <div v-else class="w-full max-w-4xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200">
                  <header class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                      <h2 class="font-semibold text-2xl text-gray-800">Schedules</h2>
                  </header>
                  <div class="p-3">
                      <div class="overflow-x-auto">
                          <table class=" w-full h-full">
                              <thead class="text-xs font-semibold uppercase h-10 text-center text-gray-400 bg-gray-50">
                                  <tr>
                                      <th class="p-2 whitespace-nowrap">
                                          <div class="font-semibold text-left">Date</div>
                                      </th>
                                      <th class="p-2 whitespace-nowrap">
                                          <div class="font-semibold text-left">Time</div>
                                      </th>
                                      <th class="p-2 whitespace-nowrap">
                                          <div class="font-semibold text-left">Status</div>
                                      </th>
                                      <th class="p-2 whitespace-nowrap">
                                          <div class="font-semibold text-left">Max Applicant</div>
                                      </th>
                                      <th class="p-2 whitespace-nowrap">
                                          <div class="font-semibold text-left"></div>
                                      </th>
                                  </tr>
                              </thead>
                              <tbody class="text-sm divide-gray-100 min-h-screen">
                                  <tr v-for="(schedule, ind) in schedules" :key="ind" class="min-h-screen">
                                      <td class="p-2 whitespace-nowrap">
                                          <div class="text-left">{{ new Date(schedule.date).toLocaleDateString() }}</div>
                                      </td>
                                      <td class="p-2 whitespace-nowrap">
                                          <div class="text-left font-medium text-green-500">{{ new Date( "1970-01-01T" + schedule.fromTime).toLocaleTimeString()}}
                                            <span class="text-gray-900">To</span> {{ new Date( "1970-01-01T" + schedule.toTime).toLocaleTimeString()}}</div>
                                      </td>
                                      <td class="p-2 whitespace-nowrap">
                                          <div :class="[schedule.status === 'Available' ? 'text-green-600': 'text-red-600','text-sm'] ">{{ schedule.status }}</div>
                                      </td>
                                      <td class="p-2 whitespace-nowrap">
                                          <div class="text-sm flex items-center justify-between">
                                            <span class="text-gary-800 font-bold">{{ schedule.maxApplicant }}</span>
                                            <a :href="`/edit-schedule/${schedule.id}`" class="text-sm ">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                            </svg>
                                          </a>
                                          </div>
                                      </td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>
                  </div>
                  <Pagination
                    :paginationLinks="paginationLinks"
                    @getForPage="getForPage"
                  />
              </div>
          </div>
      </section>
  </div>
</template>

<script setup>
import { ref } from "@vue/reactivity";
import { onMounted } from "@vue/runtime-core";
import store from "../../store";
import Pagination from "../Pagination.vue";


const schedules = ref({});
const paginationLinks = ref({});
const loading = ref(false);
onMounted(()=>{
  loading.value = true;
  store.dispatch('getSchedule').
    then(()=>{
      loading.value = false;
      schedules.value = store.state.schedules;
      paginationLinks.value = store.state.paginationLinks;
      console.log(schedules.value);
    })
})

function getForPage(ev, link) {
  loading.value = true;
  ev.preventDefault();
  if (!link.url || link.active) {
    return;
  }
    store.dispatch('getSchedule', {url: link.url})
      .then((res) => {
        loading.value = false;
        schedules.value = store.state.schedules;
        paginationLinks.value = store.state.paginationLinks;
      });
}
</script>

<style>

</style>

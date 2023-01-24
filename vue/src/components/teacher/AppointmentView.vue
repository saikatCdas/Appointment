<template>
  <div>
      <section class="flex flex-col antialiased bg-gray-100 text-gray-600 min-h-screen  p-4">
          <div class="h-full">
            <h1 v-if="props.loading" class="text-gray-800 font-bold text-center">Loading...</h1>
              <!-- Table -->
              <div v-else class="w-full max-w-4xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200">
                  <header class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                      <h2 class="font-semibold text-2xl text-gray-800">{{ props.title }}</h2>
                  </header>
                  <div class="p-3">
                      <div class="overflow-x-auto">
                        <div class="flex flex-col min-h-screen h-full">
                          <div v-if="props.appointments.length === 0" class="text-center font-semibold text-lg">{{ props.message }}</div>
                        <div v-else v-for="(appointment, ind) in appointments" :key="ind"
                          class="relative flex flex-col mt-2 md:flex-row md:space-x-5 space-y-3 md:space-y-0 rounded-xl shadow-lg p-3 max-w-xs md:max-w-3xl mx-auto border border-white bg-white">
                          <div class="w-full md:w-1/3 bg-white grid place-items-center">
                            <img :src="appointment.applicant.image_url" alt="tailwind logo"  class="rounded-xl" />
                          </div>
                            <div class="w-full md:w-2/3 bg-white flex flex-col space-y-2 p-3">
                              <div class="flex justify-between item-center">
                                <p class="text-gray-500 font-medium hidden md:block">{{ appointment.applicant.role }}</p>
                                <p class="text-gray-500 font-medium hidden md:block">{{ appointment.applicant.department }}</p>

                              </div>
                              <a :href="`/profile/${appointment.applicant.id }`" class="font-black text-blue-700 underline md:text-3xl text-xl">{{ appointment.applicant.name }}</a>
                              <div>
                                <p class="text-md font-semibold">Meeting Date:  <span class="text-gray-700"> {{ new Date(appointment.date).toLocaleDateString() }}</span></p>
                                <p class="text-md font-semibold">Meeting Time:  <span class="text-gray-700"> {{ new Date( "1970-01-01T" + appointment.meeting_time).toLocaleTimeString() }}</span></p>
                              </div>
                              <p class="mt-2 text-lg font-semibold">Why wants to meet?</p>
                              <p class="md:text-lg text-gray-500 text-base">{{ appointment.description }}</p>
                              <div :class="props.button ?'flex justify-evenly': ''">
                                <button v-if="props.button" @click="acceptAppointment(appointment)" class="px-5 py-2 shadow-lg rounded-xl font-medium  bg-green-500 hover:bg-green-600 text-gray-50">{{ props.button }}</button>
                                <button @click="deleteAppointment(appointment.id)" class="px-5 py-2 shadow-lg rounded-xl font-medium  bg-red-500 hover:bg-red-600 text-gray-50">Delete</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
                  <Pagination
                    :paginationLinks="props.paginationLinks"
                    @getForPage="getForPage"
                  />
              </div>
          </div>
      </section>
  </div>
</template>

<script setup>
import store from '../../store';
import Pagination from '../Pagination.vue';

const props = defineProps(['title', 'appointments', 'loading', 'message', 'button', 'paginationLinks']);
const emit = defineEmits(['acceptAppointment', 'deleteAppointment', 'getForPage']);

function acceptAppointment(appointment){
  emit('acceptAppointment', appointment);
}

function deleteAppointment(id){
  if(confirm("Are you sure?? Action can't be undone!!!")){
    store.dispatch('rejectAppointment', id)
    .then(()=>{
      emit('deleteAppointment', id);
    })
  }
}


function getForPage(event, link){
emit('getForPage', event, link)
}

</script>

<style>

</style>

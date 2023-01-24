<template>
 <!-- component -->
<div class="flex flex-col min-h-screen h-full bg-gray-900">
	<div v-for="(appointment, ind) in appointments" :key="ind"
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
				<p class="md:text-lg text-gray-500 text-base">{{ appointment.description }}</p>
				<div class="flex justify-evenly">
          <button @click="acceptAppointment" class="px-5 py-2 shadow-lg rounded-xl font-medium  bg-green-500 hover:bg-green-600 text-gray-50">Accept</button>
          <button @click="rejectAppointment(appointment.id)" class="px-5 py-2 shadow-lg rounded-xl font-medium  bg-red-500 hover:bg-red-600 text-gray-50">Reject</button>
        </div>
			</div>
		</div>
	</div>
</template>

<script setup>
import { ref } from "@vue/reactivity";
import { computed, onMounted } from "@vue/runtime-core";
import { useRoute, useRouter } from "vue-router";
import store from "../../store";



const route = useRoute();
const router = useRouter();

const appointments = ref({});
onMounted(()=>{
  if(route.params.slug){
    store.dispatch('getAppointmentById', route.params.slug)
      .then(()=>{
        appointments.value = store.state.appointments
        console.log(appointments.value);
      })
    }else{
      store.dispatch('getAppointment')
      .then(()=>{
        appointments.value = store.state.appointments
      })
  }
})

function acceptAppointment(ev){
  ev.preventDefault();
  store.dispatch('acceptAppointment')
    .then(()=>{
      router.push({
        name: 'RequestForAppointment'
      })
    })
}
function rejectAppointment(id){
  if(confirm("Are you sure?? Action can't be undone!!!")){
    store.dispatch('rejectAppointment', id)
    .then(()=>{
      router.push({
        name: 'RequestForAppointment'
      })
    })
  }
}



</script>

<style>

</style>


<template>
  <AppointmentStudentView
    :title="title"
    :appointments="appointments"
    :paginationLinks="paginationLinks"
    :loading="loading"
    :message="message"
    @acceptAppointment="acceptAppointment"
    @deleteAppointment="deleteAppointment"
    @getForPage="getForPage"
  />
</template>

<script setup>
import { ref } from "@vue/reactivity";
import { computed, onMounted } from "@vue/runtime-core";
import { useRoute, useRouter } from "vue-router";
import store from "../../store";
import AppointmentStudentView from "./AppointmentStudentView.vue";


const route = useRoute();
const router = useRouter();
const title = "Today's Appointment";
const loading = ref(false)
const message = "You don't have any appointment request !!";
const paginationLinks = ref({});



const appointments = ref({});
onMounted(()=>{
  loading.value = true;
  store.dispatch('getTodaysAppointment')
  .then(()=>{
    loading.value = false;
    appointments.value = store.state.appointments
    paginationLinks.value = store.state.paginationLinks;
  })
})

function deleteAppointment(id){
  appointments.value = appointments.value.filter((ap) => ap.id != id);
}

function getForPage(ev, link) {
  ev.preventDefault();
  loading.value = true;
  if (!link.url || link.active) {
    loading.value = false;
    return;
  }
  store.dispatch('getTodaysAppointment', {url: link.url})
    .then((res) => {
      loading.value = false;
      allFacultyMember.value = store.state.allFacultyMember;
      paginationLinks.value = store.state.paginationLinks;
    });
}

</script>

<style>

</style>

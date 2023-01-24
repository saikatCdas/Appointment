<template>
  <AppointmentView
    :title="title"
    :appointments="appointments"
    :paginationLinks="paginationLinks"
    :loading="loading"
    :message="message"
    @deleteAppointment="deleteAppointment"
    @getForPage="getForPage"
  />
</template>

<script setup>
import { ref } from "@vue/reactivity";
import { computed, onMounted } from "@vue/runtime-core";
import { useRoute, useRouter } from "vue-router";
import store from "../../store";
import AppointmentView from "./AppointmentView.vue";



const route = useRoute();
const router = useRouter();
const title = "Upcoming Appointment";
const loading = ref(false)
const message = "You don't have any appointment request !!";
const paginationLinks = ref({});
const appointments = ref({});


onMounted(()=>{
  loading.value = true;
  store.dispatch('getUpcomingAppointment')
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
  loading.value = true;
  ev.preventDefault();
  if (!link.url || link.active) {
    loading.value = false;
    return;
  }
  store.dispatch('getUpcomingAppointment', {url: link.url})
    .then((res) => {
      loading.value = false;
      allFacultyMember.value = store.state.allFacultyMember;
      paginationLinks.value = store.state.paginationLinks;
    });
}

</script>

<style>

</style>

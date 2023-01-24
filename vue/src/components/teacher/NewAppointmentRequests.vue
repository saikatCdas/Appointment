<template>
  <AppointmentView
    :title="title"
    :appointments="appointments"
    :paginationLinks="paginationLinks"
    :button="button"
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
import AppointmentView from "./AppointmentView.vue";



const route = useRoute();
const router = useRouter();
const title = 'New Appointment Request';
const loading = ref(false)
const button = 'Accept';
const message = "You don't have any appointment request !!";
const paginationLinks = ref({});



const appointments = ref({});
onMounted(()=>{
  loading.value = true;
  if(route.params.slug){
    store.dispatch('getAppointmentById', route.params.slug)
      .then(()=>{
        loading.value = false;
        appointments.value = store.state.appointments;
        paginationLinks.value = store.state.paginationLinks;
      })
    }else{
      store.dispatch('getNewAppointment')
      .then(()=>{
        loading.value = false;
        appointments.value = store.state.appointments
        paginationLinks.value = store.state.paginationLinks;
      })
  }
})

function acceptAppointment(appointment){
  loading.value = true;
  store.dispatch('acceptAppointment', appointment)
    .then(()=>{
      loading.value = false;
      appointments.value = appointments.value.filter((ap) => ap.id != appointment.id);

    })
}

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
  store.dispatch('getNewAppointment', {url: link.url})
    .then((res) => {
      loading.value = false;
      allFacultyMember.value = store.state.allFacultyMember;
      paginationLinks.value = store.state.paginationLinks;
    });
}

</script>

<style>

</style>

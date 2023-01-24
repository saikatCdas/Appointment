<template>
  <div class="bg-gray-900 pb-[0.1px]">
      <div class=" max-w-7xl mx-auto min-h-screen h-full ">
          <DashboardNavigation :navigation="navigation"/>

          <router-view></router-view>
      </div>
  </div>
</template>

<script setup>
import { ref } from '@vue/reactivity';
import DashboardNavigation from './DashboardNavigation.vue';
const navigation = [
  { name: 'New Appointment Requests', to: { name: 'NewAppointmentRequests' } },
  { name: "Today's Appointments", to: { name: 'TodayAppointment' } },
  { name: "Upcoming Appointments", to: { name: 'UpcomingAppointment' } },
  { name: 'Schedules', to: { name: 'ScheduleView'} },
  { name: 'Make Schedule', to: { name: 'MakeScheduleForAppointment' } },
];

</script>

<style>

</style>

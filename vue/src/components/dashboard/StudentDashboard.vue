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
  { name: 'Requests For Appointment', to: { name: 'StudentRequestForAppointment' } },
  { name: "Today's Appointments", to: { name: 'StudentTodayAppointment' } },
  { name: "Upcoming Appointments", to: { name: 'StudentUpcomingAppointment' } },
];

</script>

<style>

</style>

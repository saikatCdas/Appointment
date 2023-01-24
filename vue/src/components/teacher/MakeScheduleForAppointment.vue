<template>
  <!-- component -->
  <div class="flex bg-gray-200 items-center justify-center p-12">
    <div class="mx-auto w-full max-w-[550px]">
      <h1 class="text-2xl text-center text-gray-700 font-bold mb-4">Make Schedule For Appointment</h1>
      <hr class="mb-3">
      <form @submit="createSchedule">
        <div class="-mx-3 flex flex-wrap">
          <div class="w-full px-3 sm:w-1/2">
            <div class="mb-5">
              <label
                for="fromDate"
                class="mb-3 block text-base font-medium text-[#07074D]"
              >
              From date
              </label>
              <input v-model="schedule.fromDate"
                type="date"
                name="fromDate"
                id="fromDate"
                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
              />
            </div>
          </div>
          <div class="w-full px-3 sm:w-1/2">
            <div class="mb-5">
              <label
                for="toDate"
                class="mb-3 block text-base font-medium text-[#07074D]"
              >
              To date
              </label>
              <input v-model="schedule.toDate"
                type="date"
                name="toDate"
                id="toDate"
                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
              />
            </div>
          </div>
        </div>
        <div class="-mx-3 flex flex-wrap">
          <div class="w-full px-3 sm:w-1/2">
            <div class="mb-5">
              <label
                for="fromTime"
                class="mb-3 block text-base font-medium text-[#07074D]"
              >
                From
              </label>
              <input v-model="schedule.fromTime"
                type="time"
                name="fromTime"
                id="fromTime"
                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
              />
            </div>
          </div>
          <div class="w-full px-3 sm:w-1/2">
            <div class="mb-5">
              <label
                for="toTime"
                class="mb-3 block text-base font-medium text-[#07074D]"
              >
                To
              </label>
              <input v-model="schedule.toTime
              "
                type="time"
                name="toTime"
                id="time"
                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
              />
            </div>
          </div>
        </div>
        <div class="-mx-3 flex flex-wrap">
          <div class="w-full px-3 sm:w-1/2">
            <div class="mb-5">
              <label
                for="maxApplicant"
                class="mb-3 block text-base font-medium text-[#07074D]"
              >
                Max applicant in each day
              </label>
              <input v-model="schedule.maxApplicant"
                type="number"
                name="maxApplicant"
                id="maxApplicant"
                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
              />
            </div>
          </div>
        </div>

        <div class="-mx-3 flex flex-wrap">
          <div class="w-full px-3 sm:w-1/2">
            <div class="mb-5">
              <p
                for="time"
                class="mb-3 block text-base font-medium text-[#07074D]"
              >
                Off Day
            </p>
              <div v-for="day in days" :key="day" class="flex items-start mb-6">
                <div class="flex items-center h-5">
                  <input v-model="schedule.offDays" :id="day" :aria-describedby="day" type="checkbox" class="bg-gray-50 border-gray-300 focus:ring-3 focus:ring-blue-300 h-4 w-4 rounded" :value="day" >
                </div>
                <div class="text-sm ml-3">
                  <label :for="day" class="font-medium text-gray-900">{{ day }}</label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div>
          <button
            class="hover:shadow-form rounded-md bg-[#6A64F1] py-3 px-8 text-center text-base font-semibold text-white outline-none"
          >
            Create
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from "@vue/reactivity";
import { useRouter } from "vue-router";
import store from "../../store";


const router = useRouter();
const days = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
const schedule = ref({
  fromDate: null,
  toDate: null,
  fromTime: null,
  toTime: null,
  maxApplicant: null,
  offDays: []
});

function createSchedule (ev){
  ev.preventDefault();
  store.dispatch('createSchedule', schedule.value)
    .then(()=>{
      router.push({
        name: 'TeacherDashboard'
      })
    })
}
</script>

<style>

</style>

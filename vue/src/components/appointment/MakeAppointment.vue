<template>
  <div class="flex items-center justify-center">
    <div class="w-full max-w-md space-y-8 shadow-md mt-8 pb-8">
      <div>
        <img class="mx-auto h-12 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company" />
        <div class="mt-6 text-center font-bold tracking-tight">
          <h2 class=" text-3xl text-gray-900 mb-3">Make an appointment</h2>
        </div>
      </div>
      <div>
      </div>
      <form class="mt-8 space-y-6" @submit="appointment">
        <div class="space-y-2 p-2 rounded-md shadow-md">
          <div>
            <label for="departments" class="text-gray-600 font-semibold text-lg mx-2">Departments</label>
            <select @change="onDepartmentChange($event)" id="departments" @click="font = false" :class="[font ? 'text-gray-500' : 'text-gray-900', !teacher.department ? 'text-gray-300':'text-gray-900 ', inputClass]">
              <option value="" :class="route.params.slug ? 'hidden': ''" :selected="!teacher.department">Select your department</option>
              <option v-for="department in departments" :key="department" :value="department" :class="route.params.slug ? 'hidden' : ''" :selected=" teacher.department === department">{{ department }}</option>
            </select>
          </div>
          <div>
            <label for="teacher" class="text-gray-600 font-semibold text-lg mx-2">Teachers</label>
            <select @change="onTeacherChange($event)" id="teacher" @click="font = false" :class="[font ? 'text-gray-500' : 'text-gray-900', !teacher.name ? 'text-gray-300':'text-gray-900', inputClass]">
              <option value="" :class="route.params.slug? 'hidden' : ''" :selected="!teacher.name">Find Teacher</option>
              <option :value="teacher.id" :class="route.params.slug ? '': 'hidden'" :selected="route.params.slug">{{  teacher.name  }}</option>
              <option v-for="(tec, ind) in teachers" :key="ind" :value="tec.id" :class="route.params.slug ? 'hidden' : ''">{{ tec.name }}</option>
            </select>
          </div>
          <div>
            <label for="courses" class="text-gray-600 font-semibold text-lg mx-2">Courses</label>
            <input v-model="teacher.course" :class="[!teacher.course ? 'text-gray-300':'text-gray-900', inputClass]" id="courses" name="courses" type="text" autocomplete="courses" required=""  placeholder="Course" disabled/>
          </div>
          <div>
            <label for="teacher" class="text-gray-600 font-semibold text-lg mx-2">Available Dates</label>
            <select @change="onDateChose($event)" v-model="appointmentData.date" id="teacher" @click="font = false" :class="[font ? 'text-gray-500' : 'text-gray-900', !teacher.department ? 'text-gray-300':'text-gray-900 ', inputClass]">
              <option value="" :class="teacher.schedules ? 'hidden': ''" >Chose Date</option> -->
              <option v-for="(schedule, ind) in teacher.schedules" :key="ind" :value="schedule.date" :class="(schedule.status === 'Available') ? '': 'hidden'">{{ schedule.date }}</option>
            </select>
          </div>
          <div>
            <label for="meetingTime" class="text-gray-600 font-semibold text-lg mx-2">Meeting Time</label>
            <input :value=" meetingTime ? new Date( '1970-01-01T' + appointmentData.meeting_time).toLocaleTimeString() : ''" :class="[!teacher.course ? 'text-gray-300':'text-gray-900', inputClass]" id="meetingTime" name="meetingTime" type="text" autocomplete="meetingTime" required=""  placeholder="meetingTime" disabled/>
          </div>
          <div >
            <label for="about" class="text-gray-600 font-semibold text-lg mx-2">Description</label>
            <textarea v-model="appointmentData.description" id="about" rows="3" name="about" autocomplete="about" required="" :class="['text-gray-900 placeholder-gray-500 focus:z-10 focus:outline-none', inputClass]" placeholder="Why do you want to meet??" />
          </div>
        </div>

        <div>
          <button
            type="submit"
            :disabled="loading "
            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            :class="{
              'cursor-not-allowed': loading,
              'hover:bg-indigo-500': loading,
            }"
          >
            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
              <LockClosedIcon
                class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400"
                aria-hidden="true"
              />
            </span>
            <svg
              v-if="loading"
              class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
            >
              <circle
                class="opacity-25"
                cx="12"
                cy="12"
                r="10"
                stroke="currentColor"
                stroke-width="4"
              ></circle>
              <path
                class="opacity-75"
                fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
              ></path>
            </svg>
            Create
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { LockClosedIcon } from '@heroicons/vue/20/solid';
import { ref } from '@vue/reactivity';
import store from '../../store';
import {useRoute, useRouter} from 'vue-router';
import { computed, onMounted, watch, watchEffect } from '@vue/runtime-core';


const departments = ['Computer Science Engineering', "Electrical and Electronics Engineering","Civil Engineering","Mechanical Engineering"];
const inputClass = 'relative block w-full  appearance-none rounded-none border border-gray-300 mt-2 px-3 py-2 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm'

const router = useRouter();
const route = useRoute();
const font = ref(true);
const loading = ref(false);
const errors = ref({});

const user = computed(()=>store.state.user.data)
const allTeacher = ref({});
const teachers = ref({});
const teacher = ref({});
const meetingTime = ref(null);
const scheduleId = ref(null);

const student = computed(()=> store.state.user.data);

const appointmentData = ref({
  teacher_id: teacher.value.id,
  student_id: student.value.id,
  date: '',
  meeting_time: meetingTime,
  description: '',
  schedule_id: scheduleId,
});

onMounted(()=>{
  loading.value = true;
  if(route.params.slug){
    store.dispatch('facultyMember', route.params.slug)
      .then(()=>{
        teacher.value =  store.state.facultyMemberData;
        loading.value = false;
      })
  }else{
    store.dispatch('allFacultyMember')
    .then((res) => {
      allTeacher.value = store.state.allFacultyMember;
      teachers.value = store.state.allFacultyMember;
      loading.value = false;
    })
  }
})


function onDepartmentChange(event){
  if(event.target.value === ""){
    teachers.value = allTeacher.value;
    teacher.value = {}
  } else{
    teachers.value = allTeacher.value.filter((tec) => tec.department === event.target.value);
    teacher.value = {}
  }
}


function onTeacherChange(event){
  if(event.target.value === ''){
    teacher.value = {};
    teachers.value = allTeacher.value;
  }else{
    teacher.value = teachers.value.filter((tec) => tec.id === parseInt(event.target.value, 10))[0];
  }
}

function onDateChose(event){
  let schedule = teacher.value.schedules.filter((s) => s.date === event.target.value)
  meetingTime.value = schedule[0].next_meeting_time;
  scheduleId.value = schedule[0].id;
  console.log(meetingTime.value);
}


function appointment(ev){
  // console.log(appointmentData.value);
  ev.preventDefault();
  appointmentData.value.teacher_id = teacher.value.id;
  if(route.params.slug == user.id){
    alert(`You can't create an appointment with yourself`)
    return
  }
  store.dispatch('createAppointment', appointmentData.value)
    .then((res)=>{
      router.push({
        name: `${user.value.role}Dashboard`
      })
    })
}
</script>

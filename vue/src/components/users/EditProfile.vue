<template>
  <div class="w-full max-w-md mx-auto space-y-8 p-7">
    <div>
      <div class="mt-6 text-center font-bold tracking-tight">
        <h2 class=" text-3xl text-gray-900 mb-3">{{ route.query.id ? 'Update' + ' ' + user.name + ' ' + 'Profile' : 'Update Your Profile' }}</h2>
      </div>
    </div>
    <form class="mt-8 space-y-6" @submit="updateProfile">
      <Alert v-if="Object.keys(errorMsg).length" class="flex justify-between items-center" >
            <div class="flex-col items-stretch text-md">
              <div v-for="(field, i) of Object.keys(errorMsg)" :key="i">
                <div v-for="(error, ind) of errorMsg[field] || []" :key="ind">
                  * {{ error }}
                </div>
            </div>
            </div>
            <span @click="errorMsg = ''">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 flex items-center justify-center rounded-full transition-color cursor-pointer hover:bg-[rgba(0,0,0,0.2)]">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </span>
          </Alert>

      <input type="hidden" name="remember" value="true" />
      <div class="-space-y-px rounded-md shadow-md">

        <!-- Image  -->
        <div class="flex justify-center items-center">
          <label for="image" class="sr-only">
            Image
          </label>
          <div class="mb-4">
            <div class="flex justify-center items-center">
              <img
              v-if="user.image_url"
              :src="user.image_url"
              alt=""
              class="sm:w-48 sm:h-48 w-36 h-36 rounded-full object-cover"
            />
            <span
              v-else
              class="flex sm:w-48 sm:h-48 w-36 h-36 rounded-full overflow-hidden bg-gray-100"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-[80%] w-[80%] text-gray-300 m-auto"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  fill-rule="evenodd"
                  d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                  clip-rule="evenodd"
                />
              </svg>
            </span>
            </div>
            <button
              type="button"
              class="relative block rounded-md w-full appearance-none border border-gray-300 px-3 py-2 text-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
            >
              <input
                type="file"
                @change="onImageChoose"
                class="absolute left-0 top-0 right-0 bottom-0 opacity-0 cursor-pointer"
              />
              Change your profile picture
            </button>
          </div>
        </div>
        <!-- Image  -->


        <div class="space-y-2 pb-2">
          <label for="full-name" class="text-gray-600 ml-1 font-semibold">Full Name</label>
          <input v-model="user.name" id="full-name" name="full-name" type="text" autocomplete="full-name" required="" :class="inputClasses" placeholder="Enter your full name" />
        </div>
        <div class="space-y-2 pb-2">
          <label for="email-address" class="text-gray-600 ml-1 font-semibold">Email address</label>
          <input v-model="user.email" id="email-address" name="email" type="email" autocomplete="email" required="" :class="inputClasses" placeholder="Email address" />
        </div>
        <div class="space-y-2 pb-2">
          <label for="user-role" class="text-gray-600 ml-1 font-semibold">Department</label>
          <select v-model="user.role" id="user-role" :value="user.department" :class="[!user.department ? 'text-gray-500' : 'text-gray-900', inputClasses]">
            <option value="" selected>Choose a Role</option>
            <option value="Admin">Admin</option>
            <option value="Teacher">Teacher</option>
            <option value="Student">Student</option>
          </select>
        </div>
        <div class="space-y-2 pb-2">
          <label for="user-position" class="text-gray-600 ml-1 font-semibold">User Position</label>
          <input v-model="user.position" id="user-position" name="user-position" type="text" autocomplete="full-name" :class="inputClasses" placeholder="Enter your full name" />
        </div>
        <div class="space-y-2 pb-2">
          <label for="department" class="text-gray-600 ml-1 font-semibold">Department</label>
          <select v-model="user.department" id="department" :value="user.department" :class="[!user.department ? 'text-gray-500' : 'text-gray-900', inputClasses]">
            <option value="" selected>Choose a department</option>
            <option value="Computer Science Engineering">Computer Science Engineering</option>
            <option value="Electrical and Electronics Engineering">Electrical and Electronics Engineering</option>
            <option value="Civil Engineering">Civil Engineering</option>
            <option value="Mechanical Engineering">Mechanical Engineering</option>
          </select>
        </div>
        <div class="space-y-2 pb-2">
          <label for="courses" class="text-gray-600 ml-1 font-semibold">Courses</label>
          <input v-model="user.course" id="courses" name="courses" type="text" autocomplete="courses" :class="inputClasses" placeholder="Courses" />
        </div>
        <div class="space-y-2 pb-2">
          <label for="joining-date" class="text-gray-600 ml-1 font-semibold">Starting Date</label>
          <input v-model="user.joining_date" id="joining-date" name="joining-date" type="text" autocomplete="joining-date" :class="inputClasses" placeholder="Starting Date" />
        </div>
        <div class="space-y-2 pb-2">
          <label for="birthday" class="text-gray-600 ml-1 font-semibold">BirthDate</label>
          <input v-model="user.birthday" id="birthday" name="birthday" type="text" autocomplete="birthday" :class="inputClasses" placeholder="Date of Birth" />
        </div>
        <div class="space-y-2 pb-2">
          <label for="mobile" class="text-gray-600 ml-1 font-semibold">Mobile</label>
          <input v-model="user.mobile" id="mobile" name="mobile" type="text" autocomplete="mobile"  :class="inputClasses" placeholder="Mobile" />
        </div>
        <div class="space-y-2 pb-2">
          <label for="address" class="text-gray-600 ml-1 font-semibold">Address</label>
          <input v-model="user.address" id="address" name="address" type="text" autocomplete="address"  :class="inputClasses" placeholder="Address" />
        </div>
        <div class="space-y-2 pb-2">
          <label for="languages" class="text-gray-600 ml-1 font-semibold">Languages</label>
          <input v-model="user.languages" id="languages" name="languages" type="text" autocomplete="languages"  :class="inputClasses" placeholder="Languages" />
        </div>
        <div class="space-y-2 pb-2">
          <label for="about" class="text-gray-600 ml-1 font-semibold">About</label>
          <textarea v-model="user.about" id="about" rows="6" name="about" autocomplete="about" required="" :class="inputClasses" placeholder="Tell something about yourself" />
        </div>
      </div>

      <div class="space-y-2 pb-2">
        <button
          type="submit"
          :disabled="loading"
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
          Update profile
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { LockClosedIcon } from '@heroicons/vue/20/solid';
import Alert from '../Alert.vue'
import { ref } from '@vue/reactivity';
import store from '../../store';
import {useRoute, useRouter} from 'vue-router';
import { computed, onMounted } from '@vue/runtime-core';


const inputClasses = ['relative block w-full appearance-none rounded-none border border-gray-300 px-3 py-2 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm']

const router = useRouter();
const route = useRoute();
const loading = ref(false);
const errorMsg = ref({});
const user = ref({});

function onImageChoose(ev) {
  const file = ev.target.files[0];
  const reader = new FileReader();
  reader.onload = () => {
    // The field to send on backend and apply validations
    user.value.image = reader.result;
    // The field to display here
    user.value.image_url = reader.result;
    ev.target.value = "";
  };
reader.readAsDataURL(file);
}

onMounted(()=>{
  if(route.query.id){
    store.dispatch('facultyMember', route.query.id)
    .then(()=>{
      user.value = store.state.facultyMemberData;
    })
  }else{
    user.value = store.state.user.data;
  }
})


function updateProfile(ev) {
ev.preventDefault();
    store
      .dispatch("updateProfile", user.value)
      .then(() => {
        loading.value = false;
        if(route.query.id){
          console.log('fuck');
          router.push({
            name: 'Profile',
                query: {
                  id:route.query.id,
                },
          })
        } else{
          router.push({
          name: "Profile",
        });
        }

      })
      .catch((error) => {
      console.log(error.response);
      loading.value = false;
      if (!error.response){
        errorMsg.value = {error:{message:'Network Error'}};
      }
      else if (error.response.status === 422) {
        errorMsg.value = error.response.data.errors;
        console.log(errorMsg.value);
      } else {

      }
    });
}
</script>

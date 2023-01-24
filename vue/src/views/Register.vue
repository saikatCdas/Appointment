<template>
    <div class="w-full max-w-md space-y-8">
      <div>
        <img class="mx-auto h-12 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company" />
        <div class="mt-6 text-center font-bold tracking-tight">
          <h2 class=" text-3xl text-gray-900 mb-3">Create an account</h2>
        </div>
      </div>
      <div>
        <div>
          <div v-if="role === ''" class="flex items-center justify-center ">
            <button @click="role = 'Student'" :class="[role === 'Student' ? 'bg-blue-900 hover:bg-blue-900' : 'bg-blue-500 hover:bg-blue-700 ', 'text-white font-bold py-2 px-4 rounded ml-1 mr-2']">Student</button>
            <button @click="role = 'Teacher'" :class="[role === 'Teacher' ? 'bg-blue-900 hover:bg-blue-900' : 'bg-blue-500 hover:bg-blue-700 ', 'text-white font-bold py-2 px-4 rounded ml-1 mr-2']" >Teacher</button>
          </div>
          <div v-if="role === ''">
            <p class=" font-bold text-lg text-center text-red-500">
              Please Select a account type
            </p>
          </div>
          <div v-else>
            <p class="font-bold text-lg text-center text-emerald-600">
              {{ 'Creating account as a ' + role }}
            </p>
          </div>
        </div>
      </div>
      <form v-if="!(role === '')" class="mt-8 space-y-6" @submit="register">
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
                Chose your profile picture
              </button>
            </div>
          </div>
          <!-- Image  -->


          <div>
            <label for="full-name" class="sr-only">Full Name</label>
            <input v-model="user.name" id="full-name" name="full-name" type="text" autocomplete="full-name" required="" :class="inputClasses" placeholder="Enter your full name" />
          </div>
          <div>
            <label for="email-address" class="sr-only">Email address</label>
            <input v-model="user.email" id="email-address" name="email" type="email" autocomplete="email" required="" :class="inputClasses" placeholder="Email address" />
          </div>
          <div>
            <label for="password" class="sr-only">Password</label>
            <input v-model="user.password" id="password" name="password" type="password" autocomplete="current-password" required="" :class="inputClasses" placeholder="Password" />
          </div>
          <div>
            <label for="password-confirmation" class="sr-only">Password</label>
            <input v-model="user.password_confirmation" id="password-confirmation" name="password-confirmation" type="password" autocomplete="current-password-confirmation" required="" :class="inputClasses" placeholder="Password Confirmation" />
          </div>
          <div>
            <label for="department" class="sr-only">Select a Department</label>
            <select v-model="user.department" id="department" @click="font = false" :class="[font ? 'text-gray-500' : 'text-gray-900', inputClasses]">
              <option value="" selected>Choose a department</option>
              <option value="Computer Science Engineering">Computer Science Engineering</option>
              <option value="Electrical and Electronics Engineering">Electrical and Electronics Engineering</option>
              <option value="Civil Engineering">Civil Engineering</option>
              <option value="Mechanical Engineering">Mechanical Engineering</option>
            </select>
          </div>
          <div v-if="role === 'Teacher'">
            <label for="courses" class="sr-only">Courses</label>
            <input v-model="user.course" id="courses" name="courses" type="text" autocomplete="courses" required="" :class="inputClasses" placeholder="Courses" />
          </div>
          <div>
            <label for="joining-date" class="sr-only">Starting Date</label>
            <input v-model="user.joining_date" id="joining-date" name="joining-date" type="text" autocomplete="joining-date" required="" :class="inputClasses" placeholder="Starting Date" />
          </div>
          <div>
            <label for="birthday" class="sr-only">BirthDate</label>
            <input v-model="user.birthday" id="birthday" name="birthday" type="text" autocomplete="birthday" required="" :class="inputClasses" placeholder="Date of Birth" />
          </div>
          <div>
            <label for="mobile" class="sr-only">Mobile</label>
            <input v-model="user.mobile" id="mobile" name="mobile" type="text" autocomplete="mobile" required="" :class="inputClasses" placeholder="Mobile" />
          </div>
          <div>
            <label for="address" class="sr-only">Address</label>
            <input v-model="user.address" id="address" name="address" type="text" autocomplete="address" required="" :class="inputClasses" placeholder="Address" />
          </div>
          <div>
            <label for="languages" class="sr-only">Languages</label>
            <input v-model="user.languages" id="languages" name="languages" type="text" autocomplete="languages" required="" :class="inputClasses" placeholder="Languages" />
          </div>
          <div>
            <label for="about" class="sr-only">About</label>
            <textarea v-model="user.about" id="about" rows="6" name="about" autocomplete="about" required="" :class="inputClasses" placeholder="Tell something about yourself" />
          </div>
        </div>

        <div>
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
            Sign up
          </button>
        </div>
      </form>
      <div v-if="(role === '')">
        <p class="mt-2 text-center text-sm text-gray-600 font-medium hover:text-indigo-500">
          Already have an account??
        </p>
        <router-link
          :to="{name: 'Login'}"
          class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >
          Login here
        </router-link>
      </div>
    </div>
</template>

<script setup>
import { LockClosedIcon } from '@heroicons/vue/20/solid';
import Alert from '../components/Alert.vue';
import { ref } from '@vue/reactivity';
import store from '../store';
import {useRouter} from 'vue-router';
import { computed } from '@vue/runtime-core';

const inputClasses = ['relative block w-full appearance-none rounded-none border border-gray-300 px-3 py-2 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm']

const router = useRouter();
const font = ref(true);
const role = ref('');
const loading = ref(false);
const errorMsg = ref({});

let user = ref({
  name: "",
  email: "",
  password: '',
  password_confirmation: '',
  department:'',
  role: null,
  image: null,
  image_url: null,
  address: '',
  birth_date: '',
  joining_date: '',
  contact_number: '',
  languages: '',
  course : '',
  about: '',
});

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

function register(ev) {
  ev.preventDefault();
  loading.value = true;
  user.value.role = role.value;
  store
    .dispatch("register", user.value)
    .then(() => {
      loading.value = false;
      router.push({
        name: 'Home',
      })
    })
    .catch((error) => {
      console.log(error.response);
      loading.value = false;
      console.log(error.length);
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

<template>
  <div>
      <section class="flex flex-col antialiased bg-gray-100 text-gray-600 min-h-screen  p-4">
          <div class="h-full">
              <div class="w-full max-w-4xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200">
                  <header class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                      <h2 class="font-semibold text-gray-800">{{ props.title }}</h2>
                      <div>
                        <label for="department" class="sr-only">Department</label>
                        <select v-model="department" id="department" @change="departmentChange" @click="font = false" :class="[font ? 'text-gray-500' : 'text-gray-900', 'relative block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm']">
                          <option value="" selected>Filter by Department</option>
                          <option value="Computer Science Engineering">Computer Science Engineering</option>
                          <option value="Electrical and Electronics Engineering">Electrical and Electronics Engineering</option>
                          <option value="Civil Engineering">Civil Engineering</option>
                          <option value="Mechanical Engineering">Mechanical Engineering</option>
                        </select>
                      </div>
                  </header>
                  <div class="p-3">
                      <div class="overflow-x-auto">
                        <div class="text-sm divide-gray-100 space-y-1 min-h-screen">
                            <div v-for="(user, ind) in props.users" :key="ind" class="sm:flex flex-col items-center justify-center bg-white">

                            <div class="w-[30rem] border-2 border-b-4 border-gray-200 rounded-xl">

                              <p class="bg-sky-500 w-fit px-4 py-1 text-sm font-bold text-white rounded-tl-lg rounded-br-xl"> {{user.role}} </p>

                              <div class="grid grid-cols-6 p-5 gap-y-2">

                                <div>
                                  <svg v-if="!user.image_url" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="max-w-16 max-h-16 rounded-full">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>

                                  <img v-else class="w-16 h-16 rounded-full" :src="user.image_url" alt="">
                                </div>

                                <div class="col-span-5 md:col-span-4 ml-4">

                                  <a :href="`/profile/${user.id}`" class="text-sky-500 font-bold text-lg"> {{user.name}}</a>

                                  <p class="text-gray-600 font-bold"> {{user.department}} </p>

                                  <p class="text-gray-400">{{user.role}}</p>

                                  <p class="text-gray-400">{{user.position}}</p>

                                </div>

                                <div class="flex md:flex-col max-md:space-x-3 md:space-y-3 max-sm:col-start-2 ml-4 md:col-start-auto md:ml-0 md:justify-end">
                                  <button @click="accept(user.role, user.id)" type="button" class="rounded-lg text-sky-500 font-bold bg-sky-100  py-1 px-3 text-sm w-20 h-fit hover:text-sky-900 hover:bg-sky-500 "> {{ props.buttonValue }} </button>
                                  <button @click="deleteUser(user.id)" type="button" class="rounded-lg text-red-500 font-bold bg-red-100  py-1 px-3 text-sm w-20 h-fit hover:text-red-900 hover:bg-red-500"> Delete</button>
                                </div>

                              </div>

                              </div>
                            </div>
                        </div>
                      </div>
                  </div>
                  <Pagination
                    :paginationLinks="paginationLinks"
                    @getForPage="getForPage"
                  />
              </div>
          </div>
      </section>
  </div>
</template>

<script setup>
import { Disclosure, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
import Pagination from '../Pagination.vue';
import { ref } from '@vue/reactivity';
import { computed, watchEffect } from '@vue/runtime-core';
import { useRoute, useRouter } from 'vue-router';
import store from '../../store';

const router = useRouter();
const route = useRoute();
const font= ref(true);
const authUser = computed(()=> store.state.user.data);
const department = ref("");
const props = defineProps(['users', 'title', 'paginationLinks', 'buttonValue']);
const emit = defineEmits(['departmentChange', 'deleteUser', 'getForPage', 'buttonFunction'])


function departmentChange(){
emit('departmentChange', department.value)
}

function getForPage(event, link){
emit('getForPage', event, link)
}

function accept(role, id){
  emit('buttonFunction', role, id);
}


function deleteUser(id){
  emit('deleteUser', id);
}
</script>

<style>

</style>

<template>
    <aside class="z-10 top-0 pb-3 px-6 w-full flex flex-col justify-between  transition duration-300 md:w-4/12 lg:ml-0 lg:w-[25%] xl:w-[20%] 2xl:w-[15%] md:float-left">
        <div>

            <div class="mt-8 text-center">
                <img :src="user.image_url" alt="" class="hidden w-10 h-10 m-auto rounded-full object-cover md:block md:w-28 md:h-28">

                <h5 class="hidden mt-4 text-xl font-semibold text-gray-600 md:block">{{ user.name }}</h5>

                <span class="hidden text-gray-400 md:block">{{ user.position ?? user.role}}</span>

            </div>



            <div v-for="(nav, ind) in props.navigation" :key="ind" class="space-y-2 tracking-wide mt-8">

                <router-link :to="nav.to" aria-label="dashboard" :class="[ route.name === nav.to.name ? 'bg-gradient-to-r from-sky-600 to-cyan-400': '','relative px-4 py-3 flex items-center space-x-4 rounded-xl text-white']">

                    <svg class="-ml-1 h-6 w-6" viewBox="0 0 24 24" fill="none">

                                  <path d="M6 8a2 2 0 0 1 2-2h1a2 2 0 0 1 2 2v1a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V8ZM6 15a2 2 0 0 1 2-2h1a2 2 0 0 1 2 2v1a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2v-1Z" class="fill-current text-cyan-400 dark:fill-slate-600"></path>

                                  <path d="M13 8a2 2 0 0 1 2-2h1a2 2 0 0 1 2 2v1a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2V8Z" class="fill-current text-cyan-200 group-hover:text-cyan-300"></path>

                                  <path d="M13 15a2 2 0 0 1 2-2h1a2 2 0 0 1 2 2v1a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-1Z" class="fill-current group-hover:text-sky-300"></path>

                              </svg>

                    <span class="-mr-1 font-medium">{{ nav.name }}</span>

                </router-link>

            </div>

        </div>

    </aside>
</template>

<script setup>
import { computed } from '@vue/runtime-core';
import { useRoute } from 'vue-router';
import store from '../../store';

const route = useRoute();

const props = defineProps(['navigation']);
const user = computed(() => store.state.user.data);

</script>

<style>

</style>

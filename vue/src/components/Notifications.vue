<template>
    <!-- component -->
    <div class="flex  justify-center bg-gradient-to-t min-h-screen h-full bg-cover p-6 bg-gray-900">
        <div class="w-full md:w-1/2 lg:w-1/3">
            <div class="flex flex-col space-y-4">
              <h1 class="text-white font-bold text-2xl">Notifications</h1>
              <hr>

                <!-- Item -->
                <a v-for="(notification, ind ) in allNotifications" :key="ind" :href="`${notification.data.path}`"  class="flex justify-between py-6 px-4 bg-white/50 rounded-lg cursor-pointer">
                    <div class="flex items-center space-x-4 ">
                        <img :src="notification.data.image_url" class="rounded-full h-14 w-14" alt="">
                        <div class="flex flex-col space-y-1">
                            <a :href="`/profile/${notification.data.user_id }`" class="font-bold underline">{{ notification.data.name }}</a>
                            <span class="text-sm">{{ notification.data.message }}</span>
                        </div>
                    </div>
                  </a>
                <!-- Item -->
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "@vue/reactivity";
import { onMounted, onUpdated } from "@vue/runtime-core";
import store from "../store";


const allNotifications = ref({});

onMounted(() => {
  store.dispatch('getNotifications')
      .then((res) => {
          allNotifications.value = store.state.allNotifications;
          console.log(allNotifications.value);
      })
})

onUpdated(()=> {
  store.dispatch('markAllNotificationAsRead')
    .then((res)=> {
    })
})
</script>

<style>

</style>

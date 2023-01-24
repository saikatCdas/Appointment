<template>
    <div class="min-h-full ">
        <Disclosure as="nav" class="bg-gray-800 z-50 sticky top-0" v-slot="{ open }">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-8 w-8" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company" />
                        </div>
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4">
                                <router-link v-for="item in navigation" :key="item.name" :to="item.to" :class="[this.$route.name === item.to.name ? 'bg-[#2563EB] text-white' : 'text-gray-300 hover:bg-[#2563EB] hover:text-white', 'px-3 py-2 rounded-md text-sm font-medium']" :aria-current="item.current ? 'page' : undefined">{{ item.name }}</router-link>
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6">

                            <SearchBar @search="search"/>

                            <button v-if="token" type="button">

                                      </button>
                            <Menu as="div" class="relative ml-3">
                                <div v-if="token">
                                    <MenuButton class="ml-3 rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                                        <span class="sr-only">View notifications</span>
                                        <div class="relative">
                                            <BellIcon class="h-6 w-6" aria-hidden="true" />
                                            <span v-if="unreadNotifications.length" class="absolute -right-1 -top-1 rounded-full text-white bg-red-500 w-4 h-4 text-center text-[11px]">{{ unreadNotifications.length }}</span>
                                        </div>
                                    </MenuButton>
                                    <transition v-if="!((route.name === 'Notifications'))" enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100"
                                        leave-to-class="transform opacity-0 scale-95">
                                        <MenuItems :class=" !token? 'hidden': ''" class=" absolute right-0 z-10 mt-2 w-80 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                            <div class="flex justify-between p-2">
                                              <h1 class="ml-1 font-bold text-gray-700">Notifications</h1>
                                              <a href="/notifications" class="cursor-pointer underline text-blue-700">See all</a>
                                            </div>
                                            <hr/>
                                            <MenuItem v-for="(notification, ind) in unreadNotifications" :key="ind">
                                            <a :href="`${notification.data.path}`" class="flex items-center px-4 py-3 border-b -mx-2">
                                                <img class="h-8 w-8 rounded-full object-cover mx-1" :src="notification.data.image_url" alt="avatar">
                                                {{  }}
                                                <p class="text-gray-600 text-sm mx-2">
                                                <a class="font-bold underline text-blue-600" :href="`/profile/${notification.data.user_id }`">{{ notification.data.name }}</a> {{ notification.data.message }}
                                            </p>
                                            </a>
                                            </MenuItem>
                                        </MenuItems>
                                    </transition>
                                </div>
                            </Menu>

                            <div v-if="!token" class="hidden md:block">
                                <div class="flex items-baseline">
                                    <router-link :to="{name: 'Login'}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-300 hover:bg-[#2563EB] hover:text-white">Login</router-link>
                                    <router-link :to="{name: 'Register'}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-300 hover:bg-[#2563EB] hover:text-white">Register</router-link>
                                </div>
                            </div>

                            <!-- Profile dropdown -->
                            <Menu as="div" class="relative ml-3">
                                <div v-if="token">
                                    <MenuButton class="flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                                        <span class="sr-only">Open user menu</span>
                                        <img class="h-8 w-8 rounded-full" :src="user.image_url" alt="" />
                                    </MenuButton>
                                </div>
                                <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100"
                                    leave-to-class="transform opacity-0 scale-95">
                                    <MenuItems :class=" !token? 'hidden': ''" class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                        <MenuItem v-for="item in userNavigation" :key="item.name" v-slot="{ active }">
                                        <a :href="item.href" @click="item.function" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">{{ item.name }}</a>
                                        </MenuItem>
                                    </MenuItems>
                                </transition>
                            </Menu>
                        </div>
                    </div>
                    <div class="-mr-2 flex md:hidden">
                        <!-- Mobile menu button -->
                        <DisclosureButton class="inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                            <span class="sr-only">Open main menu</span>
                            <Bars3Icon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
                            <XMarkIcon v-else class="block h-6 w-6" aria-hidden="true" />
                        </DisclosureButton>
                    </div>
                </div>
            </div>

            <DisclosurePanel class="md:hidden">
                <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
                    <router-link v-for="item in navigation" :key="item.name" as="a" :to="item.to" :class="[item.current ? 'bg-[#2563EB] text-white' : 'text-gray-300 hover:bg-[#2563EB] hover:text-white', 'block px-3 py-2 rounded-md text-base font-medium']" :aria-current="item.current ? 'page' : undefined">{{ item.name }}</router-link>
                </div>
                <div v-if="token" class="border-t border-gray-700 pt-4 pb-3">
                    <div class="flex items-center px-5">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full" :src="user.image_url" alt="" />
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium leading-none text-white">{{ user.name }}</div>
                            <div class="text-sm font-medium leading-none text-gray-400">{{ user.email }}</div>
                        </div>
                        <router-link :to="{name: 'Notifications'}" class="relative ml-auto flex-shrink-0 rounded-full bg-gray-800 p-1 text-[#2563EB] hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                            <span class="sr-only">View notifications</span>
                            <BellIcon class="h-6 w-6" aria-hidden="true" />
                            <span v-if="unreadNotifications.length" class="absolute right-0 top-0 rounded-full text-white bg-red-500 w-4 h-4 text-center text-[11px]">{{ unreadNotifications.length }}</span>
                        </router-link>
                    </div>
                    <div class="mt-3 space-y-1 px-2">
                        <DisclosureButton v-for="item in userNavigation" @click="item.function" :key="item.name" as="a" :href="item.href" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-[#2563EB] hover:text-white">{{ item.name }}</DisclosureButton>
                    </div>
                </div>
                <div class="pb-3">
                  <SearchBar class="mx-4" @search="search"/>
                </div>
                <div v-if="!token" class="border-t border-gray-700 px-3">
                    <div class="flex items-center px-4 py-3 space-y-1 ">
                        <router-link :to="{name: 'Login'}" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-[#2563EB] hover:text-white">
                            Login
                        </router-link>
                        <router-link :to="{name: 'Register'}" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-[#2563EB] hover:text-white">
                            Register
                        </router-link>
                    </div>
                </div>
            </DisclosurePanel>
        </Disclosure>
        <router-view></router-view>
        <Footer/>
        <makeAnAppointmentButton/>
    </div>
</template>

<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
import SearchBar from './SearchBar.vue';
import Footer from './Footer.vue';
import makeAnAppointmentButton from './appointment/makeAnAppointmentButton.vue';
import { Bars3Icon, BellIcon, XMarkIcon } from '@heroicons/vue/24/outline'
import { computed, onMounted, ref } from '@vue/runtime-core'
import { useRoute, useRouter } from 'vue-router';
import store from '../store'

const user = computed(() => store.state.user.data);
const token = computed(() => store.state.user.token)
const router = useRouter();
const route = useRoute()
const unreadNotifications = ref({});

const navigation = [
    { name: 'Home', to: { name: 'Home' } },
    { name: 'Faculty', to: { name: 'Faculty' } },
]
const userNavigation = [{
        name: 'Your Profile',
        href: '#',
        function: () => {
            router.push({
                name: 'Profile'
            })
        }
    },
    {
        name: 'Dashboard',
        href: '#',
        function: () => {
            router.push({
                name: `${user.value.role}Dashboard`
            })
        }
    },
    { name: 'Sign out', href: '#', function: logout },
]

function logout(ev) {
    ev.preventDefault();
    store.dispatch('logout')
        .then(() => {
            router.push({
                name: 'Home'
            });
        })
}

onMounted(() => {
    if (user.value){
        store.dispatch('getUnreadNotification')
            .then((res) => {
                unreadNotifications.value = store.state.unreadNotifications;
            })
    }
})

function search(searchInp) {
    store.dispatch('search', searchInp)
        .then(() => {
            router.push({
                name: 'SearchView',
                params: { slug: searchInp }
            })
        })
}
</script>


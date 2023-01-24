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
    { name: 'New User Request', to: { name: 'NewUserRequest' } },
    { name: 'Faculty Members', to: { name: 'FacultyMaintaining' } },
    { name: 'Students', to: { name: 'StudentMaintaining' } },
];

</script>

<style>

</style>

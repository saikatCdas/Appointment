<template>
  <UserView
    :title="title"
    :users="newUsers"
    :paginationLinks="paginationLinks"
    :buttonValue="button"
    @getForPage="getForPage"
    @departmentChange="departmentChange"
    @deleteUser="deleteUser"
    @buttonFunction="accept"
  />
</template>

<script setup>
import UserView from './UserView.vue';
import { ref } from '@vue/reactivity';
import { onMounted } from '@vue/runtime-core';
import store from '../../store';
import { useRouter } from 'vue-router';

const title = 'New User Request';
const button = 'Accept';
const router = useRouter();
const newUsers = ref({});
const paginationLinks = ref([])

const getNewUser = (()=>
  store.dispatch('getNewUsers')
    .then(()=>{
      newUsers.value = store.state.newUsers;
      paginationLinks.value = store.state.paginationLinks;
    }))

onMounted(()=>{
  getNewUser();
})

function departmentChange(department){
  if(department=== ''){
    getNewUser();
  }else {
    store.dispatch('getNewUserByDepartment', {department:department})
    .then(()=>{
      newUsers.value = store.state.newUsers;
      paginationLinks.value = store.state.paginationLinks;
    })
  }
}

function getForPage(ev, link) {
  ev.preventDefault();
  if (!link.url || link.active) {
    return;
  } else if(department.value === ''){
    store.dispatch('getNewUsers', {url: link.url})
      .then((res) => {
        newUsers.value = store.state.newUsers;
        paginationLinks.value = store.state.paginationLinks;
      });
  }else {
    store.dispatch('getNewUserByDepartment', {department:department.value, url: link.url})
    .then(()=>{
      newUsers.value = store.state.newUsers;
      paginationLinks.value = store.state.paginationLinks;
    })
  }
}


function deleteUser(id){
  store.dispatch('deleteUser', id)
    .then(()=>{
      newUsers.value = newUsers.value.filter((user)=> user.id != id);
    })
}

function accept(role, id){
  // console.log(id);
  if(role === 'Teacher'){
    router.push({
      name: 'NewUserPositionSetup',
      query:{id:id}
    })
  }
  else{
    const user ={id: id}
    store.dispatch('acceptUser', {id: id})
      .then(()=>{
        newUsers.value = newUsers.value.filter((user)=> user.id != id);
      })
  }
}
</script>

<style>

</style>

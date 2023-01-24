<template>
  <UserView
    :title="title"
    :users="allFacultyMember"
    :paginationLinks="paginationLinks"
    :buttonValue="edit"
    @getForPage="getForPage"
    @departmentChange="departmentChange"
    @deleteUser="deleteUser"
    @buttonFunction="editProfile"
  />
</template>

<script setup>
import { ref } from '@vue/reactivity';
import { onMounted } from '@vue/runtime-core';
import { useRouter } from 'vue-router';
import store from '../../store';
import UserView from './UserView.vue';



const title = 'Faculty Members';
const edit = 'Edit'
const router = useRouter();
const allFacultyMember = ref({});
const paginationLinks = ref([]);

const getAllFaculty = ()=> {
  store.dispatch('allFacultyMember')
    .then((res) => {
      allFacultyMember.value = store.state.allFacultyMember;
      paginationLinks.value = store.state.paginationLinks;
    })
}

onMounted(()=>{
  getAllFaculty();
})



function departmentChange(department){
  if(department=== ''){
    getAllFaculty();
  }else {
    store.dispatch('getFacultyByDepartment', {department:department})
    .then(()=>{
      allFacultyMember.value = store.state.allFacultyMember;
      paginationLinks.value = store.state.paginationLinks;
    })
  }
}

function getForPage(ev, link) {
  ev.preventDefault();
  if (!link.url || link.active) {
    return;
  } else if(department.value === ''){
    store.dispatch('allFacultyMember', {url: link.url})
      .then((res) => {
        allFacultyMember.value = store.state.allFacultyMember;
        paginationLinks.value = store.state.paginationLinks;
      });
  }else {
    store.dispatch('getFacultyByDepartment', {department:department.value, url: link.url})
    .then(()=>{
      allFacultyMember.value = store.state.allFacultyMember;
      paginationLinks.value = store.state.paginationLinks;
    })
  }
}


function deleteUser(id){
  store.dispatch('deleteUser', id)
    .then(()=>{
      allFacultyMember.value = allFacultyMember.value.filter((user)=> user.id != id);
    })
}

function editProfile(role, id){
  router.push({
        name: 'EditProfile',
        query: {
          id:id,
        },
    })
}
</script>

<style>

</style>

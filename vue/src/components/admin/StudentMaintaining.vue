<template>
  <UserView
    :title="title"
    :users="students"
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


const title = 'Students';
const edit = 'Edit'
const router = useRouter();
const students = ref({});
const paginationLinks = ref([])

const getStudent = (()=>
  store.dispatch('allStudent')
    .then(()=>{
      students.value = store.state.allStudent;
      paginationLinks.value = store.state.paginationLinks;
    }))

onMounted(()=>{
  getStudent();
})

function departmentChange(department){
  if(department=== ''){
    getStudent();
  }else {
    store.dispatch('getStudentByDepartment', {department:department})
    .then(()=>{
      students.value = store.state.allStudent;
      paginationLinks.value = store.state.paginationLinks;
    })
  }
}

function getForPage(ev, link) {
  ev.preventDefault();
  if (!link.url || link.active) {
    return;
  } else if(department.value === ''){
    store.dispatch('allStudent', {url: link.url})
      .then((res) => {
        students.value = store.state.allStudent;
        paginationLinks.value = store.state.paginationLinks;
      });
  }else {
    store.dispatch('getStudentByDepartment', {department:department.value, url: link.url})
    .then(()=>{
      students.value = store.state.allStudent;
      paginationLinks.value = store.state.paginationLinks;
    })
  }
}


function deleteUser(id){
  store.dispatch('deleteUser', id)
    .then(()=>{
      students.value = students.value.filter((user)=>user.id != id)
      // store.dispatch('allFacultyMember')
      //   .then(()=>{
      //     students.value = store.state.allStudent;
      //     paginationLinks.value = store.state.paginationLinks;
      //   })
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

import { createStore } from 'vuex';
import axiosClient from '../axios'

const store = createStore({
  state:{
    user:{
      data: JSON.parse(localStorage.getItem('USER')),
      token: sessionStorage.getItem("TOKEN"),
    },
    searchData : {},
    allFacultyMember:{},
    facultyMemberData:{},
    allNotifications: {},
    unreadNotifications:{},
    appointments:{},
    allStudent:{},
    paginationLinks:[],
    newUsers:{},
    schedules:{}
  },
  getters:{},
  actions:{
    getSchedule({commit}, {url = null} ={}){
      url = url || '/get-schedules';
      return axiosClient.get(url)
        .then(({data})=>{
          commit('setSchedules', data);
        })
    },
    acceptUser({}, user){
      return axiosClient.post('/accept-user', user);
    },
    getNewUserByDepartment({commit}, {department, url}){
      url = url || `/get-new-user-by-department/${department}`;
      return axiosClient.get(url)
        .then(({data})=>{
          commit('setNewUsers',data)
        })
    },
    getNewUsers({commit}, {url = null} ={}){
      url = url || '/get-new-users';
      return axiosClient.get(url)
        .then(({data}) => {
          commit('setNewUsers', data);
        })
    },
    getStudentByDepartment({commit}, {department, url}){
      url = url || `/student-by-department/${department}`;
      return axiosClient.get(url)
        .then(({data})=>{
          commit('setAllStudent', data)
        })
    },
    allStudent({commit}, {url = null} = {}){
      url = url || '/all-student'
      return axiosClient.get(url)
          .then(({data}) => {
            commit('setAllStudent', data);
          })
    },
    deleteUser({commit}, id){
      return axiosClient.delete(`/delete-user/${id}`);
    },
    getFacultyByDepartment({commit}, {department, url}){
      url = url || `/faculty-by-department/${department}`;
      return axiosClient.get(url)
        .then(({data})=>{
          commit('setAllFacultyMember', data)
        })
    },
    updateProfile({commit}, userinfo){
      delete userinfo.image_url;
      return axiosClient.put('/update-profile', userinfo)
      .then(({data}) => {
        if(this.state.user.data.id === userinfo.id){
          commit('setUser', data.data);
          return data;
        }
      });
    },
    acceptAppointment({},appointment){
      return axiosClient.put(`/appointment/${appointment.id}`, appointment)
    },
    rejectAppointment({dispatch},id){
      return axiosClient.delete(`/appointment/${id}`).then((res) => {
        dispatch('getAppointment')
        return res;
      });
    },
    getNewAppointment({commit}, url){
      url = url || '/get-new-appointment';
      return axiosClient.get(url)
        .then(({data})=>{
          commit('setAppointments', data.appointments);
        })
    },
    getUpcomingAppointment({commit}, url){
      url = url || '/get-upcoming-appointment';
      return axiosClient.get(url)
        .then(({data}) =>{
          commit('setAppointments', data.appointments)
        })
    },
    getTodaysAppointment({commit}, url){
      url = url || '/get-todays-appointment';
      return axiosClient.get(url)
        .then(({data}) =>{
          commit('setAppointments', data.appointments)
        })
    },
    getAppointment({commit}, url){
      url = url || '/appointment';
      return axiosClient.get(url)
      .then(({data}) => {
        commit('setAppointments', data.appointments);
      })
    },
    getAppointmentById({commit}, id){
      return axiosClient.get(`/appointment/${id}`)
      .then(({data})=>{
        commit('setAppointments', data);
      })
    },
    getNotifications({commit}){
      return axiosClient.get('/get-notifications')
      .then((res)=>{
        commit('setNotifications', res.data.data);
      })
    },
    getUnreadNotification({commit}){
      return axiosClient.get('/get-unread-notifications')
      .then(({data})=>{
        commit('setUnreadNotifications', data);
      })
    },
    markAllNotificationAsRead({commit}){
      return axiosClient.get('/mark-all-notification-as-read' );
    },
    createAppointment({commit}, appointment){
      return axiosClient.post('/appointment', appointment)
            .then((res)=>{
              return res;
            });
    },
    createSchedule({commit}, schedule){
      let response;
            if(schedule.id){
                response = axiosClient.put(`/schedule/${schedule.id}`, schedule)
                .then((res) => {
                    return res;
                });
            } else {
                response = axiosClient.post('/schedule', schedule)
                .then((res)=>{
                  return res;
                });
            }

            return response;
    },
    allFacultyMember({commit}, {url = null} = {}){
      url = url || "/users";
      return axiosClient.get(url)
        .then(({data}) => {
          commit('setAllFacultyMember', data);
          return data;
        })
    },
    facultyMember({commit}, id){
      return axiosClient.get(`/users/${id}`)
        .then(({data})=>{
          commit('facultyMemberData', data);
          return data;
        })
    },
    search({commit}, search){
      return axiosClient.get(`/search/${search}`, search)
        .then(({data})=>{
          commit('setSearchData', data)
          return data;
        })
    },
    register({commit}, user) {

      delete user.image_url;

      return axiosClient.post('/register', user)
        .then(({data}) => {
          commit('setUser', data.user);
          commit('setToken', data.token)
          return data;
        })
    },
    login({commit}, user){
      return axiosClient.post('/login', user)
        .then(({data}) => {
          commit('setUser', data.user);
          commit('setToken', data.token)
          return data;
        })
    },
  logout({commit}) {
      return axiosClient.post('/logout')
        .then(response => {
          commit('logout')
          return response;
        })
    },
  },
  mutations:{
    setSchedules:(state, schedules) =>{
      state.schedules = schedules.data;
      state.paginationLinks = schedules.links;
    },
    setNewUsers:(state, newUsersData)=>{
      state.newUsers = newUsersData.data;
      state.paginationLinks = newUsersData.meta.links;
    },
    setAllStudent:(state, studentData)=> {
      state.allStudent = studentData.data;
      state.paginationLinks = studentData.meta.links;
    },
    setAppointments:(state, appointmentsData) => {
      state.appointments = appointmentsData.data;
      state.paginationLinks = appointmentsData.links
    },
    setUnreadNotifications:(state, unreadNotifications)=>{
      state.unreadNotifications = unreadNotifications;
    },
    setNotifications:(state, notifications)=>{
      state.allNotifications = notifications;
    },
    setAllFacultyMember: (state, allFacultyMember)=>{
      state.allFacultyMember = allFacultyMember.data;
      state.paginationLinks = allFacultyMember.meta.links;
    },
    facultyMemberData : (state, faculty)=>{
      state.facultyMemberData = faculty.data;
    },
    setSearchData:(state, search)=>{
       state.searchData = search.data;
    },
    setUser: (state, user) => {
      state.user.data = user;
      localStorage.setItem('USER', JSON.stringify(user))
    },
    setToken: (state, token) => {
      state.user.token = token;
      sessionStorage.setItem('TOKEN', token);
    },
    logout: (state) => {
      state.user.token = null;
      state.user.data = {};
      sessionStorage.removeItem("TOKEN");
      localStorage.removeItem("USER")
  },
  setRegistrationError:(state, registrationError) =>{
    state.registrationError = registrationError;
  },
  },
  modules:{}
});

export default store;

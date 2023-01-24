import {createRouter, createWebHistory} from 'vue-router';
import store from '../store';
import AuthLayout from '../components/AuthLayout.vue';
import SearchView from '../components/SearchView.vue';
import Register from '../views/Register.vue';
import Login from '../views/Login.vue';
import Home from '../views/Home.vue';
import EditProfile from '../components/users/EditProfile.vue';
import Profile from '../components/users/Profile.vue';
import RequireAuth from '../components/RequireAuth.vue'
import DefaultLayout from '../components/DefaultLayout.vue';
import Faculty from '../views/Faculty.vue';
import MakeScheduleForAppointment from '../components/teacher/MakeScheduleForAppointment.vue';
import MakeAppointment from '../components/appointment/MakeAppointment.vue';
import Notifications from '../components/Notifications.vue';
import RequestForAppointment from '../components/appointment/RequestForAppointment.vue';
import AdminDashboard from '../components/dashboard/AdminDashboard.vue';
import TeacherDashboard from '../components/dashboard/TeacherDashboard.vue';
import StudentDashboard from '../components/dashboard/StudentDashboard.vue';
import NotFound from '../components/NotFound.vue';
import FacultyMaintaining from '../components/admin/FacultyMaintaining.vue';
import StudentMaintaining from '../components/admin/StudentMaintaining.vue';
import NewUserRequest from '../components/admin/NewUserRequest.vue';
import UserPositionSetup from '../components/admin/UserPositionSetup.vue';
import Schedules from '../components/teacher/Schedules.vue';
import NewAppointmentRequests from '../components/teacher/NewAppointmentRequests.vue';
import TodayAppointment from '../components/teacher/TodayAppointment.vue';
import UpcomingAppointment from '../components/teacher/UpcomingAppointment.vue';
import StudentRequestForAppointment from '../components/student/StudentRequestForAppointment.vue';
import StudentTodayAppointment from '../components/student/StudentTodayAppointment.vue';
import StudentUpcomingAppointment from '../components/student/StudentUpcomingAppointment.vue';




const routes = [
  {
    path: '/',
    redirect: '/home',
    component: DefaultLayout,
    children:[
      { path: '/home', name: 'Home', component: Home },
      { path: '/faculty', name: 'Faculty', component: Faculty },
      { path: '/profile/:slug', name: 'ProfileView',component: Profile },
      { path: '/search/results/:slug', name: 'SearchView',component: SearchView },
      { path: '/auth', component: RequireAuth, meta: {requiresAuth: true},
        children:[
          { path: '/profile', name: 'Profile', component: Profile },
          { path: '/admin-dashboard', name: 'AdminDashboard', redirect: '/new-user-requests', component: AdminDashboard,
            meta: {requiresAdmin: true},
            children: [
              // { path: '/admin-dashboard', name: 'AdminDashboard',component: AdminDashboardComponent },
              { path: '/faculty-maintaining', name: 'FacultyMaintaining', component: FacultyMaintaining },
              { path: '/student-maintaining', name: 'StudentMaintaining', component: StudentMaintaining },
              { path: '/new-user-requests', name: 'NewUserRequest', component: NewUserRequest },
              { path: '/user-position', name: 'NewUserPositionSetup' , component: UserPositionSetup}
            ]
          },
          { path: '/teacher-dashboard', redirect: '/new-appointment-requests', name: 'TeacherDashboard',component: TeacherDashboard,
          meta: {requiresTeacher: true},
            children:[
              {path:'/schedule', name: 'ScheduleView', component: Schedules},
              { path: '/make-schedule', name: 'MakeScheduleForAppointment', component: MakeScheduleForAppointment },
              { path: '/new-appointment-requests', name: 'NewAppointmentRequests', component: NewAppointmentRequests},
              { path: '/today-appointment', name: 'TodayAppointment', component: TodayAppointment},
              { path: '/upcoming-appointment', name: 'UpcomingAppointment', component: UpcomingAppointment},
            ]
          },
          { path: '/student-dashboard', redirect:'/student-request-for-appointment', name: 'StudentDashboard', component: StudentDashboard,
            meta: {requiresStudent: true},
            children:[
              {path:'/student-request-for-appointment', name: 'StudentRequestForAppointment', component: StudentRequestForAppointment},
              {path: '/student-today-appointment', name: 'StudentTodayAppointment', component: StudentTodayAppointment},
              {path: '/student-upcoming-appointment', name: 'StudentUpcomingAppointment', component: StudentUpcomingAppointment}
            ]
          },
          { path: 'edit-profile', name: 'EditProfile', component: EditProfile },
          { path:'/make-appointment', name: 'MakeAppointment', component: MakeAppointment },
          { path: '/make-appointment/:slug', name: 'MakeAppointmentView', component: MakeAppointment },
          { path:'/notifications', name: 'Notifications', component: Notifications },
          { path:'/request-for-appointment', name: 'RequestForAppointment', component: RequestForAppointment },
          { path:'/request-for-appointment/:slug', name: 'RequestForAppointmentById', component: RequestForAppointment}
        ]
      },
    ]
  },

  { path: '/auth', redirect: '/login', component: AuthLayout, meta: {isGuest: true},
    children: [
      { path: '/login', name: "Login", component: Login },
      { path: '/register', name: "Register", component: Register }
    ]
  },
  { path: '/:pathMatch(.*)*', name: 'NotFound',component: NotFound }
];


const router = createRouter({
  history: createWebHistory(),
  routes,
});


router.beforeEach((to, from , next) => {
  if(to.meta.requiresAuth && !store.state.user.token){
    next({name: 'Login'});
  } else if (to.meta.requiresAdmin && !(store.state.user.data.role === 'Admin')){
    next({name: 'Home'});
  } else if (to.meta.requiresTeacher && !(store.state.user.data.role === 'Teacher')){
    next({name: 'Home'});
  } else if (to.meta.requiresStudent && !(store.state.user.data.role === 'Student')){
    next({name: 'Home'});
  } else if (store.state.user.token && to.meta.isGuest){
      next({name: 'Home'});
  } else {
      next();
  }
})


export default router;

import {createRouter, createWebHistory} from "vue-router";
import Artists from "../pages/dashboard/Artists.vue";
import Albums from "../pages/dashboard/Albums.vue";
import Login from "../pages/auth/Login.vue";
import Register from "../pages/auth/Register.vue";
import DefaultLayout from "../components/DefaultLayout.vue";
import AuthLayout from "../components/AuthLayout.vue";
import store from "../store/index.js";
import Favorites from "../pages/dashboard/Favorites.vue";
import Google from "../pages/auth/GoogleSignIn.vue";
import ArtistView from "../pages/dashboard/ArtistView.vue";
import AlbumView from "../pages/dashboard/AlbumView.vue";

const routes = [
  {
    path: '/',
    redirect: '/artists',
    component: DefaultLayout,
    meta: {requiresAuth: true},
    children: [
      {path: '/artists', name: 'Artists', component: Artists},
      {path: '/artist/:name', name: 'ArtistView', component: ArtistView},
      {path: '/albums', name: 'Albums', component: Albums},
      {path: '/album/:artist/:name', name: 'AlbumView', component: AlbumView},
      {path: '/favorites', name: 'Favorites', component: Favorites},
    ]
  },
  {
    path: '/auth',
    redirect: '/login',
    name: 'Auth',
    component: AuthLayout,
    meta: {isGuest: true},
    children: [
      {path: '/auth/google/callback', name: 'Google', component: Google},
      {path: '/login', name: 'Login', component: Login},
      {path: '/register', name: 'Register', component: Register}
    ]
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth && !store.state.user.token) {
    next({name: 'Login'})
  } else if (store.state.user.token && (to.meta.isGuest)) {
    next({name: 'Artists'});
  } else {
    next();
  }
})

export default router;

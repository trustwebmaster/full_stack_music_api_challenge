import {createRouter, createWebHistory} from "vue-router";
import Artists from "../pages/views/artists/ArtistLists.vue";
import Albums from "../pages/views/albums/AlbumLists.vue";
import Login from "../pages/auth/Login.vue";
import Register from "../pages/auth/Register.vue";
import DefaultLayout from "../components/layouts/Layout.vue";
import AuthLayout from "../components/layouts/auth/SignInLayout.vue";
import store from "../store/index.js";
import Favorites from "../pages/views/favourites/Favorites.vue";
import Google from "../pages/auth/GoogleSignIn.vue";
import ArtistView from "../pages/views/artists/Artist.vue";
import AlbumView from "../pages/views/albums/Album.vue";

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

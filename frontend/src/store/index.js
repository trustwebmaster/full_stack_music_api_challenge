import {createStore} from "vuex";
import axiosClient from "../axios";
import createPersistedState from 'vuex-persistedstate'

const store = createStore({
  plugins: [createPersistedState({
    storage: window.sessionStorage,
  })],
  state: {
    user: {
      data: {},
      token: sessionStorage.getItem("TOKEN"),
    },
    album: {
      data: {},
    },
    currentAlbum: {
      data: {},
    },
    artist: {
      data: {},
    },
    currentArtist: {
      data: {},
    },
    favAlbum: {
      data: {},
    },
    favArtist: {
      data: {},
    },
    currentFavAlbum: {
      data: {},
    },
    currentFavArtist: {
      data: {},
    },
    favoriteAlbums: {
      data: []
    },
    favoriteArtists: {
      data: []
    },
  },
  getters: {},
  actions: {
    // Registration | Login | get User | Logout Actions
    google() {
      return axiosClient.get('/auth/google/redirect')
        .then(({data}) => {
          if (data.url) {
            window.location.href = data.url
          }
        })
    },
    googleCallback({commit}, payload) {
      return axiosClient.get('/auth/google/callback')
        .then(({data}) => {
          commit('setUser', data.user);
          commit('setToken', data.access_token)
          return data;
        })
    },
    register({commit}, payload) {
      return axiosClient.post('/register', payload)
        .then(({data}) => {
          commit('setUser', data.user);
          commit('setToken', data.access_token)
          return data;
        })
    },
    login({commit}, payload) {
      return axiosClient.post('/login', payload)
        .then(({data}) => {
          commit('setUser', data.user);
          commit('setToken', data.access_token)
          return data;
        })
    },
    getUser({commit}) {
      return axiosClient.get('/user')
        .then(res => {
          console.log(res);
          commit('setUser', res.data)
        })
    },
    logout({commit}) {
      return axiosClient.post('/logout')
        .then(response => {
          commit('logout')
          return response;
        })
    },

    //Get requests Actions
    searchAlbum({commit}, name) {
      return axiosClient.post('/albums' ,name)
      .then(({data}) => {
        commit('setAlbum', data.album);
        return data;
      })
        .catch((err) => {
          throw err;
        });
    },

      searchArtist({ commit }, name) {
          return axiosClient.post('/artists', { name: name })
              .then(({ data }) => {
                  if (data.success) {
                      if (data.data.length > 0) {
                          commit('setArtist', data.data[0]);
                          return data;
                      } else {
                          console.warn('No artist data found for the provided name.');
                      }
                  } else {
                      console.error('Search artist request failed:', data.message);
                      throw new Error(data.message);
                  }
              })
              .catch((err) => {
                  console.error('Error in searchArtist action:', err);
                  throw err;
              });
      },

    //GetCurrent Album
    getCurrentAlbum({commit}, artist, name) {
      return axiosClient.get('/album/view/'+ artist +'/'+name)
        .then(({data}) => {
          commit('setCurrentAlbum', data.album);
          return data;
        })
        .catch((err) => {
          throw err;
        });
    },

    //Get Current Artist
    getCurrentArtist({commit}, name) {
        return axiosClient.post('/artist/view', { name: name })
            .then(({ data }) => {
                if (data.success) {
                    if (data.data) {
                        commit('setCurrentArtist', data.data);
                        return data.data;

                    } else {
                        console.warn('No artist data found for the provided name.');
                    }
                } else {
                    console.error('Search artist request failed:', data.message);
                    throw new Error(data.message);
                }
            })
            .catch((err) => {
                console.error('Error in searchArtist action:', err);
                throw err;
            });
    },

    //Get requests: favorites Action
    getFavoriteAlbums({commit}) {
      return axiosClient.get('/favourite/albums')
        .then(({data}) => {
          commit('setFavAlbum', data.favAlbum);
          return data;
        })
    },
    getFavoriteArtist({commit}) {
      return axiosClient.get('/favourite/artists')
        .then(({data}) => {
          commit('setFavArtist', data.favArtist);
          return data;
        })
    },

    //Add to favorites Actions
    favoriteAlbum({commit}, payload) {
      return axiosClient.post('/favourite/albums', payload)
        .then(({data}) => {
          commit('setFavAlbum', data.favAlbum);
          return data;
        })
    },
    favoriteArtist({commit}, payload) {
      return axiosClient.post('/favourite/artists', payload)
        .then(({data}) => {
          commit('setFavArtist', data.favArtist);
          return data;
        })
    },

    //Get currentFav Actions
    getCurrentFavAlbum({commit}, payload) {
      return axiosClient.get('/favourite/albums', payload)
        .then(({data}) => {
          commit('setCurrentFavAlbum', data.currentFavAlbum);
          return data;
        })
    },
    getCurrentFavArtist({commit}, payload) {
      return axiosClient.get('/favourite/artists', payload)
        .then(({data}) => {
          commit('setCurrentFavArtist', data.currentFavArtist);
          return data;
        })
    },

    //Destroy to favorites Actions
    deleteFavAlbum({commit}, payload) {
      return axiosClient.delete('/favourite/albums/'+payload)
    },
    deleteFavArtist({commit}, payload) {
      return axiosClient.delete('/favourite/artists/'+payload)
    },
  },
  mutations: {
    setAlbum: (state, album) => {
      state.album.data = album;
    },
    setArtist: (state, artist) => {
      state.artist.data = artist;
    },
    setCurrentAlbum: (state, album) => {
      state.currentAlbum.data = album;
    },
    setCurrentArtist: (state, artist) => {
      state.currentArtist.data = artist;
    },
    setFavAlbum: (state, favAlbum) => {
      state.favAlbum.data = favAlbum;
    },
    setFavArtist: (state, favArtist) => {
      state.favArtist.data = favArtist;
    },
    setCurrentFavAlbum: (state, album) => {
      state.currentFavAlbum.data = album;
    },
    setCurrentFavArtist: (state, artist) => {
      state.currentFavArtist.data = artist;
    },
    logout: (state) => {
      state.user.token = null;
      state.user.data = {};
      sessionStorage.removeItem("TOKEN");
      sessionStorage.clear();
    },
    setUser: (state, user) => {
      state.user.data = user;
    },
    setToken: (state, token) => {
      state.user.token = token;
      sessionStorage.setItem('TOKEN', token);
    },
  },
  modules: {},
})

export default store;

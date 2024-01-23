<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
  <PageComponent>
    <div>
      <div class="float-left">
        <!--        Shown when there is no item in both albums and artists          -->
        <div v-if="!favoriteAlbums.length && !favoriteArtists.length" id="alert-border-4"
             class="flex p-4 mb-4 text-yellow-800 border-t-4 border-yellow-300 bg-yellow-50 dark:text-yellow-300 dark:bg-gray-800 dark:border-yellow-800"
             role="alert">
          <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                  d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                  clip-rule="evenodd"></path>
          </svg>
          <div class="ml-3 text-sm font-medium">
            No item in favorites. Albums or artist you choose as favorites will show here.
          </div>
          <button type="button"
                  class="ml-auto -mx-1.5 -my-1.5 bg-yellow-50 text-yellow-500 rounded-lg focus:ring-2 focus:ring-yellow-400 p-1.5 hover:bg-yellow-200 inline-flex h-8 w-8 dark:bg-gray-800 dark:text-yellow-300 dark:hover:bg-gray-700"
                  data-dismiss-target="#alert-border-4" aria-label="Close">
            <span class="sr-only">Dismiss</span>
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                 xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd"
                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                    clip-rule="evenodd"></path>
            </svg>
          </button>
        </div>

        <!--        This shows all added favorite albums          -->
        <div v-if="favoriteAlbums.length">
          <h4 class="inline-flex text-left px-4 py-2 text-md font-medium text-center text-gray-900">
            Albums
          </h4>
          <div
            v-for="favoriteAlbum in favoriteAlbums"
            :key="favoriteAlbum.id">
            <div id="alert-5" class="flex p-4 bg-gray-50 dark:bg-gray-800" role="alert">
              <div :to="{ name: 'AlbumView', params: {artist: favoriteAlbum.slug, name: favoriteAlbum.album_name} }" class="cursor-pointer flex">
                <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-800 dark:text-gray-300"
                     fill="currentColor"
                     viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Info</span>
                <div class="ml-3 text-sm font-medium text-gray-800 dark:text-gray-300">
                  {{ favoriteAlbum.album_name }},
                </div>
                <div class="ml-3 text-sm font-medium text-gray-800 dark:text-gray-300">
                  {{ favoriteAlbum.slug}}
                </div>
              </div>
              <button @click="()=>deleteFavAlbum(favoriteAlbum.id)"
                      class="ml-auto -mx-1.5 -my-1.5 bg-gray-50 text-gray-500 rounded-lg focus:ring-2 focus:ring-gray-400 p-1.5 hover:bg-gray-200 inline-flex h-8 w-8 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white"
                      data-dismiss-target="#alert-5" aria-label="Close">
                <span class="sr-only">Dismiss</span>
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                     xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
              </button>
            </div>
          </div>
        </div>

        <!--        This shows all added favorite artist          -->
        <div v-if="favoriteArtists.length">
          <h4 class="inline-flex text-left px-4 py-2 text-md font-medium text-center text-gray-900">
            Artist
          </h4>
          <div
            v-for="favoriteArtist in favoriteArtists"
            :key="favoriteArtist.id">
            <div id="alert-5" class="flex p-4 bg-gray-50 dark:bg-gray-800" role="alert">
              <router-link :to="{ name: 'ArtistView', params: {name: favoriteArtist.artist_name} }" class="cursor-pointer flex">
                <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-800 dark:text-gray-300"
                     fill="currentColor"
                     viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Info</span>
                <div class="ml-3 text-sm font-medium text-gray-800 dark:text-gray-300">
                  {{ favoriteArtist.artist_name }}
                </div>
              </router-link>
              <button @click="()=>deleteFavArtist(favoriteArtist.id)"
                      class="ml-auto -mx-1.5 -my-1.5 bg-gray-50 text-gray-500 rounded-lg focus:ring-2 focus:ring-gray-400 p-1.5 hover:bg-gray-200 inline-flex h-8 w-8 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white"
                      data-dismiss-target="#alert-5" aria-label="Close">
                <span class="sr-only">Dismiss</span>
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                     xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>

      <!--        This shows details of clicked item          -->
      <div class="float-right">

      </div>
    </div>

  </PageComponent>
</template>

<script>
import PageComponent from "../../components/PageComponent.vue";
import {ref} from "vue";
import store from "../../store/index.js";
import {useRouter} from "vue-router";

export default {
  components: {
    PageComponent
  },
  setup() {
    const router = useRouter();
    const favoriteAlbums = ref([]);
    const favoriteArtists = ref([]);

    store.dispatch('getFavoriteAlbums')
      .then(data => {
        favoriteAlbums.value = data.data;
      });

    store.dispatch('getFavoriteArtist')
      .then(data => {
        favoriteArtists.value = data.data;
      });

    function deleteFavAlbum(id) {
      if (confirm('Are you sure you want to remove from list?')) {
        store
          .dispatch("deleteFavAlbum", id)
          .then(() => {
            router.push({
              name: "Albums",
            });
          })
          .catch((err) => {
            throw err
          });
      }
    }

    function deleteFavArtist(id) {
      if (confirm('Are you sure you want to remove from list?')) {
        store
          .dispatch("deleteFavArtist", id)
          .then(() => {
            router.push({
              name: "Artists",
            });
          })
          .catch((err) => {
            throw err
          });
      }
    }

    return {
      favoriteAlbums,
      favoriteArtists,
      deleteFavAlbum,
      deleteFavArtist,
    };
  },
}
</script>

<style scoped>
.float-left {
  width: 60%;
  float: left;
  padding: 20px;
}

.float-right {
  width: 40%;
  float: left;
  padding: 20px;
}
</style>

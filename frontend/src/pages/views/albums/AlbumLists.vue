<template>
  <PageComponent>
    <form @submit="searchAlbum">
      <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
      <div class="relative">
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
          <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor"
               viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
          </svg>
        </div>
        <input
          type="search" id="search"
          class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
          placeholder="Search for Most Popular Albums"
          v-model="search">
          <button type="submit"
                  @click="toggle = !toggle"
                  class="text-white absolute right-2.5 bottom-2.5 bg-purple-100 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-800 font-medium rounded-lg text-sm px-4 py-2 dark:bg-purple-800 dark:hover:bg-blue-700 dark:focus:ring-purple-800">
              Search
          </button>
      </div>
    </form>

    <div>
      <div v-show='!toggle' class="whitespace-pre-line">
        <h4
          class="pb-6 mt-6 text-md font-extrabold text-gray-900">
            Results For Searched Album
        </h4>
      </div>

        <div class="bg-white py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <ul role="list" class="mx-auto mt-20 grid max-w-2xl grid-cols-2 gap-x-8 gap-y-16 text-center sm:grid-cols-3 md:grid-cols-4 lg:mx-0 lg:max-w-none lg:grid-cols-5 xl:grid-cols-6">
                    <li v-for="album in albums">
                        <router-link
                            :to="{ name: 'AlbumView', params: {artist: album.artist, name: album.name} }"
                            class="text-blue-700 hover:underline dark:text-blue-500"
                        >
                            <img :src="album.image[2]['#text']" alt="" class="mx-auto h-24 w-24 rounded-full"/>
                            <h3 class="mt-6 text-base font-semibold leading-7 tracking-tight text-gray-900">{{ album.name }}</h3>
                            <p class="text-sm leading-6 text-gray-600">{{ 'Artist : ' +album.artist }}</p>
                        </router-link>
                    </li>
                </ul>
            </div>
        </div>
    </div>
  </PageComponent>
</template>

<script>
import PageComponent from "../../../components/layouts/PageComponent.vue";
import { ref} from "vue";
import store from "../../../store/index.js";

export default {
  components: {
    PageComponent
  },
  setup() {
    const search = ref('');
    const albums = ref([]);

    function searchAlbum(ev) {
      ev.preventDefault();
      if (search.value !== "") {
        store
          .dispatch('searchAlbum', search.value)
          .then(data => {
            albums.value = data.data;
          })
      }
    }

    return {
      search,
      albums,
      searchAlbum,
      toggle: true
    }

  }
}
</script>

<style scoped>

</style>

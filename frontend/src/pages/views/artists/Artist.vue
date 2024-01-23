<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <PageViewHeadComponent>
        <template v-slot:name-rank>
            <h4 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">{{ artist.name }}</h4>
            <h4 class="mb-2 text-2xl text-gray-900 dark:text-white" v-if="artist.stats">{{ 'Listeners - ' + artist.stats.listeners }}</h4>
            <p class="mb-3 text-lg italic text-white opacity-0 transition-opacity duration-300 group-hover:opacity-100" v-if="artist.bio && artist.bio.published">
                {{ artist.bio.published }}
            </p>
            <button @click="favoriteArtist"
                    class="text-gray-900 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-500 mr-2 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                     class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                </svg>
                Add to Favorites
            </button>
            <p class="text-white dark:text-white">
                {{ artist.url }}
            </p>
        </template>
        <template v-slot:image>
            <img
                class="h-full w-full object-cover transition-transform duration-500 group-hover:rotate-3 group-hover:scale-125"
                :src="artist.image && artist.image[3] ? artist.image[3]['#text'] : ''" alt=""
            />
        </template>
        <template v-slot:image-info>
            <h1 class="font-dmserif text-3xl font-bold text-white">{{ artist.name }}</h1>
            <button
                class="text-gray-900 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-500 mr-2 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                     class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z"/>
                </svg>
                {{ artist.stats ? artist.stats.playcount : '' }}
            </button>
        </template>

        <div>
            <div class="whitespace-pre-line">
                <p
                    class="mb-3 font-light text-gray-600 dark:text-gray-500 first-line:uppercase first-line:tracking-widest first-letter:text-7xl first-letter:font-bold first-letter:text-gray-900 dark:first-letter:text-gray-600 first-letter:mr-3 first-letter:float-left">
                    {{ artist.bio && artist.bio.content ? artist.bio.content : '' }}
                </p>
            </div>

            <div class="whitespace-pre-line flex justify-between items-center sm:flex sm:space-y-0 sm:space-x-4">
                <div>
                    <h4
                        class="pb-6 mt-6 text-md font-extrabold text-gray-900">
                        Similar Artist
                    </h4>
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <tbody>
                        <tr
                            v-for="similarArtist in artist.similar && artist.similar.artist ? artist.similar.artist : []"
                            :key="similarArtist.url"
                            class="bg-white border-b dark:bg-white dark:border-gray-100 hover:bg-gray-50 dark:hover:bg-gray-200">
                            <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                <img class="w-10 h-10 rounded-full" :src="similarArtist.image && similarArtist.image[2] ? similarArtist.image[2]['#text'] : ''" alt="">
                                <div class="pl-3">
                                    <div class="text-base text-gray-900 font-semibold">{{ similarArtist.name }}</div>
                                    <div class="font-normal text-gray-400">{{ similarArtist.url }}</div>
                                </div>
                            </th>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div>

                </div>
            </div>
        </div>
    </PageViewHeadComponent>
</template>

<script>
import { useRoute, useRouter } from "vue-router";
import store from "../../../store/index.js";
import { ref } from "vue";
import PageViewHeadComponent from "../../../components/layouts/HeaderComponent.vue";

export default {
    name: "ArtistView",
    components: {
        PageViewHeadComponent
    },
    setup() {
        const route = useRoute();
        const router = useRouter();
        const artist = ref({});

        if (route.params.name) {
            store
                .dispatch('getCurrentArtist', route.params.name)
                .then(response => {
                    artist.value = response;
                })
                .catch(error => {
                    console.error("Error fetching artist data:", error);
                });
        }

        const userId = ref(store.state.user.data.id);
        const fav = {
            user_id: userId.value.toString(),
            name: route.params.name,
        };

        function favoriteArtist(ev) {
            ev.preventDefault();
            store
                .dispatch("favoriteArtist", fav)
                .then(() => {
                    router.push({
                        name: "Favorites",
                    });
                })
                .catch(error => {
                    console.error("Error favoriting artist:", error);
                });
        }

        return {
            route,
            router,
            artist,
            userId,
            fav,
            favoriteArtist
        };
    },
};
</script>



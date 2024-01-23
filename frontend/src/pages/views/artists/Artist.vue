<template>
    <PageViewHeadComponent>
    <div class="overflow-hidden bg-white shadow sm:rounded-lg">
        <div class="px-4 py-6 sm:px-6">
            <h3 class="text-base font-semibold leading-7 text-gray-900">Artist Details </h3>
            <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">Personal details.</p>
            <button @click="favoriteArtist"
                    class="text-gray-900 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-500 mr-2 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                     class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                </svg>
                Add to Favorites
            </button>
        </div>
        <div class="border-t border-gray-100">
            <dl class="divide-y divide-gray-100">
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-900">Full name</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ artist.name }}</dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-900">Listeners</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0" v-if="artist.stats">{{ 'Listeners - ' + artist.stats.listeners }}</dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-900">Bio and Publishing Date</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0" v-if="artist.bio && artist.bio.published">
                        {{ artist.bio.published }} </dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-900">Salary expectation</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">$120,000</dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-900">About</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ artist.bio && artist.bio.content ? artist.bio.content : '' }}</dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Similar Attachments</dt>
                    <dd class="mt-2 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                        <ul role="list" class="divide-y divide-gray-100 rounded-md border border-gray-200">

                            <li v-for="similarArtist in artist.similar && artist.similar.artist ? artist.similar.artist : []"
                                :key="similarArtist.url"
                                class="flex items-center justify-between py-4 pl-4 pr-5 text-sm leading-6">
                                <div class="flex w-0 flex-1 items-center">
                                    <PaperClipIcon class="h-5 w-5 flex-shrink-0 text-gray-400" aria-hidden="true" />
                                    <div class="ml-4 flex min-w-0 flex-1 gap-2">
                                        <span class="truncate font-medium">{{ similarArtist.name }}</span>
                                        <span class="flex-shrink-0 text-gray-400">{{ similarArtist.url }}</span>
                                    </div>
                                </div>

                            </li>

                        </ul>
                    </dd>
                </div>
            </dl>
        </div>
    </div>
    </PageViewHeadComponent>
</template>

<script>
import { useRoute, useRouter } from "vue-router";
import store from "../../../store/index.js";
import { ref } from "vue";
import PageViewHeadComponent from "../../../components/layouts/HeaderComponent.vue";
import { PaperClipIcon } from '@heroicons/vue/20/solid';

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



import axiosClient from "../axios";

export default {
    state: {
        album: getDefaultDataState(),
        currentAlbum: getDefaultDataState(),
        favAlbum: getDefaultDataState(),
        currentFavAlbum: getDefaultDataState(),
        favoriteAlbums: { data: [] },
    },
    actions: {
        // ... albums actions ...
    },
    mutations: {
        // ... albums mutations ...
    },
};

function getDefaultDataState() {
    return { data: {} };
}

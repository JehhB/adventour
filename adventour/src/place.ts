import GalleryContainer from "./components/GalleryContainer.vue";
import GalleryItem from "./components/GalleryItem.vue";
import LikeButton from "./components/LikeButton.vue";
import ModalContainer from "./components/ModalContainer.vue";
import ShareButton from "./components/ShareButton.vue";
import ToastContainer from "./components/ToastContainer.vue";
import HotelMap from "./components/HotelMap.vue";
import Summary from "./components/Summary.vue";
import { BIconPinMapFill } from "bootstrap-icons-vue";
import { createApp } from "vue";
import common from "./common";

const app = createApp({});
app.use(common);

app.component("GalleryContainer", GalleryContainer);
app.component("GalleryItem", GalleryItem);
app.component("LikeButton", LikeButton);
app.component("ModalContainer", ModalContainer);
app.component("ShareButton", ShareButton);
app.component("ToastContainer", ToastContainer);
app.component("HotelMap", HotelMap);
app.component("SearchSummary", Summary);
app.component("BIconPinMapFill", BIconPinMapFill);

app.mount("#app");

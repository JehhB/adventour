import "./style.css";
import GalleryContainer from "./components/GalleryContainer.vue";
import GalleryItem from "./components/GalleryItem.vue";
import HotelMap from "./components/HotelMap.vue";
import LikeButton from "./components/LikeButton.vue";
import ModalContainer from "./components/ModalContainer.vue";
import ShareButton from "./components/ShareButton.vue";
import StaySetting from "./components/StaySetting.vue";
import Summary from "./components/Summary.vue";
import ToastContainer from "./components/ToastContainer.vue";
import { createApp } from "vue";
import common from "./common";

const app = createApp({});
app.use(common);

app.component("GalleryContainer", GalleryContainer);
app.component("GalleryItem", GalleryItem);
app.component("HotelMap", HotelMap);
app.component("LikeButton", LikeButton);
app.component("HotelSummary", Summary);
app.component("ModalContainer", ModalContainer);
app.component("ShareButton", ShareButton);
app.component("StaySetting", StaySetting);
app.component("ToastContainer", ToastContainer);

app.mount("#app");

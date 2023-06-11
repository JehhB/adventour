import "./style.css";
import GalleryContainer from "./components/GalleryContainer.vue";
import GalleryItem from "./components/GalleryItem.vue";
import HotelMap from "./components/HotelMap.vue";
import ModalContainer from "./components/ModalContainer.vue";
import StaySetting from "./components/StaySetting.vue";
import Summary from "./components/Summary.vue";
import { BIconHeartFill, BIconShareFill } from "bootstrap-icons-vue";
import { createApp } from "vue";
import common from "./common";

const app = createApp({});
app.use(common);

app.component("GalleryContainer", GalleryContainer);
app.component("GalleryItem", GalleryItem);
app.component("HotelMap", HotelMap);
app.component("HotelSummary", Summary);
app.component("ModalContainer", ModalContainer);
app.component("StaySetting", StaySetting);

app.component("BIconHeartFill", BIconHeartFill);
app.component("BIconShareFill", BIconShareFill);

app.mount("#app");

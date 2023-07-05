import "./style.css";
import GalleryContainer from "./components/GalleryContainer.vue";
import GalleryItem from "./components/GalleryItem.vue";
import HotelMap from "./components/HotelMap.vue";
import LikeButton from "./components/LikeButton.vue";
import ModalContainer from "./components/ModalContainer.vue";
import OfferingOption from "./components/OfferingOption.vue";
import OfferingSelect from "./components/OfferingSelect.vue";
import ShareButton from "./components/ShareButton.vue";
import StaySetting from "./components/StaySetting.vue";
import Summary from "./components/Summary.vue";
import ToastContainer from "./components/ToastContainer.vue";
import { BIconBuildingFill } from "bootstrap-icons-vue";
import { createApp } from "vue";
import common from "./common";

const app = createApp({});
app.use(common);

app.component("BIconBuildingFill", BIconBuildingFill);
app.component("GalleryContainer", GalleryContainer);
app.component("GalleryItem", GalleryItem);
app.component("HotelMap", HotelMap);
app.component("HotelSummary", Summary);
app.component("LikeButton", LikeButton);
app.component("ModalContainer", ModalContainer);
app.component("OfferingOption", OfferingOption);
app.component("OfferingSelect", OfferingSelect);
app.component("ShareButton", ShareButton);
app.component("StaySetting", StaySetting);
app.component("ToastContainer", ToastContainer);

app.mount("#app");

import "./style.css";
import GalleryContainer from "./components/GalleryContainer.vue";
import GalleryItem from "./components/GalleryItem.vue";
import HotelMap from "./components/HotelMap.vue";
import ModalContainer from "./components/ModalContainer.vue";
import OffPage from "./components/OffPage.vue";
import OpenButton from "./components/OpenButton.vue";
import SearchBox from "./components/SearchBox.vue";
import Summary from "./components/Summary.vue";
import ToggleContainer from "./components/ToggleContainer.vue";
import { BIconList, BIconHeartFill, BIconShareFill } from "bootstrap-icons-vue";
import { createApp } from "vue";

const app = createApp({});

app.component("BIconList", BIconList);
app.component("OffPage", OffPage);
app.component("OpenButton", OpenButton);
app.component("SearchBox", SearchBox);
app.component("ToggleContainer", ToggleContainer);

app.component("GalleryContainer", GalleryContainer);
app.component("GalleryItem", GalleryItem);
app.component("HotelMap", HotelMap);
app.component("HotelSummary", Summary);
app.component("ModalContainer", ModalContainer);

app.component("BIconHeartFill", BIconHeartFill);
app.component("BIconShareFill", BIconShareFill);

app.mount("#app");

import { createApp } from "vue";
import SearchBox from "./components/SearchBox.vue";
import ToggleContainer from "./components/ToggleContainer.vue";
import OffPage from "./components/OffPage.vue";
import GalleryContainer from "./components/GalleryContainer.vue";
import GalleryItem from "./components/GalleryItem.vue";
import HotelMap from "./components/HotelMap.vue";
import Summary from "./components/Summary.vue";
import { BIconList, BIconHeartFill, BIconShareFill } from "bootstrap-icons-vue";
import "./style.css";

const app = createApp({});

app.component("SearchBox", SearchBox);
app.component("ToggleContainer", ToggleContainer);
app.component("OffPage", OffPage);

app.component("GalleryContainer", GalleryContainer);
app.component("GalleryItem", GalleryItem);
app.component("HotelMap", HotelMap);
app.component("HotelSummary", Summary);

app.component("BIconList", BIconList);
app.component("BIconHeartFill", BIconHeartFill);
app.component("BIconShareFill", BIconShareFill);

app.mount("#app");

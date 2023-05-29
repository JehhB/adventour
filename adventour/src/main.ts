import { createApp } from "vue";
import SearchBox from "./components/SearchBox.vue";
import CarouselContainer from "./components/CarouselContainer.vue";
import CarouselItem from "./components/CarouselItem.vue";
import ToggleContainer from "./components/ToggleContainer.vue";
import OffPage from "./components/OffPage.vue";
import { BIconList } from "bootstrap-icons-vue";
import "./style.css";

const app = createApp({});

app.component("SearchBox", SearchBox);
app.component("CarouselContainer", CarouselContainer);
app.component("CarouselItem", CarouselItem);
app.component("ToggleContainer", ToggleContainer);
app.component("OffPage", OffPage);

app.component("BIconList", BIconList);

app.mount("#app");

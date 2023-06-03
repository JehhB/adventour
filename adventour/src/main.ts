import "./style.css";

import CarouselContainer from "./components/CarouselContainer.vue";
import CarouselItem from "./components/CarouselItem.vue";
import OffPage from "./components/OffPage.vue";
import OpenButton from "./components/OpenButton.vue";
import SearchBox from "./components/SearchBox.vue";
import ToggleContainer from "./components/ToggleContainer.vue";

import { BIconList } from "bootstrap-icons-vue";
import { createApp } from "vue";

const app = createApp({});

app.component("SearchBox", SearchBox);
app.component("ToggleContainer", ToggleContainer);
app.component("OffPage", OffPage);
app.component("BIconList", BIconList);
app.component("OpenButton", OpenButton);

app.component("CarouselContainer", CarouselContainer);
app.component("CarouselItem", CarouselItem);

app.mount("#app");

import { createApp } from "vue";
import SearchBox from "./components/SearchBox.vue";
import CarouselContainer from "./components/CarouselContainer.vue";
import CarouselItem from "./components/CarouselItem.vue";
import "./style.css";

const app = createApp({});
app.component("SearchBox", SearchBox);
app.component("CarouselContainer", CarouselContainer);
app.component("CarouselItem", CarouselItem);
app.mount("#app");

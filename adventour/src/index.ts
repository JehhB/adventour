import CarouselContainer from "./components/CarouselContainer.vue";
import CarouselItem from "./components/CarouselItem.vue";

import { createApp } from "vue";
import common from "./common";

const app = createApp({});
app.use(common);

app.component("CarouselContainer", CarouselContainer);
app.component("CarouselItem", CarouselItem);

app.mount("#app");

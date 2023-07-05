import CarouselContainer from "./components/CarouselContainer.vue";
import CarouselItem from "./components/CarouselItem.vue";
import LikeButton from "./components/LikeButton.vue";

import { createApp } from "vue";
import common from "./common";

const app = createApp({});
app.use(common);

app.component("CarouselContainer", CarouselContainer);
app.component("CarouselItem", CarouselItem);
app.component("LikeButton", LikeButton);

app.mount("#app");

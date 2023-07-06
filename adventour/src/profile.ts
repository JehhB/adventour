import LikeButton from "./components/LikeButton.vue";
import ChangePic from "./components/ChangePic.vue";
import ChangeName from "./components/ChangeName.vue";

import { createApp } from "vue";
import common from "./common";

const app = createApp({});
app.use(common);

app.component("LikeButton", LikeButton);
app.component("ChangePic", ChangePic);
app.component("ChangeName", ChangeName);
app.mount("#app");

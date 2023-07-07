import "bootstrap/dist/css/bootstrap.css";

import ChangePic from "./components/ChangePic.vue";
import ChangeName from "./components/ChangeName.vue";
import ModalContainer from "./components/ModalContainer.vue";

import { createApp } from "vue";
import common from "./common";

const app = createApp({});
app.use(common);

app.component("ChangePic", ChangePic);
app.component("ChangeName", ChangeName);
app.component("ModalContainer", ModalContainer);
app.mount("#app");

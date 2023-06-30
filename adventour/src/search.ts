import ModalContainer from "./components/ModalContainer.vue";
import StaySetting from "./components/StaySetting.vue";

import {
  BIconCheck,
  BIconChevronLeft,
  BIconChevronRight,
  BIconFunnelFill,
  BIconMapFill,
  BIconSortDown,
  BIconStarFill,
  BIconXLg,
} from "bootstrap-icons-vue";

import { createApp } from "vue";
import common from "./common";

const app = createApp({});
app.use(common);

app.component("ModalContainer", ModalContainer);
app.component("StaySetting", StaySetting);

app.component("BIconCheck", BIconCheck);
app.component("BIconChevronLeft", BIconChevronLeft);
app.component("BIconChevronRight", BIconChevronRight);
app.component("BIconFunnelFill", BIconFunnelFill);
app.component("BIconMapFill", BIconMapFill);
app.component("BIconSortDown", BIconSortDown);
app.component("BIconStarFill", BIconStarFill);
app.component("BIconXLg", BIconXLg);

app.mount("#app");

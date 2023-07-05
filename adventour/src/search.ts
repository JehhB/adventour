import ModalContainer from "./components/ModalContainer.vue";
import HotelMap from "./components/HotelMap.vue";
import StaySetting from "./components/StaySetting.vue";
import LikeButton from "./components/LikeButton.vue";

import {
  BIconBuildingFill,
  BIconCalendarEventFill,
  BIconCheck,
  BIconChevronLeft,
  BIconChevronRight,
  BIconFunnelFill,
  BIconMapFill,
  BIconPinMapFill,
  BIconSortDown,
  BIconStarFill,
  BIconXLg,
} from "bootstrap-icons-vue";

import { createApp } from "vue";
import common from "./common";

const app = createApp({});
app.use(common);

app.component("LikeButton", LikeButton);
app.component("ModalContainer", ModalContainer);
app.component("StaySetting", StaySetting);
app.component("HotelMap", HotelMap);

app.component("BIconBuildingFill", BIconBuildingFill);
app.component("BIconCalendarEventFill", BIconCalendarEventFill);
app.component("BIconCheck", BIconCheck);
app.component("BIconChevronLeft", BIconChevronLeft);
app.component("BIconChevronRight", BIconChevronRight);
app.component("BIconFunnelFill", BIconFunnelFill);
app.component("BIconMapFill", BIconMapFill);
app.component("BIconPinMapFill", BIconPinMapFill);
app.component("BIconSortDown", BIconSortDown);
app.component("BIconStarFill", BIconStarFill);
app.component("BIconXLg", BIconXLg);

app.mount("#app");

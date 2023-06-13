import "./style.css";

import OffPage from "./components/OffPage.vue";
import OpenButton from "./components/OpenButton.vue";
import SearchBox from "./components/SearchBox.vue";
import ToastContainer from "./components/ToastContainer.vue";
import PopoverContainer from "./components/PopoverContainer.vue";

import { BIconList, BIconGear, BIconBoxArrowRight } from "bootstrap-icons-vue";
import type { App } from "vue";

export default {
  install(app: App<Element>) {
    app.component("BIconBoxArrowRight", BIconBoxArrowRight);
    app.component("BIconGear", BIconGear);
    app.component("BIconList", BIconList);
    app.component("OffPage", OffPage);
    app.component("OpenButton", OpenButton);
    app.component("PopoverContainer", PopoverContainer);
    app.component("SearchBox", SearchBox);
    app.component("ToastContainer", ToastContainer);
  },
};

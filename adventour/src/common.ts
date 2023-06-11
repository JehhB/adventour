import "./style.css";

import OffPage from "./components/OffPage.vue";
import OpenButton from "./components/OpenButton.vue";
import SearchBox from "./components/SearchBox.vue";
import ToggleContainer from "./components/ToggleContainer.vue";

import { BIconList } from "bootstrap-icons-vue";
import type { App } from "vue";

export default {
  install(app: App<Element>) {
    app.component("BIconList", BIconList);
    app.component("OffPage", OffPage);
    app.component("OpenButton", OpenButton);
    app.component("SearchBox", SearchBox);
    app.component("ToggleContainer", ToggleContainer);
  },
};

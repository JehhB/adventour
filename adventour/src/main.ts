import { createApp } from "vue";
import SearchBox from "./components/SearchBox.vue";
import "./style.css";

const app = createApp({});
app.component("SearchBox", SearchBox);
app.mount("#app");

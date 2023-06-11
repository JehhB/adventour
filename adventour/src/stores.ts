import { reactive } from "vue";
import { ToggleableProps } from "./types";

export const toggleables = reactive<Map<string | symbol, ToggleableProps>>(
  new Map()
);

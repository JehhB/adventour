import { reactive } from "vue";
import { useUrlSearchParams } from "@vueuse/core";
import { ToggleableProps } from "./types";

export const toggleables = reactive<Map<string | symbol, ToggleableProps>>(
  new Map()
);

export const urlSearchParams = useUrlSearchParams();

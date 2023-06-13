<template>
  <div
    v-show="toggleable.active.value"
    class="absolute right-0 top-full drop-shadow-lg filter"
  >
    <svg
      xmlns="http://www.w3.org/2000/svg"
      version="1.1"
      viewBox="0 0 16 8"
      class="absolute right-5 top-0 h-2 w-4 translate-x-1/2 sm:right-6"
    >
      <polygon fill="white" style="" points="0,8 16,8 8,0" />
    </svg>
    <OnClickOutside
      @trigger="toggleable.close()"
      class="absolute right-0 top-2 min-w-[48px] rounded-lg bg-white"
    >
      <slot></slot>
    </OnClickOutside>
  </div>
</template>
<script setup lang="ts">
import { defineProps } from "vue";
import { useToggleable } from "../util";
import { toggleables } from "../stores";
import { OnClickOutside } from "@vueuse/components";

const props = defineProps<{
  name: string | symbol;
}>();

const toggleable = useToggleable(true);
toggleables.set(props.name, toggleable);
</script>

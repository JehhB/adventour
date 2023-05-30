<template>
  <Teleport to="body">
    <Transition
      enter-from-class="translate-x-full"
      enter-to-class="translate-x-0 transition-transform duration-200 ease-in"
      leave-from-class="translate-x-0"
      leave-to-class="translate-x-full transition-transform duration-150 ease-out"
    >
      <div class="absolute inset-y-0 right-0 z-50 bg-white" v-show="active">
        <slot v-bind="props"></slot>
      </div>
    </Transition>

    <Transition
      enter-from-class="!opacity-0"
      enter-to-class="transition-opacity duration-200 ease-in"
      leave-to-class="!opacity-0 transition-opacity duration-150 ease-out"
    >
      <div
        class="absolute inset-0 z-40 bg-gray-600 opacity-20"
        @click="close()"
        v-show="active"
      ></div>
    </Transition>
  </Teleport>
</template>
<script setup lang="ts">
import { defineSlots, defineProps, watchEffect } from "vue";
import type { ToggleableProps } from "../types";

const props = defineProps<ToggleableProps>();
defineSlots<{
  default(props: ToggleableProps);
}>();

watchEffect(function (onCleanup) {
  //eslint-disable-next-line
  const app = document.querySelector("#app") as any;
  app.inert = props.active;

  const body = document.querySelector("body");
  if (body) body.style.overflow = props.active ? "hidden" : "auto";

  onCleanup(() => {
    app.inert = false;
  });
});
</script>

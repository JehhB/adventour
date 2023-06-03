<template>
  <Teleport to="body">
    <Transition
      enter-from-class="translate-x-full"
      enter-to-class="translate-x-0 transition-transform duration-200 ease-in"
      leave-from-class="translate-x-0"
      leave-to-class="translate-x-full transition-transform duration-150 ease-out"
    >
      <div
        class="absolute inset-y-0 right-0 z-50 bg-white"
        v-show="container?.active.value"
      >
        <slot></slot>
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
        v-show="container?.active.value"
      ></div>
    </Transition>
  </Teleport>
</template>
<script setup lang="ts">
import { watchEffect, inject } from "vue";
import { toggleableProvider } from "../keys";

const container = inject(toggleableProvider);
function close() {
  if (!container) return;
  container.close();
}

watchEffect(function (onCleanup) {
  if (!container) return;

  //eslint-disable-next-line
  const app = document.querySelector("#app") as any;
  app.inert = container.active.value;

  const body = document.querySelector("body");
  if (body) body.style.overflow = container.active.value ? "hidden" : "auto";

  onCleanup(() => {
    app.inert = false;
  });
});
</script>

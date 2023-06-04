<template>
  <Teleport to="body">
    <Transition
      enter-from-class="opacity-0"
      enter-to-class="opacity-100 transition-opacity duration-200 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0 transition-opacity duration-150 ease-out"
    >
      <div
        class="fixed inset-x-4 top-1/2 z-50 h-64 -translate-y-1/2 rounded-xl bg-white p-4"
        v-show="container?.active.value"
        role="dialog"
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
        class="fixed inset-0 z-40 bg-gray-600 opacity-20"
        @click="close()"
        v-show="container?.active.value"
      ></div>
    </Transition>
  </Teleport>
</template>
<script setup lang="ts">
import { inject } from "vue";
import { toggleableProvider } from "../keys";
import { useInert } from "../util";

const container = inject(toggleableProvider);

function close() {
  if (!container) return;
  container.close();
}

if (container) {
  useInert(container.active);
}
</script>

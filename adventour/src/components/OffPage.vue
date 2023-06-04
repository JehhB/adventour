<template>
  <Teleport to="body">
    <Transition
      enter-from-class="translate-x-full"
      enter-to-class="translate-x-0 transition-transform duration-150 ease-in"
      leave-from-class="translate-x-0"
      leave-to-class="translate-x-full transition-transform duration-100 ease-out"
    >
      <aside
        class="fixed inset-y-0 right-0 z-50 bg-white"
        v-show="container?.active.value"
      >
        <slot></slot>
      </aside>
    </Transition>

    <Transition
      enter-from-class="!opacity-0"
      enter-to-class="transition-opacity duration-150 ease-in"
      leave-to-class="!opacity-0 transition-opacity duration-100 ease-out"
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

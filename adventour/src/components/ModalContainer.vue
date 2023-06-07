<template>
  <Teleport to="body">
    <Transition
      enter-from-class="opacity-0"
      enter-to-class="opacity-100 transition-opacity duration-200 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0 transition-opacity duration-150 ease-out"
    >
      <div
        v-bind="$attrs"
        class="fixed left-1/2 top-1/2 z-50 max-h-[calc(100%_-_2rem)] min-h-[3rem] w-[calc(100%_-_2rem)] max-w-[50ch] -translate-x-1/2 -translate-y-1/2 rounded-xl bg-white"
        v-show="container?.active.value"
        role="dialog"
      >
        <button @click="close()" class="absolute right-2 top-4 text-green-900">
          <BIconX />
        </button>
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
import { BIconX } from "bootstrap-icons-vue";

const container = inject(toggleableProvider);

function close() {
  if (!container) return;
  container.close();
}

if (container) {
  useInert(container.active);
}
</script>

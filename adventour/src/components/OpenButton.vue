<template>
  <button @click="open()" :class="{ 'is-active': container?.active.value }">
    <slot></slot>
  </button>
</template>
<script setup lang="ts">
import { inject } from "vue";
import { toggleableProvider } from "../keys";

const container = inject(toggleableProvider);
function open() {
  if (!container) return;
  container.open();
}
</script>

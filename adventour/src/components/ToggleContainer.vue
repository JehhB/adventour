<template>
  <slot name="default"></slot>
  <slot name="toggled"></slot>
</template>
<script setup lang="ts">
import { defineProps, ref, provide, readonly } from "vue";
import { toggleableProvider } from "../keys";

const props = defineProps<{ init?: boolean }>();

const active = ref(props.init || false);

provide(toggleableProvider, {
  active: readonly(active),
  open() {
    active.value = true;
  },
  close() {
    active.value = false;
  },
  toggle() {
    active.value = !active.value;
  },
});
</script>

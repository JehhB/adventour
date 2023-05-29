<template>
  <slot name="default" v-bind="{ active, toggle, open, close }"></slot>
  <slot name="toggled" v-bind="{ active, toggle, open, close }"></slot>
</template>
<script setup lang="ts">
import { defineSlots, defineProps, ref } from "vue";
import type { VNode } from "vue";
import type { ToggleableProps } from "../types";

const props = defineProps<{ init?: boolean }>();

const active = ref(props.init || false);
function toggle() {
  active.value = !active.value;
}
function open() {
  active.value = true;
}
function close() {
  active.value = false;
}

defineSlots<{
  default(props: ToggleableProps): VNode[];
  toggled(props: ToggleableProps): VNode[];
}>();
</script>

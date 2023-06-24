<template>
  <button @click="open()" :class="{ 'is-active': toggleable?.active.value }">
    <slot></slot>
  </button>
</template>
<script setup lang="ts">
import { toggleables } from "../stores";
import { defineProps, defineEmits, computed } from "vue";

const props = defineProps<{ target: string | symbol }>();
const toggleable = computed(() => toggleables.get(props.target));
const emit = defineEmits<{
  (e: "click"): void;
}>();

function open() {
  emit("click");
  if (!toggleable.value) return;
  toggleable.value.open();
}
</script>

<template>
  <button @click="open()" :class="{ 'is-active': toggleable?.active.value }">
    <slot></slot>
  </button>
</template>
<script setup lang="ts">
import { toggleables } from "../stores";
import { defineProps, computed } from "vue";

const props = defineProps<{ target: string | symbol }>();
const toggleable = computed(() => toggleables.get(props.target));

function open() {
  if (!toggleable.value) return;
  toggleable.value.open();
}
</script>

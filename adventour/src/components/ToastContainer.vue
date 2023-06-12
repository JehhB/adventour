<template>
  <ModalContainer :name="modalId"><slot /></ModalContainer>
</template>
<script setup lang="ts">
import ModalContainer from "./ModalContainer.vue";
import { computed, defineProps, watch } from "vue";
import { toggleables } from "../stores";
import { useToggleable } from "../util";
import { useTimeoutFn } from "@vueuse/core";

const modalId = Symbol();
const modal = computed(() => toggleables.get(modalId));

const props = defineProps<{ name: string | symbol }>();
const toggleable = useToggleable();
toggleables.set(props.name, toggleable);

const { start } = useTimeoutFn(
  () => {
    if (!modal.value) return;
    toggleable.close();
    modal.value.close();
  },
  1500,
  { immediate: false }
);

watch(toggleable.active, (active) => {
  if (!modal.value) return;
  if (active) {
    modal.value.open();
    start();
  }
});
</script>

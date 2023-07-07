<template>
  <component
    :is="is"
    @click="open()"
    class="cursor-pointer"
    :class="{ 'is-active': toggleable?.active.value }"
  >
    <slot></slot>
  </component>
</template>
<script setup lang="ts">
import { toggleables } from "../stores";
import { withDefaults, defineProps, defineEmits, computed } from "vue";

const props = withDefaults(
  defineProps<{ target: string | symbol; is?: string }>(),
  { is: "button" }
);
const toggleable = computed(() => toggleables.get(props.target));
const emit = defineEmits<{
  (e: "click"): void;
}>();

function open() {
  console.log("test");
  emit("click");
  if (!toggleable.value) return;
  toggleable.value.open();
}
</script>

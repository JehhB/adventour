<template>
  <div class="flex overflow-hidden rounded-lg border border-gray-700">
    <button
      @click="value--"
      :disabled="value <= min"
      class="group flex h-10 w-10 shrink-0 items-center justify-center"
    >
      <BIconDashLg class="text-green-900 group-disabled:text-gray-300" />
    </button>
    <input
      type="number"
      :min="min"
      :max="max"
      v-model="value"
      class="w-0 flex-1 text-center"
    />
    <button
      @click="value++"
      :disabled="value >= max"
      class="group flex h-10 w-10 shrink-0 items-center justify-center"
    >
      <BIconPlusLg class="text-green-900 group-disabled:text-gray-300" />
    </button>
  </div>
</template>
<script setup lang="ts">
import { defineProps, defineEmits, withDefaults, computed } from "vue";
import { BIconPlusLg, BIconDashLg } from "bootstrap-icons-vue";
import { clamp } from "lodash";

const props = withDefaults(
  defineProps<{ modelValue: number; min?: number; max?: number }>(),
  { min: Number.MIN_VALUE, max: Number.MAX_VALUE }
);
const emits = defineEmits<{ (e: "update:modelValue", value: number): void }>();

const value = computed({
  get() {
    return clamp(props.modelValue, props.min, props.max);
  },
  set(newValue) {
    emits("update:modelValue", clamp(newValue, props.min, props.max));
  },
});
</script>

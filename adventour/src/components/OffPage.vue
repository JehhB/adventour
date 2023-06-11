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
        v-show="toggleable.active.value"
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
        @click="toggleable.close()"
        v-show="toggleable.active.value"
      ></div>
    </Transition>
  </Teleport>
</template>
<script setup lang="ts">
import { defineProps } from "vue";
import { toggleables } from "../stores";
import { useInert, useToggleable } from "../util";

const props = defineProps<{ name: string | symbol }>();
const toggleable = useToggleable();
toggleables.set(props.name, toggleable);

useInert(toggleable.active);
</script>

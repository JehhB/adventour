<template>
  <Teleport to="body">
    <Transition
      enter-from-class="scale-90 opacity-0"
      enter-to-class="scale-100 opacity-100 transition duration-200 ease-in"
      leave-from-class="scale-100 opacity-100"
      leave-to-class="scale-75 opacity-0 transition duration-150 ease-out"
    >
      <div
        v-bind="$attrs"
        class="fixed left-1/2 z-50 max-h-[calc(100%_-_1rem)] min-h-[3rem] w-[calc(100%_-_1rem)] max-w-[50ch] -translate-x-1/2 overflow-y-scroll rounded-xl bg-white"
        :class="[
          props.position === 'center' && 'top-1/2 -translate-y-1/2',
          props.position === 'top' && 'top-2',
          props.position === 'bottom' && 'bottom-2',
        ]"
        v-show="toggleable.active.value"
        role="dialog"
      >
        <button
          v-if="closeButton"
          @click="
            toggleable.close();
            emit('close');
          "
          class="absolute right-2 top-4 text-green-900"
        >
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
        @click="
          toggleable.close();
          emit('close');
        "
        v-show="toggleable.active.value"
      ></div>
    </Transition>
  </Teleport>
</template>
<script setup lang="ts">
import { defineEmits, defineProps, withDefaults } from "vue";
import { useInert, useToggleable } from "../util";
import { BIconX } from "bootstrap-icons-vue";
import { toggleables } from "../stores";

const props = withDefaults(
  defineProps<{
    name: string | symbol;
    position?: "center" | "top" | "bottom";
    closeButton?: boolean;
  }>(),
  {
    position: "center",
    closeButton: true,
  }
);

const emit = defineEmits(["close"]);

const toggleable = useToggleable();
toggleables.set(props.name, toggleable);

useInert(toggleable.active);
</script>

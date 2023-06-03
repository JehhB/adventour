<template>
  <button
    @click="gallery?.spotlight(src, alt)"
    class="shrink-0 overflow-hidden rounded-lg"
  >
    <img v-bind="props" class="h-16" />
  </button>
</template>
<script setup lang="ts">
import { galleryProvider } from "../keys";
import { withDefaults, defineProps, inject } from "vue";

const props = withDefaults(
  defineProps<{
    src: string;
    alt?: string;
  }>(),
  {
    alt: "",
  }
);

const gallery = inject(galleryProvider);
gallery?.register(props.src, props.alt);
</script>

<template>
  <div class="sm:space-y-2">
    <div
      class="aspect-h-12 aspect-w-16 overflow-hidden sm:aspect-h-10 sm:rounded-3xl"
    >
      <img
        v-if="hasItem"
        :src="src"
        :alt="alt"
        :key="src"
        class="object-cover"
      />
    </div>
    <div class="w-full overflow-x-auto rounded-lg bg-gray-200 p-2">
      <div class="flex gap-2">
        <slot></slot>
      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
import { provide, ref } from "vue";
import { GalleryProvider } from "../keys";

const src = ref("");
const alt = ref("placeholder");
const hasItem = ref(false);

provide(GalleryProvider, {
  register(newSrc, newAlt) {
    if (!hasItem.value) {
      this.spotlight(newSrc, newAlt);
      hasItem.value = true;
    }
  },
  spotlight(newSrc, newAlt) {
    src.value = newSrc;
    alt.value = newAlt;
  },
});
</script>

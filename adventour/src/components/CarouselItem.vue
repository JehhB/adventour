<template>
  <a
    :href="link"
    tabindex="-1"
    class="absolute inset-0 flex flex-col justify-end overflow-clip p-8 text-white"
    v-if="active"
  >
    <img
      :src="image"
      class="absolute inset-0 -z-20 h-full w-full object-cover"
    />
    <div class="overlay absolute inset-0 -z-10 font-light"></div>
    <span class="text-5xl leading-none">
      {{ title }}
    </span>
    <span v-if="subtitle" class="carousel-item__address">
      {{ subtitle }}
    </span>
  </a>
</template>
<style scoped>
.overlay {
  background: linear-gradient(
    360deg,
    rgba(1, 1, 1, 0.65) 0%,
    rgba(0, 0, 0, 0) 40%,
    rgba(0, 0, 0, 0) 100%
  );
}
</style>
<script setup lang="ts">
import { defineProps, inject, ref } from "vue";
import { carouselProvider } from "../keys";

const active = ref(false);

const container = inject(carouselProvider);

if (container) {
  container.register({
    show() {
      active.value = true;
    },
    hide() {
      active.value = false;
    },
  });
}

defineProps<{
  link: string;
  image: string;
  title: string;
  subtitle: string;
}>();
</script>

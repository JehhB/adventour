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
  background: radial-gradient(
    114.3% 170.53% at 11.89% 114.3%,
    #1d2417 0%,
    #1b3308 4.69%,
    rgba(27, 51, 8, 0) 100%
  );
}
</style>
<script setup lang="ts">
import { defineProps, inject, ref } from "vue";
import { CarouselProvider } from "../keys";

const active = ref(false);

const container = inject(CarouselProvider);

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

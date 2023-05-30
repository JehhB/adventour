<template>
  <div class="sm:space-y-2">
    <div
      class="aspect-h-12 aspect-w-16 overflow-hidden sm:aspect-h-10 sm:rounded-lg"
    >
      <Transition
        enter-from-class="opacity-0"
        enter-to-class="transition-opacity opacity-100 delay-50 duration-200"
        leave-from-class="opacity-100"
        leave-to-class="transition-opacity opacity-0 duration-200"
      >
        <img
          v-if="hasItem"
          :src="src"
          :alt="alt"
          :key="src"
          class="object-cover"
        />
      </Transition>
    </div>
    <div class="relative">
      <button
        @click="slideLeft"
        class="absolute left-0 top-1/2 z-10 h-8 -translate-y-1/2 bg-gray-600 opacity-50 transition-[opacity,height] hover:h-full hover:opacity-100"
        v-show="showSliderControl"
      >
        <BIconChevronLeft class="scale-y-150 text-white" />
        <span class="sr-only">slide left</span>
      </button>
      <div
        class="w-full overflow-x-auto scroll-smooth rounded-lg bg-gray-200 p-2"
        ref="slider"
      >
        <div class="flex gap-2">
          <slot></slot>
        </div>
      </div>
      <button
        @click="slideRight"
        class="absolute right-0 top-1/2 z-10 h-8 -translate-y-1/2 bg-gray-600 opacity-50 transition-[opacity,height] hover:h-full hover:opacity-100"
        v-show="showSliderControl"
      >
        <BIconChevronRight class="scale-y-150 text-white" />
        <span class="sr-only">slide right</span>
      </button>
    </div>
  </div>
</template>
<script setup lang="ts">
import { onMounted, provide, ref } from "vue";
import { GalleryProvider } from "../keys";
import { BIconChevronLeft, BIconChevronRight } from "bootstrap-icons-vue";
import { useEventListener } from "@vueuse/core";

const slider = ref<HTMLDivElement>();
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

const sliderIncrement = 64;
function slideRight() {
  if (slider.value) slider.value.scrollLeft += sliderIncrement;
}

function slideLeft() {
  if (slider.value) slider.value.scrollLeft -= sliderIncrement;
}

const showSliderControl = ref(true);
function checkSize() {
  if (slider.value === undefined) return;
  showSliderControl.value =
    slider.value.clientWidth !== slider.value.scrollWidth;
}
useEventListener(window, "resize", checkSize);
onMounted(checkSize);
</script>

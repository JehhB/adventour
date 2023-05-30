<template>
  <div
    class="relative w-full overflow-hidden sm:rounded-3xl lg:w-8/12 xl:w-7/12"
    ref="carousel"
    @wheel.shift.prevent="onScroll"
  >
    <div
      class="aspect-h-12 aspect-w-16 md:aspect-h-8 xl:aspect-h-7 2xl:aspect-h-6"
    >
      <div>
        <TransitionGroup
          enter-from-class="opacity-0"
          enter-to-class="transition-opacity opacity-100 delay-150 duration-500"
          leave-from-class="opacity-100"
          leave-to-class="transition-opacity opacity-0 duration-500"
        >
          <slot></slot>
        </TransitionGroup>
        <div
          class="absolute inset-auto bottom-3 left-1/2 z-10 h-auto -translate-x-1/2 space-x-[0.325rem]"
        >
          <button
            v-for="i in length"
            :key="i"
            @click="setActive(i - 1)"
            class="h-2 rounded-full border-2 border-white transition-[width,background-color]"
            :class="
              activeIndex === i - 1 ? 'w-6 bg-white' : 'w-3 bg-transparent'
            "
          >
            <span class="sr-only"> View feature {{ i }} </span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
import {
  computed,
  onBeforeUnmount,
  onMounted,
  provide,
  reactive,
  ref,
  watch,
} from "vue";
import { usePointerSwipe } from "@vueuse/core";
import { CarouselProvider } from "../keys";
import debounce from "lodash/debounce";

type CarouselItem = { show(): void; hide(): void };

const items = reactive([] as CarouselItem[]);
const length = computed(() => items.length);
const activeIndex = ref(-1);
const carousel = ref<HTMLDivElement>();

function register(item: CarouselItem) {
  items.push(item);
  if (activeIndex.value === -1) activeIndex.value = 0;

  return () => {
    const index = items.indexOf(item);
    items.splice(index, 1);
  };
}
provide(CarouselProvider, { register });

function increment() {
  activeIndex.value = (activeIndex.value + 1) % length.value;
}

function decrement() {
  activeIndex.value = (activeIndex.value + 7) % length.value;
}

function setActive(i: number) {
  resetInterval();
  activeIndex.value = i;
}

watch(activeIndex, function (active) {
  items.forEach((item, index) => {
    if (index !== active) item.hide();
  });
  items[active].show();
});

const interval = ref<number>();
function startInterval() {
  interval.value = setInterval(increment, 7500);
}

function resetInterval() {
  clearInterval(interval.value);
  startInterval();
}

onMounted(() => {
  startInterval();
});
onBeforeUnmount(() => {
  clearInterval(interval.value);
});

const { distanceX } = usePointerSwipe(carousel, {
  onSwipeEnd(event, direction) {
    if (!carousel.value) return;
    const width = carousel.value.clientWidth;

    if (Math.abs(distanceX.value) / width > 0.5) {
      resetInterval();
      if (direction == "left") increment();
      else if (direction == "right") decrement();
    }
  },
});

const onScroll = debounce(function (event: WheelEvent) {
  resetInterval();
  if (event.wheelDelta < 0) {
    increment();
  } else {
    decrement();
  }
}, 150);
</script>

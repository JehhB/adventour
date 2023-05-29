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
        <Transition
          enter-from-class="opacity-0"
          enter-to-class="transition-opacity opacity-100 delay-150 duration-500"
          leave-from-class="opacity-100"
          leave-to-class="transition-opacity opacity-0 duration-500"
        >
          <Render :vnode="defaultSlots[activeIndex]" :key="activeIndex" />
        </Transition>
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
  PropType,
  computed,
  defineComponent,
  defineSlots,
  onBeforeUnmount,
  onMounted,
  ref,
} from "vue";
import { usePointerSwipe } from "@vueuse/core";
import debounce from "lodash/debounce";
import type { VNode } from "vue";

const slots = defineSlots<{
  default?(): VNode[];
}>();
const defaultSlots = computed(() =>
  (slots.default ? slots.default() : []).filter(
    //eslint-disable-next-line
    (vnode: any) => vnode.type.__name == "CarouselItem"
  )
);
const length = computed(() => defaultSlots.value.length);

const activeIndex = ref(0);
const carousel = ref<HTMLDivElement>();

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

const Render = defineComponent({
  props: {
    vnode: {
      required: true,
      type: Object as PropType<VNode>,
    },
  },
  render: (props: { vnode: VNode }) => props.vnode,
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

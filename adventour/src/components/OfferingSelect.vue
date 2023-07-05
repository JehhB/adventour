<template>
  <div>
    <div>
      <div class="flex items-center gap-2">
        <BIconMoonStars class="h-[14px] w-[14px] text-green-900" />
        <span class="text-sm leading-none text-gray-800">
          {{ stays }} Nights
        </span>
      </div>
      <div class="mt-2 flex items-center gap-2">
        <BIconPeople class="h-[14px] w-[14px] text-green-900" />
        <span class="text-sm leading-none text-gray-800">
          Up to {{ maxPerson }} persons
        </span>
      </div>
      <div class="mt-2 flex items-center gap-2">
        <BIconCupHot class="h-[14px] w-[14px] text-green-900" />
        <span class="text-sm leading-none text-gray-800">
          {{ longMealPlan(mealPlan) }}
        </span>
      </div>
    </div>
    <div class="mt-3 text-xs font-bold leading-none">Price per night</div>
    <div class="ml-8 mt-1 flex items-start gap-2">
      <del
        v-if="originalPrice !== 0"
        class="text-base leading-none text-gray-500"
      >
        &#8369; {{ Math.floor(originalPrice) }}
      </del>
      <span class="text-2xl leading-none text-green-900">
        &#8369; {{ Math.floor(price) }}
      </span>
    </div>
    <div class="mt-2 grid grid-cols-2 gap-x-2">
      <OpenButton
        :target="selectorModal"
        class="grid h-9 place-items-center rounded-lg border border-green-900"
      >
        <span class="text-xs font-semibold leading-none text-green-900">
          Other options
        </span>
      </OpenButton>
      <a href="#" class="grid h-9 place-items-center rounded-lg bg-green-900">
        <span class="text-xs font-semibold leading-none text-white">
          Reserve
        </span>
      </a>
    </div>
    <ModalContainer :name="selectorModal" class="!max-w-xs p-3 pt-4">
      <slot />
      <div class="mb-3 font-medium leading-none text-gray-400">
        Other options
      </div>

      <div class="mt-2 space-y-2">
        <template v-for="(item, i) in items" :key="item.offeringId">
          <button @click="activeIndex = i" class="flex items-center gap-2">
            <div
              v-if="activeIndex === i"
              class="flex items-center rounded-full border border-green-900 bg-[#C0D1A9]"
            >
              <BIconCheck class="inline h-4 w-4 text-center text-green-900" />
            </div>
            <div
              v-else
              class="h-4 w-4 rounded-full border border-gray-300 bg-gray-100"
            ></div>

            <span class="flex flex-wrap gap-1 leading-none text-gray-800">
              <span class="shrink-0">{{ item.stays }}</span>
              <BIconMoonStars class="shrink-0" />
              <span class="shrink-0">&centerdot;</span>
              <span class="shrink-0">{{ item.maxPerson }}</span>
              <BIconPeople class="shrink-0" />
              <span class="shrink-0">&centerdot;</span>
              <span class="shrink-0">{{ shortMealPlan(item.mealPlan) }}</span>
              <BIconCupHot class="shrink-0" />
              <span class="shrink-0">&centerdot;</span>
              <span class="shrink-0">&#8369; {{ Math.floor(item.price) }}</span>
            </span>
          </button>
        </template>
      </div>
    </ModalContainer>
  </div>
</template>
<script setup lang="ts">
import {
  BIconPeople,
  BIconCupHot,
  BIconMoonStars,
  BIconCheck,
} from "bootstrap-icons-vue";
import ModalContainer from "./ModalContainer.vue";
import OpenButton from "./OpenButton.vue";
import { offeringSelectProvider } from "../keys";
import { computed, provide, reactive, ref } from "vue";
import type { Offering } from "../types";

const items = reactive([]) as Offering[];
const selectorModal = Symbol();

const activeIndex = ref(0);

const price = computed(() =>
  items.length > activeIndex.value ? items[activeIndex.value].price : 0
);
const originalPrice = computed(() =>
  items.length > activeIndex.value ? items[activeIndex.value].originalPrice : 0
);
const mealPlan = computed(() =>
  items.length > activeIndex.value ? items[activeIndex.value].mealPlan : "none"
);
const stays = computed(() =>
  items.length > activeIndex.value ? items[activeIndex.value].stays : 0
);

const maxPerson = computed(() =>
  items.length > activeIndex.value ? items[activeIndex.value].maxPerson : 0
);

function longMealPlan(plan: "breakfast" | "all_inclusive" | "none") {
  if (plan === "breakfast") return "Breakfast included";
  else if (plan === "all_inclusive") return "All meals included";
  else return "Meals not included";
}

function shortMealPlan(plan: "breakfast" | "all_inclusive" | "none") {
  if (plan === "breakfast") return "With breakfast";
  else if (plan === "all_inclusive") return "With meals";
  else return "No meals";
}

function register(item: Offering) {
  items.push(item);
  return;
}
provide(offeringSelectProvider, { register });
</script>

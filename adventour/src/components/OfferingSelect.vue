<template>
  <div>
    <div>
      <div class="flex items-center gap-2">
        <BIconMoonStars class="h-[14px] w-[14px] text-green-900" />
        <span class="text-sm leading-none text-gray-800">10 Nights</span>
      </div>
      <div class="mt-2 flex items-center gap-2">
        <BIconCupHot class="h-[14px] w-[14px] text-green-900" />
        <span class="text-sm leading-none text-gray-800"
          >Meals not included</span
        >
      </div>
    </div>
    <div class="mt-3 text-xs font-bold leading-none">Price per night</div>
    <div class="ml-8 mt-1 flex items-start gap-2">
      <del class="text-base leading-none text-gray-500"> &#8369; 5000 </del>
      <span class="text-2xl leading-none text-green-900"> &#8369; 4000 </span>
    </div>
    <div class="mt-2 grid grid-cols-2 gap-x-2">
      <button
        class="grid h-9 place-items-center rounded-lg border border-green-900"
      >
        <span class="text-xs font-semibold leading-none text-green-900">
          Reserve
        </span>
      </button>
      <a href="#" class="grid h-9 place-items-center rounded-lg bg-green-900">
        <span class="text-xs font-semibold leading-none text-white">
          Reserve
        </span>
      </a>
    </div>
  </div>
</template>
<script setup lang="ts">
import { BIconCupHot, BIconMoonStars } from "bootstrap-icons-vue";
</script>

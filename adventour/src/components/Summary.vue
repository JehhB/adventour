<template>
  <a :href="link" class="flex !text-black">
    <img
      :src="image"
      :alt="caption"
      class="h-[76px] w-[76px] shrink-0 rounded object-cover"
    />
    <div class="ml-2 flex flex-1 flex-col gap-2">
      <div class="mt-2 flex items-center gap-1 text-base leading-none">
        <component v-if="icon" :is="icon" class="h-4 shrink-0 text-green-900" />
        <span>{{ title }}</span>
      </div>
      <div class="text-sm leading-none text-gray-800">
        {{ subtitle }}
      </div>
    </div>
  </a>
</template>
<script setup lang="ts">
import { defineProps } from "vue";
import type { Component } from "vue";

defineProps<{
  icon?: Component | string;
  link: string;
  image: string;
  caption: string;
  title: string;
  subtitle: string;
}>();
</script>

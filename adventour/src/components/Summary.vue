<template>
  <a :href="link" class="flex !text-black">
    <img
      :src="image"
      :alt="caption"
      class="h-[76px] w-[76px] shrink-0 rounded object-cover"
    />
    <div class="ml-2 flex flex-1 flex-col gap-2">
      <span class="mt-2 text-base leading-none">
        {{ title }}
      </span>
      <span class="text-sm leading-none">
        {{ subtitle }}
      </span>
    </div>
  </a>
</template>
<script setup lang="ts">
import { defineProps } from "vue";

defineProps<{
  link: string;
  image: string;
  caption: string;
  title: string;
  subtitle: string;
}>();
</script>

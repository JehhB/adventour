<template>
  <div class="hidden"></div>
</template>
<script setup lang="ts">
import { offeringSelectProvider } from "../keys";
import type { Offering } from "../types";
import { defineProps, inject } from "vue";

const props = defineProps<Offering>();
const select = inject(offeringSelectProvider);

if (select) {
  select.register(props);
}
</script>

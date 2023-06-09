<template>
  <div class="grid h-[240px] w-[280px] grid-cols-7">
    <button
      v-for="(day, index) in days"
      :key="day.getDate()"
      class="disabled:text-gray-500"
      :class="index === 0 && 'col-start-' + (1 + startDay)"
      @click="emit('date', day)"
      :disabled="day < today"
    >
      {{ day.getDate() }}
    </button>
  </div>
</template>
<script setup lang="ts">
import { defineProps, defineEmits, withDefaults } from "vue";

const emit = defineEmits<{
  (e: "date", date: Date): void;
}>();

const props = withDefaults(
  defineProps<{
    month: number;
    year: number;
  }>(),
  {
    month: new Date().getMonth(),
    year: new Date().getFullYear(),
  }
);

const today = new Date();
today.setHours(0);
today.setMinutes(0);
today.setSeconds(0);
today.setMilliseconds(0);

const month = new Date(props.year, props.month);
const startDay = month.getDay();
const numOfDays = new Date(props.year, props.month + 1, 0).getDate();

const days = new Array<Date>(numOfDays);
for (let i = 0; i < numOfDays; ++i) {
  days[i] = new Date(props.year, props.month, 1 + i);
}
</script>

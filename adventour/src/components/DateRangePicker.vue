<template>
  <div class="grid grid-cols-[repeat(7,40px)] justify-center">
    <span
      v-for="day in shortDay"
      class="border-b border-gray-900 text-center leading-8"
      :key="day"
    >
      {{ day }}
    </span>
  </div>
  <div
    class="flex h-[272px] flex-col items-center overflow-y-auto"
    ref="container"
  >
    <div v-for="offset in loaded" :key="offset" class="mt-2">
      <div class="flex h-8 items-center">
        <span class="font-semibold leading-none text-gray-600">
          {{ getMonth(year, month + offset) }}
        </span>
      </div>
      <Calendar
        :month="month + offset"
        :year="year"
        :button-class="buttonClass"
        class="shrink-0"
        @date="handleDate"
      />
    </div>
  </div>
</template>
<script setup lang="ts">
import { useInfiniteScroll } from "@vueuse/core";
import Calendar from "./Calendar.vue";
import { range } from "lodash";
import { withDefaults, defineProps, defineEmits, reactive, ref } from "vue";

const shortDay = ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"];
const today = new Date();
const month = today.getMonth();
const year = today.getFullYear();
const container = ref<HTMLDivElement>();

const loaded = reactive(range(0, 5));

useInfiniteScroll(container, () => {
  if (container.value === undefined) return;
  if (!container.value.checkVisibility()) return;

  const len = loaded.length;
  loaded.push(...range(len, len + 5));
});

function getMonth(year: number, month: number) {
  const months = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
  ];

  const date = new Date(year, month);
  return months[date.getMonth()] + " " + date.getFullYear();
}

const props = withDefaults(
  defineProps<{
    checkin?: Date | null;
    checkout?: Date | null;
  }>(),
  {
    checkin: null,
    checkout: null,
  }
);

const emit = defineEmits<{
  (e: "update:checkin", date: Date | null): void;
  (e: "update:checkout", date: Date | null): void;
}>();

function handleDate(date: Date) {
  if (props.checkin === null) {
    emit("update:checkin", date);
  } else if (props.checkout !== null) {
    emit("update:checkin", date);
    emit("update:checkout", null);
  } else if (date < props.checkin) {
    emit("update:checkin", date);
  } else if (date === props.checkin) {
    emit("update:checkin", null);
  } else {
    emit("update:checkout", date);
  }
}

function buttonClass(d: Date): string | false {
  const checkin = props.checkin === null ? null : props.checkin.valueOf();
  const checkout = props.checkout === null ? null : props.checkout.valueOf();
  const date = d.valueOf();

  if (checkin === null) return false;
  else if (checkout === null)
    return date === checkin && "bg-lime-800 rounded text-white";
  else if (date < checkin || date > checkout) return false;
  else if (date > checkin && date < checkout) return "bg-lime-100";
  else if (date === checkin) return "bg-lime-800 text-white rounded-l";
  else return "bg-lime-800 text-white rounded-r";
}
</script>

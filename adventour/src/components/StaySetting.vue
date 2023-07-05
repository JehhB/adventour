<template>
  <form
    method="get"
    class="sm:grid-cols-stay grid grid-cols-1 gap-1 rounded-lg bg-gray-300 p-1"
    :class="search && 'lg:grid-cols-search'"
  >
    <input
      v-if="hotelParam"
      type="hidden"
      name="hotel_id"
      :value="hotelParam"
    />
    <input type="hidden" name="n_adult" :value="nAdult" />
    <input type="hidden" name="n_child" :value="nChild" />
    <input type="hidden" name="n_room" :value="nRoom" />

    <input
      v-if="urlSearchParams.q"
      type="hidden"
      name="q"
      :value="urlSearchParams.q"
    />
    <input
      v-if="urlSearchParams.filter"
      type="hidden"
      name="filter"
      :value="urlSearchParams.filter"
    />
    <input
      v-if="urlSearchParams.price"
      type="hidden"
      name="price"
      :value="urlSearchParams.price"
    />
    <input
      v-if="urlSearchParams.rating"
      type="hidden"
      name="rating"
      :value="urlSearchParams.rating"
    />
    <input
      v-if="urlSearchParams.sort_by"
      type="hidden"
      name="rating"
      :value="urlSearchParams.sort_by"
    />

    <input
      v-if="checkin !== null"
      type="hidden"
      name="checkin"
      :value="checkin.getTime()"
    />
    <input
      v-if="checkout !== null"
      type="hidden"
      name="checkout"
      :value="checkout.getTime()"
    />

    <div
      v-if="search"
      class="flex h-10 w-full items-center gap-2 rounded-lg bg-white px-2 sm:h-12 sm:max-lg:col-span-full"
    >
      <BIconSearch class="h-6 w-6 text-gray-800" />
      <input
        type="text"
        v-model="searchInput"
        placeholder="Find destination"
        name="q"
        class="w-0 flex-1 self-center text-sm font-medium text-gray-950 placeholder:font-normal placeholder:text-gray-800 sm:text-base"
      />
      <BIconXLg v-show="searchInput" @click="searchInput = ''" />
    </div>

    <div class="relative">
      <OpenButton
        :target="dateRangePickerId"
        type="button"
        class="flex h-10 w-full items-center rounded-lg bg-white px-2 sm:h-12"
      >
        <div class="flex flex-1 items-center gap-2">
          <BIconCalendar2Week class="h-6 w-6 text-gray-800 sm:h-8 sm:w-8" />
          <div class="space-y-1">
            <div
              class="text-left text-xs font-medium leading-none text-gray-950 sm:text-sm sm:leading-none"
            >
              Check in
            </div>
            <div
              class="text-left text-xs leading-none text-gray-800 sm:text-sm sm:leading-none"
            >
              {{ formatDate(checkin) }}
            </div>
          </div>
        </div>

        <div class="flex-1 space-y-1 border-l border-gray-600 pl-2">
          <div
            class="text-left text-xs font-medium leading-none text-gray-950 sm:text-sm sm:leading-none"
          >
            Check out
          </div>
          <div
            class="text-left text-xs leading-none text-gray-800 sm:text-sm sm:leading-none"
          >
            {{ formatDate(checkout) }}
          </div>
        </div>
      </OpenButton>

      <ModalContainer :name="dateRangePickerId" position="bottom">
        <div class="pb-4 pt-9">
          <DateRangePicker
            v-model:checkin="checkin"
            v-model:checkout="checkout"
          />
        </div>
      </ModalContainer>
    </div>

    <div class="relative">
      <OpenButton
        :target="arrangementId"
        type="button"
        class="flex h-10 w-full items-center rounded-lg bg-white px-2 sm:h-12"
      >
        <div class="flex flex-1 items-center gap-2">
          <BIconPeopleFill class="h-6 w-6 text-gray-800 sm:h-8 sm:w-8" />
          <div class="space-y-1">
            <div
              class="text-left text-xs font-medium leading-none text-gray-950 sm:text-sm sm:leading-none"
            >
              Arrangement
            </div>
            <div class="flex gap-6">
              <div
                class="text-left text-xs leading-none text-gray-800 sm:text-sm sm:leading-none"
              >
                {{ nAdult }} Adult
              </div>
              <div
                class="text-left text-xs leading-none text-gray-800 sm:text-sm sm:leading-none"
              >
                {{ nChild }} Child
              </div>
              <div
                class="text-left text-xs leading-none text-gray-800 sm:text-sm sm:leading-none"
              >
                {{ nRoom }} Room
              </div>
            </div>
          </div>
        </div>
      </OpenButton>

      <ModalContainer :name="arrangementId" position="bottom">
        <div class="p-4 pt-9">
          <div class="grid grid-cols-2 gap-y-2">
            <span class="self-center text-sm leading-none">Adult</span>
            <ArrangementInput v-model="nAdult" :min="1" />
            <span class="self-center text-sm leading-none">Child</span>
            <ArrangementInput v-model="nChild" :min="0" />
            <span class="self-center text-sm leading-none">Room</span>
            <ArrangementInput v-model="nRoom" :min="1" />
          </div>
        </div>
      </ModalContainer>
    </div>

    <button
      type="submit"
      class="h-10 rounded-lg bg-green-900 text-sm font-bold leading-none text-white sm:h-12 sm:text-base sm:leading-none"
    >
      {{ search ? "Search" : "Update" }}
    </button>
  </form>
</template>
<script setup lang="ts">
import {
  BIconCalendar2Week,
  BIconPeopleFill,
  BIconSearch,
  BIconXLg,
} from "bootstrap-icons-vue";
import { urlSearchParams } from "../stores";
import ArrangementInput from "./ArrangementInput.vue";
import DateRangePicker from "./DateRangePicker.vue";
import ModalContainer from "./ModalContainer.vue";
import OpenButton from "./OpenButton.vue";
import { withDefaults, defineProps, computed } from "vue";

withDefaults(
  defineProps<{
    search: boolean;
  }>(),
  { search: false }
);

const today = new Date();
today.setHours(0);
today.setMinutes(0);
today.setSeconds(0);
today.setMilliseconds(0);

const arrangementId = Symbol();
const dateRangePickerId = Symbol();

const hotelParam = urlSearchParams.hotel_id;

const searchInput = computed({
  get() {
    return urlSearchParams.q as string;
  },
  set(val) {
    urlSearchParams.q = val;
  },
});

const nAdult = computed({
  get() {
    const init = parseInt((urlSearchParams.n_adult as string) ?? "1");
    if (init < 1) {
      urlSearchParams.n_adult = "1";
      return 1;
    }
    return init;
  },
  set(val) {
    urlSearchParams.n_adult = val.toString();
  },
});

const nChild = computed({
  get() {
    const init = parseInt((urlSearchParams.n_child as string) ?? "0");
    if (init < 0) {
      urlSearchParams.n_child = "0";
      return 0;
    }
    return init;
  },
  set(val) {
    urlSearchParams.n_child = val.toString();
  },
});

const nRoom = computed({
  get() {
    const init = parseInt((urlSearchParams.n_room as string) ?? "1");
    if (init < 1) {
      urlSearchParams.n_room = "1";
      return 1;
    }
    return init;
  },
  set(val) {
    urlSearchParams.n_room = val.toString();
  },
});

const checkin = computed({
  get() {
    if (urlSearchParams.checkin) {
      const date = new Date(parseInt(urlSearchParams.checkin as string));
      if (date < today) {
        delete urlSearchParams.checkin;
        return null;
      }
      return date;
    } else {
      return null;
    }
  },
  set(val) {
    if (val === null || val < today) {
      delete urlSearchParams.checkin;
    } else {
      urlSearchParams.checkin = val.getTime().toString();
    }
  },
});

const checkout = computed({
  get() {
    const prev = checkin.value;
    if (urlSearchParams.checkout) {
      const date = new Date(parseInt(urlSearchParams.checkout as string));
      if (prev === null || date < prev) {
        delete urlSearchParams.checkout;
        return null;
      }
      return date;
    } else {
      return null;
    }
  },
  set(val) {
    const prev = checkin.value;
    if (val === null || prev === null || val < prev) {
      delete urlSearchParams.checkout;
    } else {
      urlSearchParams.checkout = val.getTime().toString();
    }
  },
});

function formatDate(date: Date | null) {
  if (date === null) return "--/--/--";

  const year = String(date.getFullYear() % 100).padStart(2, "0");
  const month = String(date.getMonth() + 1).padStart(2, "0");
  const day = String(date.getDate()).padStart(2, "0");

  return `${month}/${day}/${year}`;
}
</script>

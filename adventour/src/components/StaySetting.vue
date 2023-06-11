<template>
  <form
    method="get"
    class="sm:grid-cols-stay grid grid-cols-1 gap-1 rounded-lg bg-gray-300 p-1"
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

    <div class="relative">
      <OpenButton
        :target="dateRangePickerId"
        type="button"
        class="flex h-10 w-full items-center rounded-lg bg-white px-2 lg:h-12"
      >
        <div class="flex flex-1 items-center gap-2">
          <BIconCalendar2Week class="h-6 w-6 text-gray-800 lg:h-8 lg:w-8" />
          <div class="space-y-1">
            <div
              class="text-left text-xs font-medium leading-none text-gray-950 lg:text-sm lg:leading-none"
            >
              Check in
            </div>
            <div
              class="text-left text-xs leading-none text-gray-800 lg:text-sm lg:leading-none"
            >
              {{ formatDate(checkin) }}
            </div>
          </div>
        </div>

        <div class="flex-1 space-y-1 border-l border-gray-600 pl-2">
          <div
            class="text-left text-xs font-medium leading-none text-gray-950 lg:text-sm lg:leading-none"
          >
            Check out
          </div>
          <div
            class="text-left text-xs leading-none text-gray-800 lg:text-sm lg:leading-none"
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
        class="flex h-10 w-full items-center rounded-lg bg-white px-2 lg:h-12"
      >
        <div class="flex flex-1 items-center gap-2">
          <BIconPeopleFill class="h-6 w-6 text-gray-800 lg:h-8 lg:w-8" />
          <div class="space-y-1">
            <div
              class="text-left text-xs font-medium leading-none text-gray-950 lg:text-sm lg:leading-none"
            >
              Arrangement
            </div>
            <div class="flex gap-6">
              <div
                class="text-left text-xs leading-none text-gray-800 lg:text-sm lg:leading-none"
              >
                {{ nAdult }} Adult
              </div>
              <div
                class="text-left text-xs leading-none text-gray-800 lg:text-sm lg:leading-none"
              >
                {{ nChild }} Child
              </div>
              <div
                class="text-left text-xs leading-none text-gray-800 lg:text-sm lg:leading-none"
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
      class="h-10 rounded-lg bg-green-900 text-sm font-bold leading-none text-white lg:h-12 lg:text-base lg:leading-none"
    >
      Update
    </button>
  </form>
</template>
<script setup lang="ts">
import { BIconCalendar2Week, BIconPeopleFill } from "bootstrap-icons-vue";
import ArrangementInput from "./ArrangementInput.vue";
import DateRangePicker from "./DateRangePicker.vue";
import ModalContainer from "./ModalContainer.vue";
import OpenButton from "./OpenButton.vue";
import { ref } from "vue";

const arrangementId = Symbol();
const dateRangePickerId = Symbol();

const currentSearchParam = new URLSearchParams(document.location.search);
const hotelParam = currentSearchParam.get("hotel_id");

const initNAdult = currentSearchParam.get("n_adult");
const nAdult = ref(initNAdult ? parseInt(initNAdult) : 1);

const initNChild = currentSearchParam.get("n_child");
const nChild = ref(initNChild ? parseInt(initNChild) : 0);

const initNRoom = currentSearchParam.get("n_room");
const nRoom = ref(initNRoom ? parseInt(initNRoom) : 1);

const initCheckin = currentSearchParam.get("checkin");
const checkin = ref(initCheckin ? new Date(parseInt(initCheckin)) : null);

const initCheckout = currentSearchParam.get("checkout");
const checkout = ref(initCheckout ? new Date(parseInt(initCheckout)) : null);

function formatDate(date: Date | null) {
  if (date === null) return "--/--/--";

  const year = String(date.getFullYear() % 100).padStart(2, "0");
  const month = String(date.getMonth() + 1).padStart(2, "0");
  const day = String(date.getDate()).padStart(2, "0");

  return `${month}/${day}/${year}`;
}
</script>

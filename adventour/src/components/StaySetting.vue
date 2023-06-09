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

    <div class="relative">
      <ToggleContainer>
        <OpenButton
          type="button"
          class="flex h-10 w-full items-center rounded-lg bg-white px-2"
        >
          <div class="flex flex-1 items-center gap-2">
            <BIconCalendar2Week class="h-6 w-6 text-gray-800" />
            <div class="space-y-1">
              <div
                class="text-left text-xs font-medium leading-none text-gray-950"
              >
                Check in
              </div>
              <div class="text-left text-xs leading-none text-gray-800">
                --/--/--
              </div>
            </div>
          </div>

          <div class="flex-1 space-y-1 border-l border-gray-600 pl-2">
            <div
              class="text-left text-xs font-medium leading-none text-gray-950"
            >
              Check out
            </div>
            <div class="text-left text-xs leading-none text-gray-800">
              --/--/--
            </div>
          </div>
        </OpenButton>

        <template v-slot:toggled>
          <ModalContainer position="bottom">Date range picker</ModalContainer>
        </template>
      </ToggleContainer>
    </div>

    <div class="relative">
      <ToggleContainer>
        <OpenButton
          type="button"
          class="flex h-10 w-full items-center rounded-lg bg-white px-2"
        >
          <div class="flex flex-1 items-center gap-2">
            <BIconPeopleFill class="h-6 w-6 text-gray-800" />
            <div class="space-y-1">
              <div
                class="text-left text-xs font-medium leading-none text-gray-950"
              >
                Arrangement
              </div>
              <div class="flex gap-6">
                <div class="text-left text-xs leading-none text-gray-800">
                  {{ nAdult }} Adult
                </div>
                <div class="text-left text-xs leading-none text-gray-800">
                  {{ nChild }} Child
                </div>
                <div class="text-left text-xs leading-none text-gray-800">
                  {{ nRoom }} Room
                </div>
              </div>
            </div>
          </div>
        </OpenButton>

        <template v-slot:toggled>
          <ModalContainer position="bottom"
            >Stay configuration picker</ModalContainer
          >
        </template>
      </ToggleContainer>
    </div>

    <button
      type="submit"
      class="h-10 rounded-lg bg-green-900 text-sm font-bold leading-none text-white"
    >
      Update
    </button>
  </form>
</template>
<script setup lang="ts">
import { BIconCalendar2Week, BIconPeopleFill } from "bootstrap-icons-vue";
import ModalContainer from "./ModalContainer.vue";
import ToggleContainer from "./ToggleContainer.vue";
import OpenButton from "./OpenButton.vue";
import { ref } from "vue";

const currentSearchParam = new URLSearchParams(document.location.search);
const hotelParam = currentSearchParam.get("hotel_id");

const initNAdult = currentSearchParam.get("n_adult");
const nAdult = ref(initNAdult ? parseInt(initNAdult) : 1);

const initNChild = currentSearchParam.get("n_child");
const nChild = ref(initNChild ? parseInt(initNChild) : 0);

const initNRoom = currentSearchParam.get("n_room");
const nRoom = ref(initNRoom ? parseInt(initNRoom) : 1);
</script>

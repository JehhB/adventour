<template>
  <OnClickOutside @trigger="isActive = false">
    <div
      class="absolute z-30 flex items-center border-gray-400 bg-white px-4 py-1 transition-[left,right,bottum,top,border-radius] duration-[50ms] sm:relative sm:inset-0 sm:w-[40ch] sm:rounded-2xl sm:border sm:transition-[border-radius]"
      :class="
        isActive
          ? 'inset-0 sm:rounded-b-none sm:border-b-0'
          : 'inset-x-14 inset-y-2 rounded-xl border delay-[250ms]'
      "
    >
      <form
        action="/search.php"
        method="GET"
        class="flex h-[30px] w-full items-center gap-2 sm:h-auto"
        autocomplete="off"
      >
        <input type="hidden" name="filter" :value="query.filter" />
        <input
          type="search"
          name="q"
          placeholder="Find destination"
          @focus="onFocus"
          v-model="query.q"
          class="w-0 flex-1 placeholder:text-gray-500"
        />
        <BIconSearch v-if="!isActive" class="text-gray-500" />
        <BIconXLg v-else @click="clear" class="text-gray-500" />
      </form>

      <Transition
        enter-from-class="max-h-0"
        enter-to-class="transition-all delay-[50ms] duration-[250ms] max-h-screen"
        leave-from-class="max-h-screen"
        leave-to-class="transition-all duration-[250ms] max-h-0"
      >
        <div
          v-show="isActive"
          class="absolute inset-x-0 top-full flex h-[calc(100vh_-_100%)] flex-col overflow-hidden bg-white sm:inset-x-[-1px] sm:h-[400px] sm:rounded-b-2xl sm:border sm:border-t-0 sm:border-gray-400"
        >
          <div class="flex flex-shrink-0 justify-around p-4">
            <button
              v-for="filter in filters"
              :key="filter"
              @click="query.filter = filter"
              class="w-1/5 rounded-full rounded-xl border-2 border-green-900 px-3 py-1 text-xs capitalize leading-none"
              :class="
                filter === query.filter
                  ? 'bg-green-900 text-white'
                  : 'bg-white text-green-900'
              "
              role="radio"
            >
              {{ filter }}
            </button>
          </div>
          <div class="flex-1 overflow-y-auto px-4 pb-4">
            <template v-if="statusCode === null || suggestions?.length !== 0">
              <ul class="list-none space-y-2">
                <template v-if="statusCode === null">
                  <li v-for="i in 4" :key="i">
                    <div class="flex gap-2">
                      <div
                        class="block-loader h-[76px] w-[76px] shrink-0 rounded"
                      ></div>
                      <div class="flex flex-1 flex-col gap-2">
                        <div class="block-loader mt-2 h-6 w-4/5 rounded"></div>
                        <div class="block-loader h-4 w-2/3 rounded"></div>
                      </div>
                    </div>
                  </li>
                </template>

                <li v-for="suggestion in suggestions" :key="suggestion.title">
                  <Summary v-bind="suggestion" />
                </li>
              </ul>
              <div class="mt-3">
                <a
                  :href="'/search.php?' + searchParam"
                  class="font-bold text-green-900"
                >
                  Find more
                </a>
              </div>
            </template>
            <template v-else>
              <em>No result found for "{{ query.q }}"</em>
            </template>
          </div>
        </div>
      </Transition>
    </div>
  </OnClickOutside>
</template>
<script setup lang="ts">
import {
  BIconSearch,
  BIconXLg,
  BIconBuildingFill,
  BIconCalendarEventFill,
  BIconPinMapFill,
} from "bootstrap-icons-vue";
import { computed, reactive, ref, watchEffect } from "vue";
import { OnClickOutside } from "@vueuse/components";
import { useFetch, watchDebounced } from "@vueuse/core";
import Summary from "./Summary.vue";

type Suggestion = {
  type: "hotel" | "event" | "place";
  link: string;
  title: string;
  subtitle: string;
  image: string;
};

const filters = ["all", "hotels", "events", "places"] as const;
type Filter = (typeof filters)[number];

const isActive = ref(false);
const query = reactive<{ q: string; filter: Filter }>({
  q: "",
  filter: filters[0],
});
const searchParam = computed(() => new URLSearchParams(query).toString());
const url = ref("");
const { data, statusCode } = useFetch(url, {
  refetch: true,
})
  .get()
  .json<Suggestion[]>();
const suggestions = computed(() => {
  if (
    statusCode.value === null ||
    statusCode.value < 200 ||
    statusCode.value > 299
  )
    return [];
  return data.value?.map((d) => ({
    title: d.title,
    link: d.link,
    image: d.image,
    caption: `Thumbnail image for ${d.title}`,
    subtitle:
      d.type === "hotel"
        ? d.subtitle.match(/(?<=\d{4}\s+)[^,]*,[^,]*$/)?.[0] ?? ""
        : d.subtitle,
    icon: {
      event: BIconCalendarEventFill,
      hotel: BIconBuildingFill,
      place: BIconPinMapFill,
    }[d.type],
  }));
});

function onFocus(event: FocusEvent) {
  (event.target as HTMLInputElement).select();
  isActive.value = true;
}

function clear() {
  query.q = "";
  isActive.value = false;
}

watchDebounced(
  searchParam,
  (param, oldParam) => {
    if (param == oldParam) return;
    url.value = "/api/search.php?" + param;
  },
  { debounce: 250, immediate: true }
);

watchEffect(() => {
  const body = document.querySelector("body");
  if (body) body.style.overflow = isActive.value ? "hidden" : "auto";
});
</script>

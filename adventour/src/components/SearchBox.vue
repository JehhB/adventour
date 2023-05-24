<template>
  <OnClickOutside @trigger="isActive = false">
    <div
      class="absolute z-40 flex items-center border-gray-400 bg-white px-4 py-1 transition-[left,right,bottum,top,border-radius] duration-[50ms] sm:relative sm:inset-0 sm:w-[40ch] sm:rounded-2xl sm:border sm:transition-[border-radius]"
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
        <input
          type="search"
          name="q"
          placeholder="Find destination"
          @focus="onFocus"
          v-model="query.search"
          class="flex-1 w-0 placeholder:text-gray-500"
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
          class="absolute inset-x-0 top-full h-[calc(100vh_-_100%)] bg-white sm:inset-x-[-1px] sm:h-[400px] sm:rounded-b-2xl sm:border sm:border-t-0 sm:border-gray-400"
        ></div>
      </Transition>
    </div>
  </OnClickOutside>
</template>
<script setup lang="ts">
import { BIconSearch, BIconXLg } from "bootstrap-icons-vue";
import { reactive, ref } from "vue";
import { OnClickOutside } from "@vueuse/components";

const isActive = ref(false);
const query = reactive({
  search: "",
  filter: "all",
});

function onFocus(event: FocusEvent) {
  (event.target as HTMLInputElement).select();
  isActive.value = true;
}

function clear() {
  query.search = "";
  isActive.value = false;
}
</script>

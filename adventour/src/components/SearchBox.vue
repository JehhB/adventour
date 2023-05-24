<template>
  <div
    class="absolute border-gray-400 px-4 py-1 bg-white z-40 flex items-center transition-all duration-[50ms] sm:relative sm:inset-0 sm:w-[40ch] sm:rounded-2xl sm:border"
    :class="isActive ? 'inset-0 sm:border-b-0 sm:rounded-b-none' : 'inset-x-14 inset-y-2 rounded-xl border'"
  >
    <form
      action="/search.php"
      method="GET"
      class="h-[30px] flex items-center sm:h-auto gap-2 w-full"
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
      <BIconXLg v-else="!isActive" @click="clear" class="text-gray-500" />
    </form>
  </div>
</template>
<script setup lang="ts">
import { BIconSearch, BIconXLg } from "bootstrap-icons-vue";
import { reactive, ref } from "vue";

const isActive = ref(false);
const query = reactive({
  search: '',
  filter: 'all',
})

function onFocus(event: FocusEvent) {
  (event.target as HTMLInputElement).select();
  isActive.value = true;
}

function clear() {
  query.search = '';
  isActive.value = false;
}
</script>

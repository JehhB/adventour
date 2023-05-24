<template>
  <div
    class="absolute inset-x-14 inset-y-2 border border-gray-400 px-4 py-1 bg-white rounded-xl z-40 sm:relative sm:inset-0 sm:w-[40ch] sm:rounded-2xl"
  >
    <form
      action="/search.php"
      method="GET"
      class="h-[30px] flex items-center sm:h-auto gap-2"
      autocomplete="off"
    >
      <input
        type="search"
        name="q"
        placeholder="Find destination"
        class="flex-1 w-0 placeholder:text-gray-500"
      />
      <BIconSearch class="text-gray-500"/>
    </form>
  </div>
</template>
<script setup lang="ts">
import { BIconSearch } from "bootstrap-icons-vue";
</script>

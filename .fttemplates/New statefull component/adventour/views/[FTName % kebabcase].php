<template>
  <div class="[FTName % kebabcase]" x-data="[FTName % snakecase]">
    <!-- TODO: [FTName] component -->
  </div>
</template>

<script>
  document.addEventListener('alpine:init', () => {
    Alpine.data('[FTName % snakecase]', function() {
      return {
        // TODO: [FTName] states
      };
    });
  })
</script>

<style>
  .[FTName % kebabcase] {
    /* TODO: [FTName] css */
  }
</style>

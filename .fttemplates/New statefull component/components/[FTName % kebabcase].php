<div class="[FTName % kebabcase]" x-data="[FTName % snakecase]">
  <!-- TODO: [FTName] component -->
</div>

<?php section('embed', __FILE__); ?>

<script>
  function [FTName % pascalcase]() {
    return {
      // TODO: [FTName] states
    }
  }

  document.addEventListener('alpine:init', () => {
    Alpine.data('[FTName % snakecase]', [FTName % pascalcase])
  })
</script>

<style>
  .[FTName % kebabcase] {
    /* TODO: [FTName] css */
  }
</style>

<?php end_section(); ?>

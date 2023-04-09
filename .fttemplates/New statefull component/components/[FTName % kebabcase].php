<div class="[FTName % kebabcase]" x-data="[FTName % snakecase]">
  <!-- TODO: [FTName] component -->
</div>

<?php if (!defined("[FTName % constantcase]")) : define("[FTName % constantcase]", 1); ?>

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

<?php endif /*[FTName % constantcase]*/ ?>
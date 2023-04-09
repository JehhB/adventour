<div class="[FTName % kebabcase]" x-data="[FTName % kebabcase]">
  <!-- TODO: [FTName] component -->
</div>

<?php if (!defined("[FTName % constantcase]")) : define("[FTName % constantcase]", 1); ?>

  <style>
    .[FTName % kebabcase] {
      /* TODO: [FTName] css */
    }
  </style>

  <script>
    function [FTName % pascalcase]() {
      return {
        // TODO: [FTName] states
      }
    }

    document.addEventListener('alpine:init', () => {
      Alpine.data('[FTName % kebabcase]', [FTName % pascalcase])
    })
  </script>

<?php endif /*[FTName % constantcase]*/ ?>
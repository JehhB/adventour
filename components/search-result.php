<div class="search-result" x-data="{filter:'all'}" x-show="searchActive" x-collapse.duration.250ms>
  <div class="search-result__tabs">
    <template x-for="category in ['all', 'hotels', 'events', 'places']">
      <button class="search-result__tabs__button" :class="filter == category && 'active'" @click="filter=category" x-text="category"></button>
    </template>
  </div>

  <?php include 'search-suggestion.php' ?>

</div>

<?php if (!defined('SEARCH_RESULT')) : define('SEARCH_RESULT', 0); ?>

  <style>
    .search-result {
      transition: max-height ease-in 250ms;
      max-height: 400px;
      position: absolute;
      left: -1px;
      width: calc(100% + 2px);
      top: 100%;
      padding: 1rem;
      background: white;
      border-radius: 0 0 1rem 1rem;
      border: 1px solid var(--fg-color);
      border-top: none;
      overflow: scroll;
    }

    .search-result__tabs {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-around;
    }

    .search-result__tabs__button {
      text-transform: capitalize;
      background-color: white;
      min-width: 20%;
      flex: 0 0 auto;
      color: var(--accent-color);
      border: 2px solid var(--accent-color);
      font-size: 0.75rem;
      line-height: 0.75rem;
      padding: 0.25rem 0.75rem;
      margin-right: 0.5rem;
      margin-bottom: 1rem;
      border-radius: 0.625rem;
    }

    .search-result__tabs__button.active {
      background-color: var(--accent-color);
      color: white;
    }

    @media (max-width: 576px) {
      .search-result {
        max-height: 100vh;
        height: 100vh !important;
        transition-duration: 0s !important;
        transition-delay: 0s !important;
        padding: 1rem 2rem 2rem 2rem;
      }

      .search-result--close {
        transition-duration: 0s;
      }
    }
  </style>

<?php endif; /*SEARCH_RESULT*/ ?>

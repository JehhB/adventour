<component>
  <div class="search-result" x-data="{filter:'all'}" x-show="searchActive" x-collapse.duration.250ms="">
    <div class="search-result__tabs">
      <?php foreach (['all', 'hotels', 'events', 'places'] as $category) : ?>
        <button class="search-result__tabs__button" :class="filter == '<?= $category ?>' && 'active'" @click="filter='<?= $category ?>'">
          <?= $category ?>
        </button>
      <?php endforeach; ?>
    </div>
    <?php insert('search-suggestion'); ?>
  </div>
</component>

<style>
  .search-result {
    transition: max-height ease-in 250ms;
    max-height: 400px;
    position: absolute;
    left: -1px;
    width: calc(100% + 2px);
    top: 100%;
    background: white;
    border-radius: 0 0 1rem 1rem;
    border: 1px solid var(--fg-color);
    border-top: none;
    display: flex;
    flex-direction: column;
    padding-bottom: 1rem;
  }

  .search-result__tabs {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
    padding: 1rem 1rem 0 1rem;
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
      height: calc(100vh - 4rem) !important;
      border-radius: 0;
      transition-duration: 0s !important;
      transition-delay: 0s !important;
    }

    .search-result--close {
      transition-duration: 0s;
    }
  }
</style>

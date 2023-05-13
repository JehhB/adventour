<component>
  <div class="search-suggestion">
    <template x-load="`/api/search.php?q=${encodeURIComponent(search)}&filter=${filter}`">
      <ul class="search-suggestion__list">

        <?php for ($i = 0; $i < 4; ++$i) : ?>
          <li>
            <?php insert('search-summary', ['isLoading' => true]); ?>
          </li>
        <?php endfor; ?>

      </ul>
    </template>
  </div>
</component>

<style>
  .search-suggestion {
    display: flex;
    flex-direction: column;
    flex-shrink: 1;
    gap: 0.5rem;
    overflow-y: auto;
  }

  .search-suggestion__list {
    padding: 0 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    list-style: none;
  }

  .search-suggestion__message {
    padding: 0 1rem;
    font-weight: 700;
    color: black;
  }
</style>

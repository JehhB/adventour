<component>
  <ul class="search-suggestion">
    <template x-load="`/api/search.php?q=${encodeURIComponent(search)}&filter=${filter}`">
      <?php
      for ($i = 0; $i < 4; ++$i) {
        insert('search-summary', ['isLoading' => true]);
      }
      ?>
    </template>
  </ul>
</component>

<style>
  .search-suggestion {
    padding: 0;
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }
</style>

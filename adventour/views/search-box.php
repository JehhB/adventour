<component>
  <div class="search-box" :class="searchActive && 'active'" x-data="search_box" @click.outside="searchActive=false">
    <input type="text" class="search-box__input" placeholder="Search location" required x-model.debounce.250ms='search' @input="searchActive=true" @focus="$el.select()" />

    <svg class="search-box__icon" viewBox="0 0 320 512" x-bind="clearSearch" tabindex="0">
      <!-- x-mark -->
      <path fill="currentColor" d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z" />
    </svg>
    <svg class="search-box__icon" viewBox="0 0 512 512" x-show="!searchActive">
      <!-- magnifying glass -->
      <path fill="currentColor" d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352c79.5 0 144-64.5 144-144s-64.5-144-144-144S64 128.5 64 208s64.5 144 144 144z" />
    </svg>

    <?php insert("search-result"); ?>
  </div>
</component>

<script>
  document.addEventListener('alpine:init', () => {
    Alpine.data('search_box', function() {
      return {
        search: '',
        searchActive: false,

        clearSearch: {
          ['x-show']() {
            return this.searchActive;
          },
          ['@click']() {
            this.searchActive = false;
            this.search = '';
          },
          ['@keyup.enter']() {
            this.searchActive = false;
            this.search = '';
          },
        },
      }
    });
  });
</script>

<style>
  .search-box {
    transition-property: border-radius;
    transition-delay: 250ms;
    position: relative;
    z-index: 200;
    display: flex;
    align-items: center;
    width: 25rem;
    margin-left: auto;
    background-color: white;
    padding: 0.25rem 1rem;
    border-radius: 1rem;
    border: 1px solid var(--fg-color);
    gap: 0.5rem;
  }

  .search-box__icon {
    color: var(--fg-color);
    height: 1rem;
    width: 1rem;
  }

  .search-box__input {
    background-color: transparent;
    border: none;
    width: 0;
    flex: 1 1 auto;
    color: var(--fg-color);
    font-size: 1rem;
    outline: transparent;
    padding: 0;
    line-height: 1em;
  }

  .search-box__input::placeholder {
    height: 1rem;
    font-family: "Inter", sans-serif;
  }

  .search-box.active {
    transition-delay: 0ms;
    border-radius: 1rem 1rem 0 0;
    border-bottom: none;
  }

  @media (max-width: 768px) {
    .search-box {
      flex-grow: 1;
      width: auto;
      margin: 0 1rem;
    }
  }

  @media (max-width: 576px) {
    .search-box {
      transition-delay: 0s;
      border-radius: 0.75rem;
      margin: 0 0.5rem;
    }

    .search-box.active {
      margin: 0;
      position: fixed;
      left: 0;
      top: 0;
      width: 100vw;
      border-radius: 0;
      padding: 2rem 2rem 0 2rem;
      border: none;
    }

    .search-box__input {
      padding: 0.25rem 0;
    }
  }
</style>

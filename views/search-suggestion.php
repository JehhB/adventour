<component>
  <div x-data="search_suggestion" class="search-suggestion">
    <template x-for="({name, address, image, link}) in suggestions" :key="name">
      <a :href="link" class="search-suggestion__summary">
        <img :src="image" :alt="'Image of ' + name" class="search-suggestion__summary__preview" />
        <div class="search-suggestion__summary__details">
          <h3 class="search-suggestion__summary__details__heading" x-text="name"></h3>
          <address class="search-suggestion__summary__details__location" x-text="address"></address>
        </div>
      </a>
    </template>

    <template x-for="i in 4">
      <div class="search-suggestion__loader" x-show="suggestionsLoading">
        <div class="search-suggestion__loader__preview block-loader"></div>
        <div class="search-suggestion__loader__details">
          <div class="search-suggestion__loader__details__heading block-loader"></div>
          <div class="search-suggestion__loader__details__location block-loader"></div>
        </div>
      </div>
    </template>
  </div>
</component>


<script>
  function SearchSuggestion() {
    return {
      suggestionsLoading: true,
      suggestions: [],

      init() {
        this.$watch('{search, filter}',
          (query, oldQuery) => {
            if (query.search === oldQuery.search &&
              query.filter === oldQuery.filter
            ) {
              return;
            }

            this.suggestions = [];
            this.suggestionsLoading = true;
            const searchUri = encodeURIComponent(query.search);
            fetch(`/api/search.php?q=${searchUri}&filter=${query.filter}`)
              .then((resp) => resp.json())
              .then((obj) => {
                this.suggestionsLoading = false;
                this.suggestions = obj.data
              })
              .catch((err) => {
                this.suggestionsLoading = false;
                console.log(err)
              });
          }
        );
      }
    };
  }

  document.addEventListener('alpine:init', () => {
    Alpine.data('search_suggestion', SearchSuggestion);
  });
</script>

<style>
  .search-suggestion {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }

  .search-suggestion__loader,
  .search-suggestion__summary {
    display: flex;
    text-decoration: none;
    color: var(--fg-color);
    align-items: center;
  }

  .search-suggestion__loader__preview,
  .search-suggestion__summary__preview {
    border-radius: 0.5rem;
    height: 72px;
    width: 72px;
    object-fit: cover;
    object-position: center;
  }

  .search-suggestion__loader__details,
  .search-suggestion__summary__details {
    flex-grow: 1;
    margin-left: 0.5rem;
  }

  .search-suggestion__loader__details__heading,
  .search-suggestion__summary__details__heading {
    font-family: "Inter", sans-serif;
    font-size: 1.5rem;
    line-height: 1em;
    font-weight: 400;
    margin-bottom: 0.5rem;
  }

  .search-suggestion__loader__details__heading {
    height: 1.5rem;
    width: 80%;
    border-radius: 4px;
  }

  .search-suggestion__loader__details__location,
  .search-suggestion__summary__details__location {
    font-style: normal;
    font-family: "Inter", sans-serif;
    font-size: 1rem;
    font-weight: 400;
  }

  .search-suggestion__loader__details__location {
    height: 1rem;
    width: 60%;
    border-radius: 4px;
  }
</style>

<component>
  <li>
    <?php if ($isLoading) : ?>
      <div class="search-summary">
        <div class="search-summary__preview block-loader"></div>
        <div class="search-summary__details">
          <div class="search-summary__details__heading block-loader"></div>
          <div class="search-summary__details__location block-loader"></div>
        </div>
      </div>
    <?php else : ?>
      <a href="<?= $link ?>" class="search-summary">
        <img src="<?= $image ?>" alt="<?= $alt ?>" class="search-summary__preview" />
        <div class="search-summary__details">
          <h3 class="search-summary__details__heading">
            <?= $name ?>
          </h3>
          <address class="search-summary__details__location">
            <?= $address ?>
          </address>
        </div>
      </a>
    <?php endif; ?>
  </li>
</component>
<style>
  .search-summary {
    display: flex;
    text-decoration: none;
    color: var(--fg-color);
    align-items: center;
  }

  .search-summary__preview {
    border-radius: 0.5rem;
    height: 72px;
    width: 72px;
    object-fit: cover;
    object-position: center;
  }

  .search-summary__details {
    flex-grow: 1;
    margin-left: 0.5rem;
  }

  .search-summary__details__heading {
    font-family: "Inter", sans-serif;
    font-size: 1.5rem;
    line-height: 1em;
    font-weight: 400;
    margin-bottom: 0.5rem;
  }

  .search-summary__details__heading.block-loader {
    height: 1.5rem;
    width: 80%;
    border-radius: 4px;
  }

  .search-summary__details__location {
    font-style: normal;
    font-family: "Inter", sans-serif;
    font-size: 1rem;
    font-weight: 400;
  }

  .search-summary__details__location.block-loader {
    height: 1rem;
    width: 60%;
    border-radius: 4px;
  }
</style>

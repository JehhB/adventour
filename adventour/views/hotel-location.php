<component>
  <section class="hotel-location-wrapper container">
    <div x-data="hotel_location()" @bboxchanged.debounce.1000ms="bboxChangeHandler" class="hotel-location">
      <div class="hotel-location__recommendation">
        <h3 class="hotel-location__recommendation__title">Recommendation in the area</h3>
        <ul class="hotel-location__recommendation__list">
          <template x-for="_ in isLoading ? 4 : 0">
            <?php insert('search-summary', ['isLoading' => true]) ?>
          </template>
        </ul>
      </div>
      <?php insert('hotel-map', ['lat' => $lat, 'lng' => $lng]); ?>
    </div>
  </section>
</component>
<script>
  document.addEventListener('alpine:init', () => {
    Alpine.data('hotel_location', function() {
      return {
        isLoading: true,

        bboxChangeHandler() {
          console.log(this.$event.detail);
        },
      };
    });
  });
</script>
<style>
  .hotel-location {
    overflow: hidden;
    border-radius: 24px;
    margin-bottom: 1rem;
    display: flex;
    align-items: stretch;
    background-color: var(--gray-100);
    width: 100%;
  }

  .hotel-location__recommendation {
    padding: 1rem;
    width: 25rem;
  }

  .hotel-location__recommendation__title {
    font-size: 1.25rem;
    text-transform: capitalize;
    margin-bottom: 1rem;
  }

  .hotel-location__recommendation__list {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    list-style: none;
    padding: 0;
  }

  @media screen and (max-width: 991px) {
    .hotel-location {
      flex-direction: column-reverse;
    }

    .hotel-location__recommendation {
      width: 100%;
    }
  }

  @media screen and (max-width: 576px) {
    .hotel-location-wrapper {
      padding: 0 0.5rem 0 0.5rem;
    }
  }
</style>

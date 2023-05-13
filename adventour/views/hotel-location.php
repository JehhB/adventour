<component>
  <section class="hotel-location-wrapper container">
    <div x-data="hotel_location(<?= $hotel_id ?>)" @bboxchanged.debounce.500ms="bboxChangeHandler" class="hotel-location">
      <div class="hotel-location__recommendation">
        <h3 class="hotel-location__recommendation__title">Recommendation in the area</h3>
        <div class="hotel-location__recommendation__list-wrapper">
          <ul class="hotel-location__recommendation__list">
            <template x-for="_ in isLoading ? 4 : 0">
              <?php insert('search-summary', ['isLoading' => true]); ?>
            </template>
            <template x-for="{summary} in isLoading ? [] : recommendations">
              <li x-html="summary"></li>
            </template>
            <template x-if="!isLoading && recommendations.length == 0">
              <em>No hotels in the area</em>
            </template>
          </ul>
        </div>
      </div>
      <?php insert('hotel-map', [
        'lat' => $lat,
        'lng' => $lng,
        'details' => [
          'image' => $images[0],
          'description' => $description,
          'name' => $name,
          'address' => $address,
        ],
      ]); ?>
    </div>
  </section>
</component>
<script>
  document.addEventListener('alpine:init', () => {
    const xhr = new XMLHttpRequest();
    xhr.responseType = "json";

    Alpine.data('hotel_location', function(hotelId) {
      return {
        isLoading: true,
        recommendations: [],

        init() {
          xhr.addEventListener('load', () => {
            this.isLoading = false;
            if (xhr.status >= 200 && xhr.status <= 299) {
              this.recommendations = xhr.response;
            } else {
              this.recommendations = [];
            }
          })
        },

        bboxChangeHandler() {
          const {
            _northEast: ne,
            _southWest: sw
          } = this.$event.detail;
          const {
            lat: lat0,
            lng: lng0
          } = ne;
          const {
            lat: lat1,
            lng: lng1
          } = sw;

          xhr.open('GET', `/api/hotel-area.php?lat0=${lat0}&lng0=${lng0}&lat1=${lat1}&lng1=${lng1}&exclude=${hotelId}`)
          this.isLoading = true;
          xhr.send();
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
    width: 25rem;
    height: 400px;
    display: flex;
    flex-direction: column;
  }

  .hotel-location__recommendation__title {
    flex: 0 0 auto;
    padding: 1rem;
    font-size: 1.25rem;
    text-transform: capitalize;
  }

  .hotel-location__recommendation__list-wrapper {
    flex: 1 1 auto;
    overflow-y: auto;
    padding: 0 1rem 1rem 1rem;
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

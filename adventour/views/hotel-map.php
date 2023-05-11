<component>
  <div class="hotel-map" x-data="hotel_map(<?= $lat ?>, <?= $lng ?>)"></div>
</component>
<script>
  document.addEventListener('alpine:init', () => {
    Alpine.data('hotel_map', function(lat, lng) {
      return {

        init() {
          const map = L.map(this.$el, {
            center: [
              parseFloat(lat),
              parseFloat(lng),
            ],
            zoom: 15,
            zoomSnap: 0.5,
            zoomDelta: 0.5,
            maxZoom: 15,
            attributionControl: false,
            zoomControl: false,
          });

          L.tileLayer('/assets/images/tile.php?x={x}&y={y}&z={z}').addTo(map);
          L.control.zoom({
            position: 'bottomright'
          }).addTo(map);
          L.marker([lat, lng]).addTo(map);

          map.addEventListener('moveend', () => {
            this.$dispatch('bboxchanged', map.getBounds());
          });
        },
      }
    });
  });
</script>
<style>
  .hotel-map {
    flex: 1 1 auto;
    height: 400px;
  }

  .leaflet-control-zoom {
    border: 1px solid var(--gray-400) !important;
    margin: 0 1rem 1rem 0 !important;
    border-radius: 8px;
  }

  .leaflet-control-zoom a:first-child {
    border-radius: 8px 8px 0 0 !important;
  }

  .leaflet-control-zoom a:last-child {
    border-radius: 0 0 8px 8px !important;
    border-bottom: none;
  }

  .leaflet-control-zoom a {
    color: var(--accent-color);
    border-bottom: 1px solid var(--gray-400);
    font-weight: 400;
  }
</style>

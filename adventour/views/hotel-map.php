<component>
  <div class="hotel-map" x-data="hotel_map(<?= $lat ?>, <?= $lng ?>, 
  `<?= e(render(
      'search-summary',
      [
        'link' => '#',
        'image' => $details['image']['src'],
        'alt' => $details['image']['alt'],
        'name' => $details['name'],
        'address' => $details['address']
      ]
    )) ?>`)"></div>
</component>
<script>
  document.addEventListener('alpine:init', () => {
    const currentMarker = L.icon({
      iconUrl: '/assets/images/marker-icon.png',
      iconRetinaUrl: '/assets/images/marker-icon-2x.png',
      iconSize: [30, 40],
      iconAnchor: [15, 40],
      popupAnchor: [0, -32],
    });

    const hotelMarker = L.icon({
      iconUrl: '/assets/images/building-icon.png',
      iconRetinaUrl: '/assets/images/building-icon-2x.png',
      iconSize: [24, 32],
      iconAnchor: [12, 32],
      popupAnchor: [0, -28],
    });

    Alpine.data('hotel_map', function(lat, lng, popup) {
      markers = new Map();

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
          L.marker([lat, lng], {
              icon: currentMarker
            })
            .addTo(map)
            .bindPopup(popup);

          this.$watch('recommendations', (recommendations) => {
            for (const key of markers.keys()) {
              if (recommendations.find(({hotel_id}) => hotel_id === key)) continue;
              markers.get(key).remove();
              markers.delete(key);
            }

            for (const hotel of recommendations) {
              if (markers.has(hotel.hotel_id)) continue;
              const marker = L.marker([hotel.lat, hotel.lng], {
                  icon: hotelMarker
                })
                .addTo(map)
                .bindPopup(hotel.summary);
              markers.set(hotel.hotel_id, marker);
            }
          });

          map.addEventListener('moveend', () => {
            this.$dispatch('bboxchanged', map.getBounds());
          });
          this.$dispatch('bboxchanged', map.getBounds());
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

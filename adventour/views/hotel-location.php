<component>
  <section class="hotel-location container">
    <?php insert('hotel-map', ['lat' => $lat, 'lng' => $lng]); ?>
  </section>
</component>
<style>
  .hotel-location {
    overflow: hidden;
    border-radius: 24px;
    margin-bottom: 1rem;
  }
</style>

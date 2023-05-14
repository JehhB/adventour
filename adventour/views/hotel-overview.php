<?php
$sql = <<<SQL
SELECT feature
FROM Features
JOIN HotelFeatures ON HotelFeatures.feature_id = Features.feature_id
WHERE hotel_id = ?
SQL;
$stmt = execute($sql, [$hotel_id]);
?>
<component>
  <section class="hotel-overview container">
    <h1 class="hotel-overview__name"><?= e($name) ?></h1>
    <address class="hotel-overview__address"><?= e($address) ?></address>

    <?php insert('hotel-gallery', ['images' => $images]); ?>

    <p class="hotel-overview__description"><?= e($description) ?></p>

    <ul class="hotel-overview__facilities">
      <?php while ($facility = $stmt->fetch()) : ?>
        <li><?= e($facility['feature']) ?></li>
      <?php endwhile; ?>
    </ul>

  </section>
</component>
<style>
  .hotel-overview {
    display: grid;
    grid-template-columns: 5fr 7fr;
    grid-template-rows: min-content min-content 1fr min-content;
    gap: 0.5rem 4rem;
    grid-template-areas:
      "gallery name"
      "gallery address"
      "gallery description"
      "gallery facilities";
    margin-bottom: 2rem;
  }

  .hotel-overview__name {
    grid-area: name;
    font-family: inherit;
    font-weight: 600;
    font-size: 1.5rem;
    line-height: 1em;
    color: var(--gray-800);
  }

  .hotel-overview__address {
    grid-area: address;
    font-size: 1rem;
    font-style: normal;
    font-weight: 400;
    line-height: 1em;
    color: var(--gray-800);
  }

  .hotel-overview__description {
    grid-area: description;
    font-size: 1rem;
    line-height: 1.25em;
    font-weight: 400;
    color: var(--gray-700);
    padding: 1rem 0 1rem 0;
  }

  .hotel-overview__facilities {
    grid-area: facilities;
    display: flex;
    justify-content: start;
    padding: 0;
    flex-wrap: wrap;
    gap: 1rem 2rem;
    list-style: none;
    padding: 2rem 0 2rem 0;
    border-top: 1px solid var(--gray-700);
  }

  .hotel-overview__facilities li {
    flex: 0 0 auto;
    color: var(--gray-800);
    font-size: 1rem;
    padding-left: 1.5rem;
    position: relative;
  }

  .hotel-overview__facilities li::before {
    position: absolute;
    content: "";
    display: inline-block;
    background-image: url('/assets/images/check-mark.svg');
    background-size: contain;
    background-position: center;
    background-repeat: no-repeat;
    width: 16px;
    height: 16px;
    top: 50%;
    left: 0;
    transform: translateY(-50%);
  }

  @media screen and (max-width: 1199px) {
    .hotel-overview {
      gap: 1 3rem;
    }
  }

  @media screen and (max-width: 991px) {
    .hotel-overview {
      grid-template-columns: 1fr;
      grid-template-rows: none;
      gap: 1rem;
      grid-template-areas:
        "name"
        "address"
        "gallery"
        "description"
        "facilities"
    }
  }

  @media screen and (max-width: 576px) {
    .hotel-overview {
      grid-template-columns: 1fr;
      gap: 1rem;
      grid-template-areas:
        "name"
        "gallery"
        "facilities";
      margin-bottom: 1rem;
    }

    .hotel-overview__name {
      padding: 0 0.5rem;
    }

    .hotel-overview__address,
    .hotel-overview__description {
      display: none;
    }

    .hotel-overview__facilities {
      padding: 0 0.5rem;
      border: none;
    }
  }
</style>

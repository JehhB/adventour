<?php
global $conn;

$sql = <<<SQL
SELECT feature
FROM Features
JOIN HotelFeatures ON HotelFeatures.feature_id = Features.feature_id
WHERE hotel_id = :hotel_id;
SQL;
$stmt = $conn->prepare($sql);
$stmt->bindParam(':hotel_id', $hotel_id, PDO::PARAM_INT);
$stmt->execute();

$facilities = $stmt->fetchAll();
?>
<component>
  <section class="hotel-overview container">
    <h1 class="hotel-overview__name"><?= $name ?></h1>
    <address class="hotel-overview__address"><?= $address ?></address>
    <?php insert('hotel-gallery', ['hotel_id' => $hotel_id]); ?>
    <p class="hotel-overview__description"><?= $description ?></p>
    <ul class="hotel-overview__facilities">
      <?php foreach ($facilities as $facility) : ?>
        <li><?= $facility['feature'] ?></li>
      <?php endforeach; ?>
    </ul>
  </section>
</component>
<style>
  .hotel-overview {
    display: grid;
    grid-template-columns: 5fr 7fr;
    gap: 0 4rem;
    grid-template-areas:
      "gallery name"
      "gallery address"
      "gallery description"
      "gallery facilities";
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
  }

  .hotel-overview__facilities {
    grid-area: facilities;
    display: flex;
    justify-content: start;
    padding: 0;
    flex-wrap: wrap;
    gap: 1rem 2rem;
    list-style: none;
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
      gap: 0 3rem;
    }
  }

  @media screen and (max-width: 991px) {
    .hotel-overview {
      grid-template-columns: 1fr;
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
        "facilities"
    }

    .hotel-overview__address,
    .hotel-overview__description {
      display: none;
    }
  }
</style>

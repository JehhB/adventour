<section class="mt-3">
  <div class="flex items-center px-2 sm:px-0">
    <h1 class="font-semibold text-neutral-800"><?= $name ?></h1>
    <div class="ml-auto flex gap-2">
      <b-icon-heart-fill class="stroke-2 text-zinc-600"></b-icon-heart-fill>
      <b-icon-share-fill class="stroke-2 text-zinc-600"></b-icon-share-fill>
    </div>
  </div>
  <gallery-container>
      <gallery-item src="/assets/images/hotelImage.php?hotel_image_id=1"></gallery-item>
      <gallery-item src="/assets/images/hotelImage.php?hotel_image_id=2"></gallery-item>
      <gallery-item src="/assets/images/hotelImage.php?hotel_image_id=3"></gallery-item>
      <gallery-item src="/assets/images/hotelImage.php?hotel_image_id=4"></gallery-item>
  </gallery-container>
</section>

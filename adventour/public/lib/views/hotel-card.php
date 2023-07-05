<div>
  <div class="aspect-h-2 aspect-w-4 relative sm:aspect-h-3">
    <div>
      <img
        src="<?= $image ?>"
        alt="Image of <?= $title ?>"
        class="h-full w-full rounded-lg object-cover"
      />
      <like-button
        id="<?= $id ?>"
        type="hotel"
        class="absolute right-2 top-2"
      ></like-button>
    </div>
  </div>
  <a href="<?= $link ?>">
    <h3 class="mt-2 text-xl leading-none"><?= $title ?></h3>
    <div class="mt-1 text-xs leading-none"><?= $subtitle ?></div>
  </a>
</div>

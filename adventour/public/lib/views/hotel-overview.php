<section class="mt-3">
  <div class="flex items-center px-2 sm:px-0">
    <h1 class="font-semibold text-neutral-800"><?= $name ?></h1>
    <div class="ml-auto flex gap-2">
      <b-icon-heart-fill class="stroke-2 text-zinc-600"></b-icon-heart-fill>
      <b-icon-share-fill class="stroke-2 text-zinc-600"></b-icon-share-fill>
    </div>
  </div>
  <gallery-container>
    <?php foreach ($images as $image) : ?>
      <gallery-item src="<?= $image['src'] ?>" alt="<?= $image['alt'] ?>"></gallery-item>
    <?php endforeach; ?>
  </gallery-container>
</section>

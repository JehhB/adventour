<component>
  <div class="hotel-gallery" x-data="{currentSrc:`<?= e($images[0]['src']) ?>`, currentAlt:`<?= e($images[0]['alt']) ?>`}">
    <img class="hotel-gallery__main" :src="currentSrc" :alt="currentAlt">
    <div class="hotel-gallery__thumbnails">
      <?php foreach ($images as $image) : ?>
        <img role="button" class="hotel-gallery__thumbnails__image" src="<?= e($image['src']) ?>" alt="<?= e($image['alt']) ?>" @click="currentSrc = $el.src; currentAlt = $el.alt">
      <?php endforeach; ?>
    </div>
  </div>
</component>
<style>
  .hotel-gallery {
    grid-area: gallery;
    overflow-x: auto;
  }

  .hotel-gallery__main {
    width: 100%;
    aspect-ratio: 3/2;
    object-fit: cover;
    border-radius: 0.5rem;
    margin-bottom: 0.5rem;
  }

  .hotel-gallery__thumbnails {
    max-width: 100%;
    overflow-x: auto;
    display: flex;
    flex-wrap: nowrap;
    height: 4rem;
    gap: 0.5rem;
  }

  .hotel-gallery__thumbnails__image {
    cursor: pointer;
    border-radius: 0.5rem;
  }

  @media screen and (max-width: 576px) {

    .hotel-gallery__main {
      border-radius: 0;
    }

    .hotel-gallery__thumbnails {
      padding: 0 0.5rem;
    }
  }
</style>

<component>
  <li class="carousel-item" x-show="<?= $index ?> === active" x-transition:leave.opacity.duration.500ms x-transition:enter.opacity.delay.150ms.duration.500ms>
    <a href="<?= $link ?>">
      <img src="<?= $image ?>" class="carousel-item__image" />
      <div class="carousel-item__overlay"></div>
      <h3 class="carousel-item__heading"><?= $title ?></h3>
      <p class="carousel-item__address"><?= $subtitle ?></p>
    </a>
  </li>
</component>
<style>
  .carousel-item__overlay {
    position: absolute;
    inset: 0 0 0 0;
    background: radial-gradient(114.3% 170.53% at 11.89% 114.3%,
        #1d2417 0%,
        #1b3308 4.69%,
        rgba(27, 51, 8, 0) 100%);
    z-index: -1;
  }

  .carousel-item {
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
  }

  .carousel-item a {
    color: white;
    text-decoration: none;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: end;
    padding: 2rem;
    font-family: "Inter", sans-serif;
  }

  .carousel-item__image {
    position: absolute;
    top: 0;
    right: 0;
    width: 100%;
    height: 100%;
    background-image: url("");
    object-position: center;
    object-fit: cover;
    z-index: -2;
  }

  .carousel-item__heading {
    font-size: 56px;
    font-family: "Inter", sans-serif;
    font-weight: 300;
  }

  .carousel-item__address {
    font-size: 24px;
    font-style: normal;
    margin-bottom: 1.5rem;
  }
</style>

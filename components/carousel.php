<section class="container">
  <ul class="carousel" x-data="carousel" x-swipe:left="increment" x-swipe:right="decrement" @wheel="scroll">
    <div class="carousel__control">
      <template x-for="(_, index) in items">
        <button class="carousel__control__selector" :class="index === active && 'active'" @click="resetInterval(); active = index"></button>
      </template>
    </div>
    <template x-for=" (item, index) in items">
      <li class="carousel__item" x-show="index === active" x-transition:leave.opacity.duration.500ms x-transition:enter.opacity.delay.150ms.duration.500ms>
        <a href="details.html">
          <img :src="item.image" class="carousel__item__image" />
          <div class="carousel__overlay"></div>
          <h3 class="carousel__item__heading" x-text="item.name"></h3>
          <address class="carousel__item__address" x-text="item.address"></address>
        </a>
      </li>
    </template>
    <template x-if="isLoading">
      <li class="carousel__item block-loader">
        </div>
    </template>
  </ul>
</section>

<?php section('embed', __FILE__); ?>

<script>
  function Carousel() {
    let interval = null;

    return {
      items: [],
      active: 0,
      isLoading: true,

      scroll() {
        if (!this.$event.shiftKey) return;

        this.$event.preventDefault();
        if (event.wheelDelta < 0) {
          this.increment();
        } else {
          this.decrement();
        }
      },

      increment() {
        if (this.items.length == 0) return;
        this.resetInterval();
        this.active = (this.active + 1) % this.items.length;
      },


      decrement() {
        if (this.items.length == 0) return;
        this.resetInterval();
        this.active = (this.active + this.items.length - 1) % this.items.length;
      },

      startInterval() {
        interval = setInterval(() => {
          if (!this.isLoading && this.items.length > 0) {
            this.increment()
          }
        }, 5000);
      },

      resetInterval() {
        clearInterval(interval);
        this.startInterval();
      },

      init() {
        this.isLoading = true;
        fetch('/api/events.php')
          .then((resp) => resp.json())
          .then((obj) => {
            this.items = obj;
            this.isLoading = false;
          })
          .catch((err) => {
            this.isLoading = false;
            console.log(err);
          });
        this.startInterval();
      }
    };
  }

  document.addEventListener('alpine:init', () => {
    Alpine.data('carousel', Carousel);
  });
</script>

<style>
  .carousel {
    width: 100%;
    aspect-ratio: 32 / 9;
    position: relative;
    border-radius: 24px;
    overflow: hidden;
    padding: 0;
    list-style-type: none;
  }

  .carousel__overlay {
    position: absolute;
    inset: 0 0 0 0;
    background: radial-gradient(114.3% 170.53% at 11.89% 114.3%,
        #1d2417 0%,
        #1b3308 4.69%,
        rgba(27, 51, 8, 0) 100%);
    z-index: -1;
  }

  .carousel__item {
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
  }

  .carousel__item a {
    color: white;
    text-decoration: none;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: end;
    padding: 2rem;
    font-family: "Inter", sans-serif;
  }

  .carousel__item__image {
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

  .carousel__item__heading {
    font-size: 56px;
    font-family: "Inter", sans-serif;
    font-weight: 300;
  }

  .carousel__item__address {
    font-size: 24px;
    font-style: normal;
    margin-bottom: 1.5rem;
  }

  @media (max-width: 991px) {
    .carousel {
      aspect-ratio: 8 / 3;
    }
  }

  @media (max-width: 768px) {
    .carousel {
      aspect-ratio: 4 / 3;
    }
  }

  @media (max-width: 576px) {
    .carousel {
      border-radius: 0;
    }
  }

  .carousel__control {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    bottom: 0.75rem;
    display: flex;
    gap: 0.25rem;
    z-index: 5;
  }

  .carousel__control__selector {
    transition: width ease 300ms, background-color ease 300ms;
    height: 0.5rem;
    width: 0.5rem;
    border-radius: 0.25rem;
    background-color: transparent;
    border: 2px solid white;
    outline: transparent;
    padding: 0;
    overflow: hidden;
  }

  .carousel__control__selector.active {
    width: 1rem;
    background-color: white;
  }
</style>

<?php end_section(); ?>

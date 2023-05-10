<component>
  <div x-data="carousel(4)" class="carousel">
    <ul class="carousel__list" x-swipe:left="increment" x-swipe:right="decrement" @wheel.debounce.150ms="scroll">
      <?php
      for ($i = 0; $i < 4; $i++) {
        insert('carousel-item', [
          'index' => $i,
          'link' => '#',
          'image' => "/assets/images/hotelImage.php?hotel_image_id=" . ($i + 1),
          'title' => "Test $i",
          'subtitle' => "Test location $i",
        ]);
      }
      ?>
    </ul>
    <div class="carousel__control">
      <?php for ($i = 0; $i < 4; $i++) : ?>
        <button class="carousel__control__selector" :class="<?= $i ?> === active && 'active'" @click="resetInterval(); active = <?= $i ?>"></button>
      <?php endfor; ?>
    </div>
  </div>
</component>
<script>
  document.addEventListener('alpine:init', () => {
    Alpine.data('carousel', function(count) {
      let interval = null;

      return {
        active: 0,
        scroll() {
          if (!this.$event.shiftKey) return;

          this.$event.preventDefault();
          if (this.$event.wheelDelta < 0) {
            this.increment();
          } else {
            this.decrement();
          }
        },

        increment() {
          this.resetInterval();
          this.active = (this.active + 1) % count;
        },


        decrement() {
          this.resetInterval();
          this.active = (this.active + count - 1) % count;
        },

        startInterval() {
          interval = setInterval(() => {
            this.increment()
          }, 5000);
        },

        resetInterval() {
          clearInterval(interval);
          this.startInterval();
        },

        init() {
          this.startInterval();
        }
      };
    });
  });
</script>

<style>
  .carousel {
    position: relative;
    width: var(--col7);
  }

  .carousel__list {
    width: 100%;
    aspect-ratio: 18 / 9;
    border-radius: 24px;
    overflow: hidden;
    padding: 0;
    position: relative;
    list-style-type: none;
  }

  @media screen and (max-width: 1199px) {
    .carousel {
      width: var(--col8);
    }
  }

  @media (max-width: 991px) {
    .carousel {
      width: 100%;
    }
  }

  @media (max-width: 768px) {
    .carousel__list {
      aspect-ratio: 4 / 3;
    }
  }

  @media (max-width: 576px) {
    .carousel__list {
      border-radius: 0;
    }
  }

  .carousel__control {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    bottom: 0.75rem;
    display: flex;
    gap: 0.325rem;
    z-index: 5;
  }

  .carousel__control__selector {
    transition: width ease 300ms, background-color ease 300ms;
    height: 0.5rem;
    width: 0.75rem;
    border-radius: 0.5rem;
    background-color: transparent;
    border: 2px solid white;
    padding: 0;
    overflow: hidden;
  }

  .carousel__control__selector.active {
    width: 1.5rem;
    background-color: white;
  }
</style>

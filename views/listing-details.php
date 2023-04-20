<component>
  <section class="details container">
    <img class="details__image" />
    <div class="details__booking">
      <h3 class="details__heading__title">Test</h3>
      <address class="details__headding__location">Address</address>
      <div class="price">
        <del class="price__original">
          &#8369; <span id="orig-price">5000</span>
        </del>
        <strong class="price__discounted">
          &#8369; <span id="orig-price">4000</span>
        </strong>
        <div class="price__coupon">20% off</div>
      </div>
      <div class="spacer"></div>
      <form method="post">
        <div class="date">
          <div class="date__in">
            <label for="checkin">Check in</label>
            <input type="date" name="checkin" id="checkin" />
          </div>
          <div class="date__out">
            <label for="checkin">Check out</label>
            <input type="date" name="checkout" id="checkout" />
          </div>
        </div>
        <a href="https://www.google.com/maps/place/Cagayan+State+University+Carig+Administration+Building/@17.6603074,121.7527621,18.37z/data=!4m6!3m5!1s0x33858f636aabf65b:0x27f70deeda1e853c!8m2!3d17.6597199!4d121.7522941!16s%2Fg%2F11c45qvzmf" class="view-map">
          <svg-element class="view-map__icon" data-src="assets/images/map.svg" data-title="a map graphics"></svg-element>
          View in maps
        </a>
        <button class="details__booking__book">Book now</button>
      </form>
    </div>
  </section>
</component>

<style>
  .details {
    gap: 2rem;
    align-items: stretch;
  }

  .details__heading {
    width: 100%;
  }

  .details__image {
    width: var(--col5);
    aspect-ratio: 4 / 3;
    object-fit: cover;
    object-position: center;
    border-radius: 24px;
  }

  .details__booking {
    width: var(--col5);
    margin-left: var(--col1);
    font-family: "Inter", sans-serif !important;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
  }

  .details__heading__title {
    font-family: "Inter", sans-serif !important;
    display: flex;
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 0.5rem;
  }

  .details__headding__location {
    font-size: 16px;
    font-weight: 400;
    font-style: normal;
    margin-bottom: 1rem;
  }

  .price {
    display: flex;
    gap: 1rem;
  }

  .price__original {
    font-size: 24px;
    color: #676767;
    font-weight: 100;
  }

  .price__discounted {
    font-size: 32px;
    font-weight: 400;
    color: #305116;
  }

  .price__coupon {
    font-size: 12px;
    padding: 4px 8px;
    border-radius: 10px;
    align-self: center;
    color: white;
    background-color: var(--accent-color);
  }

  .spacer {
    flex-grow: 1;
    min-height: 2rem;
  }

  form {
    display: flex;
    flex-wrap: wrap;
  }

  label {
    font-size: 1rem;
    font-weight: 500;
  }

  input {
    outline: transparent;
    border: none;
  }

  .date {
    margin-bottom: 1rem;
    display: flex;
    width: 80%;
    justify-content: space-evenly;
    border: 1px solid #ababab;
    background-color: white;
    border-radius: 8px;
    padding: 0.5rem 1rem;
    justify-content: space-evenly;
  }

  .date::before {
    content: "";
    height: 3rem;
    border-right: 1px solid #7d7d7d;
    order: 1;
  }

  .date__in {
    order: 0;
  }

  .date__out {
    order: 2;
  }

  .view-map {
    text-decoration: none;
    color: var(--accent-color);
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 12px;
    font-size: 20px;
    border: 2px solid var(--accent-color);
    font-weight: 600;
  }

  .view-map__icon {
    height: 32px;
  }

  .details__booking__book {
    border: 0;
    margin-left: 1rem;
    outline: transparent;
    background-color: var(--accent-color);
    color: white;
    font-size: 20px;
    line-height: 1em;
    font-weight: 600;
    padding: 13px 1rem;
    border-radius: 8px;
  }

  .date div {
    display: flex;
    flex-direction: column;
  }

  @media (max-width: 991px) {
    section {
      padding: 1rem;
    }

    .details__image {
      width: var(--col12);
    }

    .details__booking {
      width: var(--col12);
      margin-left: 0;
    }
  }

  .recommendation__list {
    width: 100%;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-gap: 1rem;
    list-style-type: none;
    padding: 0;
  }
</style>

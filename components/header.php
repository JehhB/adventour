<header class="header">
  <nav class="container">
    <a href="/" class="header__brand">
      <img src="/assets/logo.png" alt="adventour logo" class="header__brand__logo" />
      <span class="header__brand__name">Adventour</span>
    </a>

    <?php insert("search-box"); ?>

    <div class="user">
      <div class="user__profile">A</div>
    </div>
  </nav>
</header>

<?php section('embed', __FILE__); ?>

<style>
  .header {
    padding: 0.5rem 0;
    margin-bottom: 1rem;
  }

  nav.container {
    flex-wrap: nowrap;
  }

  .header__brand {
    display: flex;
    align-items: center;
    text-decoration: none;
    flex: 0 0 auto;
  }

  .header__brand__logo {
    height: 3rem;
  }

  .header__brand__name {
    font-family: "Hanalei Fill", cursive;
    font-size: 1.5rem;
    line-height: 1em;
    text-transform: uppercase;
    font-weight: 500;
    color: var(--accent-color);
    margin-left: 1rem;
  }

  .user {
    flex: 0 0 auto;
    height: 3rem;
    width: 3rem;
    font-size: 2rem;
    line-height: 2rem;
    font-family: "Hanalei Fill", cursive;
    font-weight: 700;
    color: var(--bg-color);
    margin-left: 1rem;
    background-color: var(--fg-color);
    text-align: center;
    padding: 0.5rem 0;
    border-radius: 50%;
  }

  @media (max-width: 768px) {
    .header__brand__name {
      display: none;
    }

    .user {
      margin: 0;
    }
  }

  @media (max-width: 576px) {
    .header {
      padding: 0.5rem;
      margin-bottom: 0.5rem;
    }

    .header__brand__logo {
      height: 2.5rem;
    }
  }
</style>

<?php end_section(); ?>

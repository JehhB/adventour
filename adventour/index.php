<?php section('head'); ?>
<script src="/scripts/alpine-collapse.js" defer></script>
<script src="/scripts/alpine-swipe.js"></script>
<?php end_section(); ?>

<?php start('page', ['title' => 'Home | Adventour']); ?>
<?php insert('header'); ?>
<main>
  <?php insert('carousel'); ?>
</main>

<?php stop(); ?>

<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/lib/index.php';
include $_SERVER['DOCUMENT_ROOT'] . '/lib/profile.php';
safe_start_session();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile | Adventour</title>
  </head>
  <body>
    <div id="app" v-cloak>
      <?php insert('header') ?>

      <?php insert('profile') ?>

      <?php insert('footer') ?>
      <?php insert('auth-toast') ?>
    </div>
  </body>
</html>

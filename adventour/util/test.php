<?php
define('COMPONENTS_DIR', '');
require "comps.php";

ob_start(
  function ($str) {
    global $__sections;
    return $__sections['embed'] . $str;
  }
);
?>

<script src="/scripts/alpine-intersect.js" defer></script>
<script src="/scripts/alpine-collapse.js" defer></script>
<script src="/scripts/alpine-swipe.js" defer></script>
<script src="/scripts/alpine.js" defer></script>
<link rel="stylesheet" href="/style.css">



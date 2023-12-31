<?php
global $n_bookings, $events, $likes;

use Illuminate\Database\Capsule\Manager as DB;

$profile = DB::table('Profiles')
  ->select('username', 'profile_pic',)
  ->where('user_id', $_SESSION['user'] ?? 0)
  ->first();

$hotels = null;
$places = null;
if ($_SESSION['account_type'] === 'admin') {
  $hotels = DB::table('Hotels')
    ->where('admin_id', $_SESSION['user'])
    ->count();

  $places = DB::table('Places')
    ->where('admin_id', $_SESSION['user'])
    ->count();

  $events = DB::table('Events')
    ->where('admin_id', $_SESSION['user'])
    ->count();
}

?>
<section
  id="profile"
  class="container mx-auto flex items-center justify-center gap-4 px-2 sm:px-0"
>
  <div class="w-24 shrink-0 sm:mx-10 sm:w-28 md:mx-20">
    <div class="aspect-h-1 aspect-w-1">
      <div class="rounded-full border border-gray-400 bg-white p-1">
        <img
          src="<?= $profile->profile_pic === null ? '/assets/images/placeholder.png' : '/storage/user/' . $profile->profile_pic ?>"
          alt="Profile pictures"
          class="h-full w-full rounded-full object-cover"
        />
        <div
          class="absolute bottom-0 right-0 h-8 w-8 rounded-full border border-gray-400 bg-white"
        >
          <change-pic class="h-full w-full"></change-pic>
        </div>
      </div>
    </div>
  </div>
  <div class="shrink lg:mr-64 xl:mr-80 2xl:mr-96">
    <change-name init-name="<?= sanitize($profile->username) ?>">
      <div class="mb-3 flex items-center gap-6 text-sm text-gray-700">
      <?php if ($_SESSION['account_type'] === 'admin') : ?>
        <div class="shrink-0">
          <strong><?= $hotels ?></strong> hotels
        </div>
        <div class="shrink-0">
          <strong><?= $events ?></strong> events
        </div>
        <div class="shrink-0">
          <strong><?= $places ?></strong> places
        </div>
      <?php else : ?>
        <div class="shrink-0">
          <strong><?= $n_bookings ?></strong> bookings
        </div>
        <div class="shrink-0">
          <strong><?= $events ?></strong> events
        </div>
        <div class="shrink-0">
          <strong><?= $likes ?></strong> likes
        </div>
      <?php endif; ?>
      </div>
    </change-name>
  </div>
</section>

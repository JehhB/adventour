<?php
include $_SERVER['DOCUMENT_ROOT'] . '/lib/index.php';
include $_SERVER['DOCUMENT_ROOT'] . '/lib/admin.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin | Adventour</title>
</head>

<body>
  <div id="app" v-cloak>
    <?php insert('admin-header') ?>
    <main>
      <?php insert('profile') ?>

      <section class="container mx-auto mt-4 grid grid-cols-12 gap-2">
        <h2 class="col-span-full px-2 font-heading text-lg font-semibold leading-none text-green-900 sm:px-0 sm:text-2xl">
          Analytics
        </h2>

        <div class="col-s col-span-3 grid h-24 place-items-center rounded-lg border border-gray-400 bg-zinc-50">
          <span class="text-xl font-medium">Total revenue</span>
          <span>&#8369;
            <?= number_format($total_revenue, 2) ?></span>
        </div>
        <div class="col-span-3 grid h-24 place-items-center rounded-lg border border-gray-400 bg-zinc-50">
          <span class="text-xl font-medium">Average daily rates</span>
          <span>&#8369;
            <?= number_format($avg_daily_rates, 2) ?></span>
        </div>
        <div class="col-span-3 grid h-24 place-items-center rounded-lg border border-gray-400 bg-zinc-50">
          <span class="text-xl font-medium">Average length of stay</span>
          <span><?= number_format($avg_length_of_stay, 1) ?></span>
        </div>
        <div class="col-span-3 grid h-24 place-items-center rounded-lg border border-gray-400 bg-zinc-50">
          <span class="text-xl font-medium">Average price per stays</span>
          <span>&#8369;
            <?= number_format($avg_price_per_stay, 2) ?></span>
        </div>

        <div class="col-span-4 grid h-24 place-items-center rounded-lg border border-gray-400 bg-zinc-50">
          <span class="text-xl font-medium">Hotels</span>
          <span><?= $hotel_views ?>
            views &centerdot;
            <?= $hotel_likes; ?>
            likes</span>
        </div>
        <div class="col-span-4 grid h-24 place-items-center rounded-lg border border-gray-400 bg-zinc-50">
          <span class="text-xl font-medium">Events</span>
          <span><?= $event_views ?>
            views &centerdot;
            <?= $event_likes; ?>
            likes</span>
        </div>
        <div class="col-span-4 grid h-24 place-items-center rounded-lg border border-gray-400 bg-zinc-50">
          <span class="text-xl font-medium">Places</span>
          <span><?= $place_views ?>
            views &centerdot;
            <?= $place_likes; ?>
            likes</span>
        </div>
      </section>

      <section class="container mx-auto mt-4">
        <h2 class="col-span-full px-2 font-heading text-lg font-semibold leading-none text-green-900 sm:px-0 sm:text-2xl">
          Bookings
        </h2>

        <form method="get" class="mt-2">
          <label for="search">Search</label>
          <input type="search" name="search" id="search" class="ml-1 border border-gray-400 px-2 py-1" placeholder="filter bookings" value="<?= $_GET['search'] ?? '' ?>">
        </form>

        <div class="table-responsive">
          <?php if (0 < $count) : ?>
            <table class="table-hover table-striped mt-3 table">
              <thead>
                <tr>
                  <th>Status</th>
                  <th>Placed at</th>
                  <th>Hotel</th>
                  <th>Room type</th>
                  <th>Full name</th>
                  <th>Checkin</th>
                  <th># Stays</th>
                  <th># Persons</th>
                  <th># Rooms</th>
                  <th>Total price</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody class="table-group-divider">
                <?php foreach ($bookings as $i =>
                  $booking) : ?>
                  <tr>
                    <td><?= $booking->status ?></td>
                    <td><?= $booking->placed_at ?></td>
                    <td><?= $booking->hotel ?></td>
                    <td><?= $booking->room_type ?></td>
                    <td><?= $booking->fullname ?></td>
                    <td><?= $booking->checkin ?></td>
                    <td><?= $booking->stay ?></td>
                    <td><?= $booking->n_persons ?></td>
                    <td><?= $booking->n_room ?></td>
                    <td>
                      &#8369;
                      <?= number_format($booking->total_price, 2) ?>
                    </td>
                    <td>
                      <open-button target="update <?= $i ?>" class="rounded bg-green-900 px-2 py-1 font-semibold text-white">
                        Update
                      </open-button>
                      <modal-container name="update <?= $i ?>" class="!max-w-xs p-2 pt-3">
                        <form method="POST">
                          <input type="hidden" name="booking_id" value="<?= $booking->booking_id ?>" />

                          <label class="mb-3 block w-full font-medium leading-none text-gray-400">
                            Change status
                          </label>
                          <input type="radio" name="status" value="pending" id="pending" <?= $booking->status === 'pending' ? 'checked' : '' ?> />
                          <label class="ml-1" for="pending">Pending</label>
                          <br />

                          <input type="radio" name="status" id="booked" value="booked" <?= $booking->status === 'booked' ? 'checked' : '' ?> />
                          <label class="ml-1" for="booked">Booked</label>
                          <br />

                          <input type="radio" name="status" id="stayed" value="stayed" <?= $booking->status === 'stayed' ? 'checked' : '' ?> />
                          <label class="ml-1" for="stayed">Stayed</label>
                          <br />

                          <input type="radio" name="status" id="cancelled" value="cancelled" <?= $booking->status === 'cancelled' ? 'checked' : '' ?> />
                          <label class="ml-1" for="cancelled">Cancel</label>

                          <button class="mt-2 h-8 w-full rounded-lg bg-green-900 font-medium text-white">
                            Update
                          </button>
                        </form>
                      </modal-container>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
        </div>

        <em>
          <?= $count ?>
          bookings found
        </em>
      <?php else : ?>
        <em> No booking found </em>
      <?php endif; ?>
      </section>
    </main>
    <?php insert('footer') ?>
  </div>
</body>

</html>

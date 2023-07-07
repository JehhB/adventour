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

      <main>
        <?php insert('profile') ?>

        <section class="container mx-auto mt-4">
          <h2
            class="col-span-full px-2 font-heading text-lg font-semibold leading-none text-green-900 sm:px-0 sm:text-2xl"
          >
            Bookings
          </h2>

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
                </tr>
              </thead>
              <tbody class="table-group-divider">
                <?php
                foreach ($bookings as $i => $booking) : 
                  $booking = sanitize((array) $booking);
                ?>
                <tr>
                  <td><?= $booking['status'] ?></td>
                  <td><?= $booking['placed_at'] ?></td>
                  <td><?= $booking['hotel'] ?></td>
                  <td><?= $booking['room_type'] ?></td>
                  <td><?= $booking['fullname'] ?></td>
                  <td><?= $booking['checkin'] ?></td>
                  <td><?= $booking['stay'] ?></td>
                  <td><?= $booking['n_persons'] ?></td>
                  <td><?= $booking['n_room'] ?></td>
                  <td>
                    &#8369;
                    <?= number_format($booking['total_price'], 2) ?>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <?php else : ?>
          <em> No booking found </em>
          <?php endif; ?>
        </section>

        <section
          class="container mx-auto mt-4 grid gap-4 px-2 min-[500px]:grid-cols-2 sm:grid-cols-3 sm:px-0 lg:grid-cols-4 2xl:grid-cols-6"
        >
          <h2
            class="col-span-full justify-self-start font-heading text-lg font-semibold leading-none text-green-900 hover:underline sm:text-2xl"
          >
            Favorites
          </h2>
          <?php
          foreach ($liked->get() as $i => $data) { insert('hotel-card', $data);
          } ?>
          <?php if ($likes === 0) : ?>
          <em> No favorites yet </em>
          <?php endif; ?>
        </section>
      </main>
      <?php insert('footer') ?>
      <?php insert('auth-toast') ?>
    </div>
  </body>
</html>

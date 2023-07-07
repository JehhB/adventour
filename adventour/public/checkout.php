<?php
include $_SERVER['DOCUMENT_ROOT'] . '/lib/index.php';
include $_SERVER['DOCUMENT_ROOT'] . '/lib/checkout.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Checkout</title>
  </head>
  <body>
    <main class="grid h-screen w-screen place-items-center">
      <div
        class="relative h-full w-full bg-zinc-100 sm:h-auto sm:w-auto sm:rounded-xl sm:bg-lime-100 md:flex"
      >
        <div class="p-2 sm:p-8">
          <h1 class="text-3xl font-semibold text-green-900">Checkout</h1>
          <div class="mt-4 flex w-full flex-wrap gap-4">
            <div class="w-full sm:w-60">
              <div class="aspect-h-8 aspect-w-12">
                <img
                  src="<?= $offering->image === null ? '/assets/images/no_image.svg' : ('/storage/room/'.$offering->image) ?>"
                  class="h-full w-full rounded-lg"
                  alt="Image for <?= $offering->room_type ?> of <?= $offering->name ?>"
                />
              </div>
            </div>
            <div class="w-full flex-1 sm:w-60">
              <h2 class="leading-none">
                <?= $offering->room_type ?> of
                <?= $offering->name ?>
              </h2>
              <div class="mt-3">
                <div class="flex items-center gap-2">
                  <span class="text-sm leading-none text-gray-800">
                    <?= $offering->stays ?> Nights
                  </span>
                </div>
                <div class="mt-2 flex items-center gap-2">
                  <span class="text-sm leading-none text-gray-800">
                    Up to
                    <?= $offering->max_person ?> persons
                  </span>
                </div>
                <div class="mt-2 flex items-center gap-2">
                  <span class="text-sm leading-none text-gray-800">
                    <?= match($offering->meal_plan) { default => 'Meals not
                    included', 'breakfast' => 'Breakfast included',
                    'all_inclusive' => 'All meals included' } ?>
                  </span>
                </div>
              </div>
              <div class="mt-3 text-xs font-bold leading-none">
                Price per night
              </div>
              <div class="ml-8 mt-1 flex items-start gap-2">
                <?php if ($offering->original_price != 0) : ?>
                <del class="text-base leading-none text-gray-500">
                  &#8369;
                  <?= intval($offering->original_price) ?>
                </del>
                <?php endif; ?>
                <span class="text-2xl leading-none text-green-900">
                  &#8369;
                  <?= intval($offering->price) ?>
                </span>
              </div>
            </div>
          </div>
          <form method="POST" novalidate class="flex flex-col justify-center">
            <input
              type="hidden"
              name="offering_id"
              value="<?= $_GET['offering_id'] ?>"
            />

            <h2 class="mt-4 text-lg font-medium text-green-900">
              Stay information
            </h2>

            <label for="checkin" class="mt-2">Checkin date</label>
            <input
              type="date"
              name="checkin"
              id="checkin"
              min="<?= $today ?>"
              value="<?= $checkin ?>"
              required
              class="<?= isInvalid('checkin', ['peer/checkin','outline-1','outline-red-700','invalid:outline', 'animate-shake']) ?> mt-1 rounded bg-lime-800 bg-opacity-50 px-2 py-1 text-white"
            />
            <?php if (isInvalid('checkin')) : ?>
            <strong
              class="invisible text-xs font-medium text-red-700 outline-none peer-invalid/checkin:visible"
            >
              <?= getError('checkin') ?>
            </strong>
            <?php endif; ?>

            <label for="stay" class="mt-2">Number of nights</label>
            <input
              type="number"
              name="stay"
              id="stay"
              min="1"
              max="<?= $offering->stays ?>"
              value="<?= $stay ?? 1 ?>"
              required
              class="<?= isInvalid('stay', ['peer/stay','outline-1','outline-red-700','invalid:outline', 'animate-shake']) ?> mt-1 rounded bg-lime-800 bg-opacity-50 px-2 py-1 text-white"
            />
            <?php if (isInvalid('stay')) : ?>
            <strong
              class="invisible text-xs font-medium text-red-700 outline-none peer-invalid/stay:visible"
            >
              <?= getError('stay') ?>
            </strong>
            <?php endif; ?>

            <label for="n_adult" class="mt-2">Number of adults</label>
            <input
              type="number"
              name="n_adult"
              id="n_adult"
              min="1"
              value="<?= $_GET['n_adult'] ?? 1 ?>"
              required
              class="<?= isInvalid('n_adult', ['peer/n_adult','outline-1','outline-red-700','invalid:outline', 'animate-shake']) ?> mt-1 rounded bg-lime-800 bg-opacity-50 px-2 py-1 text-white"
            />
            <?php if (isInvalid('n_adult')) : ?>
            <strong
              class="invisible text-xs font-medium text-red-700 outline-none peer-invalid/n_adult:visible"
            >
              <?= getError('n_adult') ?>
            </strong>
            <?php endif; ?>

            <label for="n_child" class="mt-2">Number of children</label>
            <input
              type="number"
              name="n_child"
              id="n_child"
              min="0"
              value="<?= $_GET['n_child'] ?? 0 ?>"
              required
              class="<?= isInvalid('n_child', ['peer/n_child','outline-1','outline-red-700','invalid:outline', 'animate-shake']) ?> mt-1 rounded bg-lime-800 bg-opacity-50 px-2 py-1 text-white"
            />
            <?php if (isInvalid('n_child')) : ?>
            <strong
              class="invisible text-xs font-medium text-red-700 outline-none peer-invalid/n_child:visible"
            >
              <?= getError('n_child') ?>
            </strong>
            <?php endif; ?>

            <label for="n_room" class="mt-2">Number of rooms</label>
            <input
              type="number"
              name="n_room"
              id="n_room"
              min="1"
              value="<?= $_GET['n_room'] ?? 1 ?>"
              required
              class="<?= isInvalid('n_room', ['peer/n_room','outline-1','outline-red-700','invalid:outline', 'animate-shake']) ?> mt-1 rounded bg-lime-800 bg-opacity-50 px-2 py-1 text-white"
            />
            <?php if (isInvalid('n_room')) : ?>

            <strong
              class="invisible text-xs font-medium text-red-700 outline-none peer-invalid/n_room:visible"
            >
              <?= getError('n_room') ?>
            </strong>
            <?php endif; ?>
            <h2 class="mt-4 text-lg font-medium text-green-900">
              User information
            </h2>

            <label for="fullname" class="mt-2">Full name</label>
            <input
              type="text"
              name="fullname"
              id="fullname"
              required
              class="<?= isInvalid('fullname', ['peer/fullname','outline-1','outline-red-700','invalid:outline', 'animate-shake']) ?> mt-1 rounded bg-lime-800 bg-opacity-50 px-2 py-1 text-white"
            />
            <?php if (isInvalid('fullname')) : ?>
            <strong
              class="invisible text-xs font-medium text-red-700 outline-none peer-invalid/fullname:visible"
            >
              <?= getError('fullname') ?>
            </strong>
            <?php endif; ?>

            <label for="phone" class="mt-2">Contact number</label>
            <input
              type="tel"
              name="phone"
              id="phone"
              required
              class="<?= isInvalid('phone', ['peer/phone','outline-1','outline-red-700','invalid:outline', 'animate-shake']) ?> mt-1 rounded bg-lime-800 bg-opacity-50 px-2 py-1 text-white"
            />
            <?php if (isInvalid('phone')) : ?>
            <strong
              class="invisible text-xs font-medium text-red-700 outline-none peer-invalid/phone:visible"
            >
              <?= getError('phone') ?>
            </strong>
            <?php endif; ?>

            <label for="notes" class="mt-2">Additional notes</label>
            <textarea
              name="notes"
              id="notes"
              rows="5"
              class="w-full rounded bg-lime-800 bg-opacity-50 px-2 py-1 text-white"
            ></textarea>
            <input
              type="submit"
              value="Place reservation"
              class="mt-4 rounded-md bg-lime-900 py-1 text-white"
            />
          </form>
        </div>
      </div>
    </main>
  </body>
</html>

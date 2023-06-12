<?php include $_SERVER['DOCUMENT_ROOT'] . "/lib/signin.php"; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
  </head>

  <body>
    <main class="flex h-screen w-screen items-center justify-center">
      <div class="relative h-full w-full sm:h-auto sm:w-auto md:flex">
        <div
          class="hidden sm:absolute sm:left-1/2 sm:top-0 sm:flex sm:w-32 sm:-translate-x-1/2 sm:-translate-y-1/2 sm:items-center sm:justify-center md:static md:w-96 md:translate-x-0 md:translate-y-0 md:rounded-l-3xl md:bg-white"
        >
          <img
            src="/assets/images/signin.svg"
            alt="Graphics showing signing up is free"
            class="w-4/5 md:w-9/12"
          />
        </div>
        <form
          method="POST"
          novalidate
          class="flex h-full w-full flex-col justify-center bg-lime-100 p-12 sm:w-96 sm:rounded-3xl sm:pt-20 md:rounded-l-none md:pt-12"
        >
          <h1
            class="mb-6 self-center text-3xl font-semibold uppercase leading-none text-gray-800"
          >
            sign up
          </h1>
          <label for="email" class="mt-2">Email</label>
          <input
            type="email"
            name="email"
            id="email"
            required
            class="<?= isInvalid('email', ['peer/email','outline-1','outline-red-700','invalid:outline', 'animate-shake']) ?> mt-1 rounded bg-lime-800 bg-opacity-50 px-2 py-1 text-white"
          />
          <?php if (isInvalid('email')) : ?>
          <strong
            class="invisible text-xs font-medium text-red-700 outline-none peer-invalid/email:visible"
          >
            <?= getError('email') ?>
          </strong>
          <?php endif; ?>

          <label for="password" class="mt-2">Password</label>
          <input
            type="password"
            name="password"
            id="password"
            minlength="8"
            required
            class="<?= isInvalid('password', ['peer/password','outline-1','outline-red-700','invalid:outline', 'animate-shake']) ?> mt-1 rounded bg-lime-800 bg-opacity-50 px-2 py-1 text-white"
          />
          <?php if (isInvalid('password')) : ?>
          <strong
            class="invisible text-xs font-medium text-red-700 outline-none peer-invalid/password:visible"
          >
            <?= getError('password') ?>
          </strong>
          <?php endif; ?>

          <label for="confirm" class="mt-2">Confirm Password</label>
          <input
            type="password"
            name="confirm"
            id="confirm"
            minlength="8"
            required
            class="<?= isInvalid('confirm', ['peer/confirm','outline-1','outline-red-700','invalid:outline', 'animate-shake']) ?> mt-1 rounded bg-lime-800 bg-opacity-50 px-2 py-1 text-white"
          />
          <?php if (isInvalid('confirm')) : ?>
          <strong
            class="invisible text-xs font-medium text-red-700 outline-none peer-invalid/confirm:visible"
          >
            <?= getError('confirm') ?>
          </strong>
          <?php endif; ?>

          <a href="/login.php" class="mt-2 text-sm text-green-900 underline">
            Already have an account?
          </a>

          <?php clearError(); ?>
          <input
            type="submit"
            value="Submit"
            class="mt-4 rounded-md bg-lime-900 py-1 text-white"
          />
        </form>
      </div>
    </main>
  </body>
</html>

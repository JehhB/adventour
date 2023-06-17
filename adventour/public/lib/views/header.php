<header>
  <nav class="container relative mx-auto flex items-center p-2 sm:px-0">
    <a href="/" class="flex w-10 items-center justify-center gap-4 sm:w-auto">
      <img
        src="/assets/images/logo.webp"
        alt="adventour logo"
        class="h-10 sm:h-12"
      />
      <span
        class="hidden font-cursive text-2xl leading-none text-green-900 sm:block"
      >
        Adventour
      </span>
    </a>

    <search-box class="sm:ml-auto"></search-box>

    <?php if (!is_auth()) : ?>
    <div class="ml-auto flex items-center sm:ml-0 lg:ml-3">
      <div class="hidden items-center justify-around gap-2 lg:flex">
        <a
          href="/login.php?referer=<?= urlencode($_SERVER['REQUEST_URI']) ?>"
          class="w-[5.5rem] rounded-xl border-2 border-green-900 bg-white p-2 text-center font-medium leading-none text-green-900"
          >Log in</a
        >
        <a
          href="/signin.php?referer=<?= urldecode($_SERVER['REQUEST_URI']) ?>"
          class="w-[5.5rem] rounded-xl border-2 border-green-900 bg-green-900 p-2 text-center font-medium leading-none text-white"
          >Sign up</a
        >
      </div>

      <open-button class="w-10 lg:hidden" target="offpage">
        <b-icon-list
          class="mx-auto text-4xl leading-[1rem] text-green-900 sm:text-[2.5rem] sm:leading-none"
        ></b-icon-list>
      </open-button>
    </div>
    <off-page name="offpage">
      <div class="flex h-full flex-col justify-center p-10">
        <nav class="my-auto space-y-3">
          <a href="/" class="flex items-center justify-center gap-4 sm:w-auto">
            <img
              src="/assets/images/logo.webp"
              alt="adventour logo"
              class="h-10 sm:h-12"
            />
            <span class="font-cursive text-2xl leading-none text-green-900">
              Adventour
            </span>
          </a>
          <div class="flex items-center justify-around gap-2">
            <a
              href="/login.php?referer=<?= urlencode($_SERVER['REQUEST_URI']) ?>"
              class="w-[5.5rem] rounded-xl border-2 border-green-900 bg-white p-2 text-center font-medium leading-none text-green-900"
            >
              Log in
            </a>
            <a
              href="/signin.php?referer=<?= urldecode($_SERVER['REQUEST_URI']) ?>"
              class="w-[5.5rem] rounded-xl border-2 border-green-900 bg-green-900 p-2 text-center font-medium leading-none text-white"
            >
              Sign up
            </a>
          </div>
        </nav>
      </div>
    </off-page>
    <?php else :
      $sql = <<<SQL
      SELECT email FROM Users WHERE user_id = :user_id
      SQL;
      $stmt = execute($sql, [':user_id' =>
    is_auth()]); $user = $stmt->fetch(); ?>
    <div class="relative ml-auto sm:ml-3">
      <open-button
        class="h-10 w-10 overflow-hidden rounded-full border-2 border-gray-300 sm:h-12 sm:w-12"
        target="user"
      >
        <img
          src="/assets/images/placeholder.png"
          alt="profile picture"
          class="h-full w-full object-cover"
        />
      </open-button>
      <popover-container name="user">
        <div class="w-52 space-y-2 p-2 sm:w-60 sm:space-y-3 sm:py-3">
          <a
            href="/profile"
            class="flex items-center gap-2 border-b border-gray-300 pb-1 sm:pb-2"
          >
            <img
              src="/assets/images/placeholder.png"
              alt="profile picture"
              class="h-8 w-8 rounded-full border-2 border-gray-300 object-cover sm:h-10 sm:w-10"
            />
            <div class="w-0 flex-1">
              <div
                class="text-sm font-medium leading-none text-gray-800 sm:text-base sm:leading-none"
              >
                John Doe
              </div>
              <div
                class="mt-[2px] text-xs font-medium leading-none text-gray-700 sm:text-sm sm:leading-none"
              >
                <?= $user['email'] ?>
              </div>
            </div>
          </a>
          <a
            href="/profile/change-password.php"
            class="flex items-center gap-2"
          >
            <b-icon-gear
              class="mx-2 h-4 w-4 text-gray-600 sm:mx-[10px] sm:h-5 sm:w-5"
            ></b-icon-gear>
            <div
              class="w-0 flex-1 text-sm font-medium leading-none text-gray-800"
            >
              Change password
            </div>
          </a>
          <a href="/profile/signout.php" class="flex items-center gap-2">
            <b-icon-box-arrow-right
              class="mx-2 h-4 w-4 text-gray-600 sm:mx-[10px] sm:h-5 sm:w-5"
            ></b-icon-box-arrow-right>
            <div
              class="w-0 flex-1 text-sm font-medium leading-none text-gray-800"
            >
              Sign out
            </div>
          </a>
        </div>
      </popover-container>
    </div>
    <?php endif; ?>
  </nav>
</header>

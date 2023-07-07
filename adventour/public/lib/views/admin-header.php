<?php
use Illuminate\Database\Capsule\Manager as DB;
$user = DB::table('Users')
  ->select(['email', 'username', 'profile_pic'])
  ->join('Profiles', 'Profiles.user_id', '=', 'Users.user_id')
  ->where('Users.user_id', is_auth())
  ->first();
?>
<header>
  <nav class="container relative mx-auto flex items-center p-2 sm:px-0">
    <a href="/admin.php" class="flex w-10 items-center justify-center gap-4 sm:w-auto">
      <img
        src="/assets/images/logo.webp"
        alt="adventour logo"
        class="h-10 sm:h-12"
      />
      <span
        class="hidden font-cursive text-2xl leading-none text-green-900 sm:block"
      >
        Admin
      </span>
    </a>

    <div class="relative ml-auto">
      <open-button
        class="h-10 w-10 overflow-hidden rounded-full border-2 border-gray-300 sm:h-12 sm:w-12"
        target="user"
      >
        <img
          src="<?= $user->profile_pic === null ? '/assets/images/placeholder.png' : '/storage/user/' . $user->profile_pic ?>"
          alt="profile picture"
          class="h-full w-full object-cover"
        />
      </open-button>
      <popover-container name="user">
        <div class="w-52 space-y-2 p-2 sm:w-60 sm:space-y-3 sm:py-3">
          <a
            href="/admin.php"
            class="flex items-center gap-2 border-b border-gray-300 pb-1 sm:pb-2"
          >
            <img
              src="<?= $user->profile_pic === null ? '/assets/images/placeholder.png' : '/storage/user/' . $user->profile_pic ?>"
              alt="profile picture"
              class="h-8 w-8 rounded-full border-2 border-gray-300 object-cover sm:h-10 sm:w-10"
            />
            <div class="w-0 flex-1">
              <div
                class="text-sm font-medium leading-none text-gray-800 sm:text-base sm:leading-none"
              >
                <?= sanitize($user->username) ?>
              </div>
              <div
                class="mt-[2px] text-xs font-medium leading-none text-gray-700 sm:text-sm sm:leading-none"
              >
                <?= sanitize($user->email) ?>
              </div>
            </div>
          </a>
          <a
            href="/change-password.php"
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
  </nav>
</header>

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

    <div class="ml-auto flex items-center sm:ml-0 lg:ml-3">
      <div class="hidden items-center justify-around gap-2 lg:flex">
        <a
          href="/login.php"
          class="w-[5.5rem] rounded-xl border-2 border-green-900 bg-white p-2 text-center font-medium leading-none text-green-900"
          >Log in</a
        >
        <a
          href="/signin.php"
          class="w-[5.5rem] rounded-xl border-2 border-green-900 bg-green-900 p-2 text-center font-medium leading-none text-white"
          >Sign up</a
        >
      </div>
      <toggle-container>
        <open-button class="w-10 lg:hidden">
          <b-icon-list
            class="mx-auto text-4xl leading-[1rem] text-green-900 sm:text-[2.5rem] sm:leading-none"
          ></b-icon-list>
        </open-button>

        <template v-slot:toggled>
          <off-page>
            <div class="flex h-full flex-col justify-center p-10">
              <nav class="my-auto space-y-3">
                <a
                  href="/"
                  class="flex items-center justify-center gap-4 sm:w-auto"
                >
                  <img
                    src="/assets/images/logo.webp"
                    alt="adventour logo"
                    class="h-10 sm:h-12"
                  />
                  <span
                    class="font-cursive text-2xl leading-none text-green-900"
                  >
                    Adventour
                  </span>
                </a>
                <div class="flex items-center justify-around gap-2">
                  <a
                    href="/login.php"
                    class="w-[5.5rem] rounded-xl border-2 border-green-900 bg-white p-2 text-center font-medium leading-none text-green-900"
                    >Log in</a
                  >
                  <a
                    href="/signin.php"
                    class="w-[5.5rem] rounded-xl border-2 border-green-900 bg-green-900 p-2 text-center font-medium leading-none text-white"
                    >Sign up</a
                  >
                </div>
              </nav>
            </div>
          </off-page>
        </template>
      </toggle-container>
    </div>
  </nav>
</header>

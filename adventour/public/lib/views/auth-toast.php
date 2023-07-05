<?php if (!is_auth()) : ?>
<toast-container name="not authenticated toast">
  <div class="flex items-center gap-3 p-4">
    <img
      src="/assets/images/authenticate.svg"
      alt="Authenticate to continue"
      class="w-20"
    />
    <div class="w-0 flex-1">
      <div class="font-heading font-semibold text-neutral-800">
        Authentication Required
      </div>
      <div class="text-sm">
        <a
          href="/login.php?referer=<?= urlencode($_SERVER['REQUEST_URI']) ?>"
          class="text-green-900"
          >Login</a
        >
        first to continue
      </div>
    </div>
  </div>
</toast-container>
<not-auth></not-auth>
<?php endif; ?>

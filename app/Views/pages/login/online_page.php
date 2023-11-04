<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= base_url('/assets/css/style.css') ?>">
  <title>Users Online</title>
</head>

<body class="flex justify-center items-start">
  <main class="container flex justify-center items-center h-screen">
    <form action="<?= base_url('auth/remove_online') ?>" method="post" class="w-[500px] h-max p-2 bg-white rounded-md">
      <? csrf_field() ?>
      <input type="hidden" name="username" value="<?= session()->get('online') ?>">
      <h2 class="text-lg font-medium text-center mb-2">Nampaknya akun dengan username <span class="font-semibold">"<?= session()->get('online') ?>"</span> sedang online!</h2>
      <button type="submit" class="p-2 bg-red-600 hover:bg-deleteHover rounded-md w-full flex justify-center items-center gap-2" onclick="return confirm(`User <?= session()->get('online') ?> sedang online. Apakah ingin menganti hak akses agar anda bisa login?`)">
        <div class="w-[30px] h-[30px] block">
          <img src="<?= base_url('assets/icons/user-forbid-line.svg') ?>" alt="eye" class="h-full w-full object-cover">
        </div>
        <h2 class="text-base font-medium text-white">Logout User</h2>
      </button>
    </form>
  </main>
</body>

</html>
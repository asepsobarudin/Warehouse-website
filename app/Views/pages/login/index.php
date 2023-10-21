<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= base_url('/assets/css/style.css') ?>">
  <title>Login Page</title>
</head>

<body class="flex justify-center items-start">

  <?php if (session()->getFlashdata('_ci_validation_errors')) :
    $errors = session()->getFlashdata('_ci_validation_errors');
  endif; ?>

  <main class="container flex justify-center items-center h-screen">
    <div class="w-[60%] h-[80%] bg-white px-4 flex justify-center items-center gap-2 rounded-md">
      <img src="<?= base_url('assets/images/wellcome.svg') ?>" alt="wellcome" class="block w-[50%]">
      <form action="<?= base_url('auth') ?>" method="post" class="w-[50%] flex flex-col justify-center items-center gap-4">
        <?= csrf_field() ?>
        <h2 class="block text-[30px] font-semibold text-add">LOGIN</h2>
        <?php if (session()->getFlashdata('fail')) : ?>
          <div class="block w-full">
            <span class="text-sm font-normal p-2 bg-delete/50 text-white w-full block">
              <?= session()->getFlashdata('fail') ?>
            </span>
          </div>
        <?php endif; ?>
        <div class="block w-full">
          <label for="username" class="relative flex justify-start items-center">
            <input type="text" id="username" class="p-2 rounded-md font-medium outline-none border-2 border-black/10 peer focus:border-black/30 w-full" name="username" value="<?= old('username') ?>" autofocus>
            <span class="absolute block font-medium text-sm text-black/50 -top-[9px] left-2 bg-white ease-out duration-100 px-1 peer-focus:text-black/60">Username</span>
          </label>
          <?php if (isset($errors['username'])) : ?>
            <span class="block text-red-600 text-sm font-medium"><?= $errors['username'] ?></span>
          <?php endif; ?>
        </div>
        <div class="block w-full">
          <label for="password" class="relative flex justify-start items-center">
            <input type="password" id="password" class="p-2 rounded-md font-medium outline-none border-2 border-black/10 peer focus:border-black/30 w-full" name="password">
            <span class="absolute block font-medium text-sm text-black/50 -top-[9px] left-2 bg-white ease-out duration-100 px-1 peer-focus:text-black/60">Password</span>
          </label>
          <?php if (isset($errors['password'])) : ?>
            <span class="block text-red-600 text-sm font-medium"><?= $errors['password'] ?></span>
          <?php endif; ?>
        </div>
        <button class="p-2 w-full flex justify-center items-center bg-add hover:bg-addHover font-semibold text-white rounded-md">
          Login
        </button>
      </form>
    </div>
  </main>
</body>

</html>
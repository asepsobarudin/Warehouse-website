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
    <div class="w-[80%] h-[80%] bg-netral flex justify-between flex-col lg:flex-row items-center gap-2 rounded-md px-4 relative overflow-hidden">
      <img src="<?= base_url('assets/images/login.jpg') ?>" alt="wellcome" class="block w-auto h-full object-contain absolute lg:relative top-0">
      <form action="<?= base_url('auth') ?>" method="post" class="w-full md:w-[80%] lg:w-[40%] h-full flex flex-col justify-between items-center gap-4 p-4 after:block relative z-10 bg-netral/80" id="form_login">
        <?= csrf_field() ?>
        <div class="flex justify-end items-center w-full gap-1">
          <img src="<?= base_url('assets/images/icons.png') ?>" alt="icons" class="w-[30px] h-[30px] object-cover rounded-full">
          <h2 class="font-medium text-start text-sm text-primary">TB Saluyu Mekar</h2>
        </div>
        <div class="block w-full">
          <div class="block w-full mb-8">
            <h2 class="block text-[30px] font-semibold text-start w-full text-primary">Log In</h2>
            <p class="text-sm text-primary/80 font-medium">Silahkan masukan username dan password.</p>
          </div>
          <?php if (session()->getFlashdata('errors')) : ?>
            <div class="block w-full mb-2">
              <span class="text-sm font-medium p-2 bg-danger/80 text-netral w-full block">
                <?= session()->getFlashdata('errors') ?>
              </span>
            </div>
          <?php endif; ?>
          <div class="flex flex-col gap-4 w-full">
            <div class="block w-full">
              <label for="username" class="block w-full">
                <div class="flex flex-col md:flex-row justify-between items-start lg:items-center w-full">
                  <span class="block font-medium text-primary/80 text-sm">Username</span>
                  <?php if (isset($errors['username'])) : ?>
                    <span class="block text-danger text-xs font-medium">"<?= $errors['username'] ?>"</span>
                  <?php endif; ?>
                </div>
                <input type="text" id="username" class="p-2 rounded-md font-medium outline-none border-2 border-primary/10 peer focus:border-primary/30 w-full" name="username" value="<?= old('username') ?>" placeholder="Masukan username anda" required>
              </label>
            </div>
            <div class="block w-full">
              <label for="password" class="relative block w-full">
                <div class="flex flex-col md:flex-row justify-between items-start lg:items-center w-full">
                  <span class="block font-medium text-primary/80 text-sm">Password</span>
                  <?php if (isset($errors['password'])) : ?>
                    <span class="block text-danger text-xs font-medium">"<?= $errors['password'] ?>"</span>
                  <?php endif; ?>
                </div>
                <input type="password" id="password" class="pl-2 py-2 pr-[40px] rounded-md font-medium outline-none border-2 border-primary/10 peer focus:border-primary/30 w-[100%]" name="password" placeholder="Masukan password anda" required>
                <label class="password_view" for="password_view">
                  <input type="checkbox" id="password_view" class="hidden">
                  <img src="<?= base_url('assets/icons/eye/eye-line-1.svg') ?>" alt="eye-line-1" class="active" id="eye_view">
                  <img src="<?= base_url('assets/icons/eye/eye-line-2.svg') ?>" alt="eye-line-2" class="nonActive" id="eye_hide">
                </label>
              </label>
            </div>
          </div>
          <button type="button" class="p-2 mt-4 w-full flex justify-center items-center buttonInfo gap-2 font-semibold" id="buttonLoading">
            <img src="<?= base_url('assets/icons/log-in-line-white-1.svg') ?>" alt="log-in" class="h-[30px] w-[30px] object-cover">
            <img src="<?= base_url('assets/icons/log-in-line-blue-1.svg') ?>" alt="log-in" class="h-[30px] w-[30px] object-cover">
            <h2>Login</h2>
          </button>
        </div>
      </form>
    </div>
  </main>

  <script>
    const passwordView = document.getElementById('password_view');
    const password = document.getElementById('password');
    const eyeView = document.getElementById('eye_view');
    const eyeHide = document.getElementById('eye_hide');
    const buttonLoading = document.getElementById('buttonLoading');
    const formLogin = document.getElementById('form_login');

    passwordView.addEventListener('click', () => {
      if (passwordView.checked == true) {
        password.type = 'text';
        eyeView.classList.remove('active');
        eyeView.classList.add('nonActive');

        eyeHide.classList.remove('nonActive');
        eyeHide.classList.add('active');
      } else {
        password.type = 'password';
        eyeView.classList.remove('nonActive');
        eyeView.classList.add('active');

        eyeHide.classList.remove('active');
        eyeHide.classList.add('nonActive');
      }
    })

    formLogin.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        buttonLoading.disabled = true;
        buttonLoading.innerHTML = "Loading...";
        formLogin.submit();
      }
    })

    buttonLoading.addEventListener('click', () => {
      buttonLoading.disabled = true;
      buttonLoading.innerHTML = "Loading...";
      formLogin.submit();
    })
  </script>
</body>

</html>
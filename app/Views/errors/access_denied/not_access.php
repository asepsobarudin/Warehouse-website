<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= base_url('/assets/css/style.css') ?>">
  <title>Akses Dibatasi</title>
</head>

<body class="h-screen flex justify-center items-center bg-black/5">
  <div class="p-2 bg-white rounded-md flex flex-col justify-center items-center gap-2">
    <h2 class="font-medium"><?= session()->get('failed') ?></h2>
    <a href="<?= base_url('/') ?>" class="block p-2 bg-blue-500 hover:bg-blue-700 font-semibold text-white rounded-md text-center w-max">Back</a>
  </div>
</body>

</html>
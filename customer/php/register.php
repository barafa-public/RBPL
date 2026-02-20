<?php
session_start();
include '../../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $alamat = $_POST['alamat'];
  $no_telepon = $_POST['no_telepon'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $confirm = $_POST['confirm_password'];

  if ($_POST['password'] !== $_POST['confirm_password']) {
    $error = "Password dan konfirmasi password tidak cocok!";
  } else {
    $query = "INSERT INTO customers (username, alamat, no_telepon, password)
                  VALUES ('$username', '$alamat', '$no_telepon', '$password')";

    if (mysqli_query($conn, $query)) {
      header("Location: login.php?status=berhasil");
      exit;
    } else {
      $error = "Gagal mendaftar, coba lagi!";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Daftar Akun Baru</title>
  <link rel="stylesheet" href="../css/register.css" />
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body>

  <div class="card">

    <div class="logo-wrap">
      <div class="logo">
        <i class="fa-regular fa-user"></i>
      </div>
    </div>

    <h1 class="title">Daftar Akun Baru</h1>
    <p class="subtitle">Lengkapi data diri Anda untuk mendaftar</p>

    <?php if (!empty($error)): ?>
      <div class="alert-error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="form-group">
        <label>Username</label>
        <div class="input-wrap">
          <i class="fa-regular fa-user icon-left"></i>
          <input type="text" name="username" placeholder="Buat Username" required />
        </div>
      </div>

      <div class="form-group">
        <label>Alamat</label>
        <div class="input-wrap">
          <i class="fa-solid fa-location-dot icon-left"></i>
          <input type="text" name="alamat" placeholder="Jln.xxx" required />
        </div>
      </div>

      <div class="form-group">
        <label>No. Telepon</label>
        <div class="input-wrap">
          <i class="fa-solid fa-phone icon-left"></i>
          <input type="tel" name="no_telepon" placeholder="xxxxxxxx" required />
        </div>
      </div>

      <div class="form-group">
        <label>Password</label>
        <div class="input-wrap">
          <i class="fa-solid fa-lock icon-left"></i>
          <input type="password" name="password" id="passwordInput" placeholder="Minimal 6 karakter" required />
          <i class="fa-regular fa-eye icon-right" id="togglePassword"></i>
        </div>
      </div>

      <div class="form-group">
        <label>Konfirmasi Password</label>
        <div class="input-wrap">
          <i class="fa-solid fa-lock icon-left"></i>
          <input type="password" name="confirm_password" id="confirmPasswordInput" placeholder="Ulangi password Anda"
            required />
          <i class="fa-regular fa-eye icon-right" id="toggleConfirm"></i>
        </div>
      </div>

      <button type="submit" class="btn-daftar">Daftar Sekarang</button>
    </form>

    <p class="login-text">
      Sudah punya akun? <a href="login.php">Masuk</a>
    </p>

  </div>

  <script>
    function toggleVisibility(inputId, iconId) {
      const input = document.getElementById(inputId);
      const icon = document.getElementById(iconId);
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
      }
    }
    document.getElementById('togglePassword').addEventListener('click', () => toggleVisibility('passwordInput', 'togglePassword'));
    document.getElementById('toggleConfirm').addEventListener('click', () => toggleVisibility('confirmPasswordInput', 'toggleConfirm'));
  </script>

</body>

</html>
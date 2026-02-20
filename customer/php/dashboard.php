<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard - Beranda</title>
  <link rel="stylesheet" href="../css/dashboard.css" />
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body>

  <!-- Header -->
  <div class="header">
    <h2 class="header-title">Beranda</h2>
    <a href="logout.php" class="btn-logout">
      <i class="fa-solid fa-arrow-right-from-bracket"></i>
    </a>
  </div>

  <!-- Konten -->
  <div class="content">

    <!-- Kartu Sambutan -->
    <div class="welcome-card">
      <div class="wave-icon">👋</div>
      <h2 class="welcome-name">Halo, <?= htmlspecialchars($username) ?>!</h2>
      <p class="welcome-text">Apa yang ingin Anda pesan hari ini?</p>
      <div class="circle circle-1"></div>
      <div class="circle circle-2"></div>
    </div>

    <!-- Menu -->
    <div class="menu-list">

      <div class="menu-item" onclick="window.location.href='pesanan.php'">
        <div class="menu-icon green">
          <i class="fa-solid fa-cart-shopping"></i>
        </div>
        <span class="menu-label">Buat Pesanan Baru</span>
        <i class="fa-solid fa-chevron-right menu-arrow"></i>
      </div>

      <div class="menu-item" onclick="window.location.href='status.php'">
        <div class="menu-icon yellow">
          <i class="fa-solid fa-box"></i>
        </div>
        <span class="menu-label">Status Pesanan</span>
        <i class="fa-solid fa-chevron-right menu-arrow"></i>
      </div>

    </div>

  </div>

</body>

</html>
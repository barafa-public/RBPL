<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}
include '../../config/connection.php';

$username = $_SESSION['username'];
$customer_id = $_SESSION['id'];

$q = mysqli_query($conn, "SELECT * FROM customers WHERE id='$customer_id'");
$customer = mysqli_fetch_assoc($q);
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Buat Pesanan</title>
  <link rel="stylesheet" href="../css/order.css" />
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body>

  <!-- Header -->
  <div class="header">
    <button class="btn-back" onclick="window.location.href='dashboard.php'">
      <i class="fa-solid fa-arrow-left"></i>
    </button>
    <h2 class="header-title">Buat Pesanan</h2>
    <div class="circle circle-1"></div>
    <div class="circle circle-2"></div>
  </div>

  <div class="content">

    <!-- Gambar Produk -->
    <div class="section-card">
      <h3 class="section-title">Gambar Produk</h3>
      <div class="product-grid">

        <div class="product-item">
          <img src="../img/aquaBox.jpg" alt="Aqua" />
          <p>Aqua</p>
        </div>

        <div class="product-item">
          <img src="../img/leMineralBox.jpg" alt="Le Mineral" />
          <p>Le Mineral</p>
        </div>

      </div>
    </div>

    <!-- Informasi Pesanan -->
    <div class="section-card">
      <h3 class="section-title">Informasi Pesanan</h3>

      <div class="form-group">
        <label>Nama Pemesan</label>
        <input type="text" value="<?= htmlspecialchars($username) ?>" readonly class="input-readonly" />
      </div>

      <div class="form-group">
        <label>Produk</label>
        <select id="selectProduct" required>
          <option value="" data-price="0">Nama produk</option>
          <option value="Aqua" data-price="50000">Aqua - Rp 50.000</option>
          <option value="Le Mineral" data-price="45000">Le Mineral - Rp 45.000</option>
        </select>
      </div>

      <div class="form-group">
        <label>Jumlah</label>
        <input type="number" id="inputQuantity" placeholder="Jumlah pesanan (dalam karton)" min="1" />
      </div>

      <div class="form-group">
        <label>Alamat Pengiriman</label>
        <textarea id="inputAddress" rows="2"><?= htmlspecialchars($customer['address']) ?></textarea>
      </div>
    </div>

    <!-- Metode Pembayaran -->
    <div class="section-card">
      <h3 class="section-title">Metode Pembayaran</h3>
      <div class="payment-options">
        <label class="payment-option active">
          <input type="radio" name="payment_method" value="Transfer Bank" checked />
          <span>Transfer Bank</span>
        </label>
        <label class="payment-option">
          <input type="radio" name="payment_method" value="QRIS" />
          <span>QRIS</span>
        </label>
        <label class="payment-option">
          <input type="radio" name="payment_method" value="E-Wallet" />
          <span>E-Wallet</span>
        </label>
        <label class="payment-option">
          <input type="radio" name="payment_method" value="COD (Cash on Delivery)" />
          <span>COD (Cash on Delivery)</span>
        </label>
      </div>
    </div>

    <!-- Ringkasan Pesanan -->
    <div class="section-card">
      <h3 class="section-title">Ringkasan Pesanan</h3>
      <div class="summary">
        <div class="summary-row">
          <span class="summary-label">Produk:</span>
          <span class="summary-value" id="summary-product">-</span>
        </div>
        <div class="summary-row">
          <span class="summary-label">Jumlah:</span>
          <span class="summary-value" id="summary-quantity">-</span>
        </div>
        <div class="summary-row">
          <span class="summary-label">Metode Bayar:</span>
          <span class="summary-value" id="summary-payment">-</span>
        </div>
      </div>
    </div>

  </div>

  <!-- Tombol Fixed Bawah -->
  <div class="bottom-bar">
    <button class="btn-order" onclick="createOrder()">Buat Pesanan</button>
  </div>

  <script>
    // Update active class pada metode pembayaran
    document.querySelectorAll('.payment-option').forEach(label => {
      label.addEventListener('click', function () {
        document.querySelectorAll('.payment-option').forEach(l => l.classList.remove('active'));
        this.classList.add('active');
      });
    });

    function updateSummary() {
      const product = document.getElementById('selectProduct');
      const quantity = document.getElementById('inputQuantity').value;
      const payment = document.querySelector('input[name="payment_method"]:checked').value;

      document.getElementById('summary-product').textContent = product.value || '-';
      document.getElementById('summary-quantity').textContent = quantity || '-';
      document.getElementById('summary-payment').textContent = payment || '-';
    }

    document.getElementById('selectProduct').addEventListener('change', updateSummary);
    document.getElementById('inputQuantity').addEventListener('input', updateSummary);
    document.querySelectorAll('input[name="payment_method"]').forEach(r => r.addEventListener('change', updateSummary));

    function createOrder() {
      const productEl = document.getElementById('selectProduct');
      const quantity = document.getElementById('inputQuantity').value;
      const address = document.getElementById('inputAddress').value;
      const payment = document.querySelector('input[name="payment_method"]:checked').value;
      const price = productEl.options[productEl.selectedIndex].dataset.price;
      const product = productEl.value;

      if (!product || !quantity || !address) {
        alert('Lengkapi semua data pesanan!');
        return;
      }

      const total = price * quantity;
      sessionStorage.setItem('order', JSON.stringify({ product, quantity, address, payment, price, total }));
      window.location.href = 'payment.php';
    }
  </script>

</body>

</html>
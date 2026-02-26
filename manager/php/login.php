<?php
session_start();
if (isset($_SESSION['manager'])) {
    header("Location: dashboard.php");
    exit;
}
include '../../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM managers WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['manager'] = $user['username'];
        $_SESSION['manager_id'] = $user['id'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Portal Manager</title>
    <link rel="stylesheet" href="/manager/css/login.css" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body>

    <div class="bg-overlay"></div>

    <div class="wrapper">
        <div class="card">

            <div class="logo-wrap">
                <div class="logo">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
            </div>

            <h1 class="title">Portal Manager</h1>
            <p class="subtitle">Akses dashboard manajemen</p>

            <?php if (!empty($error)): ?>
                <div class="alert-error"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <div class="input-wrap">
                        <i class="fa-regular fa-envelope icon-left"></i>
                        <input type="text" name="username" placeholder="Masukkan Username" required />
                    </div>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="input-wrap">
                        <i class="fa-solid fa-lock icon-left"></i>
                        <input type="password" name="password" id="passwordInput" placeholder="Masukkan Password"
                            required />
                        <i class="fa-regular fa-eye icon-right" id="togglePassword"></i>
                    </div>
                </div>

                <button type="submit" class="btn-masuk">Masuk</button>
            </form>

            <p class="footer-note">Akses terbatas untuk Manager</p>

        </div>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const input = document.getElementById('passwordInput');
            if (input.type === 'password') {
                input.type = 'text';
                this.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                this.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    </script>

</body>

</html>
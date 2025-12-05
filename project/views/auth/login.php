<?php
// views/auth/login.php
$k = db();
$errors = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim(mysqli_real_escape_string($k, $_POST['username'] ?? ''));
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $errors[] = 'Username dan password wajib diisi.';
    }

    if (empty($errors)) {
        // Coba cek ke tabel users
        $sql = "SELECT * FROM users WHERE username = ? LIMIT 1";
        $stmt = @mysqli_prepare($k, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 's', $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result && $row = mysqli_fetch_assoc($result)) {
                $stored = $row['password'];
                $valid = false;

                // cek hashed
                if (password_verify($password, $stored)) {
                    $valid = true;
                }

                // cek plain text (praktikum biasanya pakai ini)
                if ($password === $stored) {
                    $valid = true;
                }

                if ($valid) {
                    $_SESSION['user'] = array(
                        'id' => $row['id'],
                        'username' => $row['username']
                    );
                    flash_set('success', 'Login berhasil.');
                    header('Location: ' . base_url('index.php?page=user/list'));
                    exit;
                } else {
                    $errors[] = 'Password salah.';
                }

            } else {
                // fallback admin/admin
                if ($username === 'admin' && $password === 'admin') {
                    $_SESSION['user'] = array('id' => 0, 'username' => 'admin');
                    flash_set('success', 'Login berhasil (fallback).');
                    header('Location: ' . base_url('index.php?page=user/list'));
                    exit;
                }

                $errors[] = 'User tidak ditemukan.';
            }

            mysqli_stmt_close($stmt);

        } else {
            // tidak ada tabel users
            if ($username === 'admin' && $password === 'admin') {
                $_SESSION['user'] = array('id' => 0, 'username' => 'admin');
                flash_set('success', 'Login berhasil (fallback).');
                header('Location: ' . base_url('index.php?page=user/list'));
                exit;
            }

            $errors[] = 'Autentikasi gagal.';
        }
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="mb-3">Login</h5>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors as $e) echo htmlspecialchars($e) . "<br>"; ?>
                    </div>
                <?php endif; ?>

                <form method="post">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" 
                               value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <button class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>

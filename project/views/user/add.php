<?php
// views/user/add.php
$k = db();
$errors = array();
$gambarName = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $kategori = mysqli_real_escape_string($k, $_POST['kategori'] ?? '');
    $nama = mysqli_real_escape_string($k, $_POST['nama'] ?? '');
    $deskripsi = mysqli_real_escape_string($k, $_POST['deskripsi'] ?? '');
    $tanggal_masuk = $_POST['tanggal_masuk'] ?? date('Y-m-d');
    $harga_beli = (int) ($_POST['harga_beli'] ?? 0);
    $harga_jual = (int) ($_POST['harga_jual'] ?? 0);
    $stok = (int) ($_POST['stok'] ?? 0);

    // Validasi
    if ($kategori === "") $errors[] = "Kategori wajib diisi.";
    if ($nama === "") $errors[] = "Nama barang wajib diisi.";

    // Upload file
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] != UPLOAD_ERR_NO_FILE) {

        $file = $_FILES['gambar'];
        $allowed = array('image/jpeg', 'image/png', 'image/jpg');
        $maxSize = 1024 * 1024; // 1MB

        if ($file['error'] != UPLOAD_ERR_OK) {
            $errors[] = "Gagal upload file.";
        } elseif ($file['size'] > $maxSize) {
            $errors[] = "Ukuran file maksimal 1MB.";
        } elseif (!in_array(mime_content_type($file['tmp_name']), $allowed)) {
            $errors[] = "Format gambar tidak valid.";
        } else {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $gambarName = time() . "_" . rand(1000, 9999) . "." . $ext;

            $folder = __DIR__ . '/../../gambar/';
            if (!is_dir($folder)) mkdir($folder, 0777, true);

            $destination = $folder . $gambarName;
            if (!move_uploaded_file($file['tmp_name'], $destination)) {
                $errors[] = "Gagal memindahkan file gambar.";
                $gambarName = "";
            }
        }
    }

    // Jika tidak ada error, simpan ke DB
    if (empty($errors)) {
        $sql = "INSERT INTO data_barang (kategori, nama, deskripsi, tanggal_masuk, gambar, harga_beli, harga_jual, stok)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($k, $sql);
        mysqli_stmt_bind_param($stmt, "sssssiis",
            $kategori,
            $nama,
            $deskripsi,
            $tanggal_masuk,
            $gambarName,
            $harga_beli,
            $harga_jual,
            $stok
        );

        if (mysqli_stmt_execute($stmt)) {
            flash_set('success', 'Barang berhasil ditambahkan.');
            header("Location: " . base_url("index.php?page=user/list"));
            exit;
        } else {
            $errors[] = "Gagal menyimpan data: " . mysqli_error($k);
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Tambah Barang</h4>
    <a href="<?= base_url('index.php?page=user/list') ?>" class="btn btn-secondary">Kembali</a>
</div>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <input type="text" name="kategori" class="form-control" value="<?= htmlspecialchars($_POST['kategori'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Barang</label>
                <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3"><?= htmlspecialchars($_POST['deskripsi'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Masuk</label>
                <input type="date" name="tanggal_masuk" class="form-control" value="<?= htmlspecialchars($_POST['tanggal_masuk'] ?? date('Y-m-d')) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Harga Beli</label>
                <input type="number" name="harga_beli" class="form-control" value="<?= htmlspecialchars($_POST['harga_beli'] ?? 0) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Harga Jual</label>
                <input type="number" name="harga_jual" class="form-control" value="<?= htmlspecialchars($_POST['harga_jual'] ?? 0) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Stok</label>
                <input type="number" name="stok" class="form-control" value="<?= htmlspecialchars($_POST['stok'] ?? 0) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Gambar Barang</label>
                <input type="file" name="gambar" class="form-control">
            </div>

            <button class="btn btn-primary">Simpan</button>

        </form>
    </div>
</div>

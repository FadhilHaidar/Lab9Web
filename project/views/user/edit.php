<?php
// views/user/edit.php
$k = db();

if (!isset($_GET['id'])) {
    echo "<h3>ID barang tidak ditemukan.</h3>";
    exit;
}

$id = (int) $_GET['id'];

// Ambil data lama
$sql = "SELECT * FROM data_barang WHERE id_barang = $id LIMIT 1";
$res = mysqli_query($k, $sql);
$data = mysqli_fetch_assoc($res);

if (!$data) {
    echo "<h3>Data tidak ditemukan.</h3>";
    exit;
}

$errors = array();
$gambarBaru = $data['gambar'];

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $kategori = mysqli_real_escape_string($k, $_POST['kategori'] ?? '');
    $nama = mysqli_real_escape_string($k, $_POST['nama'] ?? '');
    $deskripsi = mysqli_real_escape_string($k, $_POST['deskripsi'] ?? '');
    $tanggal_masuk = $_POST['tanggal_masuk'] ?? date('Y-m-d');
    $harga_beli = (int) ($_POST['harga_beli'] ?? 0);
    $harga_jual = (int) ($_POST['harga_jual'] ?? 0);
    $stok = (int) ($_POST['stok'] ?? 0);

    if ($nama === '') $errors[] = "Nama barang wajib diisi.";
    if ($kategori === '') $errors[] = "Kategori wajib diisi.";

    // Upload gambar jika ada
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] != UPLOAD_ERR_NO_FILE) {

        $file = $_FILES['gambar'];
        $allowed = array('image/jpeg', 'image/png', 'image/jpg');
        $maxSize = 1024 * 1024;

        if ($file['error'] != UPLOAD_ERR_OK) {
            $errors[] = "Gagal upload file.";
        } elseif ($file['size'] > $maxSize) {
            $errors[] = "Ukuran maksimal 1MB.";
        } elseif (!in_array(mime_content_type($file['tmp_name']), $allowed)) {
            $errors[] = "Format gambar tidak valid.";
        } else {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $gambarBaru = time() . "_" . rand(1000, 9999) . "." . $ext;

            $folder = __DIR__ . '/../../gambar/';
            $dest = $folder . $gambarBaru;

            if (!move_uploaded_file($file['tmp_name'], $dest)) {
                $errors[] = "Gagal memindahkan file gambar.";
            } else {
                if (!empty($data['gambar']) && file_exists($folder . $data['gambar'])) {
                    unlink($folder . $data['gambar']);
                }
            }
        }
    }

    if (empty($errors)) {
        $sql = "UPDATE data_barang SET kategori=?, nama=?, deskripsi=?, tanggal_masuk=?, gambar=?, harga_beli=?, harga_jual=?, stok=?
                WHERE id_barang=?";

        $stmt = mysqli_prepare($k, $sql);
        mysqli_stmt_bind_param(
            $stmt,
            "sssssiisi",
            $kategori, $nama, $deskripsi, $tanggal_masuk,
            $gambarBaru, $harga_beli, $harga_jual, $stok, $id
        );

        if (mysqli_stmt_execute($stmt)) {
            flash_set('success', 'Data barang berhasil diperbarui.');
            header("Location: " . base_url("index.php?page=user/list"));
            exit;
        } else {
            $errors[] = "Gagal update data: " . mysqli_error($k);
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Edit Barang</h4>
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
                <label>Kategori</label>
                <input type="text" name="kategori" class="form-control" value="<?= htmlspecialchars($data['kategori']) ?>">
            </div>

            <div class="mb-3">
                <label>Nama Barang</label>
                <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data['nama']) ?>">
            </div>

            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3"><?= htmlspecialchars($data['deskripsi']) ?></textarea>
            </div>

            <div class="mb-3">
                <label>Tanggal Masuk</label>
                <input type="date" name="tanggal_masuk" class="form-control" value="<?= htmlspecialchars($data['tanggal_masuk']) ?>">
            </div>

            <div class="mb-3">
                <label>Harga Beli</label>
                <input type="number" name="harga_beli" class="form-control" value="<?= $data['harga_beli'] ?>">
            </div>

            <div class="mb-3">
                <label>Harga Jual</label>
                <input type="number" name="harga_jual" class="form-control" value="<?= $data['harga_jual'] ?>">
            </div>

            <div class="mb-3">
                <label>Stok</label>
                <input type="number" name="stok" class="form-control" value="<?= $data['stok'] ?>">
            </div>

            <div class="mb-3">
                <label>Gambar Lama</label><br>
                <?php if (!empty($data['gambar'])): ?>
                    <img src="<?= base_url('gambar/' . $data['gambar']) ?>" style="width:90px;">
                <?php else: ?>
                    <span class="text-muted">Tidak ada gambar</span>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label>Gambar Baru (opsional)</label>
                <input type="file" name="gambar" class="form-control">
            </div>

            <button class="btn btn-primary">Simpan Perubahan</button>

        </form>
    </div>
</div>

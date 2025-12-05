<?php
// views/user/delete.php
$k = db();

if (!isset($_GET['id'])) {
    flash_set('danger', 'ID tidak ditemukan.');
    header("Location: " . base_url("index.php?page=user/list"));
    exit;
}

$id = (int) $_GET['id'];

// ambil data untuk hapus gambar
$sql = "SELECT gambar FROM data_barang WHERE id_barang = $id LIMIT 1";
$res = mysqli_query($k, $sql);
$data = mysqli_fetch_assoc($res);

// hapus data
$delete = mysqli_query($k, "DELETE FROM data_barang WHERE id_barang = $id");

if ($delete) {
    if (!empty($data['gambar'])) {
        $file = __DIR__ . "/../../gambar/" . $data['gambar'];
        if (file_exists($file)) unlink($file);
    }

    flash_set('success', 'Data berhasil dihapus.');
} else {
    flash_set('danger', 'Gagal menghapus data.');
}

header("Location: " . base_url("index.php?page=user/list"));
exit;

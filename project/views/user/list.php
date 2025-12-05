<?php
// views/user/list.php
// Ambil semua data dari tabel data_barang
$k = db();
$sql = "SELECT * FROM data_barang ORDER BY id_barang DESC";
$res = mysqli_query($k, $sql);
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Data Barang</h3>
    <a href="<?= base_url('index.php?page=user/add') ?>" class="btn btn-primary">+ Tambah Barang</a>
</div>

<div class="card shadow-sm">
    <div class="card-body table-responsive">

        <table class="table table-bordered table-hover align-middle">
            <thead class="table-secondary">
                <tr>
                    <th>#</th>
                    <th>Gambar</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Deskripsi</th>
                    <th>Tgl Masuk</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!$res): ?>
                    <tr><td colspan="10">Terjadi kesalahan: <?= htmlspecialchars(mysqli_error($k)) ?></td></tr>
                <?php else: ?>
                    <?php $no = 1; ?>
                    <?php while ($row = mysqli_fetch_assoc($res)): ?>
                        <?php
                            $id = (int)$row['id_barang'];
                            $nama = htmlspecialchars($row['nama']);
                            $kategori = htmlspecialchars($row['kategori']);
                            $deskripsi = nl2br(htmlspecialchars($row['deskripsi']));
                            $tgl = htmlspecialchars($row['tanggal_masuk']);
                            $hb = number_format((int)$row['harga_beli']);
                            $hj = number_format((int)$row['harga_jual']);
                            $stok = (int)$row['stok'];
                            if (!empty($row['gambar'])) {
                                $gambar = "gambar/" . $row['gambar'];
                            } else {
                                $gambar = "";
                            }
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>

                            <td>
                                <?php if ($gambar && file_exists(__DIR__ . '/../../' . $gambar)): ?>
                                    <img src="<?= base_url($gambar) ?>" style="width:80px;height:80px;object-fit:cover;">
                                <?php else: ?>
                                    <div style="width:80px;height:80px;background:#eee;display:flex;align-items:center;justify-content:center;color:#888;">
                                        No Img
                                    </div>
                                <?php endif; ?>
                            </td>

                            <td><?= $nama ?></td>
                            <td><?= $kategori ?></td>
                            <td><?= $deskripsi ?></td>
                            <td><?= $tgl ?></td>
                            <td>Rp <?= $hb ?></td>
                            <td>Rp <?= $hj ?></td>
                            <td><?= $stok ?></td>

                            <td>
                                <a href="<?= base_url('index.php?page=user/edit&id=' . $id) ?>" class="btn btn-warning btn-sm mb-1">Edit</a>
                                <a onclick="return confirm('Yakin ingin menghapus barang ini?')"
                                   href="<?= base_url('index.php?page=user/delete&id=' . $id) ?>"
                                   class="btn btn-danger btn-sm">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php endif; ?>
            </tbody>

        </table>

    </div>
</div>

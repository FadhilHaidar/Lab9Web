# Laporan Praktikum 9: PHP Modular

1. Buatlah **_repository_** baru dengan nama **Lab9Web.**

2. Kerjakan semua latihan yang diberikan sesuai urutannya.

3. Screenshot setiap perubahannya.

4. Buatlah file **README.md** dan tuliskan penjelasan dari setiap langkah praktikum beserta screenshotnya.

5. **Commit** hasilnya pada **_repository_** masing-masing.

6. Kirim **URL _repository_** pada **_e-learning_** ecampus.

## IMPLEMENTASI PROGRAM

1. Struktur Direktori

Struktur direktori program menggunakan pola modular sebagai berikut:

2. Routing di index.php

File index.php bertugas membaca nilai page dan memutuskan view mana yang di-load. Jika halaman tidak ada, sistem akan menampilkan pesan 404.

3. Template: header dan footer

Template ini digunakan untuk menyatukan tampilan proyek sehingga semua halaman memiliki UI yang konsisten.

- header.php berisi navigasi, Bootstrap CDN, dan tema warna hijau seperti Tokopedia.

- footer.php menutup struktur HTML dan menambahkan file JavaScript.

4. CRUD dengan Upload Gambar

Operasi CRUD diimplementasikan pada folder views/user/. Setiap operasi memiliki file terpisah:

- list.php → Menampilkan data barang beserta gambar.

- add.php → Menambahkan barang baru dengan upload gambar.

- edit.php → Memperbarui data barang, mengganti gambar jika perlu.

- delete.php → Menghapus data barang serta file gambar dari server.

Upload gambar memiliki validasi:

- Tipe file harus JPG atau PNG.

- Ukuran maksimal 2 MB.

- Nama file digenerate otomatis agar tidak bertabrakan.

5. Screenshot Tampilan (Placeholder)

(Kamu tinggal ganti dengan screenshot asli)

Tampilan list barang
screenshot_list.png

Form tambah barang
screenshot_add.png

Form edit barang
screenshot_edit.png

Hasil upload gambar
screenshot_upload.png

6. SQL Schema

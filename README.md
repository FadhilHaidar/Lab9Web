# Laporan Praktikum 9: PHP Modular

1. Buatlah **_repository_** baru dengan nama **Lab9Web.**

2. Kerjakan semua latihan yang diberikan sesuai urutannya.

3. Screenshot setiap perubahannya.

4. Buatlah file **README.md** dan tuliskan penjelasan dari setiap langkah praktikum beserta screenshotnya.

5. **Commit** hasilnya pada **_repository_** masing-masing.

6. Kirim **URL _repository_** pada **_e-learning_** ecampus.

## Penjelasan PROGRAM

1. Struktur Direktori Project

<img width="196" height="576" alt="image" src="https://github.com/user-attachments/assets/e47c1061-7fe7-44b5-a48d-019e549d85fd" />

Tujuan struktur ini:

- Memisahkan logika dan tampilan supaya project mudah dirawat.

- Menggunakan template header.php dan footer.php agar semua halaman punya layout yang konsisten.

- Routing dipusatkan di index.php sehingga semua halaman dipanggil lewat satu pintu.

2. Sistem Routing di index.php

Routing digunakan agar semua halaman bisa diakses melalui parameter URL:

    index.php?page=user/list
    index.php?page=user/add
    index.php?page=user/edit&id=9
    index.php?page=auth/login

Cara kerjanya:

- Ambil parameter page dari URL.

- Cocokkan dengan file yang ada di folder views.

- Jika file ditemukan → include.

- Jika tidak → tampilkan halaman error.

Routing ini membuat project bersifat modular, tidak perlu membuat banyak file di root, semua terpusat di satu router.

3. Koneksi Database (config/database.php)

File ini berfungsi untuk menyambungkan aplikasi ke database MySQL.

Isi utamanya:

- Nama host

- User

- Password

- Nama database

- Fungsi db() yang mengembalikan koneksi

Keuntungan memakai db():

- Bisa dipanggil dari file mana saja tanpa copy-paste kode koneksi
- Lebih rapi dan reusable

4. Helper Functions (config/helpers.php)

File ini berisi fungsi umum yang dipakai di banyak halaman:

Fungsi penting:

- base_url() → untuk membuat link dinamis.

- view() → untuk memangggil halaman di folder views.

- flash_set() & flash_get() → untuk membuat notifikasi (alert).

- redirect() → untuk mempermudah pindah halaman.

Dengan helper, kode di views menjadi lebih pendek dan mudah dibaca.

5. Template Layout (header.php & footer.php)

Semua halaman automatically memakai template:

Header berisi:

- Bootstrap
-  Navbar
-   Judul halaman

Footer berisi:
- Script JS
- Penutup HTML

Keuntungan:

- Tidak perlu ulang-ulang HTML yang sama
- Jika mau ganti gaya website, cukup edit 1 file saja

6. CRUD Barang

a. List Barang (views/user/list.php)

<img width="956" height="657" alt="image" src="https://github.com/user-attachments/assets/8a8ef1f9-af44-4e91-bc0a-08644699598b" />

Menampilkan semua data dari tabel:

- kategori

- nama

- deskripsi

- tanggal masuk

- harga beli

- harga jual

- stok

- gambar

Dilengkapi tombol:

- Edit → index.php?page=user/edit&id=xx

- Hapus → index.php?page=user/delete&id=xx

- Tambah Barang

Tabel sudah dikemas dengan Bootstrap agar lebih rapi.

b. Tambah Barang (add.php)

<img width="942" height="916" alt="image" src="https://github.com/user-attachments/assets/2ccc5aad-cf74-4977-ba68-499002c2810c" />

Fitur:

- Validasi input

- Upload gambar

- Cek ukuran maksimal 1MB

- Cek format file (JPEG/PNG)

- Insert data ke database

Gambar disimpan ke folder /gambar

<img width="937" height="915" alt="image" src="https://github.com/user-attachments/assets/21bfc565-9f1c-41a1-9a99-6a026357f8e3" />

c. Edit Barang (edit.php)

<img width="941" height="923" alt="image" src="https://github.com/user-attachments/assets/5bfd0d63-64dd-4cd1-bd7c-1ba284fe2c02" />

Fitur:

- Menampilkan data lama

- Bisa mengganti gambar baru

- Gambar lama otomatis terhapus jika diganti

- Update data ke database dengan prepared statement

d. Hapus Barang (delete.php)

<img width="956" height="737" alt="image" src="https://github.com/user-attachments/assets/0f733a88-6ecd-4416-abc5-e0f426f2201d" />

Fitur:

- Hapus data berdasarkan ID

- Hapus file gambar jika ada

- Redirect dan menampilkan pesan berhasil
  
7. Fitur Login/Logout (auth/)

<img width="956" height="737" alt="image" src="https://github.com/user-attachments/assets/713b9572-197a-44f8-81ee-2caa33135ab9" />

Termasuk:

- login.php

- logout.php

Digunakan untuk dasar autentikasi sederhana.

8. Keuntungan Menggunakan Modularisasi & Routing

| Sebelum Modularisasi | Sesudah Modularisasi              |
| -------------------- | --------------------------------- |
| File berantakan      | File terkelompok rapi             |
| Variabel bercampur   | Logika terpisah dari tampilan     |
| Tidak ada template   | Layout konsisten di semua halaman |
| Akses file langsung  | Akses via router (aman & elegan)  |
| Susah dikembangkan   | Sangat mudah menambah fitur       |

Program ini sudah memenuhi seluruh konsep:

- Modularisasi

-  Routing

- CRUD

- Upload Gambar

- Validasi

- Template View

- ️ Flash Message

- ️ Folder Struktur Profesional

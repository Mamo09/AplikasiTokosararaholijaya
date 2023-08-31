# Aplikasi Tokosararaholi jaya


### PANDUAN INSTALASI AplikasiTokosararaholijaya

**Langkah 1:** Menyiapkan Aplikasi

1. Salin folder "AplikasiTokosararaholijaya" ke direktori localhost Anda. Misalnya, jika Anda menggunakan XAMPP, letakkan folder di dalam "htdocs" (biasanya di `C:\xampp\htdocs\`).

**Langkah 2:** Membuka phpMyAdmin

1. Buka browser Anda.
2. Ketikkan alamat `localhost/phpmyadmin` di bilah alamat dan tekan Enter.

**Langkah 3:** Membuat Database Baru

1. Di phpMyAdmin, buat database baru dengan nama `toko_sararaholijaya`:
   - Klik tab "Database" di bagian atas.
   - Masukkan nama database (`toko_sararaholijaya`) di bidang yang sesuai.
   - Pilih "utf8_general_ci" sebagai collation (urutan karakter).
   - Klik tombol "Create" atau "Buat" untuk membuat database.

**Langkah 4:** Mengimpor Struktur Database

1. Setelah database dibuat, pilih database `toko_sararaholijaya` di panel kiri.
2. Di atas menu, pilih tab "Import" atau "Impor".
3. Klik tombol "Choose File" atau "Pilih File" dan cari file `toko_sararaholijaya.sql` yang ada dalam folder AplikasiTokosararaholijaya.
4. Klik tombol "Go" atau "Jalankan" di bagian bawah. Ini akan mengimpor struktur database.

**Langkah 5:** Konfigurasi Koneksi Database

1. Buka file `config.php` yang ada dalam folder AplikasiTokosararaholijaya menggunakan editor teks.
2. Pastikan informasi berikut sesuai dengan pengaturan Anda:
   - `servername`: Nama server database Anda (misalnya, "localhost").
   - `database`: Nama database yang Anda buat ("toko_sararaholijaya").
   - `username`: Nama pengguna database Anda.
   - `password`: Kata sandi pengguna database Anda.

**Langkah 6:** Mengakses Aplikasi

1. Buka browser.
2. Ketikkan alamat `localhost/AplikasiTokosararaholijaya` di bilah alamat dan tekan Enter.
   
Dengan langkah-langkah ini, Anda sekarang seharusnya dapat mengakses dan menggunakan AplikasiTokosararaholijaya melalui localhost Anda. Jika ada masalah, pastikan Anda telah mengikuti setiap langkah dengan benar dan memeriksa kembali konfigurasi Anda.


user Admin

Username : admin
Password : 12345
kode pemulihan : 102030

user Owner 

Username : owner
Password : 123
kode pemulihan :302010

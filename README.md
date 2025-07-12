# Aplikasi Pembayaran Listrik

Aplikasi web berbasis CodeIgniter 3 untuk mengelola pembayaran listrik pascabayar dengan fitur login/logout, manajemen pelanggan, CRUD penggunaan listrik, dan manajemen tagihan.

## Fitur Utama

### Admin Panel

- Dashboard dengan statistik
- Manajemen pelanggan (CRUD)
- Manajemen penggunaan listrik (CRUD)
- Manajemen tagihan
- Generate tagihan otomatis

### Pelanggan Panel

- Dashboard pelanggan
- Lihat data penggunaan listrik
- CRUD penggunaan listrik per bulan
- Lihat tagihan listrik
- Profil pelanggan

## Teknologi

- **Framework**: CodeIgniter 3
- **PHP**: 8.0.30
- **Database**: MySQL/MariaDB
- **Frontend**: Bootstrap 5, Font Awesome
- **Authentication**: Session-based

## Instalasi

1. **Clone atau download project**
2. **Setup Database**

   - Buat database MySQL dengan nama `pembayaran_listrik`
   - Import file `pembayaran_listrik.sql`
   - Pastikan konfigurasi database di `application/config/database.php` sudah benar

3. **Konfigurasi Database**

   ```php
   // application/config/database.php
   $db['default'] = array(
       'hostname' => 'localhost',
       'username' => 'root',
       'password' => '',
       'database' => 'pembayaran_listrik',
       'dbdriver' => 'mysqli',
       // ... lainnya
   );
   ```

4. **Akses Aplikasi**
   - Buka browser dan akses `http://localhost/listrik`
   - Login dengan akun demo:
     - **Admin**: username: `admin1`, password: `admin123`
     - **Pelanggan**: username: `pelanggan1`, password: `pelanggan123`

## Struktur Database

### Tabel Utama

- `users` - Data pengguna (admin/pelanggan)
- `level` - Data tarif berdasarkan daya
- `pelanggan` - Data pelanggan
- `penggunaan` - Data penggunaan listrik per bulan
- `tagihan` - Data tagihan listrik

### View

- `vw_penggunaan_listrik` - View untuk menghitung tagihan

## Fitur Keamanan

- Password hashing dengan `password_hash()`
- Session management
- Input validation
- SQL injection protection
- XSS protection

## Performa

- Database indexing untuk optimasi query
- Query optimization dengan JOIN
- Caching untuk statistik

## Testing

### Skenario Testing

1. **Login/Logout**

   - Test login dengan akun valid
   - Test login dengan akun invalid
   - Test logout

2. **Admin Panel**

   - Test CRUD pelanggan
   - Test CRUD penggunaan
   - Test generate tagihan
   - Test update status tagihan

3. **Pelanggan Panel**

   - Test CRUD penggunaan listrik
   - Test lihat tagihan
   - Test profil pelanggan

4. **Database Operations**
   - Test koneksi database
   - Test query performance
   - Test data integrity

## Demo Account

### Admin

- Username: `admin1`
- Password: `admin1`
- Role: `admin`

### Pelanggan

- Username: `pelanggan1`
- Password: `pelanggan1`
- Role: `pelanggan`

## Screenshots

### Login Page

- Modern design dengan gradient background
- Form validation
- Flash messages

### Admin Dashboard

- Statistik cards
- Quick actions
- Recent data tables

### Pelanggan Dashboard

- Informasi pelanggan
- Statistik penggunaan
- Recent tagihan

## Troubleshooting

### Error Koneksi Database

- Pastikan MySQL/MariaDB berjalan
- Cek konfigurasi database
- Pastikan database `pembayaran_listrik` sudah dibuat

### Error 404 / URL Not Found

- Pastikan mod_rewrite Apache aktif
- Cek file `.htaccess` sudah ada di root folder
- Pastikan URL diakses dengan benar: `http://localhost/listrik`
- Jika masih error, coba akses: `http://localhost/listrik/index.php/auth/login`

### Session Error

- Pastikan folder `application/cache` writable
- Cek konfigurasi session

### Logout tidak berfungsi

- Pastikan session sudah dikonfigurasi dengan benar
- Cek apakah ada error di console browser
- Pastikan redirect URL sudah benar

## Kontribusi

Untuk berkontribusi pada project ini:

1. Fork repository
2. Buat branch fitur baru
3. Commit perubahan
4. Push ke branch
5. Buat Pull Request

## Lisensi

Project ini menggunakan lisensi MIT.

## Support

Untuk bantuan atau pertanyaan, silakan hubungi developer.

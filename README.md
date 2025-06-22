Berikut adalah struktur file `README.md` untuk proyek **LaporCepat**, lengkap dengan placeholder gambar yang bisa kamu isi nanti:

````markdown
# 🗣️ LaporCepat - Layanan Pengaduan Masyarakat Online

**Suarakan keluhan Anda, dapatkan tanggapan cepat dan transparan.**

LaporCepat adalah aplikasi web modern yang menjembatani komunikasi antara masyarakat dan instansi pemerintah. Aplikasi ini memungkinkan masyarakat melaporkan masalah publik seperti jalan rusak, tumpukan sampah, atau gangguan layanan lainnya secara **mudah**, **cepat**, dan **transparan**.

---

## 🚀 Fitur Utama

### 🔹 Untuk Masyarakat
- **Registrasi & Login** – Sistem autentikasi pengguna yang aman.
- **Buat Laporan** – Formulir untuk memasukkan keluhan lengkap dengan judul, deskripsi, kategori, dan tanggal kejadian.
- **Unggah Lampiran** – Bisa melampirkan foto atau video bukti.
- **Lokasi GPS** – Fitur "Gunakan Lokasi Saya Saat Ini".
- **Pantau Status** – Melihat riwayat laporan dan statusnya (Menunggu Verifikasi, Diproses, Selesai, Ditolak).
- **Notifikasi Real-time** – Lewat aplikasi dan email.
- **Halaman Profil** – Mengelola informasi akun pengguna.

### 🔸 Untuk Admin
- **Dashboard Admin** – Menampilkan statistik laporan.
- **Kelola Pengaduan** – Menyaring dan memproses laporan masuk.
- **Update Status & Tanggapan** – Memberi status terbaru dan tanggapan publik.
- **Kelola Pengguna** – Mengelola data pengguna & peran.
- **Kelola Kategori** – Menambah, mengedit, dan menghapus kategori laporan.

---

## 🖼️ Tampilan Aplikasi

### 🏠 Halaman Utama
![Gambar Halaman Utama](images/halaman-utama.png)

### 👤 Dashboard Masyarakat
![Gambar Dashboard Masyarakat](images/dashboard-masyarakat.png)

### 🛠️ Dashboard Admin
![Gambar Dashboard Admin](images/dashboard-admin.png)

### 📄 Detail Laporan
![Gambar Detail Laporan](images/detail-laporan.png)

---

## 📊 Diagram Sistem

### 1. Use Case Diagram
Menunjukkan interaksi pengguna (Masyarakat dan Admin) dengan sistem.
![Use Case Diagram](images/usecase-diagram.png)

### 2. Class Diagram
Merepresentasikan model dan relasi dalam aplikasi.
![Class Diagram](images/class-diagram.png)

---

## 🛠️ Teknologi yang Digunakan

| Komponen  | Teknologi |
|-----------|-----------|
| Backend   | Laravel 10, PHP 8.2 |
| Frontend  | Blade, Tailwind CSS, Vite |
| Database  | MySQL |
| Email     | Mailtrap |

---

## ⚙️ Instalasi & Konfigurasi

### 1. Clone Repository
```bash
git clone https://github.com/username/lapor-cepat.git
cd lapor-cepat
````

### 2. Instalasi Dependensi

```bash
composer install
npm install
```

### 3. Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Atur Database di `.env`

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lapor_cepat_db
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Migrasi & Seeding Database

```bash
php artisan migrate:fresh --seed
```

### 6. Link Storage

```bash
php artisan storage:link
```

### 7. Jalankan Server

**Terminal 1 (Backend):**

```bash
php artisan serve
```

**Terminal 2 (Frontend):**

```bash
npm run dev
```

Buka browser dan akses aplikasi di [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 🔑 Akun Default (Setelah Seeder)

* **Email**: [admin@admin.com](mailto:admin@admin.com)
* **Password**: password

---

## 🙌 Kontribusi

Pull request sangat diterima! Untuk perubahan besar, silakan buka issue terlebih dahulu.

---

## 📄 Lisensi

Proyek ini berada di bawah lisensi [MIT](LICENSE).

```

### Catatan
- Gambar-gambar seperti `images/usecase-diagram.png`, `images/class-diagram.png`, dll, bisa kamu buat lalu simpan di folder `/public/images/` atau tempat lain yang sesuai.
- Jangan lupa update link GitHub jika ingin diunggah ke GitHub publik.

Kalau kamu ingin saya bantu membuat diagramnya juga (dalam bentuk gambar), tinggal bilang saja ya.
```

# 🏸 HansPadel - Facility Booking & Management System
![Laravel](https://img.shields.io/badge/Laravel-12-red)
![PHP](https://img.shields.io/badge/PHP-8.3-blue)
![Filament](https://img.shields.io/badge/Filament-v3-orange)
![Docker](https://img.shields.io/badge/Docker-Ready-2496ED)
![License](https://img.shields.io/badge/License-MIT-green)
Sistem Informasi Booking dan Manajemen Fasilitas berbasis **Laravel 12** yang dirancang untuk mengelola proses penyewaan lapangan (Padel) secara digital. Sistem menyediakan antarmuka pengguna untuk melakukan pemesanan lapangan, serta dashboard admin berbasis **Filament v3** untuk mengelola data operasional.

---

# 🚀 Fitur Utama

### 👤 Autentikasi Pengguna
- Login menggunakan Google OAuth.
- Role Based Access Control (RBAC).
- Manajemen User & Role.
- Activity Log seluruh aktivitas admin.

### 📅 Booking Lapangan
- Melakukan booking lapangan secara online.
- Validasi jadwal agar tidak terjadi bentrok.
- Status Booking:
  - Pending
  - Confirmed
  - Cancelled
  - Completed

### 🏟️ Manajemen Lapangan
- CRUD Data Lapangan.
- Pengelolaan fasilitas setiap lapangan.
- Status lapangan aktif / nonaktif.

### 🛠️ Manajemen Fasilitas
- Menambahkan fasilitas yang dimiliki lapangan.
- Relasi fasilitas dengan lapangan.
- Mendukung banyak fasilitas dalam satu lapangan.

### 📊 Dashboard Admin
- Statistik jumlah lapangan.
- Statistik booking.
- Statistik booking berhasil.
- Monitoring user.
- Activity Log terbaru.

### 📑 Project Report
- Dokumentasi perkembangan project.
- Menyimpan laporan beserta tipe laporan.

### 🔗 REST API
- Endpoint API untuk kebutuhan integrasi.
- Siap digunakan oleh aplikasi Mobile maupun Frontend lainnya.

### 🐳 Docker Ready
- PHP 8.3
- Nginx
- MariaDB
- Docker Compose
- Siap dijalankan pada Linux maupun VPS Production.

---

# 🛠️ Tech Stack

| Technology | Version |
|------------|---------|
| Laravel | 12.x |
| PHP | 8.3 |
| Filament | v3 |
| Livewire | v3 |
| Blade | Latest |
| MariaDB | 10.11 |
| Docker | Latest |
| Nginx | Stable Alpine |
| Google OAuth | Laravel Socialite |

---

# 📂 Struktur Project

```
.
├── db/
├── docs/
├── nginx/
├── php/
├── src/
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── public/
│   ├── resources/
│   ├── routes/
│   └── storage/
├── docker-compose.yml
└── README.md
```

---

# ⚙️ Persyaratan

Sebelum menjalankan project, pastikan telah menginstall:

- Docker
- Docker Compose
- Git

Tidak diperlukan instalasi PHP maupun Composer secara lokal karena seluruh service berjalan di dalam Docker.

---

# 🚀 Instalasi

Clone repository

```bash
git clone <repository-url>
cd ProjekNew
```

Copy environment

```bash
cp .env.example .env
```

Jalankan Docker

```bash
docker compose up -d --build
```

Install dependency

```bash
docker exec -it hanspadel_php composer install
```

Generate Application Key

```bash
docker exec -it hanspadel_php php artisan key:generate
```

Migrasi Database

```bash
docker exec -it hanspadel_php php artisan migrate --seed
```

Optimasi

```bash
docker exec -it hanspadel_php php artisan optimize
```

---

# 🔐 Default Login

## Super Admin

```
Email    : admin@example.com
Password : password
```

> Sesuaikan dengan data yang terdapat pada Seeder.

---

# 📦 Database

Entity utama pada sistem:

- Users
- Roles
- Permissions
- Courts (Lapangan)
- Facilities
- Bookings
- Booking Details
- Project Reports
- Activity Logs

---

# 📖 Fitur Admin

- Dashboard
- User Management
- Role Management
- Permission Management
- Court Management
- Facility Management
- Booking Management
- Project Report
- Activity Log

---

# 🔒 Keamanan

- Google OAuth Login
- CSRF Protection
- Laravel Authentication
- Role Based Access Control (RBAC)
- Activity Logging
- HTTPS Ready
- Docker Isolated Environment

---

# 🌐 Deployment

Project telah dikonfigurasi agar dapat dijalankan menggunakan:

- Docker
- Nginx Reverse Proxy
- Cloudflare
- SSL HTTPS
- Linux VPS

---

# 📸 Preview

## Dashboard Admin

- Statistik Booking
- Statistik Lapangan
- Activity Log
- User Management
- Booking Management

---

# 👨‍💻 Developer

Developed by **Raihan Isad**

Universitas Esa Unggul

2026

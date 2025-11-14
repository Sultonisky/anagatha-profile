# Railway Setup untuk Queue Worker

Dokumentasi ini menjelaskan cara setup queue worker di Railway untuk aplikasi Laravel ini.

## Prerequisites

1. Pastikan migration untuk queue table sudah ada:
   ```bash
   php artisan queue:table
   php artisan migrate
   ```

2. Set environment variable `QUEUE_CONNECTION=database` di Railway

## Setup di Railway

### 1. Service Web (Main Application)

1. Di Railway dashboard, buat atau gunakan service yang sudah ada
2. Set environment variables:
   - `SERVICE_TYPE=web` (atau tidak perlu di-set, default adalah web)
   - `QUEUE_CONNECTION=database`
   - `APP_ENV=production`
   - `APP_DEBUG=false`
   - Dan environment variables lainnya (database, mail, dll)

3. Service ini akan menjalankan web server

### 2. Service Queue Worker

1. Di Railway dashboard, buat **service baru** dari repository yang sama
2. Set environment variables:
   - `SERVICE_TYPE=worker` (PENTING!)
   - `QUEUE_CONNECTION=database`
   - `APP_ENV=production`
   - `APP_DEBUG=false`
   - **Copy semua environment variables dari service web** (database connection, mail config, dll)

3. Service ini akan menjalankan queue worker yang memproses email di background

## Cara Setup di Railway Dashboard

### Langkah-langkah:

1. **Buka Railway Dashboard** → Pilih project Anda

2. **Untuk Service Web (jika belum ada):**
   - Klik "New" → "GitHub Repo" (atau pilih repo yang sudah ada)
   - Railway akan auto-detect Dockerfile
   - Set environment variables:
     ```
     SERVICE_TYPE=web
     QUEUE_CONNECTION=database
     ```

3. **Untuk Service Queue Worker:**
   - Klik "New" → "GitHub Repo" → Pilih **repo yang sama**
   - Railway akan menggunakan Dockerfile yang sama
   - Set environment variables:
     ```
     SERVICE_TYPE=worker
     QUEUE_CONNECTION=database
     ```
   - **PENTING:** Copy semua environment variables dari service web (database, mail, dll)

4. **Deploy kedua service**

## Verifikasi

Setelah deploy:

1. **Service Web** harus running dan bisa diakses
2. **Service Queue Worker** harus running (cek logs untuk memastikan queue worker berjalan)
3. Test contact form - email harus terkirim lebih cepat karena diproses di background

## Troubleshooting

### Queue worker tidak jalan
- Pastikan `SERVICE_TYPE=worker` sudah di-set
- Cek logs di Railway dashboard untuk service worker
- Pastikan `QUEUE_CONNECTION=database` sudah di-set

### Email masih lambat
- Pastikan queue worker service sudah running
- Cek apakah migration `create_jobs_table` sudah dijalankan
- Pastikan `QUEUE_CONNECTION=database` di kedua service

### Migration error
- Migration akan dijalankan otomatis saat startup
- Pastikan database credentials sudah benar di environment variables

## Environment Variables yang Diperlukan

### Untuk Service Web:
```
SERVICE_TYPE=web (optional, default)
QUEUE_CONNECTION=database
APP_ENV=production
APP_DEBUG=false
DB_CONNECTION=mysql
DB_HOST=...
DB_DATABASE=...
DB_USERNAME=...
DB_PASSWORD=...
MAIL_MAILER=smtp
MAIL_HOST=...
MAIL_PORT=...
MAIL_USERNAME=...
MAIL_PASSWORD=...
MAIL_FROM_ADDRESS=...
MAIL_FROM_NAME=...
```

### Untuk Service Worker:
```
SERVICE_TYPE=worker (REQUIRED!)
QUEUE_CONNECTION=database
APP_ENV=production
APP_DEBUG=false
DB_CONNECTION=mysql
DB_HOST=... (sama dengan web service)
DB_DATABASE=... (sama dengan web service)
DB_USERNAME=... (sama dengan web service)
DB_PASSWORD=... (sama dengan web service)
MAIL_MAILER=smtp
MAIL_HOST=... (sama dengan web service)
MAIL_PORT=... (sama dengan web service)
MAIL_USERNAME=... (sama dengan web service)
MAIL_PASSWORD=... (sama dengan web service)
MAIL_FROM_ADDRESS=... (sama dengan web service)
MAIL_FROM_NAME=... (sama dengan web service)
```

## Catatan

- Kedua service (web dan worker) harus menggunakan **database yang sama**
- Queue worker akan otomatis restart jika crash (Railway default behavior)
- Queue worker akan memproses job dari tabel `jobs` di database
- Email akan dikirim di background, tidak blocking request user


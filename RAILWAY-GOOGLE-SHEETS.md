# ✅ Flow Deploy Google Sheets di Railway

Dokumentasi ini menjelaskan cara deploy aplikasi dengan integrasi Google Sheets ke Railway. **File `credentials.json` tidak ikut ke GitHub** (sudah di-ignore), jadi harus di-upload manual ke server.

---

## 📋 Prerequisites

1. ✅ Code sudah di-push ke GitHub
2. ✅ Railway project sudah dibuat dan terhubung ke GitHub
3. ✅ File `credentials.json` dari Google Cloud Console sudah tersedia
4. ✅ Google Sheet ID dan Sheet Name sudah diketahui

---

## 🚀 Langkah 1: Deploy Code (Tanpa credentials.json)

**Push ke GitHub → Railway auto-deploy.**

Railway **tidak membutuhkan** file `credentials.json` saat build → aman.

```bash
git push origin main
```

Railway akan otomatis:
- ✅ Build Docker image
- ✅ Install dependencies
- ✅ Deploy aplikasi

**Catatan:** Aplikasi akan error saat runtime jika `credentials.json` belum ada, tapi build tetap berhasil.

---

## 📦 Langkah 2: Setup Persistent Storage (Volume)

Setelah deploy → masuk Railway → buka project → buka tab **"Storage"** atau **"Volumes"**.

Kamu harus punya **Persistent Storage (Volume)** untuk menyimpan file credentials.

### Kalau belum ada volume:

1. Railway Dashboard → Project → Klik **"+ New"** atau **"Add"**
2. Pilih **"Volume"** atau **"Persistent Storage"**
3. **Mount path:**
   ```
   /app/storage/app/google
   ```
4. Klik **"Create"** atau **"Add"**

Jadi di dalam Railway filesystem, folder Google credentials-nya ada di:
```
/app/storage/app/google/credentials.json
```

Ini akan match dengan Laravel:
```php
storage_path('app/google/credentials.json')
```

**Catatan:** 
- Volume = persistent storage yang tidak akan hilang walaupun deploy ulang
- Path `/app` adalah root directory aplikasi Laravel di Railway

---

## 📤 Langkah 3: Upload credentials.json ke Volume

Railway UI → Volumes → browse folder → upload file:

1. Buka Railway Dashboard → Project
2. Buka tab **"Storage"** atau **"Volumes"**
3. Klik pada volume yang baru dibuat
4. Klik **"Upload"** atau **"Browse"**
5. Pilih file `credentials.json` dari komputer Anda
6. Upload ke path:
   ```
   /app/storage/app/google/credentials.json
   ```

**Verifikasi:**
- File harus ada di path: `/app/storage/app/google/credentials.json`
- File tidak boleh di root `/app/` atau di tempat lain

---

## 🔐 Langkah 4: Set Environment Variables (Wajib untuk Production)

Di Railway → Project → Service → Tab **"Variables"**, tambahkan:

```env
GOOGLE_SHEET_ID=your_spreadsheet_id_here
GOOGLE_SHEET_NAME=Sheet1
```

**Cara mendapatkan Google Sheet ID:**
1. Buka Google Sheet di browser
2. Lihat URL: `https://docs.google.com/spreadsheets/d/SPREADSHEET_ID/edit`
3. Copy `SPREADSHEET_ID` (string panjang di antara `/d/` dan `/edit`)

**Contoh:**
```env
GOOGLE_SHEET_ID=1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms
GOOGLE_SHEET_NAME=Sheet1
```

**Catatan:**
- `GOOGLE_SHEET_NAME` default adalah `Sheet1` jika tidak di-set
- Nama sheet harus sesuai dengan nama tab di Google Sheet

---

## ✅ Langkah 5: Redeploy Service

Setelah upload `credentials.json` dan set environment variables:

1. Railway Dashboard → Service
2. Klik **"Redeploy"** atau tunggu auto-deploy dari GitHub push
3. Tunggu sampai deployment selesai

**Catatan:** 
- Volume tidak akan hilang saat redeploy
- File `credentials.json` tetap ada di volume

---

## 🧪 Langkah 6: Test dari Production

1. Buka staging/production URL dari Railway
2. Buka halaman contact form
3. Isi form dan submit
4. Cek Google Sheet → data harus masuk ke sheet
5. Jika berhasil → ✅ **Deployment berhasil!**

**Troubleshooting jika data tidak masuk:**
- Cek Railway logs untuk error
- Pastikan `credentials.json` ada di path yang benar
- Pastikan `GOOGLE_SHEET_ID` dan `GOOGLE_SHEET_NAME` sudah benar
- Pastikan Google Service Account sudah punya akses ke Sheet

---

## 💡 FAQ

### Q: Apa file credentials.json hilang setelah redeploy?

**A: Tidak.**

Karena Railway Volume = persistent storage, file tidak akan hilang walaupun:
- ✅ Deploy 100x
- ✅ Redeploy service
- ✅ Restart container
- ✅ Update code

Volume hanya akan hilang jika:
- ❌ Volume dihapus manual
- ❌ Project dihapus

---

### Q: Apa aman menyimpan credentials.json di Railway?

**A: Ya, aman.**

Karena:
- ✅ File tidak ada di GitHub (sudah di `.gitignore`)
- ✅ File hanya ada di Railway private storage (Volume)
- ✅ Tidak bisa diakses via URL/public
- ✅ Laravel `storage/app/` folder bersifat private
- ✅ Sangat umum dipakai untuk integrasi Google Cloud
- ✅ Railway Volume terenkripsi dan hanya bisa diakses oleh service yang di-mount

---

### Q: Bagaimana cara update credentials.json?

**A: Upload ulang file.**

1. Railway Dashboard → Volumes
2. Hapus file lama (jika perlu)
3. Upload file baru dengan nama yang sama: `credentials.json`
4. Redeploy service

---

### Q: Error "Google credentials.json not found"

**Solusi:**
1. Pastikan Volume sudah dibuat dan di-mount ke `/app/storage/app/google`
2. Pastikan file `credentials.json` sudah di-upload ke path yang benar
3. Pastikan path di Laravel code: `storage_path('app/google/credentials.json')`
4. Cek Railway logs untuk path yang dicari Laravel

---

### Q: Error "Missing GOOGLE_SHEET_ID in environment"

**Solusi:**
1. Pastikan environment variable `GOOGLE_SHEET_ID` sudah di-set di Railway
2. Pastikan nama variable benar: `GOOGLE_SHEET_ID` (bukan `GOOGLE_SHEETS_ID`)
3. Redeploy service setelah set environment variable

---

### Q: Data tidak masuk ke Google Sheet

**Solusi:**
1. Pastikan Google Service Account sudah punya akses ke Sheet
2. Pastikan `GOOGLE_SHEET_ID` benar
3. Pastikan `GOOGLE_SHEET_NAME` sesuai dengan nama tab di Sheet
4. Cek Railway logs untuk error detail
5. Pastikan Sheet tidak dalam mode "View Only" untuk Service Account

---

## 🎯 Ringkasan (Super Simpel)

### Local Development
- ✅ Simpan file di `storage/app/google/credentials.json`
- ✅ Set `.env`:
  ```env
  GOOGLE_SHEET_ID=xxx
  GOOGLE_SHEET_NAME=Sheet1
  ```

### GitHub
- ✅ File `credentials.json` di-ignore (tidak ikut repo)
- ✅ Push code seperti biasa

### Railway Production
- ✅ Tambah Volume → Mount ke `/app/storage/app/google`
- ✅ Upload file `credentials.json` ke volume
- ✅ Set ENV: `GOOGLE_SHEET_ID` dan `GOOGLE_SHEET_NAME`
- ✅ Redeploy service

### Laravel Code
- ✅ Akses pakai `storage_path('app/google/credentials.json')` → selalu benar
- ✅ Config di `config/google_sheets.php` → baca dari ENV

---

## 📝 Checklist Deployment

- [ ] Code sudah di-push ke GitHub
- [ ] Railway project sudah dibuat
- [ ] Volume sudah dibuat dan di-mount ke `/app/storage/app/google`
- [ ] File `credentials.json` sudah di-upload ke volume
- [ ] Environment variable `GOOGLE_SHEET_ID` sudah di-set
- [ ] Environment variable `GOOGLE_SHEET_NAME` sudah di-set (atau default `Sheet1`)
- [ ] Service sudah di-redeploy
- [ ] Test contact form → data masuk ke Google Sheet ✅

---

## 🔗 Referensi

- [Railway Volumes Documentation](https://docs.railway.app/storage/volumes)
- [Google Sheets API Documentation](https://developers.google.com/sheets/api)
- [Laravel Storage Documentation](https://laravel.com/docs/storage)

---

**Selamat deploy! 🚀**

Jika ada masalah, kirim screenshot structure Railway atau error logs, kita bisa troubleshoot lebih lanjut.


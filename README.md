# 🛡️ Life Vest Tracker - GMF AeroAsia

Aplikasi pelacakan tanggal kedaluwarsa life vest untuk armada pesawat GMF AeroAsia.

---

## 📋 Daftar Isi

- [Cara Menjalankan](#-cara-menjalankan)
- [Panduan Penggunaan](#-panduan-penggunaan)
- [Keyboard Shortcuts](#-keyboard-shortcuts)
- [Menambahkan Pesawat Baru](#-menambahkan-pesawat-baru)
- [Struktur File](#-struktur-file-penting)

---

## 🚀 Cara Menjalankan

### Prasyarat
- PHP 8.1+
- Composer
- Node.js & npm
- MySQL/MariaDB (via Laragon/XAMPP)

### Langkah-langkah

```bash
# 1. Install dependencies
composer install
npm install

# 2. Setup database
cp .env.example .env
php artisan key:generate

# 3. Edit .env - sesuaikan database
DB_DATABASE=lifevest_tracker
DB_USERNAME=root
DB_PASSWORD=

# 4. Jalankan migration
php artisan migrate

# 5. Jalankan server (buka 2 terminal)
# Terminal 1:
php artisan serve

# Terminal 2:
npm run dev
```

Buka http://localhost:8000

---

## 📖 Panduan Penggunaan

### Dashboard
- Menampilkan **Fleet Overview** (ringkasan status semua pesawat)
- Menampilkan **Fleet Status** per tipe (B737, B777, A330)
- **Search**: Cari pesawat berdasarkan registrasi
- **Filter**: Filter berdasarkan tipe pesawat
- Klik kartu pesawat untuk masuk ke halaman seat map

---

## 🖱️ SELECT KURSI

| Aksi | Fungsi |
|------|--------|
| **Klik biasa** | Pilih 1 kursi (hapus selection sebelumnya) |
| **Ctrl + Klik** | Tambah kursi ke selection (multi-select) |
| **Shift + Klik** | Pilih range dari kursi terakhir ke kursi ini |
| **Klik nomor BARIS** | Pilih semua kursi di baris tersebut |
| **Klik huruf KOLOM** | Pilih semua kursi di kolom tersebut |

---

## ❌ UNSELECT / HAPUS SELECTION

| Aksi | Fungsi |
|------|--------|
| **Klik area kosong** | Hapus semua selection |
| **Tekan ESC** | Hapus semua selection |
| **Ctrl + Klik kursi** | Hapus kursi dari selection (toggle) |
| **Klik "Clear Selection"** | Hapus semua selection |

---

## 📅 SET TANGGAL EXPIRY

1. Pilih kursi yang ingin di-update (bisa multi-select)
2. Klik tombol **"Set Date"** di toolbar
3. Pilih tanggal expiry life vest dari calendar
4. Klik **"Apply"** untuk menyimpan

> 💡 **Catatan:** Bisa update banyak kursi sekaligus!

---

## ⌨️ KEYBOARD SHORTCUTS

| Shortcut | Fungsi |
|----------|--------|
| **Ctrl + A** | Pilih SEMUA kursi |
| **Enter** | Buka dialog Set Date (jika ada kursi terpilih) |
| **Escape (ESC)** | Tutup dialog / Hapus selection |

---

## 🎨 ARTI WARNA STATUS

| Warna | Status | Keterangan |
|-------|--------|------------|
| 🟢 **HIJAU** | Safe | Expiry > 6 bulan lagi |
| 🟡 **KUNING** | Warning | Expiry 3-6 bulan lagi |
| 🔴 **MERAH** | Critical | Expiry < 3 bulan lagi |
| 🟣 **UNGU** | Expired | Sudah melewati tanggal expiry |
| ⚪ **ABU-ABU** | No Data | Belum ada tanggal expiry |

---

## ✈️ Menambahkan Pesawat Baru

> ⚠️ **Sistem sekarang menggunakan config-based layout!**

### 🔄 KONDISI A: Layout SAMA dengan Pesawat Lain

Jika layout kursi **sama persis** dengan pesawat yang sudah ada:

#### Langkah 1: Tambah di Config
📁 **File:** `config/aircraft_layouts.php`

```php
'PK-XXX' => [
    'type' => 'B737-800',    // atau 'B737 MAX 8', 'A330-300', dll
    'icon' => '✈️',
    'layout' => 'b737-e46',   // Pakai layout yang sudah ada
],
```

**Selesai!** Controller otomatis menggunakan layout dari config.

---

### 📝 KONDISI B: Layout BERBEDA (Buat Template Baru)

Jika layout kursi **berbeda** dengan yang sudah ada:

#### Langkah 1: Tambah Config
📁 **File:** `config/aircraft_layouts.php`

```php
'PK-XXX' => [
    'type' => 'A330-300',
    'icon' => '🛩️',
    'layout' => 'a330-xxx',  // Nama template baru
],
```

#### Langkah 2: Buat Template Baru
📁 **File:** `resources/views/aircraft/a330-xxx.blade.php`

Copy dari template yang mirip lalu edit sesuai kebutuhan.

**Penting di header:** Gunakan config lookup untuk tipe pesawat:
```blade
<span class="info-value">{{ config('aircraft_layouts.' . $registration . '.type', 'A330-300') }}</span>
```

#### Langkah 3: Tambah Class Rows Config
📁 **File:** `config/aircraft_class_rows.php`

```php
'a330-xxx' => [
    'business' => range(6, 11),
    'economy' => array_diff(range(21, 50), [24]), // skip row 24
],
```

#### Langkah 4: Pastikan Ada Script Config
Di bagian akhir template, **WAJIB** ada:

```blade
@push('scripts')
    <script>
        window.AIRCRAFT_CONFIG = {
            registration: '{{ $registration }}',
            updateUrl: '{{ route('aircraft.updateSeats', $registration) }}',
            csrfToken: '{{ csrf_token() }}'
        };
    </script>
@endpush
```

---

## 📁 Struktur File Penting

```
lifevest-laravel/
├── config/
│   ├── aircraft_layouts.php      # Config registrasi & layout mapping
│   └── aircraft_class_rows.php   # Config class type per layout
├── app/Http/Controllers/
│   ├── DashboardController.php   # Logic dashboard
│   └── AircraftController.php    # Logic seat map (config-based)
├── resources/views/
│   ├── layouts/app.blade.php     # Master layout + Navbar
│   ├── dashboard.blade.php       # Halaman dashboard
│   ├── aircraft/
│   │   ├── b737-e46.blade.php    # B737 Layout (46 rows)
│   │   ├── b737-e47.blade.php    # B737 Layout (47 rows)
│   │   ├── b737-e48.blade.php    # B737 Layout (48 rows)
│   │   ├── b777-2class.blade.php # B777 2-Class
│   │   ├── b777-3class.blade.php # B777 3-Class (First)
│   │   ├── a330-900a.blade.php   # A330-900 Layout A
│   │   ├── a330-900b.blade.php   # A330-900 Layout B
│   │   ├── a330-300a.blade.php   # A330-300 Layout A
│   │   ├── a330-300b.blade.php   # A330-300 Layout B
│   │   ├── a330-300c.blade.php   # A330-300 Layout C (All Economy)
│   │   ├── a330-200a.blade.php   # A330-200 Layout A
│   │   └── a330-200b.blade.php   # A330-200 Layout B
│   └── components/
│       ├── cockpit-section.blade.php
│       ├── seat-cell.blade.php
│       ├── toolbar.blade.php
│       ├── status-legend.blade.php
│       └── date-modal.blade.php
└── resources/
    ├── css/
    │   ├── style.css             # CSS global + Navbar
    │   └── dashboard.css         # CSS dashboard
    └── js/
        └── app.js                # JavaScript interaksi
```

---

## 🛠️ Teknologi

- **Backend:** Laravel 12
- **Frontend:** Vanilla CSS & JavaScript (Glassmorphism UI)
- **Database:** MySQL
- **Build Tool:** Vite
- **Timezone:** Asia/Jakarta (GMT+7)

---

## 📊 Fleet Overview

| Tipe | Jumlah Registrasi | Layout |
|------|-------------------|--------|
| B737-800 | 40+ | e46, e47, e48 |
| B737 MAX 8 | 1 | e46 |
| B777-300 | 8 | 2class, 3class |
| A330-900 | 5 | 900a, 900b |
| A330-300 | 12 | 300a, 300b, 300c |
| A330-341 | 2 | 300c |
| A330-200 | 5 | 200a, 200b |


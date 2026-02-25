# 📘 User Manual — Life Vest Tracker

---

## 📋 Daftar Isi

1. [Dashboard](#1--dashboard)
2. [Seat Map](#2--seat-map--halaman-detail-pesawat)
3. [Export PDF](#3--export-pdf)
4. [Blank Form](#4--blank-form)
5. [Batch Input](#5--batch-input)
6. [Fleet Manager](#6--fleet-manager)
7. [Dark / Light Mode](#7--dark--light-mode)
8. [Keyboard Shortcuts](#8--keyboard-shortcuts)
9. [Arti Warna Status](#9--arti-warna-status)
10. [Tips & FAQ](#10--tips--faq)

---

## 1. 🏠 Dashboard

Dashboard adalah halaman utama yang menampilkan ringkasan seluruh armada.

### Fleet Overview (Kartu Ringkasan)

Di bagian atas terdapat 4 kartu ringkasan:

| Kartu | Keterangan |
|-------|------------|
| 🟢 **Safe** | Life vest yang masih > 6 bulan dari kadaluarsa |
| 🟡 **Warning** | Life vest yang tersisa 3–6 bulan |
| 🔴 **Critical** | Life vest yang tersisa < 3 bulan |
| 🟣 **Expired** | Life vest yang sudah melewati tanggal kadaluarsa |

### Filter Fleet (Dropdown Multi-Select)

Klik tombol **"✈️ Filter Fleet"** di pojok kanan atas bagian Fleet Overview.

- Akan muncul dropdown dengan **checkbox** untuk setiap tipe pesawat (A320, A330, ATR72, B737, B777).
- **Centang satu atau lebih tipe** → angka di kartu ringkasan akan berubah sesuai total dari tipe yang dipilih.
- **"All Fleets"** → centang/uncentang semua sekaligus.
- **Default**: semua tipe tercentang (menampilkan total keseluruhan).

### Filter Pesawat

Klik tombol **"🔍 Filter"** untuk membuka panel filter lanjutan:

| Filter | Fungsi |
|--------|--------|
| **Airline** | Filter berdasarkan maskapai (Garuda Indonesia, Citilink, dll) |
| **Type** | Filter berdasarkan tipe pesawat (B737-800, A330-300, dll) |
| **Status** | Filter berdasarkan status pesawat (Active / Prolong) |
| **Health** | Filter berdasarkan kesehatan life vest (Safe / Warning / Critical) |
| **Search** | Cari berdasarkan nomor registrasi |

Klik **"Clear"** untuk mereset semua filter.

### Kartu Pesawat

Setiap pesawat ditampilkan sebagai kartu yang berisi:
- Nomor registrasi
- Tipe pesawat
- Mini bar status (hijau/kuning/merah/ungu)
- Health badge (Safe/Warning/Critical)

**Klik kartu** untuk masuk ke halaman seat map pesawat tersebut.

---

## 2. 🪑 Seat Map — Halaman Detail Pesawat

Halaman ini menampilkan peta kursi lengkap pesawat beserta status life vest di setiap kursi.

### Navigasi

Akses via klik kartu pesawat di Dashboard, atau langsung ke URL:
```
/aircraft/{registration}
```
Contoh: `/aircraft/PK-GFD`

### Memilih Kursi (Select)

| Aksi | Fungsi |
|------|--------|
| **Klik biasa** | Pilih 1 kursi (hapus selection sebelumnya) |
| **Ctrl + Klik** | Tambah kursi ke selection (multi-select) |
| **Shift + Klik** | Pilih range dari kursi terakhir ke kursi ini |
| **Klik nomor BARIS** (angka di kiri) | Pilih semua kursi di baris tersebut |
| **Klik huruf KOLOM** (huruf di atas) | Pilih semua kursi di kolom tersebut |

### Menghapus Selection (Unselect)

| Aksi | Fungsi |
|------|--------|
| **Klik area kosong** | Hapus semua selection |
| **Tekan ESC** | Hapus semua selection |
| **Ctrl + Klik kursi yang sudah dipilih** | Toggle kursi dari selection |
| **Klik "✖️ Clear Selection"** | Hapus semua selection |

### Set Tanggal Expiry

1. Pilih kursi yang ingin di-update (bisa satu atau banyak sekaligus).
2. Klik tombol **"📅 Set Date"** di toolbar (atau tekan **Enter**).
3. Pilih tanggal expiry life vest dari calendar.
4. Klik **"Apply"** untuk menyimpan.

> 💡 **Tips:** Bisa update banyak kursi sekaligus! Pilih semua kursi yang memiliki tanggal sama, lalu set date satu kali.

### Toolbar

Toolbar ada di bagian atas halaman seat map, berisi:

| Tombol | Fungsi |
|--------|--------|
| **📅 Set Date** | Set tanggal expiry untuk kursi yang dipilih |
| **✖️ Clear Selection** | Hapus semua selection |
| **Export PDF** | Export seat map sebagai PDF report (buka di tab baru) |
| **Blank Form** | Export form kosong untuk inspeksi manual (buka di tab baru) |
| **⚡ Batch Input** | Buka halaman batch input untuk input data massal |

### Bagian-bagian Seat Map

Seat map terdiri dari beberapa bagian:

1. **Cockpit** — Kursi pilot (Captain, First Officer, Observer, ACM)
2. **Business Class** — Kursi kelas bisnis (jika ada)
3. **Economy Class** — Kursi kelas ekonomi
4. **Spare** — Life vest cadangan (PAX = dewasa, INF = bayi)

---

## 3. 📄 Export PDF

Export seluruh seat map sebagai dokumen PDF berwarna, lengkap dengan status dan tanggal expiry.

### Cara Menggunakan

1. Buka halaman seat map pesawat.
2. Klik tombol **"Export PDF"** di toolbar.
3. PDF akan terbuka di tab baru browser.
4. Dari situ Anda bisa **download** atau **print** langsung.

### Isi PDF

- Header: Nama airline, registrasi, tipe pesawat, tanggal cetak
- Seat map lengkap dengan warna status
- Tanggal expiry di setiap kotak kursi
- Bagian Cockpit, Cabin, dan Spare
- Footer dan tanda tangan

---

## 4. 📝 Blank Form

Form kosong untuk diisi manual oleh teknisi saat inspeksi di lapangan.

### Cara Menggunakan

1. Buka halaman seat map pesawat.
2. Klik tombol **"Blank Form"** di toolbar.
3. PDF form kosong akan terbuka di tab baru.
4. **Print** form tersebut untuk dibawa ke lapangan.

### Isi Blank Form

- Header: Nama airline, registrasi, tipe pesawat, kolom tanggal (manual)
- Kotak kursi kosong (hanya nomor seat, tanggal diisi tangan)
- Instruksi: "Tulis tanggal expired pada setiap kotak seat (format: DD/MM/YYYY)"
- **Spare Section**: Kotak bernomor untuk cadangan PAX & INF

### Jumlah Kotak Spare (Buffer per Tipe)

Jumlah kotak spare yang dicetak sudah dihitung dengan buffer agar mencukupi:

| Tipe | PAX | INF |
|------|:---:|:---:|
| A320 | 15 | 20 |
| A330 | 15 | 40 |
| ATR72 | 10 | 10 |
| B737 | 10 | 25 |
| B777 | 35 | 40 |

- Kolom tanda tangan (Approved By / Checked By)

---

## 5. ⚡ Batch Input

Fitur untuk input data expiry secara massal — cocok untuk copy-paste dari Excel.

### Cara Menggunakan

1. Buka halaman seat map pesawat.
2. Klik tombol **"⚡ Batch Input"** di toolbar.
3. Halaman batch input akan terbuka.

### Cara Input Data

1. Setiap kolom kursi (A, B, C, D, E, F) memiliki **textarea** sendiri.
2. **Copy kolom tanggal dari Excel**, lalu **paste** ke textarea yang sesuai.
3. Setiap baris di textarea = 1 kursi (urutannya dari baris pertama ke bawah).
4. Klik **"Save All"** untuk menyimpan semua data sekaligus.

### Format Tanggal yang Didukung

| Format | Contoh |
|--------|--------|
| `MMM-YY` | `Oct-25`, `Jan-34` |
| `DD-MMM-YY` | `24-Jan-25` |
| `DD/MM/YYYY` | `01/03/2030` |

### Bagian Spare

Di bawah bagian economy, ada textarea terpisah untuk:
- **PAX Spare** — Life vest cadangan dewasa
- **INF Spare** — Life vest cadangan bayi

Paste tanggal saja, jumlah otomatis dihitung.

---

## 6. ⚙️ Fleet Manager

Fleet Manager (`/fleet`) adalah pusat kontrol untuk mengelola data pesawat dan airline.

### Cara Akses

Klik tombol **"Manage Fleet"** di navbar, atau akses langsung: `/fleet`

### Tab Aircraft

Menampilkan daftar seluruh pesawat dalam tabel.

| Fitur | Keterangan |
|-------|------------|
| **Search** | Cari berdasarkan registrasi |
| **Filter Airline** | Filter berdasarkan maskapai |
| **Filter Status** | Filter Active / Prolong |
| **Filter Type** | Filter berdasarkan tipe pesawat |
| **+ Add New Aircraft** | Tambah pesawat baru |

#### Menambah Pesawat Baru

1. Klik **"+ Add New Aircraft"**.
2. Isi form:
   - **Airline**: Pilih maskapai
   - **Registration**: Nomor registrasi (misal: PK-GPC)
   - **Type**: Tipe pesawat (misal: A330-300)
   - **Layout**: Pilih layout kursi dari dropdown
   - **Status**: Pilih Active atau Prolong
3. Klik **Save**.

#### Edit Pesawat

- Klik **"Edit"** di baris pesawat.
- Hanya **Status** yang bisa diubah (Registration, Airline, Type terkunci).
- Klik **Save** untuk menyimpan.

#### Hapus Pesawat

- Klik **"Delete"** di baris pesawat.
- Konfirmasi penghapusan.
- ⚠️ **Data seat pesawat tersebut juga akan terhapus.**

### Tab Airlines

Menampilkan daftar maskapai yang terdaftar.

| Fitur | Keterangan |
|-------|------------|
| **Name** | Nama maskapai |
| **Code** | Kode IATA (GA, QG, dll) |
| **Aircraft Count** | Jumlah pesawat yang terdaftar |

#### Menambah Airline Baru

1. Klik **"+ Add New Airline"**.
2. Isi nama (contoh: Citilink) dan kode IATA (contoh: QG).
3. Klik **Save**.

#### Edit Airline

- Klik **"Edit"** di baris airline.
- Ubah nama atau kode IATA.
- Klik **Save**.

#### Hapus Airline

- Klik **"Delete"** di baris airline.
- ⚠️ **Hanya bisa dihapus jika tidak ada pesawat yang terdaftar di airline tersebut.**

---

## 7. 🌙 Dark / Light Mode

- Klik ikon **🌙** atau **☀️** di navbar (pojok kanan atas).
- Preferensi tema akan tersimpan di browser.
- Semua halaman mendukung kedua mode.

---

## 8. ⌨️ Keyboard Shortcuts

| Shortcut | Fungsi | Halaman |
|----------|--------|---------|
| **Ctrl + A** | Pilih SEMUA kursi | Seat Map |
| **Enter** | Buka dialog Set Date (jika ada kursi terpilih) | Seat Map |
| **Escape (ESC)** | Tutup dialog / Hapus selection | Seat Map |

---

## 9. 🎨 Arti Warna Status

| Warna | Status | Keterangan |
|-------|--------|------------|
| 🟢 **Hijau** | Safe | Expiry > 6 bulan lagi |
| 🟡 **Kuning** | Warning | Expiry 3–6 bulan lagi |
| 🔴 **Merah** | Critical | Expiry < 3 bulan lagi |
| 🟣 **Ungu** | Expired | Sudah melewati tanggal expiry |
| ⚪ **Abu-abu** | No Data | Belum ada tanggal expiry |

---

## 10. 💡 Tips & FAQ

### Tips

- **Select cepat**: Klik nomor baris atau huruf kolom untuk memilih seluruh baris/kolom sekaligus.
- **Batch update**: Pilih banyak kursi yang punya tanggal sama → Set Date sekali saja.
- **Copy-paste dari Excel**: Gunakan Batch Input untuk input data dari spreadsheet.
- **Cetak Blank Form** sebelum inspeksi di lapangan — kotak spare sudah disiapkan dengan jumlah buffer.

### FAQ

**Q: Kenapa tombol Set Date tidak aktif (disabled)?**
A: Anda belum memilih kursi. Pilih minimal 1 kursi terlebih dahulu.

**Q: Bisakah saya mengubah registrasi atau tipe pesawat?**
A: Tidak bisa dari halaman Edit. Hapus pesawat lalu tambahkan ulang dengan data yang benar.

**Q: Berapa format tanggal yang didukung di Batch Input?**
A: Tiga format: `Oct-25`, `24-Jan-25`, dan `01/03/2030`.

**Q: Apa bedanya Export PDF dan Blank Form?**
A: Export PDF berisi data lengkap (dengan tanggal & warna status). Blank Form adalah form kosong untuk diisi manual oleh teknisi.

**Q: Bagaimana jika layout pesawat belum tersedia?**
A: Hubungi developer untuk membuat layout baru. Lihat Developer Manual untuk panduan teknis.

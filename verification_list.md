# 🧪 Verification Checklist: Unique Aircraft Layouts

Checklist ini mencakup **1 perwakilan** dari setiap varian layout dan tipe pesawat yang ada di sistem. Tujuannya untuk memastikan:
1.  **Layout Kursi** benar (jumlah baris, konfigurasi ABCD).
2.  **Tipe Pesawat** di header benar (terutama untuk varian seperti MAX 8 atau A330-341).
3.  **Fitur Khusus** berfungsi (Cargo, First Class, Economy Premium).

---

## 🛫 B737 Fleet (Narrow Body)

- [ ] **B737-800 Layout A (E46)**
    - **Sample:** `PK-GFD`
    - **Cek:** Economy sampai Row **46**. Row 24 **SKIP**. Header: "B737-800".

- [ ] **B737 MAX 8**
    - **Sample:** `PK-GDC`
    - **Cek:** Layout sama dengan GFD (E46). Header harus: **"B737 MAX 8"**.

- [ ] **B737-800 Layout B (E47)**
    - **Sample:** `PK-GUD`
    - **Cek:** Economy sampai Row **47** (Row 47 hanya ABC).

- [ ] **B737-800 Layout C (E48)**
    - **Sample:** `PK-GUH`
    - **Cek:** Economy sampai Row **48**.

---

## 🛫 A330 Fleet (Wide Body)

- [ ] **A330-900 Layout A (2-Class)**
    - **Sample:** `PK-GHE`
    - **Cek:** Business (6-11), Economy (21-58). Header: "A330-900".

- [ ] **A330-900 Layout B (Economy Premium)**
    - **Sample:** `PK-GHH`
    - **Cek:** **Economy Premium** (Row 21-27) Layout 2-3-2. Header: "A330-900".

- [ ] **A330-300 Layout A (Standard)**
    - **Sample:** `PK-GPZ`
    - **Cek:** Business (6-11), Economy (21-55). Header: "A330-300".

- [ ] **A330-300 Layout B (Business 2-2-2)**
    - **Sample:** `PK-GPU`
    - **Cek:** Business (6-11) Layout **2-2-2** (AC - DG - HK).

- [ ] **A330-300 Layout C (All Economy)**
    - **Sample:** `PK-GPC`
    - **Cek:** **Tidak ada Business Class**. Full Economy dari 21 sampai 70.

- [ ] **A330-341 (All Economy Variant)**
    - **Sample:** `PK-GPE`
    - **Cek:** Layout sama dengan Layout C (All Econ). Header harus: **"A330-341"**.

- [ ] **A330-200 Layout A**
    - **Sample:** `PK-GPO`
    - **Cek:** Business hanya Row **6-8**. Header: "A330-200".

- [ ] **A330-200 Layout B**
    - **Sample:** `PK-GPQ`
    - **Cek:** Business Row **6-11**. Header: "A330-200".

- [ ] **A330 Cargo**
    - **Sample:** `PK-GPA`
    - **Cek:** Hanya Economy Row 21-33. Bawahnya ada **Gambar Box 📦 Cargo**. Header: "A330-300".

---

## 🛫 B777 Fleet (Flagship)

- [ ] **B777-300 (2-Class)**
    - **Sample:** `PK-GIA`
    - **Cek:** Business (6-12), Economy (21-63).

- [ ] **B777-300 (3-Class / First Class)**
    - **Sample:** `PK-GIF`
    - **Cek:** Ada **First Class** (Row 1-2). Business Row 6-16.

---

## 🛫 ATR Fleet (Regional)

- [ ] **ATR72-600**
    - **Sample:** `PK-GAF`
    - **Cek:** Pesawat Kecil. Layout **2-2** (AC - HK). Header: "ATR72-600".

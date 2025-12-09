# Metode SAW (Simple Additive Weighting) - Google Colab

Salin kode di bawah ini cell per cell ke Google Colab.
File Excel sudah di-upload ke storage Google Colab.

---

## CELL 1: Import Library

```python
# Langkah 1: Import Library
import numpy as np
import pandas as pd

print("Library berhasil di-import!")
```

---

## CELL 2: Membaca Data dari Excel

```python
# Mengambil data dari excel
data = pd.read_excel('data_saw.xlsx')

# Menampilkan 5 data atas pada data
data.head()
```

---

## CELL 3: Menyiapkan Data Alternatif dan Kriteria

```python
# Menyimpan kolom kriteria
# Sesuaikan nama kolom dengan file Excel kamu
kolom_alternatif = data.columns[0]  # Kolom pertama = nama alternatif
kolom_kriteria = data.columns[1:]   # Kolom sisanya = kriteria

# Ambil nama alternatif
nama_alternatif = data[kolom_alternatif].tolist()

# Ambil data kriteria sebagai numpy array
alternatives = data[kolom_kriteria].values.astype(float)

print("=== Nama Alternatif ===")
for i, nama in enumerate(nama_alternatif):
    print(f"A{i+1}: {nama}")

print(f"\n=== Kriteria ===")
for i, col in enumerate(kolom_kriteria):
    print(f"C{i+1}: {col}")

print(f"\n=== Matriks Keputusan ===")
print(alternatives)
```

---

## CELL 4: Definisikan Bobot dan Jenis Kriteria

```python
# Langkah 3: Definisikan bobot kriteria
# Sesuaikan dengan jumlah kriteria kamu
# Contoh: 4 kriteria dengan bobot [0.4, 0.2, 0.2, 0.2]
weights = np.array([0.4, 0.2, 0.2, 0.2])

# Jenis kriteria: 'cost' (minimisasi) atau 'benefit' (maksimisasi)
# Contoh: Harga = cost (semakin kecil semakin baik)
#         Lainnya = benefit (semakin besar semakin baik)
jenis_kriteria = ['cost', 'benefit', 'benefit', 'benefit']

print("=== Bobot Kriteria ===")
for i, (col, w, jenis) in enumerate(zip(kolom_kriteria, weights, jenis_kriteria)):
    print(f"C{i+1} ({col}): {w} - {jenis}")

print(f"\nTotal Bobot: {weights.sum()}")
```

---

## CELL 5: Normalisasi Matriks

Rumus SAW:
- **Cost (minimisasi)**: $r_{ij} = \frac{min(x_j)}{x_{ij}}$
- **Benefit (maksimisasi)**: $r_{ij} = \frac{x_{ij}}{max(x_j)}$

```python
# Langkah 4: Normalisasi Matriks
# Kriteria: cost (minimisasi), benefit (maksimisasi)

def normalize(matrix, jenis_kriteria):
    norm_matrix = np.zeros_like(matrix, dtype=float)
    
    for j in range(matrix.shape[1]):
        if jenis_kriteria[j] == 'cost':
            # Cost: min / nilai
            norm_matrix[:, j] = matrix[:, j].min() / matrix[:, j]
        else:
            # Benefit: nilai / max
            norm_matrix[:, j] = matrix[:, j] / matrix[:, j].max()
    
    return norm_matrix

# Normalisasi data alternatif
normalized_alternatives = normalize(alternatives, jenis_kriteria)

print("=== Matriks Ternormalisasi ===")
print(normalized_alternatives)
```

---

## CELL 6: Menghitung Nilai Preferensi (Skor Akhir)

Rumus: $V_i = \sum_{j=1}^{n} w_j \times r_{ij}$

```python
# Langkah 5: Menghitung Nilai Preferensi
# Rumus: V = sum(w * r)

final_scores = []
for i in range(len(normalized_alternatives)):
    score = 0
    for j in range(len(weights)):
        score += normalized_alternatives[i][j] * weights[j]
    final_scores.append(score)

# Gabungkan nama alternatif dan skor
gabung = [(f"A{i+1}", nama_alternatif[i], s) for i, s in enumerate(final_scores)]

# Tampilkan sebelum diurutkan
print("Skor Akhir:")
for kode, nama, s in gabung:
    print(f"{kode} ({nama}): {s:.4f}")
```

---

## CELL 7: Mengurutkan Nilai Preferensi (Ranking)

```python
# Langkah 6: Urutkan berdasarkan skor dari tertinggi ke terendah
urut = sorted(gabung, key=lambda x: x[2], reverse=True)

# Tampilkan hasil
print("=" * 50)
print("HASIL RANKING METODE SAW")
print("=" * 50)
print(f"{'Rank':<6}{'Kode':<8}{'Nama':<20}{'Skor':<10}")
print("-" * 50)

for rank, (kode, nama, score) in enumerate(urut, 1):
    print(f"{rank:<6}{kode:<8}{nama:<20}{score:.4f}")

print("=" * 50)
```

---

## CELL 8: Simpan Hasil ke Excel

```python
# Simpan hasil ke Excel
df_hasil = pd.DataFrame(urut, columns=['Kode', 'Nama Alternatif', 'Skor SAW'])
df_hasil.insert(0, 'Ranking', range(1, len(df_hasil) + 1))

# Simpan
output_file = 'Hasil_SAW.xlsx'
df_hasil.to_excel(output_file, index=False)

print(f"File '{output_file}' berhasil disimpan!")
display(df_hasil)
```

---

## CELL 9: Download File Hasil

```python
# Download file hasil
from google.colab import files
files.download('Hasil_SAW.xlsx')
```

---

## Contoh Data Excel (data_saw.xlsx):

| Alternatif | Harga (C1) | Kapasitas Baterai (C2) | Kamera (C3) | Penyimpanan (C4) |
|------------|------------|------------------------|-------------|------------------|
| A1         | 3000000    | 4000                   | 48          | 64               |
| A2         | 4000000    | 5000                   | 64          | 128              |
| A3         | 5000000    | 4500                   | 32          | 256              |

---

## Ringkasan Langkah SAW:

| No | Langkah | Keterangan |
|----|---------|------------|
| 1 | Import Library | numpy, pandas |
| 2 | Baca Data | pd.read_excel() |
| 3 | Definisikan Bobot | weights = [0.4, 0.2, 0.2, 0.2] |
| 4 | Normalisasi | Cost: min/nilai, Benefit: nilai/max |
| 5 | Hitung Preferensi | V = Σ (w × r) |
| 6 | Ranking | Urutkan dari tertinggi |

---

## Keterangan Jenis Kriteria:

- **Cost (Minimisasi)**: Semakin kecil nilainya semakin baik (contoh: Harga)
- **Benefit (Maksimisasi)**: Semakin besar nilainya semakin baik (contoh: Kapasitas, Kamera, Penyimpanan)

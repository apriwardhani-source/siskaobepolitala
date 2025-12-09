# Metode TOPSIS (Technique for Order Preference by Similarity to Ideal Solution)
## Praktikum - Google Colab

Salin kode di bawah ini cell per cell ke Google Colab.
File `2. Data Mustahik.xlsx` sudah di-upload ke storage Google Colab.

---

## CELL 1: Import Library yang Diperlukan

```python
# Library yang Digunakan
import pandas as pd
import numpy as np
import math

print("Library berhasil di-import!")
```

---

## CELL 2: Membaca Data dari File Excel

```python
# Mengambil data dari excel
data = pd.read_excel('2. Data Mustahik.xlsx')

# Menampilkan 5 data atas pada data
data.head()
```

---

## CELL 3: Menyimpan Data dengan Kriteria yang Dipilih

```python
# Menyimpan data dengan mengambil beberapa kriteria
# Kriteria: Identitas, Jumlah Tanggungan, Total Pendapatan, Total Pengeluaran
data_awal = data[['Identitas','Jumlah Tanggungan','Total Pendapatan','Total Pengeluaran']]
data_awal.head()
```

---

## CELL 4: Menampilkan Deskripsi Data

```python
# Untuk menampilkan deskripsi dari data dan karena semua kriteria numerik
data_awal.describe()
```

---

## CELL 5: Membuat Matriks Ternormalisasi

Rumus normalisasi TOPSIS:
$$r_{ij} = \frac{x_{ij}}{\sqrt{\sum_{i=1}^{m} x_{ij}^2}}$$

```python
# Inisialisasi matriks ternormalisasi
matriks_R = []
pembagi = []

# Ambil hanya kolom numerik (tanpa Identitas)
kolom_kriteria = data_awal.columns[1:]  # ['Jumlah Tanggungan', 'Total Pendapatan', 'Total Pengeluaran']

# 1. Menghitung nilai sigma dari kuadrat(xij)
for col in kolom_kriteria:
    sum_kuadrat = (data_awal[col] ** 2).sum()
    pembagi.append(sum_kuadrat)

# 2. Menghitung matriks ternormalisasi
for i in range(len(data_awal)):
    temp = []
    for j, col in enumerate(kolom_kriteria):
        nilai = data_awal.loc[data_awal.index[i], col] / math.sqrt(pembagi[j])
        temp.append(round(float(nilai), 4))
    matriks_R.append(temp)

# Menampilkan hasil
print("Tipe data:", type(matriks_R))
print("\nMatriks Ternormalisasi:")
for i, row in enumerate(matriks_R[:5]):  # Tampilkan 5 baris pertama
    print(f"Baris {i}: {row}")
print("...")
```

---

## CELL 6: Menyimpan Matriks Ternormalisasi ke Excel

```python
# Mengubah list ke dataframe
temp = pd.DataFrame(matriks_R, columns=['Jumlah Tanggungan','Total Pendapatan','Total Pengeluaran'])
matriks_ternormalisasi = pd.concat([data_awal['Identitas'], temp], axis=1)
matriks_ternormalisasi

# Menyimpan dalam excel
matriks_ternormalisasi.to_excel('Hasil Penerapan TOPSIS.xlsx', sheet_name='Matriks Ternormalisasi')
```

---

## CELL 7: Membuat Matriks Keputusan Ternormalisasi Terbobot

Rumus: $y_{ij} = r_{ij} \times w_j$

Bobot kriteria:
- Jumlah Tanggungan: 0.3 (Keuntungan/Benefit)
- Total Pendapatan: 0.5 (Biaya/Cost)
- Total Pengeluaran: 0.2 (Keuntungan/Benefit)

```python
# Inisialisasi bobot
bobot = [0.3, 0.5, 0.2]

# yij x wj
matriks_y = []
for i in range(len(matriks_R)):
    temp = []
    for j in range(len(matriks_R[0])):
        nilai = round(float(matriks_R[i][j] * bobot[j]), 4)
        temp.append(nilai)
    matriks_y.append(temp)

print("Matriks Terbobot:")
for i, row in enumerate(matriks_y[:5]):
    print(f"Baris {i}: {row}")
print("...")
```

---

## CELL 8: Menyimpan Matriks Terbobot ke Excel

```python
# Mengubah list ke dataframe
pd_matriks_y = pd.DataFrame(matriks_y, columns=['Jumlah Tanggungan','Total Pendapatan','Total Pengeluaran'])
matriks_ternormalisasi_terbobot = pd.concat([data_awal['Identitas'], pd_matriks_y], axis=1)

# Menyimpan dalam excel Hasil Penerapan TOPSIS
with pd.ExcelWriter('Hasil Penerapan TOPSIS.xlsx',
                    mode='a', if_sheet_exists='replace') as writer:
    matriks_ternormalisasi_terbobot.to_excel(writer, sheet_name='Matriks Ternormalisasi Terbobot')
```

---

## CELL 9: Membuat Matriks Ideal Positif dan Negatif

Rumus:
- $A^+ = (y_1^+, y_2^+, ..., y_n^+)$ → max jika benefit, min jika cost
- $A^- = (y_1^-, y_2^-, ..., y_n^-)$ → min jika benefit, max jika cost

```python
# Jenis kriteria: Keuntungan (Benefit) atau Biaya (Cost)
jenis_kriteria = ['Keuntungan', 'Biaya', 'Keuntungan']

# Matriks ideal positif (A+)
matriks_Apositif = []
for j, col in enumerate(kolom_kriteria):
    if jenis_kriteria[j] == 'Keuntungan':
        nilai = float(matriks_ternormalisasi_terbobot[col].max())
    else:
        nilai = float(matriks_ternormalisasi_terbobot[col].min())
    matriks_Apositif.append(round(nilai, 4))
print("Matriks A+ (Ideal Positif):")
print(matriks_Apositif)

# Matriks ideal negatif (A-)
matriks_Anegatif = []
for j, col in enumerate(kolom_kriteria):
    if jenis_kriteria[j] == 'Keuntungan':
        nilai = float(matriks_ternormalisasi_terbobot[col].min())
    else:
        nilai = float(matriks_ternormalisasi_terbobot[col].max())
    matriks_Anegatif.append(round(nilai, 4))
print("\nMatriks A- (Ideal Negatif):")
print(matriks_Anegatif)
```

---

## CELL 10: Menghitung Jarak Pemisahan (Separation Measure)

Rumus:
$$S_i^+ = \sqrt{\sum_{j=1}^{n}(y_{ij} - y_j^+)^2}$$
$$S_i^- = \sqrt{\sum_{j=1}^{n}(y_{ij} - y_j^-)^2}$$

```python
# Menghitung Matriks S+ (Jarak ke Solusi Ideal Positif)
matriks_SPositif = []
for i in range(len(matriks_ternormalisasi_terbobot)):
    jumlah = 0
    for j, col in enumerate(kolom_kriteria):
        # yij - y positif
        nilai_yij = matriks_ternormalisasi_terbobot.loc[matriks_ternormalisasi_terbobot.index[i], col]
        selisih = nilai_yij - matriks_Apositif[j]
        # (yij - y positif)^2
        kuadrat = selisih ** 2
        jumlah += kuadrat
    nilai = round(float(math.sqrt(jumlah)), 4)
    matriks_SPositif.append(nilai)

print("Matriks S+ (Jarak ke Ideal Positif):")
print(matriks_SPositif[:10])
print("...")
```

---

## CELL 11: Menghitung Jarak ke Solusi Ideal Negatif (S-)

```python
# Menghitung Matriks S- (Jarak ke Solusi Ideal Negatif)
matriks_SNegatif = []
for i in range(len(matriks_ternormalisasi_terbobot)):
    jumlah = 0
    for j, col in enumerate(kolom_kriteria):
        # yij - y negatif
        nilai_yij = matriks_ternormalisasi_terbobot.loc[matriks_ternormalisasi_terbobot.index[i], col]
        selisih = nilai_yij - matriks_Anegatif[j]
        # (yij - y negatif)^2
        kuadrat = selisih ** 2
        jumlah += kuadrat
    nilai = round(float(math.sqrt(jumlah)), 4)
    matriks_SNegatif.append(nilai)

print("Matriks S- (Jarak ke Ideal Negatif):")
print(matriks_SNegatif[:10])
print("...")
```

---

## CELL 12: Menyimpan Matriks Pemisahan ke Excel

```python
# Mengubah list ke dataframe
pd_matriks_SPositif = pd.DataFrame(matriks_SPositif, columns=['Pemisahan Positif'])
pd_matriks_SNegatif = pd.DataFrame(matriks_SNegatif, columns=['Pemisahan Negatif'])
matriks_pemisahan = pd.concat([data_awal['Identitas'], pd_matriks_SPositif, pd_matriks_SNegatif], axis=1)

# Menyimpan dalam excel
with pd.ExcelWriter('Hasil Penerapan TOPSIS.xlsx',
                    mode='a', if_sheet_exists='replace') as writer:
    matriks_pemisahan.to_excel(writer, sheet_name='Matriks Pemisahan')

print(matriks_pemisahan)
```

---

## CELL 13: Menghitung Kedekatan Relatif ke Solusi Ideal (C+)

Rumus:
$$C_i^+ = \frac{S_i^-}{S_i^+ + S_i^-}$$

```python
# Kedekatan Relatif ke Solusi Ideal C+ setiap alternatif
matriks_CPositif = []
for i in range(len(matriks_SPositif)):
    # Rumus: SNegatif / (SPositif + SNegatif)
    nilai = round(float(matriks_SNegatif[i] / (matriks_SPositif[i] + matriks_SNegatif[i])), 4)
    matriks_CPositif.append(nilai)

print("Kedekatan Relatif (C+):")
print(matriks_CPositif[:10])
print("...")
```

---

## CELL 14: Menyimpan Kedekatan Relatif ke Excel

```python
# Mengubah list ke dataframe
pd_matriks_CPositif = pd.DataFrame(matriks_CPositif, columns=['Kedekatan Relatif'])
pd_matriks_kedekatan = pd.concat([data_awal['Identitas'], pd_matriks_CPositif], axis=1)

# Menyimpan dalam excel
with pd.ExcelWriter('Hasil Penerapan TOPSIS.xlsx',
                    mode='a', if_sheet_exists='replace') as writer:
    pd_matriks_kedekatan.to_excel(writer, sheet_name='Matriks Kedekatan')

pd_matriks_kedekatan
```

---

## CELL 15: Mengurutkan Alternatif (Ranking)

```python
# Hasil diurutkan dari nilai besar ke nilai kecil
hasil_peringkat = pd_matriks_kedekatan.sort_values(by='Kedekatan Relatif', ascending=False)
print(hasil_peringkat)
```

---

## CELL 16: Menyimpan Hasil Pemeringkatan ke Excel

```python
# Menyimpan dalam excel Hasil Penerapan TOPSIS
with pd.ExcelWriter('Hasil Penerapan TOPSIS.xlsx',
                    mode='a', if_sheet_exists='replace') as writer:
    hasil_peringkat.to_excel(writer, sheet_name='Hasil Pemeringkatan')

print("File 'Hasil Penerapan TOPSIS.xlsx' berhasil disimpan!")
print("\nSheet yang tersedia:")
print("1. Matriks Ternormalisasi")
print("2. Matriks Ternormalisasi Terbobot")
print("3. Matriks Pemisahan")
print("4. Matriks Kedekatan")
print("5. Hasil Pemeringkatan")
```

---

## CELL 17: Download File Hasil

```python
# Download file hasil
from google.colab import files
files.download('Hasil Penerapan TOPSIS.xlsx')
```

---

## Ringkasan Langkah-Langkah TOPSIS:

| No | Langkah | Rumus |
|----|---------|-------|
| 1 | Membuat Matriks Keputusan | Data awal (m alternatif x n kriteria) |
| 2 | Normalisasi Matriks | $r_{ij} = \frac{x_{ij}}{\sqrt{\sum x_{ij}^2}}$ |
| 3 | Matriks Terbobot | $y_{ij} = r_{ij} \times w_j$ |
| 4 | Solusi Ideal Positif (A+) | max(benefit), min(cost) |
| 5 | Solusi Ideal Negatif (A-) | min(benefit), max(cost) |
| 6 | Jarak ke A+ (S+) | $S^+ = \sqrt{\sum(y_{ij} - y_j^+)^2}$ |
| 7 | Jarak ke A- (S-) | $S^- = \sqrt{\sum(y_{ij} - y_j^-)^2}$ |
| 8 | Kedekatan Relatif (C+) | $C^+ = \frac{S^-}{S^+ + S^-}$ |
| 9 | Ranking | Urutkan C+ dari besar ke kecil |

---

## Keterangan Kriteria:

| Kriteria | Bobot | Jenis |
|----------|-------|-------|
| Jumlah Tanggungan | 0.3 | Keuntungan (Benefit) |
| Total Pendapatan | 0.5 | Biaya (Cost) |
| Total Pengeluaran | 0.2 | Keuntungan (Benefit) |

**Catatan:**
- **Benefit (Keuntungan)**: Semakin besar nilainya semakin baik
- **Cost (Biaya)**: Semakin kecil nilainya semakin baik

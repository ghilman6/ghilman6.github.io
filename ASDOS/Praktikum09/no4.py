# file pinjaman  ngapus kode anggota
# 1. ngecek kode buku ada ngga ? index centang
# 2. ngecek kode anggota ada ngga didalam baris kode buku? centang
# 3. remove kode anggota centang

# file anggota  hitung denda
# 1. ngecek kode aggotanya index centang
# 2. cek dia nf group atau bukan centang 
# 3. hitung denda bedasarkan status centang
 
# file buku nambah stok
# 1. cek kode bukunya ada atau tidak index ceklis 
# 2. maka stok buku yang dipinjam ditambah 1 ceklis 

# kd_buku = "JAK517"
# kd_anggota = "LIB859"

# dataPinjam = []
# myfile = open("peminjaman.txt")
# for line in myfile:
#     dataPinjam.append(line.strip())

# for i in range(len(dataPinjam)):
#     if dataPinjam[i][:6] == kd_buku:
#         dataPinjam[i] = dataPinjam[i].split(",")
#         for j in range(1,len(dataPinjam[i])):
#             if dataPinjam[i][j] == kd_anggota:
#                 dataPinjam[i].remove(kd_anggota)
#                 break
#         if len(dataPinjam[i]) == 1:
#             del dataPinjam[i]
#             break
#         else:
#             dataPinjam[i] = ",".join(dataPinjam[i])

# f = open("peminjaman.txt","w+")
# for i in dataPinjam:
#     f.write(i+"\n")
# f.close()
    
            

# # ketemu = False
# if ketemu:
#     print("Ada anggota")
# else:
#     print("ngga ada anggota")


# kd_anggota = "LIB885"

# dataAnggota = []
# myfile = open("anggota.txt")
# for line in myfile:
#     dataAnggota.append(line.strip())

# terlambat = int(input("Masukan hari = "))
# denda = 0

# for i in dataAnggota:
#     if i[:6] == kd_anggota:
#         if i[-1] == "1":
#             print("NF grop")
#             denda = 1000 * terlambat
#         else:
#             print("Masyarakat umum")
#             denda = 2500 * terlambat

# print("Denda keterlambatannya adalah :",denda)


kd_buku = "GHI637"

dataBuku = []
myfile = open("buku.txt")
for line in myfile:
    dataBuku.append(line.strip())

for i in range(len(dataBuku)):
    if dataBuku[i][:6] == kd_buku:
        dataBuku[i] = dataBuku[i].split(",")
        dataBuku[i][-1] = str(int(dataBuku[i][-1])+1)
        dataBuku[i] = ",".join(dataBuku[i])

f = open("buku.txt","w+")
for i in dataBuku:
    f.write(i+"\n")
f.close()

    
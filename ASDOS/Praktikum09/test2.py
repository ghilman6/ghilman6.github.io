# ketemu = False
# for i in range(len(dataBuku)):
#     if dataBuku[i][:6] == kd_buku:
#         dataBuku[i] = dataBuku[i].split(",")
#         if int(dataBuku[i][-1]) > 0:
#             ketemu = True
        
# if ketemu:
#     print("Ada Bukunya Ada stoknya")
# else:
#     print("ada Bukunya ngga ada stok")

# kd_buku = "TUH065"
# kd_anggota = "LIB302"

# dataPinjam = []
# f = open('peminjaman.txt')
# for each_line in f:
#     dataPinjam.append(each_line.strip())
# f.close()

# ketemu = False
# for i in range(len(dataPinjam)):
#     if dataPinjam[i][:6] == kd_buku:
#             ketemu = True

# if ketemu:
#     f = open('peminjaman.txt','w+')
#     for i in range(len(dataPinjam)):
#         if dataPinjam[i][:6] == kd_buku:
#             f.write(dataPinjam[i]+","+kd_anggota+"\n")
#         else:
#             f.write(dataPinjam[i]+"\n")
#     f.close()
# else:
#     f = open('peminjaman.txt','a+')
#     f.write(kd_buku+","+kd_anggota+"\n")
#     f.close()

kd_buku = "TUH065"
dataBuku = []
f = open('buku.txt')
for each_line in f:
    dataBuku.append(each_line.strip())
f.close()

f = open('buku.txt','w+')
for i in range(len(dataBuku)):
    if dataBuku[i][:6] == kd_buku:
        dataBuku[i] = dataBuku[i].split(",")
        dataBuku[i][-1] = str(int(dataBuku[i][-1]) - 1)
        dataBuku[i] = ",".join(dataBuku[i])
    f.write(dataBuku[i]+"\n")
f.close()

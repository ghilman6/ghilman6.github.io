dataBuku = []
f = open('myfileBuku.txt')
for each_line in f:
    dataBuku.append(each_line.strip())
f.close()    

kd_buku = "JAK517"
for i in range(len(dataBuku)):
    if dataBuku[i][:6] == kd_buku:
        dataBuku[i] = dataBuku[i].split(",") #Ini untuk mengubah jadi list (ngambil stok)
        if int(dataBuku[i][-1]) > 0 :
            print("stok ada")
        else:
            print("stok tidak ada")
        dataBuku[i] = ",".join(dataBuku[i])#Ngembaliin menjadi str


# kd_buku = "JAK517"
# # Mengurangi stok
for i in range(len(dataBuku)): #Ini adalah perulangan 
    if dataBuku[i][:6] == kd_buku: # Mengecek buku ada atau tidak di dalam file 
        dataBuku[i] = dataBuku[i].split(",") #Ini untuk mengubah jadi list (ngambil stok)
        dataBuku[i][-1] = str(int(dataBuku[i][-1]) -1)# Ngubah stok 
        dataBuku[i] = ",".join(dataBuku[i])#Ngembaliin menjadi str


# f = open('myfileBuku.txt',"w+")
# for i in dataBuku:
#     f.write(i + '\n')
# f.close()
# print(dataBuku)

kd_buku = "AIH058"
kd_anggota = "LIB094"


dataPinjam = []
f = open('peminjaman.txt')
for each_line in f:
    dataPinjam.append(each_line.strip())
f.close()

ada = 0
for i in range(len(dataPinjam)): #Ini adalah perulangan 
    if dataPinjam[i][:6] == kd_buku:
        dataPinjam[i] = dataPinjam[i]+","+kd_anggota
        ada = 1


if ada == 1:
    f = open('peminjaman.txt',"w+")
    for i in dataPinjam:
        f.write(i+"\n")
    f.close()
else:
    f = open('peminjaman.txt',"a+")
    f.write(kd_buku+","+kd_anggota+"\n")
    f.close()






# print("-------------")
# data = []
# for i in dataBuku:
#     i = i.split(",")
#     data.append(i)
# print(data)




# h = 0
# multi = []
# for i in dataBuku:
#     if i[:6] == kd_buku:
#         print("Ada loh Bukunya")
#         for j in dataBuku:
#             j = j.split(",")
#             multi.append(j)
#         i = i.split(",")
#         multi[h][-1] = str(int(i[3])-1)
#     h+=1
# for i in range(len(multi)):
#     multi[i] = ",".join(multi[i])
# myfile = open('myfileBuku.txt', 'w+')
# for i in multi:
#     myfile.write(i+"\n")
# myfile.close()




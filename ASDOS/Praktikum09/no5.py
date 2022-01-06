# 1. Ngambil data (buku,anggota,peminjam) lalu disimpan menjadi dict centang
# 2. nampilin judul buku dan nampilin penulis sesuai yg kita inginkan  centang
# 3. nampilih anggota yang meminjam buku sesuai yg kita inginkan centang


# ubah data text -> list (temp) -> dict (dataBuku)
temp = []
dataBuku = {}
myfile = open("buku.txt")
for line in myfile:
    temp = line.split(",") #Mengubah menjadi multiple list
    dataBuku[temp[0]] = [temp[1],temp[2],str(int(temp[3]))] #Mengubah multi list menjadi dict

temp = []
dataAnggota = {}
myfile = open("anggota.txt")
for line in myfile:
    temp = line.split(",") #Mengubah menjadi multiple list
    dataAnggota[temp[0]] = [temp[1],str(int(temp[2]))] #Mengubah multi list menjadi dict

temp = []
dataPinjam = {}
myfile = open("peminjaman.txt")
for line in myfile:
    temp = line.split(",") #Mengubah menjadi multiple list
    temp[-1] = temp[-1][0:-1]
    dataPinjam[temp[0]] = temp[1:] #Mengubah multi list menjadi dict

#kita nampilin value dataBuku dimana keysnya adalah kode buku yang ada didalam dataPinjam
print("*** DAFTAR PEMINJAMAN BUKU ***\n")

for i in dataPinjam.keys():
    nomer = 0
    print("Judul : "+dataBuku[i][0])
    print("Penulis : "+dataBuku[i][1])
    print("Daftar Pinjam:")
    for j in dataPinjam[i]:
        nomer +=1
        print(str(nomer)+". "+str(dataAnggota[j][0])+("(*)" if dataAnggota[j][1] == "1" else ""))
    print()


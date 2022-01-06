from os import read, system
from time import sleep
def clear():
    print("Enter back to MENU")
    a = input()
    _ = system('cls')
def menu():
    print(
    """***** SELAMAT DATANG DI NF LIBRARY *****
    MENU:
    [1] Tambah Anggota Baru
    [2] Tambah Buku Baru
    [3] Pinjam Buku
    [4] Kembalikan Buku
    [5] Lihat Data Peminjaman
    [6] Lihat Data Anggota
    [7] Lihat Data Buku
    [8] Keluar""")
    
def daftarAnggota(kode, nama, status):
    myfile = open("anggota.txt", 'a+')
    myfile.write("\n"+kode +","+nama+","+status)
    myfile.close()

def nambahBuku(kode,judul,penulis, stok):
    myfile = open("buku.txt", 'a+')
    myfile.write(kode +","+judul+","+penulis+","+stok+"\n")
    myfile.close()

def readBuku():
    dataBuku = []
    f = open('buku.txt')
    for each_line in f:
        dataBuku.append(each_line.strip())
    f.close()
    return dataBuku

def readAnggota():
    dataAnggota = []
    f = open('anggota.txt')
    for each_line in f:
        dataAnggota.append(each_line.strip())
    f.close()
    return dataAnggota

def cek_buku(kd_buku):
    for i in readBuku():
        if i[:6] == kd_buku:
            return True
    return False

def cek_anggota(kd_anggota):
    for i in readAnggota():
        if i[:6] == kd_anggota:
            return True
    return False

def cek_stok(kd_buku):
    dataBuku = readBuku()
    for i in range (len(dataBuku)):
        if dataBuku [i][:6] == kd_buku:
            dataBuku[i] = dataBuku[i].split(",")# Mengubah string menjadi list
            if int(dataBuku[i][-1]) > 0:
                return True
    return False

def kurangStok(kd_buku):
    dataBuku = readBuku()
    for i in range(len(dataBuku)): #Ini adalah perulangan 
        if dataBuku[i][:6] == kd_buku: # Mengecek buku ada atau tidak di dalam file 
            dataBuku[i] = dataBuku[i].split(",") #Ini untuk mengubah jadi list (ngambil stok)
            dataBuku[i][-1] = str(int(dataBuku[i][-1]) - 1)# Ngubah stok 
            dataBuku[i] = ",".join(dataBuku[i])#Ngembaliin menjadi str
    myfile = open('buku.txt', 'w+')
    for i in dataBuku:
        myfile.write(i+"\n")
    myfile.close()

def readPinjamBuku():    
    a_list = []
    myfile = open("peminjaman.txt")
    for line in myfile:
        a_list.append(line.strip())
    return a_list

def pinjamBuku(kd_buku,kd_anggota):
    dataPinjam = readPinjamBuku()
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

def cek_statusAngggota(kd_anggota):
    dataAnggota = readAnggota()
    for i in range(len(dataAnggota)):
        if dataAnggota[i][:6] == kd_anggota:
            if dataAnggota[i][-1] == "1":
                return True
            else:
                return False
def anggota_pinjam(kd_buku,kd_anggota):
    dataPinjam = readPinjamBuku()
    for i in range(len(dataPinjam)):
        if dataPinjam[i][:6] == kd_buku:
            dataPinjam[i] = dataPinjam[i].split(",") #Ini untuk mengubah jadi list 
            if dataPinjam[i].count(kd_anggota) == 1:
                return True
            else:
                return False
    
def remove_anggota(kd_buku,kd_anggota):
    dataPinjam = readPinjamBuku()
    for i in range(len(dataPinjam)):
        if dataPinjam[i][:6] == kd_buku: # Mengecek buku ada atau tidak di dalam file 
            dataPinjam[i] = dataPinjam[i].split(",") #Ini untuk mengubah jadi list 
            dataPinjam[i].remove(kd_anggota)
            if len(dataPinjam[i]) == 1 :
                del dataPinjam[i]
            else:
                dataPinjam[i] = ",".join(dataPinjam[i])#Ngembaliin menjadi str
        
    myfile = open('peminjaman.txt', 'w+')
    for i in dataPinjam:
        myfile.write(i+"\n")
    myfile.close()

def viewPinjam():
    # ubah data text -> list (temp) -> dict (dataBuku)
    # Data buku
    temp = []
    dataBuku = {}
    myfile = open("buku.txt")
    for line in myfile:
        temp = line.split(",") #Mengubah menjadi multiple list
        dataBuku[temp[0]] = [temp[1],temp[2],str(int(temp[3]))] #Mengubah multi list menjadi dict
    # Data Anggota
    temp = []
    dataAnggota = {}
    myfile = open("anggota.txt")
    for line in myfile:
        temp = line.split(",") #Mengubah menjadi multiple list
        dataAnggota[temp[0]] = [temp[1],str(int(temp[2]))] #Mengubah multi list menjadi dict
    # Data Pinjam
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
    
def viewAnggota():
    dataAnggota = readAnggota()

    print("**** DAFTAR ANGGOTA ****\n")
    for i in range(len(dataAnggota)):
        dataAnggota[i] = dataAnggota[i].split(",")
        print("Anggota "+ dataAnggota[i][0])
        print("Nama : "+dataAnggota[i][1])
        print("Status : NF Group" if dataAnggota[i][2] == "1" else "Status : Masyarakat Umum")
        print()

def viewBuku():
    dataBuku = readBuku()
    print("**** DAFTAR BUKU ****\n")
    for i in range(len(dataBuku)):
        dataBuku[i] = dataBuku[i].split(",")
        print("Kode Buku "+ dataBuku[i][0])
        print("Judul : "+dataBuku[i][1])
        print("Penulis : "+dataBuku[i][2])
        print("Stok : "+dataBuku[i][3])
        print()

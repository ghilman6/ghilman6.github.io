import random, string
kode = "LIB" + ''.join(random.choice(string.digits) for _ in range(3))
nama = input("Masukkan nama: ")
nf = input("Apakah merupakan karyawan NF Group? (Y/T): ")
nf = "1" if nf == "Y" else "2" if nf == "T" else "Tidak Terdaftar"
# Mengedit file teks
myfile = open('myfile.txt', 'a+')
myfile.write(kode+","+nama+","+nf+"\n")
myfile.close()

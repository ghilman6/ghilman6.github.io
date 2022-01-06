def cek_nama(name):
    name = name.split(" ")
    cek = 0
    for i in name:
        if i[0].isupper():
            cek +=1    
    if cek == len(name):
        return True
    else:
        return False
    
list_nama = []

namaa = input("Masukkan nama:")
if cek_nama(namaa):
    list_nama.append(namaa)
    print("Nama Benar!")
else:
    print("Masukkan nama ulang!")
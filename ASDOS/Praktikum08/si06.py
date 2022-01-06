# nama = "Ubay sukma ara zia mervyan irfan nana komar"
# nama_list = nama.split()
# print(nama)
# print(nama_list)
# print(len(nama_list))

# nama_str = " dan ".join(nama_list)

# print(nama_str)

#Resto NF
# menu = [["Air Putih","Jus Kelapa","Jus Alpukat"],
#         ["Nasi Goreng", "Bakso", "Sop Iga"],
#         ["Seblak", "Cireng", "Coklat", "Otak-otak"]]
# menu1=[]
# for i in menu:
#     for x in i:
#         menu1.append(x)
# print(menu1)
# while True:
#     print("Daftar Menu")
#     print("1. MENU Minuman")
#     print("2. MENU Makanan")
#     print("3. MENU Cemilan")
#     print("4. Pesanan Selesai")
#     # Memilih Menu
#     pilih = int(input("Masukan Pilihan = "))-1
#     if pilih == 3:
#         break
#     # Menampilkan Menu Pilihan
#     for i in range(len(menu[pilih])):
#         print(str(i+1)+". "+menu[pilih][i])
#     # Memilih Pesanan
#     pesan = int(input("Masukan Pesanan = "))-1 
#     #Menampilkan Pesanan
#     print("Pesanan yang kamu pesan adalah", menu[pilih][pesan])

f = open("nama.txt","r")
nama = f.read()
nama = nama.split()
print(nama)
f.close()

f = open("nama.txt","w")
a=1
for i in nama:
    f.write(str(a)+". "+i+"\n")
    a+=1



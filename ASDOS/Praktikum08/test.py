# nama_si07 = "Ala, Dina, Umi, Oci, Lulu, Ijul, OmUki, Ponco, Hana, Adul, Udin, Diul, Hina"
# print(nama_si07)
# nama_si07_list = nama_si07.split(", ")
# print(nama_si07_list)
# nama_si07_str = ','.join(nama_si07_list)
# print(nama_si07_str,"sedang ada di praktikum ddp")

#Resto NF
menu =  [["Jus kelapa", "Jus alpuket","Air Putih", "kopi", "milkshake", "boba"],
        ["mie samyang", "Nasi goreng","Mie ayam", "soto ayam", "baso"],
        ["seblak", "salad buah","makaroni", "rujak jambu", "lumpia basah", "cilung"]]
menu_dipesan = []
print("Daftar menu utama")
print("1. Menu Minuman")
print("2. Menu Makanan")
print("3. Menu Cemilan")
print("4. Pesanan Selesai")
while True:
    pilih = int(input("Masukan Pilihan = "))-1 # Milih menu
    if pilih == 3:
        break
    # Menampilkan Menu yang dipilih
    for i in range(len(menu[pilih])):
        print(str(i+1)+".",menu[pilih][i])

    pilih_menu = int(input("Masukan Pilihan Menu = "))-1 # Milih menu yang diplih
    menu_dipesan.append(menu[pilih][pilih_menu])
    print("Menu yang anda pilih adalah", menu[pilih][pilih_menu]) # Menampilkan Menu yang dipilih

    #Nampilin seluruh menu yang dipesan
a = 1
for i in menu_dipesan:
    print(str(a)+".",i)
    a += 1

# Pake while
# i = 0
# while i < len(menu[pilih]):
#     print(str(i+1)+".",menu[pilih][i])
#     i +=1

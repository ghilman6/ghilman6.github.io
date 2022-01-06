# kelas = "Iqrom Ammar mila putri maulana tari faiha wais hernada jaisy fatah alip muhtar"
# kelas_list = kelas.split()
# # print(kelas)
# # print(kelas_list)
# # print(len(kelas_list))
# # print(kelas[6:12])
# kelas_str = " ".join(kelas_list)
# print(kelas_list)
# print(kelas_str)

# Resto NF
menu = [["kopi","jus marimas","jus alpukat","jus kelapa"], 
        ["Bakso", "Sop iga", "Nasi goreng", "Mie Goreng"],
        ["Seblak", "Kuaci", "Basreng", "Cakwe", "Cireng"]]
menu2 = []
for i in menu:
    # print(i)
    for x in i:
        print(x)
        menu2.append(x)
print(menu)
print(menu2)

# print("Selamat Datang di Resto NF")
# print("Daftar Menu")
# print("1. Menu Minuman")
# print("2. Menu Makanan")
# print("3. Menu Cemilan")

# pilih = int(input("Masukan Pilihan : "))-1
# a = 1
# for i in menu[pilih]:
#     print(str(a)+". "+i)
#     a += 1

# pesan = int(input("Masukan Pesanan : "))-1

# print("Pesanan yang dipesan adalah",menu[pilih][pesan])
# Fungsi untuk mengecek apakah ada Huruf besar atau Huruf kecil dalam string
def isUpperOrLower(var=""):
    if var != var.upper() and var != var.lower():
        return True
    return False

# Fungsi untuk mengecek apakah ada angka dalam string
def is_number(var=""):
    for i in range(10):
        if var.count(str(i))>=1:
            return True
    return False

# Fungsi untuk mengecek apakah ada Symbol !@#$ dalam string
def is_symbol(var=""):
    if '!' in var or '@' in var or '#' in var or '$' in var :
        return True
    else:
        return False

total_item = 0
total_harga_awal = 0 
total_harga = 0 
# Ini program menghitung barang masuk dan total harga
while True :
    barang = input("Masukkan nama produk yang akan dibeli atau X untuk selesai: ")
    if barang == "X":
        break
    else:
        harga = float(input("Masukkan harga produk: "))
        print("Berhasil menambahkan "+barang+" dengan harga "+str(harga))
        total_item = total_item + 1
        total_harga_awal = total_harga_awal + harga
        
if total_item != 0:
    print(" ")
    print("Total produk yang dibeli:",total_item)
    print("Total harga produk:",total_harga_awal)
    print(" ")

if total_item != 0:
    anggota = input("Apakah Anda seorang anggota? (Y/T): ")
    if anggota == "Y":

        # Ini Program Email valid 
        while True:
            email = input("Masukan Email : ")
            if email[-4:] == ".com" and email.count("@") == 1 and email[-5] != "@" :
                break
            print("email tidak valid. Ulangi.")

        # Ini Program Password valid 
        while True:
            password = input("Masukan Password : ")
            if len(password) >=8 and isUpperOrLower(password) and is_number(password) and is_symbol(password):
                break
            print("password tidak valid. Ulangi.")  

        # Ini Program penentuan diskon sesuai dengan level  
        while True: 
            level = input("Masukkan level kepesertaan Anda (Silver/Gold/Diamond): ")  
            if level == "Silver":
                if total_item < 5:
                    total_harga = total_harga_awal - (5 / 100 * total_harga_awal)
                    print("Selamat! Anda mendapat potongan harga 5%") 
                    break          
                else:
                    total_harga = total_harga_awal - (10 / 100 * total_harga_awal)  
                    print("Selamat! Anda mendapat potongan harga 10%")        
                    break                   
            elif level == "Gold":
                if total_item < 5:
                    total_harga = total_harga_awal - (10 / 100 * total_harga_awal)           
                    print("Selamat! Anda mendapat potongan harga 10%")                           
                    break
                else:
                    total_harga = total_harga_awal - (15 / 100 * total_harga_awal)
                    print("Selamat! Anda mendapat potongan harga 15%")                           
                    break
            elif level == "Diamond":
                if total_item < 5:
                    total_harga = total_harga_awal - (15 / 100 * total_harga_awal)           
                    print("Selamat! Anda mendapat potongan harga 15%")                           
                    break
                else:
                    total_harga = total_harga_awal - (20 / 100 * total_harga_awal)               
                    print("Selamat! Anda mendapat potongan harga 20%")    
                    break
            else:
                print("Masukan tidak valid. Ulangi.")                     
        print("Total harga yang harus dibayar: ",total_harga)
    else:
        print("Total harga yang harus dibayar: ",total_harga_awal) 

if total_item == 0:
    print("Terima kasih. Sampai jumpa.")
else:
    print("Terima kasih telah berbelanja di NFElectrics.")





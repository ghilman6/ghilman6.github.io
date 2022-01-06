import random, string
from function import *

menu()

while True:
    pilih = input("\nMasukkan menu pilihan Anda: ")
    # Menu 1
    if pilih == "1":
        print("\n*** PENDAFTARAN ANGGOTA BARU ***")
        kode = "LIB" + ''.join(random.choice(string.digits) for _ in range(3))
        nama = input("Masukkan nama: ")
        status = input("Apakah merupakan karyawan NF Group? (Y/T): ")
        status = "1" if status == "Y" else  "2"
        daftarAnggota(kode,nama,status)
        print("Pendaftaran anggota dengan kode "+kode+" atas nama "+nama+" berhasil.")

    # Menu 2
    elif pilih == "2":
        print("\n*** PENAMBAHAN BUKU BARU ***\n")
        judul = input("Judul: ")
        penulis = input("Penulis: ")
        stok = input("Stok: ")

        penulis = penulis.split()
        penulis = "".join(penulis)
        kode = penulis[:3].upper() + ''.join(random.choice(string.digits) for _ in range(3))

        nambahBuku(kode,judul, penulis, stok)
        print("Penambahan buku baru dengan kode "+kode+" dan judul "+judul+" berhasil.")

    # Menu 3
    elif pilih == "3":
        print("\n*** PEMINJAMAN BUKU ***")
        kd_buku = input("Kode buku: ")
        if cek_buku(kd_buku):
            kd_anggota = input("Kode anggota: ")
            if cek_anggota(kd_anggota):
                if cek_stok(kd_buku):
                    pinjamBuku(kd_buku,kd_anggota)
                    kurangStok(kd_buku)
                    print("Peminjaman buku "+kd_buku+" oleh "+kd_anggota+" berhasil.")
                else:
                    print("Stok buku kosong. Peminjaman gagal.")
            else:
                print("Kode anggota tidak terdaftar. Peminjaman gagal.\n")
        else:
            print("Kode buku tidak ditemukan. Peminjaman gagal.\n")

    # Menu 4
    elif pilih == "4":
        print("\n*** PENGEMBALIAN BUKU ***")
        kd_buku = input("Kode buku: ")
        if cek_buku(kd_buku):
            kd_anggota = input("Kode anggota: ")
            if anggota_pinjam(kd_buku,kd_anggota):
                denda = int(input("Keterlambatan pengembalian (dalam hari, 0 jika tidak terlambat): "))
                if cek_statusAngggota(kd_anggota):
                    denda = 1000 * denda
                else:
                    denda = 2500 * denda
                print("Total denda =",denda)
                print("Silakan membayar denda keterlambatan di kasir.")
                remove_anggota(kd_buku,kd_anggota)
                print("Pengembalian buku "+kd_buku+" oleh "+kd_anggota+" berhasil.")

            else:
                print("Kode anggota tidak terdaftar sebagai peminjam buku tersebut. Pengembalian buku gagal.\n")
        else:
            print("Kode buku salah. Pengembalian buku gagal.")
    elif pilih == "5":
        viewPinjam()
    elif pilih == "6":
        viewAnggota()
    elif pilih == "7":
        viewBuku()
    elif pilih == "8":
        print("Terima kasih atas kunjungan Anda...")
        break
    else:
        print("Pilihan Anda salah. Ulangi.")
    clear()
    menu()
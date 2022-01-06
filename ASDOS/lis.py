# hasil = 0
# n = 4
# angka = ["satu", "dua", "tiga", "empat", "lima"]
# for i in range(len(angka)):
#     if len(angka[i]) <= n :
#         hasil += 1
# print(hasil)


def count_by_len(str_list,N = 0):
    hasil = 0
    for i in range(len(str_list)):
        if len(str_list[i]) <= N :
            hasil += 1
    return hasil

print(count_by_len(["Semangat!",10]))
# angka.sort()
# print(angka)
# angka.reverse()
# print(angka)
# print(angka[1])







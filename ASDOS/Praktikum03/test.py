nilai = eval(input("Masukan Nilai = "))
if nilai > 0:
    for i in range(1,nilai+1):
        if i % 3 == 0 or i % 5 == 0 or i % 7 == 0:
            print(i)
else:
    print("Tidak Valid")

if nilai > 0:
    print("Bilangan Positif")
elif nilai < 0:
    print("Bilangan negatif")
else:
    print("Bilangan 0")
# var = "Selamat datang! Apa kabar?"

# a = var.lower().count("a")
# u = var.lower().count("u")
# i = var.lower().count("i")
# e = var.lower().count("e")
# o = var.lower().count("o")
# hasil = a + u + i +e + o
# print(hasil)

def mistery(a, b):
    if a > 0 and b < 0:
        print("1")
        return mistery(b, a)
    elif a < 0 and b < 0:
        print("1")
        return mistery(-1*a, -1*b)

    if a > b:
        print("1")
        return mistery(b, a)
    elif b != 0:
        print("1")
        return a + mistery(a, b-1)
    else:
        return 0
mistery(3,2)
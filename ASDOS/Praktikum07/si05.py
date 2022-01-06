# nama = ["ghilman","baihaki","fadlan",["jakarta","bekasi","depok"]]
# print(nama[3][1])

# angka = [" ",2.6,3,[4,5],[0,1,[3,2]]]
# if 0 in angka[4]:
#     print("ada")
# else:
#     print("ngga ada")

# def soal(x):
#     if x > 2:
#         x = x * 2
#     if x > 4:
#         x = 0
#     return x

# def jawab(x):
#     if x > 2:
#         x = 0
#     return x

# def fac(x):
#     if x == 1:
#         return 1
#     else:
#         return x*fac(x-1)

# print(fac(3))
# print(soal(-3), soal(5))
# print("============")
# print(jawab(-3), jawab(5))

# a = 5
# b = 4
# c = 9
# x = 10
# y = 10
# if a > b:
#     if a > c:
#         x = a + (b - c)
#     else:
#         y = c + (b - a)
# else:
#     if c != 0:
#         x = x + a
#     else:
#         y = y - b
# print(x)
# print(y)

# print(50 % 5 + 100)
# print(25 * 8 - 100)
# print(5 ** 2 ** 2)
# print(51 + 7 ** 2)
# print(50 // 4 * 8)

# a = "Selamat"
# b = "datang"
# c = 10

# print(a[5:1:-1] + b[2:] )

# a = 3.0
# b = 'hello'
# c = 10
# d = 7

# if a > len(b) or len(b) == c / 2:
#     print("true")
# else :
#     print("false")

# x = 0
# for i in range(1,3):
#     for j in range(3,5):
#         if j % i == 0:
#             x = x + 2
#             print("di eksekusi")
# print(x)

# x = 3
# while x < 10:
#     if x % 2 == 0:
#         print(x)
#         break
#     x = x + 1
    
# def f(x):
#     x = x * x
#     return x

# x = 3
# print(x)        # Baris luaran (1)
# print(f(x))     # Baris luaran (2)
# print(x)        # Baris luaran (3)

# def rec(n):
#     if n == 0:
#         return 1
#     else:
#         return 3 * rec(n-2)



# def nonrec(n):
#     result = 1
#     while n > 0:
#         result = result - 2
#         n = n * 3
#     return result

# print(rec(4))
# print(nonrec(4))

def rec(n):
    if n % 2 == 1:
        print("n % 2")
        return rec(n-1)
    if n == 0:
        print("n == 0")
        return n
    else:
        print("else")
        return n + rec(n-2)

print(rec(9))
# x = 3
# y = 4
# while y <= x:
#    y = y * 2

# print(x)
# print(y)

# def cekBilangan(a, b, c):
#     if a*b == c or c*b == a or a*c == b:
#         return True
#     else:
#         return False

# print(cekBilangan(1, 2, 2))
# print("-------------")
# print(cekBilangan(-1.25, -2.5, 0.5))
# print("-------------")
# print(cekBilangan(-5, 10, 2))
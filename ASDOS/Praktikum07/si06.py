# print(25 * 2 ** 2)
# print(123 - 73 % 50)
# print(10 + 6 * 15)
# print(5 ** 3 - 10)
# print(25 // 2 * 8)

# a = "Selamat"
# b = "datang"
# c = 10
# print(a[2: :2] + b[-2:])
# print((b[0] + a[-3]) * c)
# print(a + b + str(c) )

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
# print(x,y)

# def soal(x):
#     if x > 2:
#         x = x * 2
#     if x > 4:
#         x = 0
#     return x

# def jawab(x):
#     x = 0
#     return x

# print(soal(1),soal(10))
# print("------------")
# print(jawab(1),jawab(10))

# x = 0
# for i in range(1,4):
#     for j in range(3,5):
#         if j % i == 0:
#             x = x + 3
#             print("x = x + 3 di eksekusi")
# print(x)

# x = 0
# y = 0
# while y < x:
#     y = y + 7
# print(x, y)

# x = 1
# while x < 10:
#     if x % 2 == 0:
#         print(x)
#         break
#     x = x + 1

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
# print(rec(2))
# print("-----")
# print(nonrec(2))

# def cekBilangan(a, b, c):
#     if a*b == c or b*c == a or a*c == b:
#         return True
#     else:
#         return False

# print(cekBilangan(-1.25, -2.5, 0.5))
# x = 2
# y = 1
# while y <= x:
#     y = y * 2

# print(x)
# print(y)

# a = "Selamat"
# b = "datang"
# c = 10
# print(a[5:1:-1] + b[2:])
# print((a[2] + b[-1]) * c )
# print(a + b + c )

# print(round(7.5 - 0.5) * 9)
# print(3 + abs(-7.0))
# print(abs(round(2 - 5) * 0.3))
# print(abs(-7 - 3) // 3)
# print(round(9 / 3) / 3)

# def f(num1, num2=5):
#     res = num1 * num2
#     print(res)

# f(8, 3)
# f(7)

# a = "Selamat"
# b = "datang"
# c = 10

# print(a[-2: :-2] + b[:2])
# print((b[1] + a[-3]) * c )
# print(a + str(b) + c  )
# t = "Python"
# print(t.replace("t", "yy"))
# print(t.endswith("on") )


my_list = [1, 3, 5, 4, 3, 2, 1]
hasil = []
for i in range(len(my_list)):
    if my_list[i] % 7 == 0:
        hasil.append(my_list[i])
print(sum(hasil))


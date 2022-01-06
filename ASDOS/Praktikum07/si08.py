# print(107 - 85 // 12)
# print(4 * 5 ** 2)
# print(2 * 5 * 10)
# print(50 + 17 * 3)
# print(9 * 13 - 10)

# print(100 // round(2.8 - 0.5))
# print(round(abs(70 / 3)))
# print(10 - abs(3.0 - 6))
# print(round(12.5) / 2)
# print(0.5 + round(7 + 0.7))

# a = 3.0
# b = 'hello'
# c = 10
# d = 7

# if len(b) * 2 != c:
#     print("True")
# else:
#     print("False")

# def soal(x):
#     if x > 2:
#         x = x * 2
#     if x > 4:
#         x = 0
#     return x

# def jawab(x):
#     if x > 2:
#         x = 0
#     else:
#         x = x * 2
#     return x

# print(soal(1),soal(6))
# print("-------------")
# print(jawab(1),jawab(6))

# x = 0
# for i in range(1,3):
#     for j in range(3,5):
#         if j % i == 0:
#             print("x = x + 3 Di eksekusi")
#             x = x + 3
# print(x)

# for i in range(1,5):
#     print(str(i) * i)

# x = 1
# while x < 10:
#     if x % 7 == 0:
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

# def f(num1, num2=4):
#     res = num1 * num2
#     print(res)
# f(6, 5)
# f(10)

# def rec(n):
#     if n == 0:
#         return 1
#     else:
#         return 3 * rec(n-2)

# print(rec(2))

# def nonrec(n):
#     result = 1
#     while n > 0:
#         result = result * 3
#         n = n - 2
#     return result

# print(nonrec(2))


# def cekBilangan(a,b,c):
#     if a+b == c or a+c == b or b+c == a:
#         return True
#     else:
#         return False

# print(cekBilangan(1, 2, 3))
# print(cekBilangan(1.5, 6, 4.5))
# print(cekBilangan(4, 1, 2))   

my_list=[1,2,3,4,5]
print(sum(my_list))
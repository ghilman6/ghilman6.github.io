# def rec(num):
#     if num == 0:
#         return num
#     else:
#         return num % 10 + rec(num // 10)
# print(rec(1234))

# a = 10
# while True:
#     if a == 0:
#         break
#     print(a)
#     a = a - 1

def uts_no7(x=0):
    if x > 2:
        x = x * 2
    if x > 4:
        x = 0
    return x

def uts(x=0):
    if x > 2:
        x = 0
    return x

# print(uts_no7(-2))
# print(uts_no7(5))

# print("--------------")
# print(uts(-2))
# print(uts(5))

# a = "Selamat"
# b = "datang"
# c = 10
# print(a + str(b) + c  )

# # no 16
# x= 0
# a = -20
# b = 30
# for i in range (a ,b):
#     if i > 0:
#         if b % 3 == 0:
#             x = x+2
#         elif b % 5 == 0:
#             x = x+3
#         else:
#             x = x+4
#     else:
#         x = x+5      
my_list = ['ini', 'adalah', 'sebuah list',4]
print(my_list)
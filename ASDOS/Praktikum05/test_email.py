def is_number(var=""):
    for i in range(10):
        if var.count(str(i))>=1:
            return True
    return False

def is_symbol(var=""):
    if '!' in var or '@' in var or '#' in var or '$' in var :
        return True
    else:
        return False

def isUpperOrLower(var=""):
    if not var.upper()in var and not var.lower()in var:
        return True
    return False

print(isUpperOrLower("asd"))
# while True:
#     password = input("Masukan Password : ")
#     if is_number(password):
#         break
#     print("Masukin Password yang bener") 
# while True:
#     email = input("Masukan Email : ")
#     if email[-4:] == ".com" and email.count("@") == 1  :
#         break
# email = "ghilman@gmail.com"
# print(email[-4:])
# print("@" in email)

# while True:
#     password = input("Masukan Password : ")
#     if len(password) >= 8 : 
#         break
# password = "wawe*q1"
# print(is_symbol(password))
# print(is_number(password))    
    #     print("Bener cottttt")
    #     break
# email = "asdas@as.com"
# if email[-4:] == ".com" and email.count("@") == 1 and email[-5] != "@" :
#     print("True")

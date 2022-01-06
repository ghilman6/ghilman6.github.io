def rekursif(a):
    print(a)
    if a < 5:
        return rekursif(a+1)+1
    return a

print(rekursif(1))
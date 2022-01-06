# def readAnggota():
#     dataAnggota = []
#     f = open('anggota.txt')
#     for each_line in f:
#         dataAnggota.append(each_line.strip())
#     f.close()
#     return dataAnggota

# def readBuku():
#     dataBuku = []
#     f = open('buku.txt')
#     for each_line in f:
#         dataBuku.append(each_line.strip())
#     f.close()
#     return dataBuku
    
# dataAnggota  = readAnggota()
# print(dataAnggota)
# # dataAnggotaD = {}
# kd_buku = "GHI637"
# dataBuku  = readBuku()
# for i in range(len(dataBuku)):
#     if dataBuku [i][:6] == kd_buku:
#         dataBuku[i] = dataBuku[i].split(",")
#         if 
# dataBukuD = {}

# for i in range(len(dataBuku)):
#     dataBukuD[dataBuku[i][:6]] = dataBuku[i][7:].split(",")

# print(dataBukuD["TUH065"][0])

def banding(a,b):
    if a > b :
        return True
    else:
        return False
    
a = 3
b = 0
if banding(a,b):
    print("a lebih besar dari b")
else:
    print("b lebih besar dari a")
import random, string
judul = input("Judul: ")
penulis = input("Penulis: ") #Misalkan isi = "Ai Habra" "GHIlman"
stok = input("Stok: ")

penulis = penulis.split() #['Ai','Habra']
penulis = "".join(penulis) #"AiHabra"
kode = penulis[:3].upper() + ''.join(random.choice(string.digits) for _ in range(3))



myfile = open('myfileBuku.txt', 'a+')
myfile.write(kode+","+judul+","+penulis+","+stok+"\n")
myfile.close()
